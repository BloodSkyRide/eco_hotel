<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class modelTransfer extends Model
{
    protected $table = "transferencias";
    protected $fillable = ["fecha", "hora", "cajero_responsable", "valor", "url_imagen", "created_at", "updated_at", "description"];


    public static function insertTransfer($data){

        return self::insert($data);

    }

    public static function getTransfersForMonth($year,$month, $today){

        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->orderBy("fecha","desc")
            ->get();

    }


}
