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

class WorkAccident extends Command
{
    protected $signature = 'command:WorkAccident';
    protected $description = 'İş Kazası bilgilerini veritabanına aktarır.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $google_max_page = settings('google_max_page');
        $this->info("Work Accident Mining Start ". Carbon::now()->format("d.m.Y H:i:s"));

        $words = Word::where("type", 1)->get(); //dinamik kelimeler.
        foreach ($words as $word) {
            for ($i = 0; $i <= intval($google_max_page); $i += 10) {
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

                if (isset($results)) {
                    foreach ($results as $row) { //Google Custom Search ile aranan kelimenin bulunduğu sitelerin içerisinde arama yapılacak.
                        if (isset($row->url)) {
                            try {
                                if (Tracking::where("type", 1)->where("main_url", $row->url)->exists()) { //daha önceden bu url girilmiş mi ?
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
                                    if (!empty($dom)) {
                                        $findStatus = false;
                                        $description = "";
                                        $paragraphs = $dom->find("p"); //<p> tag içerisinde arama yapılıyor

                                        if (!empty($paragraphs)) {
                                            foreach ($paragraphs as $paragraph) {
                                                try {

                                                    if (strpos($paragraph, "yaralandı") !== false
                                                        || strpos($paragraph, "yaralı") !== false
                                                        || strpos($paragraph, "yaralanmıştır") !== false
                                                        || strpos($paragraph, "ölü") !== false
                                                        || strpos($paragraph, "öldü") !== false
                                                        || strpos($paragraph, "hayatını kaybetti") !== false
                                                        || strpos($paragraph, "yaşamını yitirdi") !== false
                                                        || strpos($paragraph, "yaşam mücadelesini kaybetti") !== false
                                                    ) {

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


                                        if ($findStatus == false) { //eğer <p> tag içerisinde bulunmaz ise div de ara
                                            $divs = $dom->find("div");
                                            if (!empty($divs)) {
                                                foreach ($divs as $div) {
                                                    try {
                                                        if (strpos($div, "yaralandı") !== false
                                                            || strpos($div, "yaralı") !== false
                                                            || strpos($div, "yaralanmıştır") !== false
                                                            || strpos($div, "ölü") !== false
                                                            || strpos($div, "öldü") !== false
                                                            || strpos($div, "hayatını kaybetti") !== false
                                                            || strpos($div, "yaşamını yitirdi") !== false
                                                            || strpos($div, "yaşam mücadelesini kaybetti") !== false) {
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
                                            $tracking = new Tracking;
                                            $tracking->type = 1; //İş kazası
                                            $tracking->title = $row->subject;
                                            $tracking->description = strip_tags($description);
                                            $tracking->main_url = $row->url;
                                            $tracking->status = 0; //Bekliyor
                                            $tracking->save();
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

                                    sleep(1); //çok fazla trafik sağlayıp robot değilime takılmamak için sorgu başına bekletme. Yukarı yapılan herhangi bir curl işlemi olmadığından şuanlık gereksizdir.
                                }
                            }catch (\Exception $exception) {
                                $log = new Log;
                                $log->type = 1;
                                $log->title = "Results Foreach Error";
                                $log->description = "Link:" . $row->url . " Line: " . $exception->getLine() . " - Exception:" . $exception->getMessage();
                                $log->save();
                            }
                        }//if row->url == null

                    } //results foreach end

                }else{
                    //DAHA FAZLA SAYFA BULUNAMADIĞINDAN VEYA SORGU SINIRINDAN İŞLEM SONLANDIRILDI.
                    break;
                }
                sleep(2); //  diğer sayfaya geçmeden önce 2 saniye bekle
            }
        }

        $this->info("Work Accident Mining End ". Carbon::now()->format("d.m.Y H:i:s"));
    }
}
