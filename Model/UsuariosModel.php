<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/UtilitarioModel.php';

    function IniciarSesionModel($identificacion, $contrasena)
    {
        try
        {
            $conn = OpenDB();

            $identificacion = $conn -> real_escape_string($identificacion);
            $contrasena     = $conn -> real_escape_string($contrasena);

            $sql = "CALL sp_iniciar_sesion('$identificacion','$contrasena')";
            $response = $conn -> query($sql);

            // se guarda el resultado antes de cerrar la conexion
            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'IniciarSesionModel');
            return null;
        }
    }

    function RegistrarPacienteModel($cedula, $correo, $contrasena, $nombre, $telefono, $fechaNacimiento, $genero, $direccion)
    {
        try
        {
            $conn = OpenDB();

            $cedula     = $conn -> real_escape_string($cedula);
            $correo     = $conn -> real_escape_string($correo);
            $contrasena = $conn -> real_escape_string($contrasena);
            $nombre     = $conn -> real_escape_string($nombre);
            $telefono   = $conn -> real_escape_string($telefono);
            $direccion  = $conn -> real_escape_string($direccion);

            // los opcionales vacios se mandan como NULL
            $fechaNacimiento = ($fechaNacimiento == '') ? "NULL" : "'$fechaNacimiento'";
            $genero          = ($genero == '')          ? "NULL" : "'$genero'";

            $sql = "CALL sp_registrar_paciente('$cedula','$correo','$contrasena','$nombre','$telefono',$fechaNacimiento,$genero,'$direccion')";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'RegistrarPacienteModel');
            return false;
        }
    }

    // valida que el correo exista y este activo, devuelve los datos del usuario
    function ValidarCorreoModel($correo)
    {
        try
        {
            $conn = OpenDB();

            $correo = $conn -> real_escape_string($correo);

            $sql = "CALL sp_validar_correo('$correo')";
            $response = $conn -> query($sql);

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ValidarCorreoModel');
            return null;
        }
    }

    // le pone al usuario la contrasena temporal generada
    function ActualizarContrasenaModel($usuarioId, $contrasena)
    {
        try
        {
            $conn = OpenDB();

            $contrasena = $conn -> real_escape_string($contrasena);

            $sql = "CALL sp_actualizar_contrasena($usuarioId,'$contrasena')";
            $response = $conn -> query($sql);

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            CloseDB($conn);
            return ($datos != null && $datos['resultado'] == 'OK');
        }
        catch(Exception $e)
        {
            AddError($e, 'ActualizarContrasenaModel');
            return false;
        }
    }

    // cambio de contrasena con sesion iniciada, el SP valida la actual
    function CambiarContrasenaModel($usuarioId, $actual, $nueva)
    {
        try
        {
            $conn = OpenDB();

            $actual = $conn -> real_escape_string($actual);
            $nueva  = $conn -> real_escape_string($nueva);

            $sql = "CALL sp_cambiar_contrasena($usuarioId,'$actual','$nueva')";
            $response = $conn -> query($sql);

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            CloseDB($conn);
            return ($datos != null) ? $datos['resultado'] : 'ERROR';
        }
        catch(Exception $e)
        {
            AddError($e, 'CambiarContrasenaModel');
            return 'ERROR';
        }
    }

    // datos actuales del usuario, para precargar la pantalla de mi perfil
    function ConsultarUsuarioModel($usuarioId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_consultar_usuario($usuarioId)";
            $response = $conn -> query($sql);

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ConsultarUsuarioModel');
            return null;
        }
    }

    // actualiza los datos personales desde la pantalla de mi perfil
    function ActualizarPerfilModel($usuarioId, $cedula, $nombre, $correo, $telefono)
    {
        try
        {
            $conn = OpenDB();

            $cedula   = $conn -> real_escape_string($cedula);
            $nombre   = $conn -> real_escape_string($nombre);
            $correo   = $conn -> real_escape_string($correo);
            $telefono = $conn -> real_escape_string($telefono);

            $sql = "CALL sp_actualizar_perfil($usuarioId,'$cedula','$nombre','$correo','$telefono')";
            $response = $conn -> query($sql);

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            CloseDB($conn);
            return ($datos != null && $datos['resultado'] == 'OK');
        }
        catch(Exception $e)
        {
            AddError($e, 'ActualizarPerfilModel');
            return false;
        }
    }

    function ObtenerPacienteModel($usuarioId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_obtener_paciente($usuarioId)";
            $response = $conn -> query($sql);

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ObtenerPacienteModel');
            return null;
        }
    }

    function ObtenerMedicoModel($usuarioId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_obtener_medico($usuarioId)";
            $response = $conn -> query($sql);

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ObtenerMedicoModel');
            return null;
        }
    }

    function ListarUsuariosModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_listar_usuarios()";
            $response = $conn -> query($sql);

            $datos = array();
            while($fila = $response -> fetch_assoc())
            {
                $datos[] = $fila;
            }

            CloseDB($conn);
            return $datos;
        }
        catch(Exception $e)
        {
            AddError($e, 'ListarUsuariosModel');
            return array();
        }
    }

    // activa o desactiva un usuario (1 o 0)
    function CambiarEstadoUsuarioModel($usuarioId, $activo)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_cambiar_estado_usuario($usuarioId,$activo)";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return true;
        }
        catch(Exception $e)
        {
            AddError($e, 'CambiarEstadoUsuarioModel');
            return false;
        }
    }
