<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; //11. validando datos del cliente en laravel
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

    //Crear un registro - 16. API RESTful Crear nuevo registro de curso en Laravel
    public function store(Request $request) //$request: recibe los valores del formulario
    {
        $token = $request->header('Authorization');
        $clientes = Cliente::all();
        $json = array();

        foreach ($clientes as $key => $value) {

            if ("Basic " . base64_encode($value["id_cliente"] . ":" . $value["llave_secreta"]) == $token) {

                //Recoger datos
                $datos = array(
                    "titulo" => $request->input("titulo"),
                    "descripcion" => $request->input("descripcion"),
                    "instructor" => $request->input("instructor"),
                    "imagen" => $request->input("imagen"),
                    "precio" => $request->input("precio")
                );
                /* echo '<pre>';
                print_r($datos);
                echo '</pre>';
                return; //para cancelar cualquier proceso que ocurra de aca hacia abajo */

                if (!empty($datos)) {

                    $validator = Validator::make($datos, [
                        'titulo' => 'required|string|max:255|unique:cursos', //cursos es el nombre de la tabla en la DB
                        'descripcion' => 'required|string|max:255|unique:cursos',
                        'instructor' => 'required|string|max:255',
                        'imagen' => 'required|string|max:255|unique:cursos',
                        'precio' => 'required|numeric',

                    ]);

                    //var_dump($validator->fails());
                    //die;
                    //si falla la validacion 11. validando datos del cliente en laravel

                    if ($validator->fails()) {
                        //var_dump('entra');
                        //die;
                        $jsonarray = array(

                            "status" => 404,
                            "detalle" => "Registro con errores: puede que cualquiera de los items tenga error..."

                        );

                        return json_encode($jsonarray, true); //cancelamos con un return el proceso para almacenar los cursos
                    } else {

                        $cursos = new Curso();
                        $cursos->titulo = $datos["titulo"];
                        $cursos->descripcion = $datos["descripcion"];
                        $cursos->instructor = $datos["instructor"];
                        $cursos->imagen = $datos["imagen"];
                        $cursos->precio = $datos["precio"];
                        $cursos->id_creador = $value["id"]; //viene del foreach

                        $cursos->save(); //para guardar en la DB

                        $json = array(

                            "status" => 200,
                            "detalle" => "Registro exitoso, su curso ha sido guardado"

                        );

                        return json_encode($json, true);
                    }
                } else {

                    $json = array(

                        "status" => 404,
                        "detalle" => "Los Registros no pueden estar vacios"

                    );

                    return json_encode($json, true);
                } //fin: if ($validator->fails())
            } //fin: if (base64_encode() == $token)
        } //fin: foreach 
        return json_encode($json, true);
    } //fin: public function store(Request $request)

    //17. API RESTful Editar un registro de curso en Laravel (TOMAR UN REGISTRO)
    public function show($id, Request $request) //$request: recibe los valores del formulario
    {
        $token = $request->header('Authorization');
        $clientes = Cliente::all();
        $json = array();

        foreach ($clientes as $key => $value) {

            if ("Basic " . base64_encode($value["id_cliente"] . ":" . $value["llave_secreta"]) == $token) {

                $curso = Curso::where("id", $id)->get();

                if (!empty($curso)) {

                    $json = array(

                        "status" => 200,
                        "detalles" => $curso

                    );
                } else {

                    $json = array(

                        "status" => 200,
                        "detalles" => "No hay ningún curso registrado"

                    );
                }
            } else {

                $json = array(

                    "status" => 404,
                    "detalles" => "No está autorizado para recibir los registros"

                );
            }
        }

        return json_encode($json, true);
    }

    //17. API RESTful Editar un registro de curso en Laravel (MODIFICAR TODOS LOS REGISTROS)
    public function update($id, Request $request) //$request: recibe los valores del formulario
    {
        $token = $request->header('Authorization');
        $clientes = Cliente::all();
        $json = array();

        foreach ($clientes as $key => $value) {

            if ("Basic " . base64_encode($value["id_cliente"] . ":" . $value["llave_secreta"]) == $token) {

                //Recoger datos
                $datos = array(
                    "titulo" => $request->input("titulo"),
                    "descripcion" => $request->input("descripcion"),
                    "instructor" => $request->input("instructor"),
                    "imagen" => $request->input("imagen"),
                    "precio" => $request->input("precio")
                );
                /* echo '<pre>';
                print_r($datos);
                echo '</pre>';
                return; //para cancelar cualquier proceso que ocurra de aca hacia abajo */

                if (!empty($datos)) {

                    $validator = Validator::make($datos, [
                        'titulo' => 'required|string|max:255', //cursos es el nombre de la tabla en la DB
                        'descripcion' => 'required|string|max:255',
                        'instructor' => 'required|string|max:255',
                        'imagen' => 'required|string|max:255', //se elimina el unique:cursos porque si no, no nos va a dejar modificar
                        'precio' => 'required|numeric',

                    ]);

                    //var_dump($validator->fails());
                    //die;
                    //si falla la validacion 11. validando datos del cliente en laravel

                    if ($validator->fails()) {
                        //var_dump('entra');
                        //die;
                        $jsonarray = array(

                            "status" => 404,
                            "detalle" => "Registro con errores: puede que cualquiera de los items tenga error..."

                        );

                        return json_encode($jsonarray, true); //cancelamos con un return el proceso para almacenar los cursos
                    } else {

                        //17. API RESTful Editar un registro de curso en Laravel
                        //esta es la parte que se va a modificar en: Editar
                        //vamos a pedir a la tabla de cursos que me traiga toda la info de ese $id
                        //con el $id que me traiga toda la informacion del curso
                        $traer_curso = Curso::where("id", $id)->get();
                        if ($traer_curso[0]["id_creador"] == $value["id"]) {

                            $datos = array(
                                "titulo" => $datos["titulo"],
                                "descripcion" => $datos["descripcion"],
                                "instructor" => $datos["instructor"],
                                "imagen" => $datos["imagen"],
                                "precio" => $datos["precio"]
                            );

                            $cursos = Curso::where("id", $id)->update($datos);

                            $json = array(

                                "status" => 200,
                                "detalle" => "Registro exitoso, su curso ha sido modificado"

                            );

                            return json_encode($json, true);
                        } else {
                            $json = array(

                                "status" => 404,
                                "detalle" => "No esta autorizado para modificar este curso"

                            );

                            return json_encode($json, true);
                        }

                        $json = array(

                            "status" => 200,
                            "detalle" => "Registro exitoso, su curso ha sido guardado"

                        );

                        return json_encode($json, true);
                    }
                } else {

                    $json = array(

                        "status" => 404,
                        "detalle" => "Los Registros no pueden estar vacios"

                    );

                    return json_encode($json, true);
                } //fin: if ($validator->fails())
            } //fin: if (base64_encode() == $token)
        } //fin: foreach 
        return json_encode($json, true);
    } //fin: public function store(Request $request)
}
