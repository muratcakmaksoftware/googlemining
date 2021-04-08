<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::orderBy("type", "DESC")->get();

        return view('log.index')
            ->with("logs", $logs);
    }

    public function delete(Request $request){
        try{
            $id = $request->get("id");
            $log = Log::where("id", $id)->first();
            if(isset($log)){
                $log->delete();
                return response()->json(['status' => 1, 'message' => "Başarıyla Silindi!"]);
            }else{
                return response()->json(['status' => 0, 'message' => "ID BULUNAMADI!"]);
            }

        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => "Bir Hata Oluştu: ".$e->getMessage()]);
        }
    }

    public function clearLog(Request $request){
        try{
            $status = Log::truncate();
            if($status){
                return response()->json(['status' => 1, 'message' => "Başarıyla Tüm Log Temizlendi!"]);
            }else{
                return response()->json(['status' => 0, 'message' => "ID BULUNAMADI!"]);
            }

        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => "Bir Hata Oluştu: ".$e->getMessage()]);
        }
    }
}
