<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NotificacionCreada;
use App\Events\requestFood;
use App\Models\modelProducts;
use App\Models\modelKitchen;
use Tymon\JWTAuth\Facades\JWTAuth;

class kitchenController extends Controller
{


    public $state_preparation = "preparacion";
    public function orderKitchen(Request $request)
    {


        $array = $request->products_kitchen;
        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $cajero = $decode_token["nombre"];
        $id_cajero = $decode_token["cedula"];
        $hora = date('H:i:s');
        $fecha_actual = date('Y-m-d');

        foreach ($array as $item) {

            $nombre_producto = modelProducts::getNameProduct($item['id_item'])->first()->nombre_producto;
            $cantidad = $item['cantidad'];

            $data_insert = [
                "nombre_producto" => $nombre_producto,
                "cantidad" => $cantidad,
                "descripcion" =>  $item['description'],
                "hora" => $hora,
                "estado" => $this->state_preparation,
                "fecha" => $fecha_actual,
                "nombre_cajero" => $cajero,
                "id_cajero" => $id_cajero
            ];

            $image_product = modelProducts::getProduct($item['id_item'])->url_imagen;

            $id_order = modelKitchen::insertOrderKitchen($data_insert);


            broadcast(new NotificacionCreada(
                $nombre_producto,
                $cantidad,
                $hora,
                'pedido',
                $id_cajero,
                $item['description'],
                $cajero,
                $fecha_actual,
                $image_product,
                $id_order
            ));
            sleep(1);
        }

        return response()->json(["status" => true, "message" => "Evento emitido de manera satisfactoria"]);
    }


    public function getShowKitchen(Request $request)
    {


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $cedula = $decode_token['cedula'];
        $role = $decode_token['rol'];
        $today = date('Y-m-d');

        $orders = modelKitchen::getOrdersToday($today);

        $render = view("menuDashboard.historyOrderKitchen", ["orders" => $orders, 'id' => $cedula, "rol" => $role])->render();


        return response()->json(["status" => true, "html" => $render]);
    }


    public function changeState(Request $request)
    {

        $id_order = $request->id_order;

        $state = $request->state;

        $change_state = modelKitchen::changeStateForId($id_order, $state);


        if ($change_state) {

            return self::getShowKitchen($request);
        } else return response()->json(["status" => true]);
    }



    public function changeStateButton(Request $request)
    {

        $id_order = $request->id_order;
        $state = $request->state;


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        if ($state === "preparado") {

            $order = modelKitchen::getOrderId($id_order);
            $name_order = $order->nombre_producto;
            $amount_order = $order->cantidad;
            $hora = date('H:i:s');
            $id_cajero = $decode_token['cedula'];

                broadcast(new NotificacionCreada($name_order, $amount_order,  $hora, 'devolucion', $id_cajero));
        }

        $change_state = modelKitchen::changeStateForId($id_order, $state);

        if ($change_state) return response()->json(["status" => true]);
        else return response()->json(["status" => false]);
    }


    public function getIdUser(Request $request){

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token['cedula'];


        return response()->json(["status" => true, "id_access" => $self_id]);


    }


    public static function getRange(Request $request){


        $range = $request->range;

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $cedula = $decode_token['cedula'];
        $role = $decode_token['rol'];
        

        $orders = modelKitchen::getOrdersToday($range);

        $render = view("menuDashboard.historyOrderKitchen", ["orders" => $orders, 'id' => $cedula, "rol" => $role])->render();


        return response()->json(["status" => true, "html" => $render]);

    }
}
