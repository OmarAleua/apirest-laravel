<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; //11. validando datos del cliente en laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //11. validando datos del cliente en laravel
use Illuminate\Support\Facades\Hash; //12. creando las credenciales del cliente api
use App\Models\Cliente; //13. Guardando los datos del Cliente - Instanciamos el Modelo 

class ClientesController extends Controller
{
    public function index()
    {

        $jsonarray = array(
            "detalle-ClientesController" => "no encontrado"
        );

        return json_encode($jsonarray, true);
    }

    //Crear un Registro 10. recibiendo datos del cliente API

    public function store(Request $request)
    {
        //Recoger datos
        $datos = array(
            "nombre" => $request->input("nombre"),
            "apellido" => $request->input("apellido"),
            "email" => $request->input("email")
        );
        //echo '<pre>';
        //print_r($datos);
        //echo '</pre>';
        //Validar Datos 11. validando datos del cliente en laravel

        if (!empty($datos)) {

            $validator = Validator::make($datos, [
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:clientes'

            ]);

            //var_dump($validator->fails());
            //die;
            //si falla la validacion 11. validando datos del cliente en laravel

            if ($validator->fails()) {
                //var_dump('entra');
                //die;
                $jsonarray = array(

                    "status" => 404,
                    "detalle" => "Registro con errores"

                );

                return json_encode($jsonarray, true);
            } else {

                //Ejecutar el Metodo Save: guardar - 13. Guardando los datos del Cliente
                $id_cliente = Hash::make($datos["nombre"] . $datos["apellido"] . $datos["email"]);
                $llave_secreta = Hash::make($datos["email"] . $datos["apellido"] . $datos["nombre"], ['rounds' => 12]);

                $cliente = new Cliente(); //creamos un objeto - utilizando la Clase del Metodo Cliente
                $cliente->nombre = $datos["nombre"];
                $cliente->apellido = $datos["apellido"];
                $cliente->email = $datos["email"];
                $cliente->id_cliente = str_replace('$', 'a', $id_cliente); //15. Solicitando Token de Autorización en Laravel
                $cliente->llave_secreta = str_replace('$', 'o', $llave_secreta); //15. Solicitando Token de Autorización en Laravel
                $cliente->save(); //vamos a guardar

                $json = array(

                    "status" => 200,
                    "detalle" => "Registro exitoso, tome sus credenciales y guardelas",
                    "credenciales" => array(
                        "id_cliente" => str_replace('$', 'a', $id_cliente), //15. Solicitando Token de Autorización en Laravel
                        "llave_secreta" => str_replace('$', 'o', $llave_secreta) //15. Solicitando Token de Autorización en Laravel
                    )

                );

                return json_encode($json, true);

                /* lo quitamos en el video 13. Guardando los datos del Cliente - queda lo de arriba
                //12. Creando las credenciales del Cliente API
                $id_cliente = Hash::make($datos["nombre"] . $datos["apellido"] . $datos["email"]);
                $llave_secreta = Hash::make($datos["email"] . $datos["apellido"] . $datos["nombre"], ['rounds' => 12]);
                //imprime 12. Creando las credenciales del Cliente API
                echo '<pre>';
                print_r($id_cliente);
                echo '</pre>';
                echo '<pre>';
                print_r($llave_secreta);
                echo '</pre>';
                */
            }
        } else {

            $json = array(

                "status" => 404,
                "detalle" => "Registro con errores"

            );

            return json_encode($json, true);
        }
    }
}
