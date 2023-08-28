<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\UsuarioController;
use Controllers\PermisoController;
use Controllers\RolController;
use Controllers\DetalleController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);
//rutas usuarios
$router->get('/usuarios', [UsuarioController::class,'index'] );
$router->post('/API/usuarios/guardar', [UsuarioController::class,'guardarAPI'] );

//rutas permiso
$router->get('/permisos', [PermisoController::class,'index']);
$router->post('/API/permisos/guardar', [PermisoController::class,'guardarAPI'] );
$router->post('/API/permisos/modificar', [PermisoController::class,'modificarAPI'] );
$router->post('/API/permisos/eliminar', [PermisoController::class,'eliminarAPI'] );
$router->get('/API/permisos/buscar', [PermisoController::class,'buscarAPI'] );
$router->post('/API/permisos/activar', [PermisoController::class,'activarAPI'] );
$router->post('/API/permisos/desactivar', [PermisoController::class,'desactivarAPI'] );
//$router->post('/API/permisos/buscarUsuario', [PermisoController::class,'buscarUsuarioAPI'] );



//rutas roles
$router->get('/roles', [RolController::class,'index']);
$router->post('/API/roles/guardar', [RolController::class,'guardarAPI'] );
$router->post('/API/roles/modificar', [RolController::class,'modificarAPI'] );
$router->post('/API/roles/eliminar', [RolController::class,'eliminarAPI'] );
$router->get('/API/roles/buscar', [RolController::class,'buscarAPI'] );


$router->get('/usuarios/estadistica', [DetalleController::class,'estadistica']);
$router->get('/API/usuarios/estadisticaUsu', [DetalleController::class,'detalleUsuariosAPI']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
