<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class guestController extends Controller
{
    public function getShowGuest(Request $request){


        $render = view("menuDashboard.guest")->render();

        return response()->json(["status" => true, "html" => $render]);

    }
}
