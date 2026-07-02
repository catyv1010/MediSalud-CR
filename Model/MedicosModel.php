<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/UtilitarioModel.php';

    function ListarEspecialidadesModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_listar_especialidades()";
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
            AddError($e, 'ListarEspecialidadesModel');
            return array();
        }
    }

    function MedicosPorEspecialidadModel($especialidadId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_medicos_por_especialidad($especialidadId)";
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
            AddError($e, 'MedicosPorEspecialidadModel');
            return array();
        }
    }

    function FranjasMedicoModel($medicoId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_franjas_medico($medicoId)";
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
            AddError($e, 'FranjasMedicoModel');
            return array();
        }
    }

    function HorasOcupadasModel($medicoId, $fecha)
    {
        try
        {
            $conn = OpenDB();

            $fecha = $conn -> real_escape_string($fecha);

            $sql = "CALL sp_horas_ocupadas($medicoId,'$fecha')";
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
            AddError($e, 'HorasOcupadasModel');
            return array();
        }
    }

    function ListarMedicosAdminModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_listar_medicos_admin()";
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
            AddError($e, 'ListarMedicosAdminModel');
            return array();
        }
    }

    function CrearMedicoModel($cedula, $correo, $contrasena, $nombre, $telefono, $especialidadId, $colegiado)
    {
        try
        {
            $conn = OpenDB();

            $cedula     = $conn -> real_escape_string($cedula);
            $correo     = $conn -> real_escape_string($correo);
            $contrasena = $conn -> real_escape_string($contrasena);
            $nombre     = $conn -> real_escape_string($nombre);
            $telefono   = $conn -> real_escape_string($telefono);
            $colegiado  = $conn -> real_escape_string($colegiado);

            $sql = "CALL sp_crear_medico('$cedula','$correo','$contrasena','$nombre','$telefono',$especialidadId,'$colegiado')";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'CrearMedicoModel');
            return false;
        }
    }

    function ActualizarMedicoModel($medicoId, $nombre, $telefono, $especialidadId, $colegiado)
    {
        try
        {
            $conn = OpenDB();

            $nombre    = $conn -> real_escape_string($nombre);
            $telefono  = $conn -> real_escape_string($telefono);
            $colegiado = $conn -> real_escape_string($colegiado);

            $sql = "CALL sp_actualizar_medico($medicoId,'$nombre','$telefono',$especialidadId,'$colegiado')";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return true;
        }
        catch(Exception $e)
        {
            AddError($e, 'ActualizarMedicoModel');
            return false;
        }
    }

    function CrearEspecialidadModel($nombre, $descripcion)
    {
        try
        {
            $conn = OpenDB();

            $nombre      = $conn -> real_escape_string($nombre);
            $descripcion = $conn -> real_escape_string($descripcion);

            $sql = "CALL sp_crear_especialidad('$nombre','$descripcion')";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return $response;
        }
        catch(Exception $e)
        {
            AddError($e, 'CrearEspecialidadModel');
            return false;
        }
    }

    function ActualizarEspecialidadModel($id, $nombre, $descripcion)
    {
        try
        {
            $conn = OpenDB();

            $nombre      = $conn -> real_escape_string($nombre);
            $descripcion = $conn -> real_escape_string($descripcion);

            $sql = "CALL sp_actualizar_especialidad($id,'$nombre','$descripcion')";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return true;
        }
        catch(Exception $e)
        {
            AddError($e, 'ActualizarEspecialidadModel');
            return false;
        }
    }

    // si la especialidad tiene medicos asociados la base no deja borrarla
    function EliminarEspecialidadModel($id)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_eliminar_especialidad($id)";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return true;
        }
        catch(Exception $e)
        {
            AddError($e, 'EliminarEspecialidadModel');
            return false;
        }
    }

    function AgregarHorarioModel($medicoId, $diaSemana, $horaInicio, $horaFin)
    {
        try
        {
            $conn = OpenDB();

            $diaSemana  = $conn -> real_escape_string($diaSemana);
            $horaInicio = $conn -> real_escape_string($horaInicio);
            $horaFin    = $conn -> real_escape_string($horaFin);

            $sql = "CALL sp_agregar_horario($medicoId,'$diaSemana','$horaInicio','$horaFin')";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return true;
        }
        catch(Exception $e)
        {
            AddError($e, 'AgregarHorarioModel');
            return false;
        }
    }

    function EliminarHorarioModel($horarioId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_eliminar_horario($horarioId)";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return true;
        }
        catch(Exception $e)
        {
            AddError($e, 'EliminarHorarioModel');
            return false;
        }
    }
