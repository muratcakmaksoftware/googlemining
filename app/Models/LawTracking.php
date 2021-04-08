<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawTracking extends Model
{
    protected $table = "law_tracking";
    public $timestamps = true;

    public function getAccidentTypeTextAttribute(){
        switch($this->accident_type){
            case 0 : return "Tek Taraflı";
            case 1 : return "Çift Taraflı";
            case 2 : return "Zincirleme";
            default : return "Bulunamadı";
        }
    }

    public function backTracking()
    {
        return $this->hasOne(Tracking::class, 'id', 'tracking_id');
    }

    public function getStatusTypeTextAttribute(){
        switch($this->status){
            case 0 : return "Bekliyor";
            case 1 : return "Arandı";
            case 2 : return "Arandı Açmadı";
            case 3 : return "İşlemde";
            case 4 : return "Tamamlandı";
            case 5 : return "Kaydı Kapat";
            default : return "Bulunamadı";
        }
    }

}
