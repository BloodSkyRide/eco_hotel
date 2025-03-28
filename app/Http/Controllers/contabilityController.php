<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use App\Models\modelSell;
use App\Models\modelContability;
use App\Models\modelEgress;
use App\Models\modelEgressTotal;


class contabilityController extends Controller
{

    protected $permited_users = ["1093228865", "1091272724", "25164634"];


    public function getShowContability(Request $request)
    {


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"];

        $rol = $decode_token["rol"];

        $confirm = in_array($self_id, $this->permited_users);

        if ($confirm) {

            $fechaActual = Carbon::now();
            $today = Carbon::now()->format('Y-m-d');

            $year = $fechaActual->year;
            $month = $fechaActual->month;
            $day = $fechaActual->day;

            $confirmation = self::editDataContability($today);

            if ($confirmation) {

                self::sumEgress($self_name);
                $data = modelContability::getContabilityForMonth($year, $month, $day);

                $total_venta = modelContability::getTotalSell($year, $month, $day);

                $get_egresos = modelEgressTotal::getEgressForMonth($year, $month, $day);

                $get_total_egress = modelEgress::getTotalEgress($year, $month, $day);

                $get_egress_deatail = modelEgress::getEgressForDate($today);

                $total_egress_detail = modelEgress::totalEgress($today);

                $render = view("menuDashboard.contability", ["data" => $data, 
                "total" => $total_venta, 
                "egresos" => $get_egresos, 
                "total_egreso" => $get_total_egress,
                "egress_detail" => $get_egress_deatail,
                "egress_total" => $total_egress_detail])->render();

                return response()->json(["status" => true, "html" => $render]);
            }
        } else {


            return response()->json(["message" => "Acceso denegado, ponte en contacto con el desarrollador si crees que hay un error", "status" => "error"]);
        }

        return response()->json(["message" => "Error interno en el servidor", "status" => false]);
    }


    private function editDataContability($today)
    {



        $fechaActual = Carbon::now();
        $today = Carbon::now()->format('Y-m-d');

        $year = $fechaActual->year;
        $month = $fechaActual->month;
        $day = $fechaActual->day;
        $flag = 0;

        for ($i = 1; $i <= $day; $i++) {

            $build_date = "$year-$month-$i";
            $data = modelContability::verifyData($build_date);

            if ($data) {

                $total_venta_hoy = modelSell::totalSells($build_date);
                $new_data = modelContability::updateRegister($build_date, $total_venta_hoy);
            } else {

                $venta_actual = modelSell::totalSells($build_date);
                $data_insert = ["fecha" => $build_date, "total_venta_dia" => $venta_actual];
                $insert = modelContability::insertContability($data_insert);
            }

            $flag++;
        }



        return ($flag === $day) ? true : false;
    }


    public function uploadEgress(Request $request)
    {


        if ($request->hasFile("image")) {

            $path = self::saveEgressImage($request);

            $description = $request->descripcion;

            $value = $request->valor;

            $today = Carbon::now()->format('Y-m-d');

            $data = ["fecha" => $today, "valor" => $value, "descripcion" => $description, "url_imagen" => $path];

            $save_data = modelEgress::insertEgress($data);

            $end = (!$save_data) ? false : true;

            return response()->json(["status" => $end]);
        }
    }

    // private function saveEgressImage($request)
    // {


    //     $imagen = $request->file("image");


    //     $base_name = pathinfo($imagen, PATHINFO_FILENAME);
    //     $root_path = 'storage/egress';
    //     $hoy = Carbon::now()->format('Y-m-d');
    //     $name_final = $base_name . "_" . $hoy;


    //     $path = $imagen->storeAs("egress", $name_final . ".jpg", "public");
    //     return $root_path . "/" . $name_final . ".jpg";
    // }
    private function saveEgressImage($request)
    {
        $imagen = $request->file("image");
    
        // Nombre final del archivo
        $name_final = pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME) . "_" . Carbon::now()->format('Y-m-d_H-i-s') . ".jpg";
        $full_path = storage_path("app/public/egress/" . $name_final);
    
        // Optimizar imagen antes de guardarla
        $this->optimizeImage($imagen, $full_path);
    
        return "storage/egress/" . $name_final;
    }
    
    private function optimizeImage($image, $destination)
    {
        $src = imagecreatefromjpeg($image->getPathname()); 
        imagejpeg($src, $destination, 50); 
    
        imagedestroy($src);
    }

    private function sumEgress($name)
    {



        $fechaActual = Carbon::now();
        $today = Carbon::now()->format('Y-m-d');

        $year = $fechaActual->year;
        $month = $fechaActual->month;
        $day = $fechaActual->day;
        $flag = 0;

        for ($i = 1; $i <= $day; $i++) {

            $build_date = "$year-$month-$i";
            $data = modelEgressTotal::verifyData($build_date);

            if ($data) {

                $total_egreso_hoy = modelEgress::totalEgress($build_date);
                $new_data = modelEgressTotal::updateRegister($build_date, $total_egreso_hoy);
            } else {

                $egress_actually = modelEgress::totalEgress($build_date);
                $data_insert = ["fecha" => $build_date, "valor" => $egress_actually, "respuesto" => $name];
                $insert = modelEgressTotal::insertEgress($data_insert);
            }

            $flag++;
        }



        return ($flag === $day) ? true : false;
    }

    public function egressForDate(Request $request){


        $fecha_buscar = $request->fecha;

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"];

        $rol = $decode_token["rol"];
        

        $confirm = in_array($self_id, $this->permited_users);

        if ($confirm) {

            $fechaActual = Carbon::now();
            $today = Carbon::now()->format('Y-m-d');

            $year = $fechaActual->year;
            $month = $fechaActual->month;
            $day = $fechaActual->day;

            $confirmation = self::editDataContability($today);

            if ($confirmation) {

                self::sumEgress($self_name);
                $data = modelContability::getContabilityForMonth($year, $month, $day);

                $total_venta = modelContability::getTotalSell($year, $month, $day);

                $get_egresos = modelEgressTotal::getEgressForMonth($year, $month, $day);

                $get_total_egress = modelEgress::getTotalEgress($year, $month, $day);

                $get_egress_deatail = modelEgress::getEgressForDate($fecha_buscar);

                $total_egress_detail = modelEgress::totalEgress($fecha_buscar);

                $render = view("menuDashboard.contability", ["data" => $data, 
                "total" => $total_venta, 
                "egresos" => $get_egresos, 
                "total_egreso" => $get_total_egress,
                "egress_detail" => $get_egress_deatail,
                "egress_total" => $total_egress_detail])->render();

                return response()->json(["status" => true, "html" => $render]);
            }
        } else {


            return response()->json(["message" => "Acceso denegado, ponte en contacto con el desarrollador si crees que hay un error", "status" => "error"]);
        }

        return response()->json(["message" => "Error interno en el servidor", "status" => false]);

    }
}
