<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class modelChatBot extends Model
{
    protected $table = "chat_bot";
    protected $fillable = ["id_chat","telefono", "ultimo_mensaje", "estado_conversacion","consentimiento","fecha", "hora", "created_at", "updated_at"];

    public static function insertConversation($data){

        return self::insert($data);

    }


    public static function verifyExists($numero){

        return self::where("telefono", $numero)->exists();


    }


    public static function verifyStateConversation($numero){

        return self::where('telefono', $numero)
        ->value("estado_conversacion");

    }

    public static function changeStateConversation($state, $numero){


        return self::where('telefono', $numero)
        ->update(["estado_conversacion" => $state]);


    }

    public static function updateChat($numero,$message){

        return self::where('telefono', $numero)
        ->update(["ultimo_mensaje" => $message]);

    }
}
