const eliminarMateria = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/getDetalleGM/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {idDetalle, nombreMateria, nombreGrado, nombreEtapa} = data;
            $('#id').val(idDetalle);
            $('#textoConfirmarEliminar').text('¿Está seguro que desea eliminar la materia '+nombreMateria+' del plan académico '+nombreGrado+' de '+nombreEtapa+'?');
            
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

const agregarMateria = () => {
    $('#agregarMateria').modal('show');
}