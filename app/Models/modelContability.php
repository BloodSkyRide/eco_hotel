<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelContability extends Model
{
    use HasFactory;
    protected $table = "contabilidad";
    protected $fillable = ["id_contabilidad", "fecha", "total_venta_dia", "created_at", "updated_at"];

    public static function getContabilityForMonth($year,$month, $today){


        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->get();


    }

    public static function insertContability($data){

        return self::insert($data);

    }


    public static function verifyData($today){

        return self::where("fecha",$today)
        ->exists();

    }

    public static function updateRegister($today, $total_sell){

        return self::where("fecha", $today)
        ->update(["total_venta_dia"  => $total_sell]);

    }

    public static function getTotalSell($year,$month, $today){

        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->sum("total_venta_dia");

    }
}
