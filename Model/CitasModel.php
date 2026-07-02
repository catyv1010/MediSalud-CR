<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/UtilitarioModel.php';

    // el SP valida que el horario este libre, si esta ocupado lanza error
    function AgendarCitaModel($pacienteId, $medicoId, $fecha, $hora, $motivo)
    {
        try
        {
            $conn = OpenDB();

            $fecha  = $conn -> real_escape_string($fecha);
            $hora   = $conn -> real_escape_string($hora);
            $motivo = $conn -> real_escape_string($motivo);

            $sql = "CALL sp_agendar_cita($pacienteId,$medicoId,'$fecha','$hora','$motivo')";
            $response = $conn -> query($sql);

            $datos = null;
            while($fila = $response -> fetch_assoc())
            {
                $datos = $fila;
            }

            CloseDB($conn);
            return ($datos != null) ? $datos['cita_id'] : false;
        }
        catch(Exception $e)
        {
            AddError($e, 'AgendarCitaModel');
            return false;
        }
    }

    // el SP exige 24 horas de anticipacion, si no cumple lanza error
    function CancelarCitaModel($citaId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_cancelar_cita($citaId)";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return true;
        }
        catch(Exception $e)
        {
            AddError($e, 'CancelarCitaModel');
            return false;
        }
    }

    function ListarCitasPacienteModel($pacienteId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_listar_citas_paciente($pacienteId)";
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
            AddError($e, 'ListarCitasPacienteModel');
            return array();
        }
    }

    function ListarCitasMedicoModel($medicoId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_listar_citas_medico($medicoId)";
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
            AddError($e, 'ListarCitasMedicoModel');
            return array();
        }
    }

    function AgendaDiariaMedicoModel($medicoId, $fecha)
    {
        try
        {
            $conn = OpenDB();

            $fecha = $conn -> real_escape_string($fecha);

            $sql = "CALL sp_agenda_diaria_medico($medicoId,'$fecha')";
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
            AddError($e, 'AgendaDiariaMedicoModel');
            return array();
        }
    }

    function ListarCitasAdminModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_listar_citas_admin()";
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
            AddError($e, 'ListarCitasAdminModel');
            return array();
        }
    }

    function ActualizarEstadoCitaModel($citaId, $estadoId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_actualizar_estado_cita($citaId,$estadoId)";
            $response = $conn -> query($sql);

            CloseDB($conn);
            return true;
        }
        catch(Exception $e)
        {
            AddError($e, 'ActualizarEstadoCitaModel');
            return false;
        }
    }

    function DatosCitaModel($citaId)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_datos_cita($citaId)";
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
            AddError($e, 'DatosCitaModel');
            return null;
        }
    }

    function CitasDelMesModel($mes, $anio)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_citas_del_mes($mes,$anio)";
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
            AddError($e, 'CitasDelMesModel');
            return array();
        }
    }

    function ReporteMensualModel($mes, $anio)
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_reporte_mensual($mes,$anio)";
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
            AddError($e, 'ReporteMensualModel');
            return array();
        }
    }

    function ContadoresPanelModel()
    {
        try
        {
            $conn = OpenDB();

            $sql = "CALL sp_contadores_panel()";
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
            AddError($e, 'ContadoresPanelModel');
            return null;
        }
    }
