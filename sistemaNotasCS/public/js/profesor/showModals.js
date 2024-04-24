const actualizarDatosModal = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/admin/obtenerInformacionProfesor/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {DUI, nombres, apellidos, correo} = data;
            $('#dui').val(id);
            $('#nombre').val(nombres);
            $('#apellido').val(apellidos);                    
            $('#correo').val(correo);
            
            $('#modalDatosProfesor').modal('show');                        
        },
    
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error : function(xhr, status) {
            swal({
                title: "Error",
                text: "Ha ocurrido un error al mostrar los datos, pongase en contacto con el administrador",
                icon: "error",
                button: "OK",
            })
        },       
    });
}

const eliminarMateria = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/admin/obtenerDetalleMateria/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {idMateria, nombreMateria,idProfesor, idDetalle} = data;
            $('#idJ').val(data.nombreMateria);
            $('#idA').val(data.idDetalle);
            $('#textoConfirmarEliminar').text('¿Está seguro que desea eliminar la materia '+nombreMateria+'?');
            
            $('#eliminarMateria').modal('show');                        
        },
    
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error : function(xhr, status) {
            swal({
                title: "Error",
                text: "Ha ocurrido un error al mostrar los datos, pongase en contacto con el administrador",
                icon: "error",
                button: "OK",
            })
        },       
    });
}

const agregarMaterias = () => {
    $('#modalAddMateria').modal('show');
}

const actualizarFotoModal = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/admin/obtenerInformacionProfesor/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {DUI} = data;
            $('#id').val(id);
            
            $('#modalFotoProfesor').modal('show');                        
        },
    
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error : function(xhr, status) {
            swal({
                title: "Error",
                text: "Ha ocurrido un error al mostrar los datos, pongase en contacto con el administrador",
                icon: "error",
                button: "OK",
            })
        },       
    });
}

const eliminarProfesor = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/admin/obtenerInformacionProfesor/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {DUI, nombres, apellidos} = data;
            $('#id').val(id);
            $('#textoConfirmarEliminar').text('¿Está seguro que desea eliminar al profesor '+nombres+' '+apellidos+'?');
            
            $('#eliminarProfesor').modal('show');                        
        },
    
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error : function(xhr, status) {
            swal({
                title: "Error",
                text: "Ha ocurrido un error al mostrar los datos, pongase en contacto con el administrador",
                icon: "error",
                button: "OK",
            })
        },       
    });
}

const reactivarProfesor = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/admin/obtenerInformacionProfesor/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {DUI, nombres, apellidos} = data;
            $('#idR').val(id);
            $('#textoConfirmarReactivar').text('¿Está seguro que desea reactivar al profesor '+nombres+' '+apellidos+'?');
            
            $('#reactivarProfesor').modal('show');                        
        },
    
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error : function(xhr, status) {
            swal({
                title: "Error",
                text: "Ha ocurrido un error al mostrar los datos, pongase en contacto con el administrador",
                icon: "error",
                button: "OK",
            })
        },       
    });
}

const actualizarNota11 = (evaluacion, grupo) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000//mostrarNotas/${evaluacion}/${grupo}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {nota, nombres, apellidos, evaluacion, grupo} = data;
            $('#grupo').val(grupo);
            $('#textoConfirmarReactivar').text('¿Está seguro que desea modificar la contraseña al estudiante '+nombres+' '+apellidos+'?');
            
            $('#modalNotas').modal('show');                        
        },
    
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error : function(xhr, status) {
            swal({
                title: "Error",
                text: "Ha ocurrido un error al mostrar los datos, pongase en contacto con el administrador",
                icon: "error",
                button: "OK",
            })
        },       
    });
}

const actualizarNota = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://127.0.0.1:8000/profesor/obtenerNotas/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {nota, idNota} = data;
            $('#notaA').val(idNota);
            $('#notaActual').text(nota);
            $('#textoConfirmarReactivar').text('¿Está seguro que desea modificar la contraseña al estudiante?');
            
            $('#modalNotas').modal('show');                        
        },
    
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error : function(xhr, status) {
            swal({
                title: "Error",
                text: "Ha ocurrido un error al mostrar los datos, pongase en contacto con el administrador",
                icon: "error",
                button: "OK",
            })
        },       
    });
}