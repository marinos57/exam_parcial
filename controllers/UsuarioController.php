<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use MVC\Router;
use Model\Permiso;
use Model\ActiveRecord;
use Model\Rol;
class UsuarioController
{

    public static function index(Router $router)
    {
        $usuarios = usuario::all();
        $router->render('usuarios/index', [
            'usuarios' => $usuarios,
        ]);
    }

    public static function guardarApi()
{
    try {
        $nombre = $_POST['usu_nombre'];
        $apellido = $_POST['usu_apellido'];
        $usuario = $_POST['usu_usuario'];
        $password = $_POST['usu_password'];

        // Aquí se valida si ya existe un usuario con el mismo nombre de usuario
        $usuarioExistente = Usuario::fetchFirst("SELECT * FROM usuario WHERE usu_usuario = '$usuario'");
        if ($usuarioExistente) {
            echo json_encode([
                'mensaje' => 'El nombre de usuario ya está en uso',
                'codigo' => 0
            ]);
            return;
        }

        // Aquí se crea un nuevo objeto Usuario para guardar en la base de datos
        $nuevoUsuario = new Usuario([
            'usu_nombre' => $nombre,
            'usu_apellido' => $apellido,
            'usu_usuario' => $usuario,
            'usu_password' => password_hash($password, PASSWORD_DEFAULT),
            'usu_situacion' => 1
        ]);

        $resultado = $nuevoUsuario->guardar();

        if ($resultado['resultado'] == 1) {
            echo json_encode([
                'mensaje' => 'Registro guardado correctamente',
                'codigo' => 1
            ]);
        } else {
            echo json_encode([
                'mensaje' => 'Ocurrió un error al guardar el registro',
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

// Función del controlador para cambiar contraseña
public static function cambiarContrasenaApi()
{
    try {
        $idUsuario = $_POST['usu_id'];
        $nuevaContraseña = $_POST['nueva_contraseña'];

        // Obtener el usuario por su ID usando fetchFirst
        $usuario = Usuario::fetchFirst("usu_id = :id", [":id" => $idUsuario]); 

        if (!$usuario) {
            echo json_encode([
                'mensaje' => 'Usuario no encontrado',
                'codigo' => 0
            ]);
            return;
        }

        // Actualizar la contraseña en la instancia del usuario
        $usuario['usu_password'] = password_hash($nuevaContraseña, PASSWORD_DEFAULT);
        
        // Guardar los cambios en la base de datos usando fetchArray
        $resultado = $usuario->guardar();

        if ($resultado['resultado'] == 1) {
            echo json_encode([
                'mensaje' => 'Contraseña cambiada correctamente',
                'codigo' => 1
            ]);
        } else {
            echo json_encode([
                'mensaje' => 'Ocurrió un error al cambiar la contraseña',
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


}