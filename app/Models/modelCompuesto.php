<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelCompuesto extends Model
{

    use HasFactory;
    protected $table = "compuestos";
    protected $fillable = ["id_compuesto", "id_producto_venta",  "nombre_compuesto", "id_item_fk", "descuento", "fecha_creacion", "created_at", "updated_at"];


    public static function insertCompound($data){


        return self::insert($data);

    }

    public static function getComposed($id_product){

        // return self::where('id_producto_venta', $id_product)
        // ->get();

        return self::join('inventario', 'inventario.id_item', '=', 'compuestos.id_item_fk')
        ->select("inventario.nombre", "compuestos.descuento")
        ->where('inventario.id_item', $id_product)
        ->get();

    }


    public static function getAllCompound(){


        return self::all();
    }




}
