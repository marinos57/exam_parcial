<?php

namespace Controllers;

use Exception;
use Model\Permiso;
use Model\Usuario;
use Model\Rol;
use MVC\Router;

class PermisoController
{
    public static function index(Router $router)
    {
        $usuarios = static::buscarUsuario();
        $roles = static::buscarRol();
        $permisos = Permiso::all();

        $router->render('permisos/index', [
            'usuarios' => $usuarios,
            'roles' => $roles,
            'permisos' => $permisos,
        ]);
    }

    public static function buscarUsuario()
    {
        $sql = "SELECT * FROM usuario where usu_situacion = 1";

        try {
            $usuarios = Usuario::fetchArray($sql);

            return $usuarios;
        } catch (Exception $e) {
            //throw $th;
            return [];
        }
    }


    public static function buscarRol()
    {
        $sql = "SELECT * FROM rol where rol_situacion = 1";

        try {
            $roles = Rol::fetchArray($sql);
            return $roles;
        } catch (Exception $e) {
            //throw $th;
            return [];
        }
    }

    public static function guardarAPI()
    {


        try {
            $permiso = new Permiso($_POST);
            $resultado = $permiso->crear();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
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
        }
    }

    public static function modificarAPI()
    {

        try {
            $permiso = new Permiso($_POST);
            $resultado = $permiso->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro modificado correctamente',
                    'codigo' => 1
                ]);
            } else {
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
        }
    }

    public static function eliminarAPI()
    {
        try {
            $permiso_id = $_POST['permiso_id'];
            $permiso = Permiso::find($permiso_id);

            $permiso->permiso_rol = null;
            //$permiso->permiso_situacion = 0;

            $resultado = $permiso->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro eliminado correctamente',
                    'codigo' => 1
                ]);
            } else {
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
        }
    }

    public static function activarAPI()
    {


        try {
            $usu_id = $_POST['usu_id'];
            $sql = "UPDATE usuario set usu_estado = 'ACTIVO' where usu_id = ${usu_id}";
            $resultado = Usuario::SQL($sql);
            $resultado = 1;

            if ($resultado == 1) {
                echo json_encode([
                    'mensaje' => 'Usuario activado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al actualizar',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function desactivarAPI()
    {

        try {
            $usu_id = $_POST['usu_id'];
            $sql = "UPDATE usuario set usu_estado = 'INACTIVO' where usu_id = ${usu_id}";
            $resultado = Usuario::SQL($sql);
            $resultado = 1;



            if ($resultado == 1) {
                echo json_encode([
                    'mensaje' => 'Usuario activado correctamente',
                    'codigo' => 1
                ]);
            } else {
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
        }
    }


    public static function buscarAPI()
    {
        $usu_id = $_GET['usu_id'];
        $rol_id = $_GET['rol_id'];

        $sql = "SELECT
        p.permiso_id,
        u.usu_nombre AS permiso_usuario,
        u.usu_id,
        r.rol_nombre AS permiso_rol,
        r.rol_id,
        u.usu_estado
    FROM
        usuario u
    LEFT JOIN
        permiso p ON u.usu_id = p.permiso_usuario
    LEFT JOIN
        rol r ON p.permiso_rol = r.rol_id
    WHERE
        (u.usu_situacion = 1) AND
        (u.usu_estado = 'PENDIENTE' OR u.usu_estado = 'ACTIVO' OR u.usu_estado = 'INACTIVO') OR
        (p.permiso_situacion = 1) OR
        p.permiso_id IS NULL;
    ";

        if ($usu_id != '') {
            $sql .= " AND usuarios.usu_id = '$usu_id'";
        }

        if ($rol_id != '') {
            $sql .= " AND roles.rol_id = '$rol_id'";
        }


        try {
            $permisos = Permiso::fetchArray($sql);
            echo json_encode($permisos);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    // public static function buscarUsuarioAPI()
    // {
    //     $usu_nombre = $_GET['usu_nombre'];
    //     $usu_apellido = $_GET['usu_apellido'];
    //     $usu_usuario = $_GET['usu_usuario'];

    //     $sql = "SELECT * FROM usuario"; // Usar tabla 'usuario' 

    //     if ($usu_nombre) {
    //         $sql .= " AND usu_nombre LIKE '%$usu_nombre%'";
    //     }

    //     if ($usu_apellido) {
    //         $sql .= " AND usu_apellido LIKE '%$usu_apellido%'";
    //     }

    //     if ($usu_usuario) {
    //         $sql .= " AND usu_usuario LIKE '%$usu_usuario%'";
    //     }

    //     try {
    //         $usuarios = Usuario::fetchArray($sql);
    //         header('Content-Type: application/json');
    //         echo json_encode($usuarios);
    //     } catch (Exception $e) {
    //         echo json_encode([
    //             'detalle' => $e->getMessage(),
    //             'mensaje' => 'Ocurrió un error',
    //             'codigo' => 0
    //         ]);
    //     }
    // }
}
