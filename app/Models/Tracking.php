<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tracking extends Model
{
    use SoftDeletes;

    protected $table = "tracking";
    public $timestamps = true;


    public function getTypeTextAttribute(){
        switch($this->type){
            case 0 : return "Trafik Kazası";
            case 1 : return "İş Kazası";
            case 2 : return "Çekici Bildirim";
            default : return "Bulunamadı";
        }
    }

    public function getStatusTextAttribute(){
        switch($this->status){
            case 0 : return "Bekleme";
            case 1 : return "Bulunamadı";
            case 2 : return "Onaylandı";
            case 3 : return "İptal";
            default : return "Bulunamadı";
        }
    }

    public function links()
    {
        return $this->hasMany(LinkTracking::class, 'tracking_id', 'id');
    }

    public function lawTracking()
    {
        return $this->hasOne(LawTracking::class, 'tracking_id', 'id');
    }

}
