const actualizarDatosModal = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/obtenerInformacionProfesor/${id}`,            
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
            Swal.fire({
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
        url : `http://localhost:2002/public/admin/obtenerDetalleMateria/${id}`,            
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
            Swal.fire({
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
        url : `http://localhost:2002/public/admin/obtenerInformacionProfesor/${id}`,            
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
            Swal.fire({
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
        url : `http://localhost:2002/public/admin/obtenerInformacionProfesor/${id}`,            
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
            Swal.fire({
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
        url : `http://localhost:2002/public/admin/obtenerInformacionProfesor/${id}`,            
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
            Swal.fire({
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
        url : `http://localhost:2002/public/profesor/obtenerNotas/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {nota, idNota} = data;
            $('#notaA').val(idNota);
            $('#txtNota').val(nota);
            
            $('#modalNotas').modal('show');                        
        },
    
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error : function(xhr, status) {
            Swal.fire({
                title: "Error",
                text: "Ha ocurrido un error al mostrar los datos, pongase en contacto con el administrador",
                icon: "error",
                button: "OK",
            })
        },       
    });
}