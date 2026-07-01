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
            AddError($e, 'IniciarSesionModel', 0);
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
            AddError($e, 'RegistrarPacienteModel', 0);
            return false;
        }
    }

    function ObtenerUsuarioPorCorreoModel($correo)
    {
        try
        {
            $conn = OpenDB();

            $correo = $conn -> real_escape_string($correo);

            $sql = "CALL sp_obtener_usuario_por_correo('$correo')";
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
            AddError($e, 'ObtenerUsuarioPorCorreoModel', 0);
            return null;
        }
    }

    function GuardarTokenModel($usuarioId, $token, $minutos)
    {
        try
        {
            $conn = OpenDB();

            $token = $conn -> real_escape_string($token);

            $sql = "CALL sp_guardar_token($usuarioId,'$token',$minutos)";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return true;
        }
        catch(Exception $e)
        {
            AddError($e, 'GuardarTokenModel', $usuarioId);
            return false;
        }
    }

    function ValidarTokenModel($token)
    {
        try
        {
            $conn = OpenDB();

            $token = $conn -> real_escape_string($token);

            $sql = "CALL sp_validar_token('$token')";
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
            AddError($e, 'ValidarTokenModel', 0);
            return null;
        }
    }

    function RestablecerContrasenaModel($token, $contrasena)
    {
        try
        {
            $conn = OpenDB();

            $token      = $conn -> real_escape_string($token);
            $contrasena = $conn -> real_escape_string($contrasena);

            $sql = "CALL sp_restablecer_contrasena('$token','$contrasena')";
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
            AddError($e, 'RestablecerContrasenaModel', 0);
            return false;
        }
    }

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
            AddError($e, 'CambiarContrasenaModel', $usuarioId);
            return 'ERROR';
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
            AddError($e, 'ObtenerPacienteModel', $usuarioId);
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
            AddError($e, 'ObtenerMedicoModel', $usuarioId);
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
            AddError($e, 'ListarUsuariosModel', 0);
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
            AddError($e, 'CambiarEstadoUsuarioModel', $usuarioId);
            return false;
        }
    }
