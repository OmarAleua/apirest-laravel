<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListaDeTareasController extends Controller
{
    public function index()
    {

        $json = array(
            "detalle" => "no encontrado"
        );

        echo json_encode($json, true);
    }
}
