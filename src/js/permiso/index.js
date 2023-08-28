import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion} from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje  } from "../lenguaje";


const formulario = document.querySelector('form')
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const divPassword = document.getElementById('usu_password');

divPassword.parentElement.style.display = 'none';

btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'



let contador = 1; 
const datatable = new Datatable('#tablaPermisos', {
    language : lenguaje,
    data : null,
    columns: [
        {
            title : 'NO',
            render : () => contador ++
            
        },
        // { title: 'NOMBRE', 
        // data: 'usu_nombre' },

        // { title: 'APELLIDO', 
        // data: 'usu_apellido' },

        // { title: 'NOMBRE DE USUARIO', 
        // data: 'usu_usuario' },
        {
            title : 'USUARIO',
            data: 'permiso_usuario'
        },
        {
            title : 'PERMISO',
            data: 'permiso_rol',
        },
        {
            title : 'ESTADO',
            data: 'usu_estado',
        },
        {
            title : 'MODIFICAR',
            data: 'permiso_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-usuario='${row["permiso_usuario"]}' data-rol='${row["permiso_rol"]}' >Modificar</button>`
        },
        {
            title : 'ELIMINAR',
            data: 'permiso_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
        {
            title : 'ACTIVAR',
            data: 'usu_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => row['usu_estado'].trim()==='PENDIENTE' || row['usu_estado'].trim()==='INACTIVO'? `<button class="btn btn-success" data-id='${data}' >Activar</button>` :''
        },
        {
            title : 'DESACTIVAR',
            data: 'usu_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => row['usu_estado'].trim()==='ACTIVO'? `<button class="btn btn-info" data-id='${data}' >DESACTIVAR</button>`: ''
        },
    ]
})

//buscar 

const buscar = async () => {
    let permiso_usuario = formulario.permiso_usuario.value;
    let permiso_rol = formulario.permiso_rol.value;
    const url = `/exam_parcial/API/permisos/buscar?permiso_usuario=${permiso_usuario}&permiso_rol=${permiso_rol}`;
    const config = {
        method : 'GET'
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        datatable.clear().draw()
        if(data){
            contador = 1;
            datatable.rows.add(data).draw();
        }else{
            Toast.fire({
                title : 'No se encontraron registros',
                icon : 'info'
            })
        }
       
    } catch (error) {
        console.log(error);
    }
}


//guardar

const guardar = async (evento) => {
    evento.preventDefault();
    if(!validarFormulario(formulario, ['permiso_id'])){
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return 
    }

    const body = new FormData(formulario)
    body.delete('permiso_id')
    const url = '/exam_parcial/API/permisos/guardar';
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");
    const config = {
        method : 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

       
        const {codigo, mensaje,detalle} = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                break;
        
            case 0:
                icon = 'error'
                console.log(detalle)
                break;
        
            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

//traer y colocar los datos

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const usuario = button.dataset.usuario;
    const rol = button.dataset.rol;

    const dataset = {
        id,
        usuario,
        rol
    };
    colocarDatos(dataset);
        const body = new FormData(formulario);
        body.append('permiso_id', id);
        body.append('permiso_usuario', usuario);
        body.append('permiso_rol', rol); 
        const passwordInput = formulario.usu_password;
        formulario.usu_password.value = dataset.password;
        passwordInput.readOnly = true;

        divPassword.parentElement.style.display = ' block';
};


////modificar 

const modificar = async () => {
    if(!validarFormulario(formulario)){
        alert('Debe llenar todos los campos');
        return 
    }

    const { value: newPassword } = await Swal.fire({
        title: 'Ingrese la nueva contraseña:',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off',
            autocorrect: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => {
            if (!value) {
                return 'Debe ingresar una contraseña';
            }
        }
    });

    if (newPassword === undefined) {
        return;
    }

    const id = formulario.permiso_id.value;
    const permiso_usuario = formulario.permiso_usuario.value;
    const permiso_rol = formulario.permiso_rol.value;

    

    const url = '/exam_parcial/API/permisos/modificar';
    const body = new FormData(formulario)
    body.append('permiso_id', id);
    body.append('usu_password', newPassword);
    body.append('permiso_usuario', permiso_usuario);
    body.append('permiso_rol', permiso_rol);
    const config = {
        method : 'POST',
        body
    }


    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();
        // console.log(data)
        // return;
        const {codigo, mensaje,detalle} = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.usu_password.value = newPassword;
                formulario.reset();
                icon = 'success'
                buscar();
                cancelarAccion();
                break;
        
            case 0:
                icon = 'error'
                console.log(detalle)
                break;
        
            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

///eliminar


const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id
    // console.log(id)
    if(await confirmacion('warning','¿Desea eliminar este registro?')){
        const body = new FormData()
        body.append('permiso_id', id)
        const url = '/exam_parcial/API/permisos/eliminar';
        const headers = new Headers();
        headers.append("X-Requested-With","fetch");
        const config = {
            method : 'POST',
            body
        }
        try {
            const respuesta = await fetch(url, config)
            const data = await respuesta.json();
            // console.log(data)
            const {codigo, mensaje,detalle} = data;
    
            let icon = 'info'
            switch (codigo) {
                case 1:
                    icon = 'success'
                    buscar();
                    break;
            
                case 0:
                    icon = 'error'
                    console.log(detalle)
                    break;
            
                default:
                    break;
            }
    
            Toast.fire({
                icon,
                text: mensaje
            })
    
        } catch (error) {
            console.log(error);
        }
    }
}

/// activar y desactivar usuario 



const activar = async (e) => {
    const button = e.target;
    const id = button.dataset.id
    
    console.log(id)
    if(await confirmacion('warning','¿Desea activar este usuario?')){
        const body = new FormData()
        body.append('usu_id', id)
        const url = '/exam_parcial/API/permisos/activar';
        const headers = new Headers();
        headers.append("X-Requested-With","fetch");
        const config = {
            method : 'POST',
            body
        }
        try {
            
            const respuesta = await fetch(url, config)    
            const data = await respuesta.json();
            const {codigo, mensaje} = data;
    
            let icon = 'info'
            switch (codigo) {
                case 1:
                    icon = 'success'
                    buscar();
                    break;
            
                case 0:
                    icon = 'error'
                    console.log(mensaje)
                    break;
            
                default:
                    break;
            }
    
            Toast.fire({
                icon,
                text: mensaje
            })
    
        } catch (error) {
            console.log(error);
        }
    }
}

const desactivar = async (e) => {
    const button = e.target;
    const id = button.dataset.id
    
    console.log(id)
    if(await confirmacion('warning','¿Desea desactivar este usuario?')){
        const body = new FormData()
        body.append('usu_id', id)
        const url = '/exam_parcial/API/permisos/desactivar';
        const headers = new Headers();
        headers.append("X-Requested-With","fetch");
        const config = {
            method : 'POST',
            body
        }
        try {
            
            const respuesta = await fetch(url, config)    
            const data = await respuesta.json();
            const {codigo, mensaje} = data;
    
            let icon = 'info'
            switch (codigo) {
                case 1:
                    icon = 'success'
                    buscar();
                    break;
            
                case 0:
                    icon = 'error'
                    console.log(mensaje)
                    break;
            
                default:
                    break;
            }
    
            Toast.fire({
                icon,
                text: mensaje
            })
    
        } catch (error) {
            console.log(error);
        }
    }
}



// const buscarUsuario = async () => {
//     let usu_nombre = formulario.usu_nombre.value;
//     let usu_apellido = formulario.usu_apellido.value;
//     let usu_usuario = formulario.usu_usuario.value;

//     const url = `/exam_parcial/API/permisos/buscarUsuario?usu_nombre=${usu_nombre}&usu_apellido=${usu_apellido}&usu_usuario=${usu_usuario}`;
    
//     const config = {
//         method: 'GET'
//     }

//     try {
//         const respuesta = await fetch(url, config)
//         const data = await respuesta.json();

//         console.log(data);
//         datatable.clear().draw()
//         if(data){
//             contador = 1;
//             datatable.rows.add(data).draw();
            
//         }else{
//             Toast.fire({
//                 title : 'No se encontraron registros',
//                 icon : 'info'
//             })
//         }
       
//     } catch (error) {
//         console.log(error);
//     }
// }

/// colocar datos


const colocarDatos = (dataset) => {
    formulario.permiso_usuario.value = dataset.usuario;
    formulario.permiso_rol.value = dataset.rol;

    formulario.permiso_id.value = dataset.id;

    btnGuardar.disabled = true
    btnGuardar.parentElement.style.display = 'none';
    btnBuscar.disabled = true
    btnBuscar.parentElement.style.display = 'none';
    btnModificar.disabled = false
    btnModificar.parentElement.style.display = '';
    btnCancelar.disabled = false
    btnCancelar.parentElement.style.display = '';

  
}


///// cancelar accion

const cancelarAccion = () => {
    btnGuardar.disabled = false
    btnGuardar.parentElement.style.display = ''
    btnBuscar.disabled = false
    btnBuscar.parentElement.style.display = ''
    btnModificar.disabled = true
    btnModificar.parentElement.style.display = 'none'
    btnCancelar.disabled = true
    btnCancelar.parentElement.style.display = 'none'

    divPassword.parentElement.style.display = 'none';

   
}



buscar();

//datatable.on('click','.btn-warning', traeDatos )

formulario.addEventListener('submit', guardar)
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)
datatable.on('click','.btn-warning', traeDatos )
datatable.on('click','.btn-danger', eliminar )
datatable.on('click','.btn-success', activar )
datatable.on('click','.btn-info', desactivar )





