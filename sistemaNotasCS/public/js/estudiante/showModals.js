const actualizarDatosModal = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/obtenerInformacionEstudiante/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {NIE, carnet, nombres, apellidos, fechaNacimiento, sexo, correo} = data;
            $('#nie').val(NIE);
            $('#carnet').val(carnet);
            $('#nombre').val(nombres);
            $('#apellido').val(apellidos);          
            $('#fechaNacimiento').val(fechaNacimiento);           
            $('#correo').val(correo);
            $("#sexo option[value='"+sexo+"']").attr("selected",true);
            $('#fechaNacimiento').flatpickr({
                "maxDate": "today",      
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
                    }, 
                    months: {
                        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                        longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    },
                },
                "defaultDate": fechaNacimiento,
            })
            
            $('#modalDatos').modal('show');                        
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

const actualizarFotoModal = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/obtenerInformacionEstudiante/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {NIE} = data;
            $('#id').val(NIE);
            
            $('#modalFoto').modal('show');                        
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

const eliminarEstudiante = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/obtenerInformacionEstudiante/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {NIE, nombres, apellidos} = data;
            $('#id').val(id);
            $('#textoConfirmarEliminar').text('¿Está seguro que desea eliminar al estudiante '+nombres+' '+apellidos+'?');
            
            $('#eliminarEstudiante').modal('show');                        
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

const reactivarEstudiante = (id) => {

    $.ajax({
        // la URL para la petición
        url : `http://localhost:2002/public/admin/obtenerInformacionEstudiante/${id}`,            
        type : 'GET',        
        dataType : 'json',
            
        success : function(data) {
            const {DUI, nombres, apellidos} = data;
            $('#idR').val(id);
            $('#textoConfirmarReactivar').text('¿Está seguro que desea reactivar al estudiante '+nombres+' '+apellidos+'?');
            
            $('#reactivarEstudiante').modal('show');                        
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