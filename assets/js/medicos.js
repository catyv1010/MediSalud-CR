// validaciones de los formularios de medicos (registrar y editar)

$(function () {

    $("#form-medico").validate({
        rules: {
            cedula: { required: true, maxlength: 20 },
            nombre: { required: true },
            correo: { required: true, email: true },
            especialidad: { required: true },
            colegiado: { required: true, maxlength: 50 },
            contrasena: { required: true, minlength: 6, maxlength: 20 }
        },
        messages: {
            cedula: { required: "Ingrese la cédula", maxlength: "Máximo 20 caracteres" },
            nombre: { required: "Ingrese el nombre completo" },
            correo: { required: "Ingrese el correo", email: "El correo no tiene un formato válido" },
            especialidad: { required: "Seleccione la especialidad" },
            colegiado: { required: "Ingrese el número de colegiado", maxlength: "Máximo 50 caracteres" },
            contrasena: { required: "Ingrese la contraseña temporal", minlength: "Mínimo 6 caracteres", maxlength: "Máximo 20 caracteres" }
        }
    });

    $("#form-editar-medico").validate({
        rules: {
            nombre: { required: true },
            especialidad: { required: true },
            colegiado: { required: true, maxlength: 50 }
        },
        messages: {
            nombre: { required: "Ingrese el nombre completo" },
            especialidad: { required: "Seleccione la especialidad" },
            colegiado: { required: "Ingrese el número de colegiado", maxlength: "Máximo 50 caracteres" }
        }
    });

});
