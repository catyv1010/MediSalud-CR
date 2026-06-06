// =====================================================================
// medisalud.js - JavaScript propio del proyecto (con jQuery)
// Validacion visual de Bootstrap para los formularios y
// chequeo de que las dos contrasenas del registro coincidan.
// =====================================================================

$(function () {

    // validacion visual de Bootstrap: si el formulario tiene campos
    // invalidos, se bloquea el envio y se pintan los errores
    $("form.needs-validation").on("submit", function (e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass("was-validated");
    });

    // en el registro: las dos contrasenas deben coincidir
    $("#contrasena_confirmar").on("input", function () {
        var coincide = this.value === $("#contrasena").val();
        this.setCustomValidity(coincide ? "" : "Las contraseñas no coinciden");
    });

});
