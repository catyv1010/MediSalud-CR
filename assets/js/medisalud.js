// js propio del proyecto (jquery)

$(function () {

    // validacion de bootstrap: si hay campos malos no se envia y se pintan los errores
    $("form.needs-validation").on("submit", function (e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass("was-validated");
    });

    // las dos contrasenas del registro deben coincidir
    $("#contrasena_confirmar").on("input", function () {
        var coincide = this.value === $("#contrasena").val();
        this.setCustomValidity(coincide ? "" : "Las contraseñas no coinciden");
    });

});
