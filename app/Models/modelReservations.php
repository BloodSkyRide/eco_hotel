<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class modelReservations extends Model
{


    protected $table = "reservaciones";
    protected $fillable = [
        "id_reservacion",
        "monto_reservado",
        "monto_adeudado",
        "valor_paquete",
        "titular",
        "fecha",
        "chat",
        "fecha_reservacion",
        "cedula",
        "medio_pago",
        "contacto",
        "numero_huespedes",
        "descripcion_reserva",
        "hora_reserva",
        "id_reserva_unit",
        "estado", 
        "id_transferencia"
    ];
    public static function getReservations($fecha)
    {
        return modelReservations::where("fecha_reservacion", $fecha)
            ->get();
    }



    public static function insertReservations($data)
    {
        return modelReservations::insert($data);
    }

    public static function getCodeReservation($code)
    {
        return modelReservations::where("id_reserva_unit", $code)
            ->first();
    }

    public static function getIdTransfer($id_reservation){

        return self::where("id_reservacion", $id_reservation)
        ->first();

    }


    public static function changeStateReservation($id, $state)
    {
        return modelReservations::where("id_reservacion", $id)
            ->update(["estado" => $state]);
    }
}
