// validaciones del formulario de especialidades

$(function () {

    $("#form-especialidad").validate({
        rules: {
            nombre: { required: true, maxlength: 100 }
        },
        messages: {
            nombre: { required: "Ingrese el nombre de la especialidad", maxlength: "Máximo 100 caracteres" }
        }
    });

});
