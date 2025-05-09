<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelEgressTotal extends Model
{
    use HasFactory;

    protected $table = "egresos_totales";
    protected $fillable = ["id_egreso_totales", "fecha", "valor","respuesto", "created_at", "updated_at"];


    public static function insertEgress($data){


        return self::insert($data);
    }


    public static function verifyData($today){

        return self::where("fecha",$today)
        ->exists();

    }

    public static function updateRegister($today, $total_egress){

        return self::where("fecha", $today)
        ->update(["valor"  => $total_egress]);

    }

    public static function totalEgress($fecha)
    {

        return self::where("fecha", $fecha)
            ->sum('valor');
    }


    public static function getEgressForMonth($year,$month, $today){

        
        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->orderBy("fecha","desc")
            ->get();
     }

    public static function getTotalEgress($year,$month, $today){

        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->sum("valor");

    }
}
