<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\modelTransfer;
use Carbon\Carbon;

class transfersController extends Controller
{
    public function getShowTransfers(Request $request){

        $fechaActual = Carbon::now();
        $today = Carbon::now()->format('Y-m-d');

        $year = $fechaActual->year;
        $month = $fechaActual->month;
        $day = $fechaActual->day;

        $get_transfers_month = modelTransfer::getTransfersForMonth($year, $month, $today);

        $render = view("menuDashboard.transfers",["transferencias_mes" => $get_transfers_month])->render();


        return response()->json(["status" => true, "html" => $render]);

    }


    public function insertTransfer(Request $request){

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"];

        $rol = $decode_token["rol"];

        $description = $request->descripcion;

        $entity_bank = $request->entidad;

        $value = $request->valor;

        $image = $request->image;

        $date = Carbon::now()->format("Y-m-d");
        $time = Carbon::now()->format("H:i:s");

        $url_image = self::saveImageTransfer($request);

        $data_insert = ["fecha"  => $date, "hora" => $time, "cajero_responsable" => $self_name, "valor" => $value, 
        "url_imagen" => $url_image, "entidad" => $entity_bank, "descripcion" => $description];


        $insert_data = modelTransfer::insertTransfer($data_insert);

        if($data_insert){


            return response()->json(["status" => true]);
        }


    }


    private function saveImageTransfer($request){

        $imagen = $request->file("image");
    
        // Nombre final del archivo
        $name_final = pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME) . "_" . Carbon::now()->format('Y-m-d_H-i-s') . ".jpg";
        $full_path = storage_path("app/public/transfers/" . $name_final);
    
        // Optimizar imagen antes de guardarla
        $this->optimizeImage($imagen, $full_path);
    
        return "storage/transfers/" . $name_final;


    }

    private function optimizeImage($image, $destination)
    {
        $src = imagecreatefromjpeg($image->getPathname()); 
        imagejpeg($src, $destination, 50); 
    
        imagedestroy($src);
    }


}
