<?php

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use App\Models\LawTracking;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;
use KubAT\PhpSimple\HtmlDomParser;

class TrackingController extends Controller
{
    public function trafficAccident()
    {
        $trackings = Tracking::where("type", 0)->where("status", 0)->get(); //Trafik kazası ve beklemede olanları getirir.
        return view('tracking.traffic_accident')
            ->with("trackings", $trackings);
    }

    public function cancel(Request $request){ //Takip İptal gönderme
        try{
            $tracking_id = $request->get("tracking_id");
            $tracking = Tracking::where("id", $tracking_id)->first();
            if(isset($tracking)){
                $tracking->status = 3; //iptal
                $tracking->save();
                return response()->json(['status' => 1, 'message' => "Başarıyla İptal Edildi!"]);
            }else{
                return response()->json(['status' => 0, 'message' => "ID BULUNAMADI!"]);
            }

        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => "Bir Hata Oluştu: ".$e->getMessage()]);
        }

    }

    public function lawTrafficAccidentCreate(Request $request){ //Trafik Kazasını Hukuka gönderme
        try{
            $tracking_id = $request->get("tracking_id");
            $accident_type = $request->get("accident_type");
            $plates = $request->get("plates");
            $drivers = $request->get("drivers");
            $accident_date = $request->get("accident_date");
            $city = $request->get("city");
            $accident_injured = $request->get("accident_injured");
            $accident_death = $request->get("accident_death");
            $insurance_company = $request->get("insurance_company");
            $policy_no = $request->get("policy_no");
            $phone = $request->get("phone");
            $description = $request->get("description");

            $tracking = Tracking::where("id", $tracking_id)->first();
            if(isset($tracking)){
                $lawTracking = new LawTracking;
                $lawTracking->tracking_id = $tracking->id;
                $lawTracking->accident_type = $accident_type;
                $lawTracking->plates = $plates;
                $lawTracking->drivers = $drivers;
                $lawTracking->accident_date = Carbon::parse($accident_date)->format("Y-m-d");
                $lawTracking->city = $city;
                $lawTracking->accident_injured = $accident_injured;
                $lawTracking->accident_death = $accident_death;
                $lawTracking->insurance_company = $insurance_company;
                $lawTracking->policy_no = $policy_no;
                $lawTracking->phone = $phone;
                $lawTracking->description = $description;

                if($lawTracking->save()){
                    $tracking->status = 2; //takibi onaylamaya gönderme
                    $tracking->save();
                    return response()->json(['status' => 1, 'message' => "Başarıyla Hukuka Gönderildi!"]);
                }else{
                    return response()->json(['status' => 0, 'message' => "Başarıyla Gönderme Başarısız!"]);
                }

            }else{
                return response()->json(['status' => 0, 'message' => "İşlem yaptığınız kayıt bulunamadı!"]);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => "Bir Hata Oluştu: ".$e->getMessage()]);
        }

    }

    public function lawWorkAccidentCreate(Request $request){ //İş Kazasını Hukuka gönderme
        try{
            $tracking_id = $request->get("tracking_id");
            $accident_type = $request->get("accident_type");
            $accident_date = $request->get("accident_date");
            $city = $request->get("city");
            $accident_injured = $request->get("accident_injured");
            $accident_death = $request->get("accident_death");
            $phone = $request->get("phone");
            $description = $request->get("description");

            $tracking = Tracking::where("id", $tracking_id)->first();
            if(isset($tracking)){
                $lawTracking = new LawTracking;
                $lawTracking->tracking_id = $tracking->id;
                $lawTracking->accident_type = $accident_type;
                $lawTracking->accident_date = Carbon::parse($accident_date)->format("Y-m-d");
                $lawTracking->city = $city;
                $lawTracking->accident_injured = $accident_injured;
                $lawTracking->accident_death = $accident_death;
                $lawTracking->phone = $phone;
                $lawTracking->description = $description;

                if($lawTracking->save()){
                    $tracking->status = 2; //takibi onaylamaya gönderme
                    $tracking->save();
                    return response()->json(['status' => 1, 'message' => "Başarıyla Hukuka Gönderildi!"]);
                }else{
                    return response()->json(['status' => 0, 'message' => "Başarıyla Gönderme Başarısız!"]);
                }

            }else{
                return response()->json(['status' => 0, 'message' => "İşlem yaptığınız kayıt bulunamadı!"]);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => "Bir Hata Oluştu: ".$e->getMessage()]);
        }

    }

    public function getApproved(Request $request){ //Tüm Onaylananları listeler.
        $trackings = Tracking::where("status", 2)->get();
        return view('tracking.approved')
            ->with("trackings", $trackings);
    }

    public function getCancel(Request $request){ //Tüm İptal Edilenleri Listeler.
        $trackings = Tracking::where("status", 3)->get();
        return view('tracking.cancel')
            ->with("trackings", $trackings);
    }

    public function backTracking(Request $request){ //Takip İptal den geri alma
        try{
            $tracking_id = $request->get("tracking_id");
            $tracking = Tracking::where("id", $tracking_id)->first();
            if(isset($tracking)){
                $tracking->status = 0; //bekleyene geri alma
                $tracking->save();
                return response()->json(['status' => 1, 'message' => "Başarıyla Geri Alındı!"]);
            }else{
                return response()->json(['status' => 0, 'message' => "ID BULUNAMADI!"]);
            }

        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => "Bir Hata Oluştu: ".$e->getMessage()]);
        }

    }


    public function workAccident()
    {
        $trackings = Tracking::where("type", 1)->where("status", 0)->get(); //İş kazası ve beklemede olanları getirir.
        return view('tracking.work_accident')
            ->with("trackings", $trackings);
    }

    public function tow()
    {
        return view('tracking.tow');
    }


}
