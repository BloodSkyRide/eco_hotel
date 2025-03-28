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


    public function insertTransferencia(Request $request){

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"];

        $rol = $decode_token["rol"];




    }


}
