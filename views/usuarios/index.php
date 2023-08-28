<div class="container mt-5">
        <div class="text-center mb-4">
            <h2 class="text-primary">REGISTRO DE USUARIOS</h2>
        </div>
        <div class="row justify-content-center">
            <form class="col-lg-4 border rounded p-3" id="formularioUsuarios">
                <div class="mb-3">
                    <label for="usu_nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="usu_nombre" name="usu_nombre" placeholder="Ejemplo: BRIAN" autocomplete="username">
                </div>
                <div class="mb-3">
                    <label for="usu_apellido" class="form-label">apellido</label>
                    <input type="text" class="form-control" id="usu_apellido" name="usu_apellido" placeholder="Ejemplo: MARIN"autocomplete="username">
                </div>
                <div class="mb-3">
                    <label for="usu_usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usu_usuario" name="usu_usuario" placeholder="Ejemplo: brian13">
                    <span class="small text-muted">Ingresa un nombre de usuario que utilizaras para ingresar.</span>
                </div>
                <div class="mb-3">
                    <label for="usu_password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="usu_password" name="usu_password" autocomplete="new-password" placeholder="Ingrese al menos 8 caracteres">
                </div>
                <div class="col">
                    <button type="submit" form="formularioUsuarios" id="btnCambiarContrasena" class="btn btn-primary w-100">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="<?= asset('./build/js/usuario/index.js') ?>"></script>