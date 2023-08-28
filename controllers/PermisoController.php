<?php

namespace Controllers;

use Exception;
use Model\Permiso;
use Model\Usuario;
use Model\Rol;
use MVC\Router;

class PermisoController
{
    public static function index(Router $router){
        $usuarios = static::buscarUsuario();
        $roles = static::buscarRol();
        $permisos = Permiso::all();

        $router->render('permisos/index', [
            'usuarios' => $usuarios,
            'roles' => $roles,
            'permisos' => $permisos,
        ]);
    }

    public static function buscarUsuario(){
        $sql = "SELECT * FROM usuario where usu_situacion = 1";

        try {
            $usuarios = Usuario::fetchArray($sql);

            return $usuarios;
                       
        } catch (Exception $e) {
            //throw $th;
            return[]; 
        }

    }


    public static function buscarRol(){



}

