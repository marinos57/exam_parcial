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

    public static function modificarAPI()










}