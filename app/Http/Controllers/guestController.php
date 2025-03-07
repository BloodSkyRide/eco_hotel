<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\modelGuest;
use App\Models\modelSell;
use App\Models\modelProducts;
use App\Models\modelInventario;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Http\Request;

class guestController extends Controller
{


    protected $id_defecto = 500;// id por defecto para crear el producto de venta correspondiente a la alquilada de las habitaciones
    protected $id_pasadia_amarilla = 45;
    protected $nombre_pasadia_amarilla = "pasadia HOTEL";
    public function getShowGuest(Request $request){

        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $rol = $decode_token["rol"];

        $fecha = date('Y-m-d');
        $guests = modelGuest::getGuest($fecha);
        $total_guests_sell = modelGuest::totalSellGuests($fecha);
        $render = view("menuDashboard.guest",["rol" => $rol, "guests" => $guests, "total" => $total_guests_sell])->render();

        return response()->json(["status" => true, "html" => $render]);

    }



    private function verifyProductSellerRoom(){

         

        $verificador = modelProducts::verifyProductSeller($this->id_defecto);

        $confirmation = count($verificador);

        if($confirmation > 0) return false;
        else{

            $data = [
                "id_producto" =>$this->id_defecto, 
                "nombre_producto" => "Habitacion", 
                "precio" => "0", 
                "descripcion" => "Comoda habitacion en eco hotel parador de rapi", 
                "fecha_creacion" => "2024-12-19",  
                "url_imagen" => "storage/product_images/product_defect.png" ];
                 
            modelProducts::insertProduct($data);
        }   

    }


    public function sendregister(Request $request){

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"] . " " . $decode_token["apellido"];

        $registros = $request->json()->all();
        $precio_alquiler = $request->precio;
        $tipo_estadia = $request->estadia;

        self::verifyProductSellerRoom();
        $hora =  Carbon::now();
        $fecha = date('Y-m-d');
        $verify_pasadia = modelInventario::verifyPasadia($this->id_pasadia_amarilla);

        if(!$verify_pasadia){

            $data_inventory = [

                "id_item" => $this->id_pasadia_amarilla,
                "nombre" => $this->nombre_pasadia_amarilla,
                "unidades_disponibles" => 200,// cantidad de unidades disponibles
                "fecha_creacion" => $fecha,
                "hora_creacion" => $hora,
                "tope_min" => 50,
                "abastecimiento"  => "ABASTECIDO",
                "precio_costo" => 270,
                "estado" => "DISPONIBLE",

            ];

            modelInventario::createProduct($data_inventory);
        }



        $confirmation = count($registros['registros']);

        $precio_divisor = $precio_alquiler / $confirmation;


        $flag = 0;

        foreach($registros['registros'] as $item){


            $data = [

                "nombre_huesped" => $item['nombre'],
                "apellido_huesped" => $item['apellido'],
                "cedula_huesped" => $item['cedula'],
                "nacimiento" => $item['nacimiento'],
                "email" => $item['email'],
                "origen" => $item['origen'],
                "destino" => $item['destino'],
                "estado_civil" => $item['estado_civil'],
                "celular" => $item['celular'],
                "hora" => $hora,
                "habitacion" => $item['habitacion'],
                "estadia" => $tipo_estadia,
                "total_venta" =>$precio_divisor,
                "fecha" =>$fecha,


            ];


            $insert = modelGuest::insertGuests($data);

            if($insert) $flag++;
        }

        $data_sell = [
            
            "id_producto_venta" => $this->id_defecto,
            "nombre_producto_venta" => "Habitacion ".$item['habitacion'],
            "descripcion_producto_venta" => "Cómoda habitacion en el eco hotel parador de rapi.",
            "unidades_venta" => $confirmation,
            "id_user_cajero" => $self_id,
            "nombre_cajero" => $self_name,
            "hora" => $hora,
            "fecha" => $fecha,
            "total_venta" => $precio_alquiler
        ];
        modelSell::insertSell($data_sell);


        if($flag === $confirmation){

            modelInventario::decrementInventory($this->id_pasadia_amarilla, $confirmation );
            return response()->json(["status" => true]);
        }
        else{

            return response()->json(["status" => false, "mesagge" => "No se completo el guardado correctamente!"]);

        }

    }


    public function getRange(Request $request){


        $fecha = $request->fecha;

        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $rol = $decode_token["rol"];
        $guests = modelGuest::getGuest($fecha);
        $total_guests_sell = modelGuest::totalSellGuests($fecha);
        $render = view("menuDashboard.guest",["rol" => $rol, "guests" => $guests, "total" => $total_guests_sell])->render();

        return response()->json(["status" => true, "html" => $render]);


    }
}
