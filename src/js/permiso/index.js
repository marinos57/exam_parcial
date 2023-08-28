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
};


