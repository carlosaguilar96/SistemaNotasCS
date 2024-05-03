const actualizarDatosModal = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/obtenerInformacionAdministrador/${id}`,            
        type : 'GET',        
        dataType : 'json',  
            
        success : function(data) {
            const {DUI, nombres, apellidos, correo} = data;
            $('#dui').val(id);
            $('#nombre').val(nombres);
            $('#apellido').val(apellidos);                    
            $('#correo').val(correo);
            
            $('#modalDatos').modal('show');                        
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

const actualizarFotoModal = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/obtenerInformacionAdministrador/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {DUI} = data;
            $('#id').val(id);
            
            $('#modalFotoAdmin').modal('show');                        
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

const eliminarAdministrador = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/obtenerInformacionAdministrador/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {DUI, nombres, apellidos} = data;
            $('#id').val(id);
            $('#textoConfirmarEliminar').text('¿Está seguro que desea eliminar al administrador '+nombres+' '+apellidos+'?');
            
            $('#eliminarAdministrador').modal('show');                        
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

const reactivarAdministrador = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/obtenerInformacionAdministrador/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {DUI, nombres, apellidos} = data;
            $('#idR').val(id);
            $('#textoConfirmarReactivar').text('¿Está seguro que desea reactivar al administrador '+nombres+' '+apellidos+'?');
            
            $('#reactivarAdmin').modal('show');                        
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