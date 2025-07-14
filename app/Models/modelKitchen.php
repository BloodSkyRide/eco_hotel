<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class modelKitchen extends Model
{
    protected $table = "cocina_pedidos";
    protected $primaryKey = 'id_pedido';
    protected $fillable = ["id_pedido","id_producto_venta","nombre_producto", "cantidad", "descripcion", "auxiliar", "hora", "estado", "fecha", "nombre_cajero", "id_cajero", "created_at", "updated_at"];

    public static function insertOrderKitchen($data_insert){

    $order = self::create($data_insert);
    return $order->id_pedido;

    }


    public static function getOrdersToday($today){

        return self::where("fecha", $today)
        ->orderBy("hora","desc")
        ->get();
    }


    public static function unitOrderKitchen($today){

    return self::select('id_producto_venta','nombre_producto', DB::raw('SUM(cantidad) as total'))
        ->where('fecha', $today)
        ->groupBy('nombre_producto', "id_producto_venta")
        ->orderByDesc('total') // opcional: para ver primero los más pedidos
        ->get();
    }


    public static function changeStateForId($id_order, $state){


        return self::where("id_pedido", $id_order)
        ->update(["estado" => $state]);

    }


    public static function getOrderId($id_order){


        return self::where("id_pedido", $id_order)
        ->first();
    }
}
