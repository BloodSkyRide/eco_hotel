<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class transfersController extends Controller
{
    public function getShowTransfers(Request $request){

        
        $render = view("menuDashboard.transfers",[])->render();


        return response()->json(["status" => true, "html" => $render]);

    }
}
