document.addEventListener("DOMContentLoaded", function(event) {    
    
    //Iniciando máscara para campos de texto
    var txtNIE = document.getElementById('nie');
    
    if(txtNIE != null) 
    {
        var maskOptions = {
            mask: '00000000'
        };
        var mask = IMask(txtNIE, maskOptions);
    }

    var txtCarnet = document.getElementById('carnet');
    
    if(txtCarnet != null) 
    {
        var maskOptions = {
            mask: 'aa000000'
        };
        var mask = IMask(txtCarnet, maskOptions);
    }

    var txtNombre = document.getElementById('nombre');
    
    const nombreMask = IMask(txtNombre, {
        mask: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/
    });

    var txtApellidos = document.getElementById('apellido');
    
    const apellidosMask = IMask(txtApellidos, {
        mask: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/
    });

    var txtCorreo = document.getElementById('correo');

    const correoMask = IMask(txtCorreo, {
        mask: /^\S+@?\S*$/
    });

    document.getElementById('fechaNacimiento').flatpickr({
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
    })
});