<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transfersTotalModel extends Model
{
    protected $table = "transferencias_totales";
    protected $fillable = ["fecha", "valor", "created_at", "updated_at"];


    public static function insertTransfer($data)
    {
        return self::insert($data);
    }

    public static function existsTransfers($date){


        return self::where("fecha", $date)
        ->exists();

    }

    public static function updateTransfers($date,$sum){

        return self::where("fecha", $date)
        ->update(["valor" => $sum]);


    }

    public static function getTransfersForMonth($year,$month, $today){

        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->orderBy("fecha","desc")
            ->get();

    }


    public static function totalSum($year,$month, $today){

        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->orderBy("fecha","desc")
            ->sum("valor");

    }
}
