const agregarSeccion = () => {
    $('#agregarSeccion').modal('show');
}

const agregarEstudiantes = () => {
    $('#agregarEstudiantes').modal('show');
}

const asignarProfesor = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/getProfesoresPorMateria/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            //const {} = data;
            $('#año').val(id);
            texto = '<select class="form-select" name="profesor" aria-label="Default select example"><option value="0" selected>Seleccione un profesor</option>';
            for(i=0; i < data.length; i++){
                texto+='<option value="'+data[i].idProfesor+'">'+data[i].nombres+' '+data[i].apellidos+'</option>';
            }
            texto+= '</select>';
            $("#selectdiv").html(texto);
            
            $('#asignarProfesor').modal('show');                        
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