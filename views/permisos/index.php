<h1 class="text-center">ASIGNACION DE ROL</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioPermiso">
        <input type="hidden" name="permiso_id" id="permiso_id">
        <!-- se agregara este input para cambiar la contraseña -->
        
        <!-- <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <div id="usu_password"  class="col">
                    <label for="usu_password">Presione para cambiar la contrasena</label>
                    <input type="password" name="usu_password" id="usu_password" class="form-control">
                </div>
            </div>
        </div> -->
        <div class="row mb-3">
            <div class="col">
                <label for="permiso_usuario">USUARIO</label>
                <select name="permiso_usuario" id="permiso_usuario" class="form-control">
                    <option value="">SELECCIONE...</option>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <option value="<?= $usuario['usu_id'] ?>"><?= $usuario['usu_nombre'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="permiso_rol">ASIGNAR UN ROL</label>
                <select name="permiso_rol" id="permiso_rol" class="form-control">
                    <option value="">SELECCIONE...</option>
                    <?php foreach ($roles as $rol) : ?>
                        <option value="<?= $rol['rol_id'] ?>"><?= $rol['rol_nombre'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioPermiso" id="btnGuardar" data-saludo="hola" class="btn btn-primary w-100">Guardar</button>
            </div>
            <div class="col">
                <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
            </div>
            <div class="col">
                <button type="button" id="btnBuscar" class="btn btn-info w-100">Buscar</button>
            </div>
            <div class="col">
                <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
            </div>
        </div>
    </form>
</div>
<!-- Vista para cambiar contraseña -->
<div id="contenedorContraseña">
    <h2>Cambiar Contraseña</h2>
    <form id="formularioContraseña">
        <div class="row mb-3">
            <div class="col">
                <label for="nuevaContraseña">Nueva Contraseña:</label>
                <input type="password" id="nuevaContraseña" class="form-control" required>
            </div>
        </div>
        <button type="button" id="btnCambiarContraseña" class="btn btn-primary">Cambiar Contraseña</button>
        <button type="button" id="btnCancelarContraseña" class="btn btn-secondary">Cancelar</button>
    </form>
</div>

<h1>Datatable de listado de usuario</h1>
<div class="row justify-content-center">
    <div class="col table-responsive">
        <table id="tablaPermisos" class="table table-bordered table-hover">
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/permiso/index.js') ?>"></script>