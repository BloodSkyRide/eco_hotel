<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modelSell;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class historySellController extends Controller
{
    public function getShowHistorySell(Request $request){


        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $rol = $decode_token["rol"];

        $today = Carbon::now()->format('Y-m-d');

        
        $history_sells = modelSell::getSells($today);
        
        $total_venta = modelSell::totalSells($today);

        $total_venta_unificada = modelSell::unitTotalSells($today);

        $total_venta_users = modelSell::getTotalForUsers($today);


        $render = view("menuDashboard.historySell", ["rol" => $rol, "historial" => $history_sells, "total" => $total_venta, "unificado" => $total_venta_unificada, "users" => $total_venta_users])->render();

        return response()->json(["status" => true, "html" => $render]);

    }


    public function searchForRangeHistory(Request $request){

        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $rol = $decode_token["rol"];
        $today = $request->fecha;

        $history_sells = modelSell::getSells($today);
        
        $total_venta = modelSell::totalSells($today);

        $total_venta_unificada = modelSell::unitTotalSells($today);

        $total_venta_users = modelSell::getTotalForUsers($today);

        $render = view("menuDashboard.historySell", ["rol" => $rol, "historial" => $history_sells, "total" => $total_venta, "unificado" => $total_venta_unificada, "users" => $total_venta_users])->render();

        return response()->json(["status" => true, "html" => $render]);

    }
}
