<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelEgress extends Model
{
    use HasFactory;

    protected $table = "egresos";
    protected $fillable = ["id_egress", 
    "fecha", "valor", "descripcion", "url_imagen", "created_at", "updated_at", "caja", "nombre", "cedula"];


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

    //     return self::selectRaw("fecha, SUM(valor) as total_venta")
    // ->whereBetween("fecha", [$startDate, $endDate])
    // ->orderBy("fecha", "desc")
    // ->groupBy("fecha")
    // ->get();
     }

    public static function getTotalEgress($year,$month, $today){

        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->sum("valor");

    }


    public static function getEgressForDate($date){


        return self::where("fecha", $date)
        ->get();
    }

    public static function getEgressCaja($date, $self_id){

        return self::where("fecha", $date)
        ->where("cedula", $self_id)
        ->where("caja", 1)
        ->sum("valor");

    }


}
