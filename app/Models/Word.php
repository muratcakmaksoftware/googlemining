<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $table = "words";
    public $timestamps = false;

    public function getTypeTextAttribute(){
        switch($this->type){
            case 0 : return "Trafik Kazası";
            case 1 : return "İş Kazası";
            case 2 : return "Çekici Bildirim";
            default : return "Bulunamadı";
        }
    }
}
