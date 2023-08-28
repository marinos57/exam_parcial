<?php

namespace Controllers;

use Exception;
use Model\Rol;
use MVC\Router;

class RolController{

    public static function guardarAPI(){


        try {
            //code...
            $nombre = $_POST["rol_nombre"];
            $rol = new Rol([
                'rol_nombre'=>$nombre]);
            $resultado = $rol->crear();
        
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1

                ]);
             }else{
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
             }

        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);

            //throw $th;
        }
    }

    public static function modificarAPI(){

        try {
            $rol = new Rol($_POST);
            $resultado = $rol->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro modificado correctamente',
                    'codigo' => 1
                ]);
                } else {
                    echo json_encode([
                        'mensaje'=>'No se encontraron registros a actualizar',
                        'codigo' => 0
                    ]);

                }
            //code...
        } catch (Exception  $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje'=>"Error al realizar la operación",
                'codigo' => 0

            ]);
            //throw $th;
        }

    }

    public static function eliminarAPI(){


        
    }












}