<?php

    // conexion a la base, si cambia el puerto solo se toca aqui
    function OpenDB()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        return new mysqli("127.0.0.1:3307", "root", "", "medisalud_cr");
    }

    function CloseDB($conn)
    {
        $conn -> close();
    }

    // guarda los errores en la bitacora de la base
    function AddError($error, $accion, $idUsuario)
    {
        try
        {
            $conn = OpenDB();

            $mensaje = $conn -> real_escape_string($error -> getMessage());

            $sql = "CALL sp_registrar_error('$mensaje', '$accion', $idUsuario)";
            $conn -> query($sql);

            CloseDB($conn);
        }
        catch(Exception $e)
        {
            // si ni la bitacora funciona no hay nada mas que hacer
        }
    }
