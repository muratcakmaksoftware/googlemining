<?php

use App\Models\Setting;

if (!function_exists('turkishPlateSearch')) {
    /**
     * Metnin içerisinde plaka arama. Bulamazsa ise boş array döner.
     * @param  string $data
     * @return array
     */
    //https://www.phpliveregex.com/  //testin yapılması
    //wiki baz alındı: https://en.wikipedia.org/wiki/Vehicle_registration_plates_of_Turkey
    $GLOBALS['regexPlate1'] = "/\b\d{2}\W[A-Z]{1,3}\W\d{2,5}\b/"; // 99 X 99 ~ 99 XXX 99999
    //$GLOBALS['regexPlate2'] = "/\b\d{2}[a-zA-Z]{1,3}\d{2,5}\b/"; // 99X99 ~ 99XXX99999 //60x60 gibi resimleri bulduğu için iptal edildi.

    /*
     \b kelime sınırlama
     \d sayı
     \W kelime olmayan karakter -_* gibi
     \[a-zA-Z] büyük küçük latin harf
     \{0,3} adet aralığı belirlenmesi
     * */

    function turkishPlateSearch($data)
    {
        $data = strip_tags($data);
        $matches = [];
        preg_match($GLOBALS['regexPlate1'], $data, $matches);
        if(count($matches) > 0){
            return $matches;
        }else{
            //preg_match($GLOBALS['regexPlate2'], $data, $matches);
            return $matches;
        }

    }
}

function settings($key, $value = null){
    if($value != null){ //veri güncelleme
        $setting = Setting::where("key_name", $key)->first();
        if(isset($setting)){ //varsa güncelle
            $setting->value = $value;
            return $setting->save();
        }else{ //yoksa ekle
            $setting = new Setting;
            $setting->key_name = $key;
            $setting->value = $value;
            return $setting->save();
        }
    }else{ // veri getirme.
        $setting = Setting::where("key_name",$key)->first();
        if(isset($setting)){
            return $setting->value;
        }else{
            return null;
        }
    }
}

function removeqsvar($url, $varname) {
    return preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
}

function getSiteName($url){
    return parse_url($url, PHP_URL_HOST);
}



