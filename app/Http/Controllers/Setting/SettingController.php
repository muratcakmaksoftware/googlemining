<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\LawTracking;
use App\Models\LinkTracking;
use App\Models\Setting;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $site_name = settings("site_name");
        $logo = Storage::disk('upload')->url(settings("logo"));

        $google_max_page = settings("google_max_page");
        $google_custom_search_api_key = settings("google_custom_search_api_key");
        $search_engine_id = settings("search_engine_id"); //genel arama trafik kazası için kullanılıyor
        $work_accident_search_engine_id = settings("work_accident_search_engine_id"); //iş kazası için site filtrelemeli arama

        return view('settings.index')
            ->with("work_accident_search_engine_id", $work_accident_search_engine_id)
            ->with("google_max_page", $google_max_page)
            ->with("search_engine_id", $search_engine_id)
            ->with("google_custom_search_api_key", $google_custom_search_api_key)
            ->with("logo", $logo)
            ->with("site_name", $site_name);
    }

    public function update(Request $request)
    {
        $site_name = $request->get("site_name");
        $google_max_page = $request->get("google_max_page");
        //$google_custom_search_api_key = $request->get("google_custom_search_api_key");
        //$search_engine_id = $request->get("search_engine_id");
        //$work_accident_search_engine_id = $request->get("work_accident_search_engine_id");

        settings("site_name", $site_name);
        settings("google_max_page", $google_max_page);
        //settings("google_custom_search_api_key", $google_custom_search_api_key);
        //settings("search_engine_id", $search_engine_id);
        //settings("work_accident_search_engine_id", $work_accident_search_engine_id);

        if($request->hasFile("logo")){
            $request->validate([
                'logo' => 'required|image|mimes:jpg,png|max:1024|dimensions:max_width=128,max_height=128|',
            ]);

            $logo = settings("logo"); //logo var mı?
            if(isset($logo)){ //varsa öncekini sil.
                Storage::disk('upload')->delete($logo);
            }

            //Yeni logonun eklenmesi.
            $image = $request->file("logo");
            $randomNumber = rand(0, 99999999);
            $fileName = md5($randomNumber.time()).".".$image->clientExtension();
            $folder = '/images/';
            $filePath = $folder.$fileName;
            $image->storeAs($folder, $fileName, 'upload');
            settings("logo", $filePath);
        }

        return redirect()->back();
    }

    function clearAllData(){
        try{
            Tracking::truncate();
            LinkTracking::truncate();
            LawTracking::truncate();

            return response()->json(['status' => 1, 'message' => "Başarıyla Sıfırlandı!"]);

        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => "Bir Hata Oluştu: ".$e->getMessage()]);
        }
    }
}
