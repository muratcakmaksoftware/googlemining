<?php


namespace App\Helpers\GoogleSearch;


use DOMDocument;
use DOMXPath;
use KubAT\PhpSimple\HtmlDomParser;

class GoogleSearch
{
    protected $searchArray;

    //Arama ayarları
    function __construct($phrase, $parameters){
        $this->searchArray = http_build_query(array_merge(
            ['q' => str_replace(" ", "+",$phrase)],
            ['source' => "lnms"],
            $parameters
        ));
    }

    //Google search edilen çıktıyı sade halde verir.
    public function getResultRaw(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/search?" . $this->searchArray);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 0);

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public function getResultLinks($resultRaw){
        $dom = new DomDocument();
        @$dom->loadHTML($resultRaw);
        $xpath = new DOMXpath($dom);

        $links = [];
        foreach ($xpath->query("//div[@class='kCrYT']") as $el){

            $check = $xpath->query(".//h3", $el);
            if($check->length > 0){ //2 tane aynı url atlatılması.
                $url = "";
                $hrefs = $xpath->query("./a/@href", $el);
                foreach ($hrefs as $href){
                    $url = $href->value;
                    break;
                }
                $url = str_replace("/url?q=", " ", $url);
                $url = strtok($url, '?'); // Querystring clear
                $url = strtok($url, '&'); // Querystring clear
                $url = trim($url);

                $subject = "";
                $titles = $xpath->query(".//div[contains(@class, 'BNeawe vvjwJb AP7Wnd')]", $el);
                foreach ($titles as $title){
                    $subject = $title->textContent;
                    break;
                }

                $links[] = (object)[
                    "subject" => $subject,
                    "url" => $url,
                ];
            }
        }

        return $links;
    }

}
