const agregarMateria = () => {
    $('#agregarMateria').modal('show');
}

const updateMateria = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/getMateria/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {idMateria, nombreMateria} = data;
            $('#idU').val(idMateria);
            $('#nombreU').val(nombreMateria);
            
            $('#updateMateria').modal('show');                        
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
        url : `http://localhost:2002/public/admin/getMateria/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {idMateria, nombreMateria} = data;
            $('#idE').val(idMateria);
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

const restoreMateria = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/getMateria/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {idMateria, nombreMateria} = data;
            $('#idR').val(idMateria);
            $('#textoConfirmarReactivar').text('¿Está seguro que desea reactivar la materia '+nombreMateria+'?');
            
            $('#reactivarMateria').modal('show');                        
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