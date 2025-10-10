<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class modelTransfer extends Model
{
    protected $table = "transferencias";
    protected $fillable = ["fecha", "hora", "cajero_responsable", "valor", "url_imagen", "created_at", "updated_at", "descripcion", "id_cajero"];
    protected $primaryKey = "id_transferencias";

    public static function insertTransfer($data){

        return self::insert($data);

    }

        public static function insertTransferGetId($data)
    {
        $transfer = self::create($data); // crea el registro y devuelve el modelo creado
        return $transfer->id_transferencias; // devuelve el ID recién insertado
    }

    public static function getTransfersForMonth($year,$month, $today){

        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->orderBy("fecha","desc")
            ->get();

    }


    public static function existsTransfers($date){


        return self::where("fecha", $date)
        ->exists();

    }





    public static function sumTransfers($date){

        return self::where("fecha", $date)
        ->sum("valor");

    }


    public static function getTransfersForDay($today){


        return self::where("fecha", $today)
        ->orderBy("fecha","desc")
        ->get();
    }



    public static function searchForRangeTransfers($date){

        return self::where("fecha", $date)
        ->orderBy("fecha","desc")
        ->get();

    }

    public static function getSumTransfersforUser($self_id, $date){


        return self::where("fecha",$date)
        ->where("id_cajero", $self_id)
        ->sum("valor");
    }


    public static function setTransfer($id_transfer, $data){

        return self::where("id_transferencias", $id_transfer)
        ->update($data);


    }


}
