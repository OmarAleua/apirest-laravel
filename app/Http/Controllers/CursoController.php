<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso; //14. Creando el Modelo y Controlador de la tabla Cursos - Instanciamos el Modelo
use App\Models\Cliente; //15. Solicitando Token de Autorización en Laravel
use Illuminate\Support\Facades\Validator;

class CursoController extends Controller
{
    //14. Creando el Modelo y Controlador de la tabla Cursos - me va a mostrar todos los registros
    public function index(Request $request)
    {

        //15. Solicitando Token de Autorización en Laravel : 11:15min
        $token = $request->header('Authorization');
        $clientes = Cliente::all();
        $json = array();

        foreach ($clientes as $key => $value) {

            if ("Basic " . base64_encode($value["id_cliente"] . ":" . $value["llave_secreta"]) == $token) {

                //crear un objeto = modelo:funcion all 
                $cursos = Curso::all();
                if (!empty($cursos)) {
                    $json = array(

                        "status" => 200,
                        "total_registros" => count($cursos),
                        "detalles" => $cursos
                    );
                } else {
                    $json = array(

                        "status" => 200,
                        "total_registros" => 0,
                        "detalles" => "No hay ningun curso registrado"
                    );
                }
                return json_encode($json, true);
            } else {
                $json = array(

                    "status" => 404,
                    "detalle" => "No esta autorizado para recibir los registros",
                    //"id_cliente" => $value["id_cliente"],
                    //"llave_secreta" => $value["llave_secreta"],
                    //"token= " => $token,
                    //"Basic== " => ("Basic " . base64_encode($value["id_cliente"] . ":" . $value["llave_secreta"]))
                );
            }
        }
        return json_encode($json, true);
    }
}
