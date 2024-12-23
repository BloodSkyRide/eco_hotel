<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\select;

class modelProducts extends Model
{

    use HasFactory;

    protected $table = "productos_venta";
    protected $fillable = ["nombre_producto","precio","descripcion", "fecha_creacion", "url_imagen", "created_at", "updated_at" ];

    public static function insertProduct($data){


        return self::create($data)->id; // se debe

    }

    public static function searcher($search_text){

        return self::where("nombre_producto","LIKE", "%". $search_text. "%")
        ->limit(5)
        ->get();


    }


    public static function getNameProduct($id_product){

        return self::where("id_producto", $id_product)
        ->select("nombre_producto")
        ->get();
    }

    public static function getDescriptionProduct($id_product){

        return self::where("id_producto", $id_product)
        ->select("descripcion")
        ->get();
    }

    public static function getProduct($id_product){

        return self::where("id_producto", $id_product)
        ->first();
    }

    public static function getPathForId($id_item){


        return self::where("id_producto", $id_item)
        ->select("url_imagen")
        ->first();
    }

    public static function modifyImage($id_item, $url){

        return self::where("id_producto", $id_item)
        ->update(["url_imagen" => $url]);


    }


    public static function modifyDescription($id_item,$description){


        return self::where("id_producto", $id_item)
        ->update(["descripcion" => $description]);
    }

    public static function modifyCost($id_item, $modify_cost){


        return self::where("id_producto", $id_item)
        ->update(["precio" => $modify_cost]);

    }

    public static function getAllProducts(){


        return self::all();

    }

    public static function deleteRegister($id_item){

        return self::where("id_producto", $id_item)
        ->delete();
    }
}
