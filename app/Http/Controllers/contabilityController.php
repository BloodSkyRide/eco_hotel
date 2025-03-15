<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use App\Models\modelSell;
use App\Models\modelContability;

class contabilityController extends Controller
{

    protected $permited_users = ["1093228865", "1091272724", "25164634"];


    public function getShowContability(Request $request)
    {


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $rol = $decode_token["rol"];

        $confirm = in_array($self_id, $this->permited_users);

        if ($confirm) {

            $fechaActual = Carbon::now();
            $today = Carbon::now()->format('Y-m-d');

            $year = $fechaActual->year; 
            $month = $fechaActual->month;
            $day = $fechaActual->day;

            $confirmation = self::editDataContability($year, $month, $today);

            if($confirmation){

                
                $data = modelContability::getContabilityForMonth($year, $month, $day);

                $total_venta = modelContability::getTotalSell($year,$month, $today);
                dd($total_venta);
                $render = view("menuDashboard.contability", ["data" => $data, "total" => $total_venta])->render();
    
                return response()->json(["status" => true, "html" => $render]);
            }
        } else {


            return response()->json(["message" => "Acceso denegado, ponte en contacto con el desarrollador si crees que hay un error", "status" => "error"]);
        }

        return response()->json(["message" => "Error interno en el servidor", "status" => false]);
    }


    private function editDataContability($anio, $mes, $today){


        $data = modelContability::verifyData($today);
        
        $confirmation = false;
        
        if($data){

            $total_venta_hoy = modelSell::totalSells($today);
            $new_data = modelContability::updateRegister($today, $total_venta_hoy);
            $confirmation = true;

        }else{

            $venta_actual = modelSell::totalSells($today);
            $data_insert = ["fecha" => $today, "total_venta_dia" => $venta_actual];
            $insert = modelContability::insertContability($data_insert);
            $confirmation = true;
        }

        return $confirmation;


    }
}
