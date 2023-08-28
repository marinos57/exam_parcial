<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use MVC\Router;

class DetalleController
{
    public static function estadistica(Router $router)
    {
       
            $router->render('usuarios/estadistica', []);
  
    }

    public static function detalleUsuariosAPI(){

        $sql = "SELECT usu_estado, COUNT(usu_id) AS cantidad_usuarios
        FROM usuario
        GROUP BY usu_estado";

        try {
            
            $usuarios = Usuario::fetchArray($sql);
    
            echo json_encode($usuarios);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


}
