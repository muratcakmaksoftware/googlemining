<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "logs";
    public $timestamps = true;

    public function getTypeTextAttribute(){
        switch ($this->type){
            case 0: return "Düşük";
            case 1: return "Orta";
            case 2: return "Yüksek";
            default: return "BULUNAMADI";
        }
    }

    public function getTypeColorAttribute(){
        switch ($this->type){
            case 0: return "green";
            case 1: return "orange";
            case 2: return "red";
            default: return "BULUNAMADI";
        }
    }

}
