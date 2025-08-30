<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelGuest extends Model
{
    use HasFactory;

    protected $table = "alquiler_habitaciones";
    protected $fillable = ["id_habitacion", "nombre_huesped", "apellido_huesped","tipo_documento", "cedula_huesped", "acompanantes", "nacimiento", "email", "origen", "destino", "estado_civil", "celular", "hora", "habitacion", "estadia", "total_venta", "fecha", "createdd_at", "updatedd_at"];
    

    public static function insertGuests($data){


        return self::insert($data);


    }

    public static function getGuest($fecha){

        return self::where("fecha",$fecha)
        ->orderBy("hora", "desc")
        ->get();

    }


    public static function totalSellGuests($fecha){

        return self::where("fecha", $fecha)
        ->sum('total_venta');

    }


}
