<?php
    require 'log.php';
    date_default_timezone_set('America/El_Salvador');
    $fecha = date("Y-m-d");
    $user = $_SESSION['usuario'];

    $sqlCheckExistence = "SELECT COUNT(*) FROM registros WHERE fecha = ? AND user = ?";
    $stmtCheckExistence = $conn->prepare($sqlCheckExistence);
    $stmtCheckExistence->bind_param("ss", $fecha, $user);
    $stmtCheckExistence->execute();
    $stmtCheckExistence->bind_result($count);
    $stmtCheckExistence->fetch();
    $stmtCheckExistence->close();

    $mensaje = "";

    if ($count > 0) {
        $mensaje = "Ya existe un registro hecho el día de hoy";
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $horaEntrada = date("H:i");
            $proyecto = $_POST["op-proyectos"];
            
            $equipoSeleccionado = isset($_POST["seleccionar"]) && is_array($_POST["seleccionar"]) ? $_POST["seleccionar"] : [];
            $equipoSeleccionadoString = !empty($equipoSeleccionado) ? implode(",", $equipoSeleccionado) : '';            
            
            $anexo_contenido = file_get_contents($_FILES['anexo']['tmp_name']);
            $comentarios = $_POST["comentarios"];
            $nombre = $_SESSION['firstName'];
            $apellidos = $_SESSION['lastName'];
            $user = $_SESSION['usuario'];

          
            $sqlInsert = "INSERT INTO registros (proyecto, equipo, anexo, comentario, horaEntrada, fecha, firstName, lastName, user) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("sssssssss", $proyecto, $equipoSeleccionadoString, $anexo_contenido, $comentarios, $horaEntrada, $fecha, $nombre, $apellidos, $user);

            if ($stmtInsert->execute()) {
                header("Location:../../pages/user.php");
                exit();
            } else {
                echo "Error al registrar la entrada: " . $stmtInsert->error;
            }

            $stmtInsert->close();
        }
    }
?>
