<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class modelcontrol_inventarios extends Model
{
   protected $fillable = ["id_item","id_original", "nombre", "unidades_disponibles", "fecha_reporte","hora_reporte", "categoria"];
   protected $table  = "control_inventarios";




   public static function insertData($data_insert){

    return self::insert($data_insert);

   }


   public static function verifyExists($date){

    return self::where("fecha_reporte",$date)
    ->exists();

   }

   public static function getItemControl($id_item,$date){

    return self::where("id_original",$id_item)
    ->where("fecha_reporte", $date)
    ->first();

   }


       public static function decrementControlInventory($id_item, $decrement, $date){

        return self::where('id_original', $id_item)
        ->where("fecha_reporte", $date)
        ->decrement('unidades_disponibles', $decrement);
    }
}
