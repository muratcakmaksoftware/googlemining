<?php

namespace App\Console\Commands;

use App\Helpers\GoogleSearch\GoogleSearch;
use App\Models\LinkTracking;
use App\Models\Log;
use App\Models\Tracking;
use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Console\Command;
use KubAT\PhpSimple\HtmlDomParser;

class TrafficAccident extends Command
{
    protected $signature = 'command:TrafficAccident';
    protected $description = 'Trafik kaza bilgilerini veritabanına aktarır.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $google_max_page = settings('google_max_page');
        $this->info("Traffic Accident Mining Start ". Carbon::now()->format("d.m.Y H:i:s"));

        $words = Word::where("type", 0)->get(); //dinamik kelimeler.
        foreach ($words as $word){
            for($i = 0; $i <= intval($google_max_page); $i+=10){
                $results = null;
                try {
                    $googleSearch = new GoogleSearch($word->name, array(
                        'tbm' => "nws", //haberlerde ara
                        'start' => $i,
                    ));

                    $resultRaw = $googleSearch->getResultRaw();
                    $results = $googleSearch->getResultLinks($resultRaw);

                } catch (\Exception $exception) {
                    $results = null;
                }

                if(isset($results)){
                    foreach ($results as $row) {

                        if(isset($row->url)){
                            try {
                                if (Tracking::where("type", 0)->where("main_url", $row->url)->exists()) { //daha önceden bu url girilmiş mi ?
                                    //bu url daha önceden kontrol edilmiş ve bulunamamış. Bu yüzden bu url atlanıyor.
                                } else {

                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $row->url);
                                    curl_setopt($ch, CURLOPT_HEADER, 0); //başlık iptali
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //ssl devre dışı
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //ssl devre dışı
                                    curl_setopt($ch, CURLOPT_POST, 0); //post yöntemi devre dışı get ile al
                                    $response = curl_exec($ch);

                                    $curl_info = curl_getinfo($ch);
                                    if ($response === false || $curl_info['http_code'] != 200) {
                                        $log = new Log;
                                        $log->type = 2;
                                        $log->title = "Results DATA";
                                        $log->description = "Link:" . $row->url . " HTTP_CODE: ".$curl_info['http_code'] ." Detay: ".curl_error($ch);
                                        $log->save();
                                    }

                                    curl_close($ch);

                                    $dom = HtmlDomParser::str_get_html($response);
                                    if(!empty($dom)){
                                        $findStatus = false;
                                        $description = "";
                                        $paragraphs = $dom->find("p"); //<p> tag içerisinde plaka var mı diye aranıyor
                                        $matches = [];
                                        if(!empty($paragraphs)){
                                            foreach ($paragraphs as $paragraph) {
                                                try {
                                                    $matches = turkishPlateSearch($paragraph);
                                                    if (count($matches) > 0) {
                                                        $description = $paragraph;
                                                        $findStatus = true;
                                                        break;
                                                    }
                                                } catch (\Exception $exception) {
                                                    $log = new Log;
                                                    $log->type = 0;
                                                    $log->title = "Paragraph Error";
                                                    $log->description = "Link:" . $row->url . " Line: " . $exception->getLine() . " Exception:" . $exception->getMessage();
                                                    $log->save();
                                                }

                                            }
                                        }


                                        if ($findStatus == false) { //eğer <p> tag içerisinde bir plaka bulamaz ise div taraması gerçekleştirilecek.
                                            $divs = $dom->find("div"); //<div> tag içerisinde plaka var mı diye aranıyor
                                            if(!empty($divs)){
                                                foreach ($divs as $div) {
                                                    try {
                                                        $matches = turkishPlateSearch($div);
                                                        if (count($matches) > 0) {
                                                            $description = $div;
                                                            $findStatus = true;
                                                            break;
                                                        }
                                                    } catch (\Exception $exception) {
                                                        $log = new Log;
                                                        $log->type = 0;
                                                        $log->title = "Div Error";
                                                        $log->description = "Link:" . $row->url . " Line: " . $exception->getLine() . " - Exception:" . $exception->getMessage();
                                                        $log->save();
                                                    }

                                                }
                                            }
                                        }

                                        if ($findStatus) { //Eğer veri bulunduysa kayıt edilmesi.
                                            $plates = "";
                                            foreach ($matches as $match) {
                                                $plates .= $match . ", ";
                                            }
                                            $plates = trim($plates, ", ");

                                            $json_data = (object)array(
                                                "plate" => $plates
                                            );

                                            $plate = $matches[0]; //ilk plaka bilgisi

                                            //aynı plaka kazası bilgisinin 2 ay içerisindeki haber bilgilerini tek haberde tutmak için gereklidir.
                                            $start_month = Carbon::now()->startOfMonth()->format("Y-m-d");
                                            $end_month = Carbon::now()->addMonths(2)->format("Y-m-d");

                                            $trackingCheck = Tracking::where("type", 0)->where("plate", $plate)->whereBetween('created_at',array($start_month,$end_month))->first();
                                            if (isset($trackingCheck)) {//Bu plaka daha önceden kayıt yapılmış mı ?
                                                //Her zaman farklı linkleri kontrol ettiğimizden aynı siteden de olsa bu plaka farklı bir linke sahiptir. Bu yüzden direk kayıt yapılabilir.
                                                $linkTracking = new LinkTracking;
                                                $linkTracking->tracking_id = $trackingCheck->id;
                                                $linkTracking->site_name = getSiteName($row->url);
                                                $linkTracking->url = $row->url;
                                                $linkTracking->save();
                                            } else { // Yeni bir plaka
                                                $tracking = new Tracking;
                                                $tracking->type = 0; //Trafik kazası
                                                $tracking->title = $row->subject;
                                                $tracking->description = strip_tags($description);
                                                $tracking->plate = $plate;
                                                $tracking->json_data = json_encode($json_data);
                                                $tracking->main_url = $row->url;
                                                $tracking->status = 0; //Bekliyor
                                                if ($tracking->save()) {
                                                    $linkTracking = new LinkTracking;
                                                    $linkTracking->tracking_id = $tracking->id;
                                                    $linkTracking->site_name = getSiteName($row->url);
                                                    $linkTracking->url = $row->url;
                                                    $linkTracking->save();
                                                }
                                            }
                                        } else {
                                            //Veri bulunamazsa aynı url tekrar kontrol edilmesin diye pasife edilmesi için kayıt edilmesi.
                                            $tracking = new Tracking;
                                            $tracking->type = 0; //Trafik kazası
                                            $tracking->title = $row->subject;
                                            $tracking->description = null;
                                            $tracking->plate = null;
                                            $tracking->json_data = null;
                                            $tracking->main_url = $row->url;
                                            $tracking->status = 1; //Plaka Bulunamadı
                                            $tracking->save();
                                        }
                                    }//else dom bulunamazsa boş geç

                                    sleep(1); //çok fazla trafik sağlayıp robot değilime takılmamak için sorgu başına bekletme.
                                }

                            } catch (\Exception $exception) {
                                $log = new Log;
                                $log->type = 1;
                                $log->title = "Results Foreach Error";
                                $log->description = "Link:" . $row->url . " Line: " . $exception->getLine() . " - Exception:" . $exception->getMessage();
                                $log->save();
                            }
                        } //if row->url == null

                    }// results foreach end
                }else{
                    //DAHA FAZLA SAYFA BULUNAMADIĞINDAN VEYA SORGU SINIRINDAN İŞLEM SONLANDIRILDI.
                    break;
                }

                sleep(2); //  diğer sayfaya geçmeden önce 2 saniye bekle
            }
        }

        $this->info("Traffic Accident Mining End ". Carbon::now()->format("d.m.Y H:i:s"));
    }
}
