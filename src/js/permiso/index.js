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


btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'



let contador = 1; 
const datatable = new Datatable('#tablaClientes', {
    language : lenguaje,
    data : null,
    columns: [
        {
            title : 'NO',
            render : () => contador ++
            
        },
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

