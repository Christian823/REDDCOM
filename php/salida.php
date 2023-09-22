<?php
require 'login.php';
require 'connect.php';
$usuario = $_SESSION['usuario'];
$horaSalida = "";
$fecha = date("Y-m-d");

// Consulta para obtener la hora de salida existente
$sqlHoraSalida = "SELECT horaSalida FROM user WHERE horaSalida <> '' AND user = ? AND fecha = ?";
$stmtHoraSalida = $conn->prepare($sqlHoraSalida);
$stmtHoraSalida->bind_param("ss", $usuario, $fecha);
$stmtHoraSalida->execute();
$stmtHoraSalida->bind_result($horaSalidaExistente);
$stmtHoraSalida->fetch();
$stmtHoraSalida->close();

$mensaje = "";

if (!empty($horaSalidaExistente)) {
    $mensaje = "Ya existe un registro hecho el dia de hoy";
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        date_default_timezone_set('America/El_Salvador');
        $horaSalida = date("H:i");
    
        $sqlHoraEntrada = "SELECT horaEntrada FROM user WHERE user = ? AND fecha = ?";
        $stmtHoraEntrada = $conn->prepare($sqlHoraEntrada);
        $stmtHoraEntrada->bind_param("ss", $usuario, $fecha);
        $stmtHoraEntrada->execute();
        $stmtHoraEntrada->bind_result($horaEntradaString);
        $stmtHoraEntrada->fetch();
        $stmtHoraEntrada->close();
    
        $horaEntrada2 = new DateTime($horaEntradaString);
        $horaSalida2 = new DateTime($horaSalida);
        $intervalo = $horaSalida2->diff($horaEntrada2);
    
        $horasEXTRA = $intervalo->format('%H.%I');
        
        if ($horasEXTRA > 8) {
            $horasEXTRA = $horasEXTRA - 8;
        } else {
            $horasEXTRA = 0;
        }

        $anexo_contenido = file_get_contents($_FILES['anexo2']['tmp_name']);
        $comentarios = $_POST["comentarios2"];
        $nombre = $_SESSION['firstName'];
        $apellidos = $_SESSION['lastName'];

        $sql = "UPDATE user 
                SET anexo2 = ?, comentario2 = ?, horaSalida = ?, hextra = ?
                WHERE fecha = ? AND firstName = ? AND lastName = ? AND user = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssss", $anexo_contenido, $comentarios, $horaSalida, $horasEXTRA, $fecha, $nombre, $apellidos, $usuario);

            if ($stmt->execute()) {
                header("Location:../html/user.php");
            } else {
                echo "Error al registrar la salida: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

?>
