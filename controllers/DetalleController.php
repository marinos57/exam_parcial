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
    public static function estadistica2(Router $router)
    {
       
            $router->render('usuarios/estadistica2', []);
        
  
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

    public static function detalleUsuarios2API(){

        $sql = "SELECT r.rol_nombre, COUNT(p.permiso_id) AS cantidad_usuarios
        FROM rol r
        LEFT JOIN permiso p ON r.rol_id = p.permiso_rol
        LEFT JOIN usuario u ON p.permiso_usuario = u.usu_id
        WHERE r.rol_situacion = 1 AND u.usu_situacion = 1
        GROUP BY r.rol_id, r.rol_nombre
        ORDER BY r.rol_id;
        ";

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
