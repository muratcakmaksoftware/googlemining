<?php

namespace App\Http\Controllers\LawTracking;

use App\Http\Controllers\Controller;
use App\Models\LawTracking;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
class LawTrackingController extends Controller
{
    public function index()
    {
        //Trafik kazası hukukta
        $trafficAccident = Tracking::with('lawTracking')->whereHas('lawTracking', function ($query){
            $query->where("status", "!=", 5);
        })->where("type", 0)->where("status", 2)->get();

        //İş kazası hukukta
        $workAccident = Tracking::with('lawTracking')->whereHas('lawTracking', function ($query){
            $query->where("status", "!=", 5);
        })->where("type", 1)->where("status", 2)->get();
        return view('lawTracking.index')
            ->with("workAccident", $workAccident)
            ->with("trafficAccident", $trafficAccident);
    }


    public function backTracking(Request $request){ //Hukukta kısmından geri alma
        try{
            $tracking_id = $request->get("tracking_id");
            $tracking = Tracking::where("id", $tracking_id)->first();
            if(isset($tracking)){
                $delete = LawTracking::where("tracking_id", $tracking->id)->delete(); //Bu kayda dahil hukukta bilgileri siliniyor.
                if($delete){
                    $tracking->status = 0; //bekleyene geri alma
                    $tracking->save();
                    return response()->json(['status' => 1, 'message' => "Başarıyla Geri Alındı!"]);
                }else{
                    return response()->json(['status' => 0, 'message' => "Silme hatası!"]);
                }

            }else{
                return response()->json(['status' => 0, 'message' => "ID BULUNAMADI!"]);
            }

        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => "Bir Hata Oluştu: ".$e->getMessage()]);
        }

    }

    public function lawSaveTracking(Request $request){ //Hukukta kısmından geri alma
        try{
            $law_tracking_id = $request->get("law_tracking_id");
            $status = $request->get("status");
            $description = $request->get("description");

            $lawTracking = LawTracking::where("id", $law_tracking_id)->first();
            if(isset($lawTracking)){
                $lawTracking->status = $status;
                $lawTracking->law_description = $description;
                $lawTracking->save();
                return response()->json(['status' => 1, 'message' => "Başarıyla Güncellendi!"]);
            }else{
                return response()->json(['status' => 0, 'message' => "ID BULUNAMADI!"]);
            }

        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => "Bir Hata Oluştu: ".$e->getMessage()]);
        }

    }

}
