<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class modelKitchen extends Model
{
    protected $table = "cocina_pedidos";
    protected $primaryKey = 'id_pedido';
    protected $fillable = ["id_pedido","nombre_producto", "cantidad", "descripcion", "auxiliar", "hora", "estado", "fecha", "nombre_cajero", "id_cajero", "created_at", "updated_at"];

    public static function insertOrderKitchen($data_insert){

    $order = self::create($data_insert);
    return $order->id_pedido;

    }


    public static function getOrdersToday($today){

        return self::where("fecha", $today)
        ->get();

    }


    public static function changeStateForId($id_order, $state){


        return self::where("id_pedido", $id_order)
        ->update(["estado" => $state]);

    }
}
