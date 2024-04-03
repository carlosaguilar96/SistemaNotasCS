document.addEventListener("DOMContentLoaded", function(event) {    
    
    //Iniciando máscara para campos de texto
    var txtDUI = document.getElementById('dui');
    
    if(txtDUI != null)
    {
        var maskOptions = {
            mask: '00000000-0'
        };
        var mask = IMask(txtDUI, maskOptions);
    }

    var txtCarnet = document.getElementById('carnet');
    
    const carnetMask = IMask(txtCarnet, {
        mask: /^[a-zA-Z.]+$/
    });

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

});