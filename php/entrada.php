<?php
require 'connect.php';
require 'login.php';
$fecha = date("Y-m-d");
$user = $_SESSION['usuario'];

$sql = "SELECT COUNT(*) FROM user WHERE fecha = ? AND user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $fecha, $user);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

$mensaje = "";

if ($count > 0) {
    $mensaje = "Ya existe un registro hecho el dia de hoy";
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        date_default_timezone_set('America/El_Salvador');
        $horaEntrada = date("H:i");
        $fecha = date("Y-m-d");
        $proyecto = $_POST["op-proyectos"];
        
        $equipoSeleccionado = isset($_POST["seleccionar"]) && is_array($_POST["seleccionar"]) ? $_POST["seleccionar"] : [];

        $equipoSeleccionadoString = !empty($equipoSeleccionado) ? implode(",", $equipoSeleccionado) : '';

        $anexo_contenido = file_get_contents($_FILES['anexo']['tmp_name']);
        $comentarios = $_POST["comentarios"];
        $nombre = $_SESSION['firstName'];
        $apellidos = $_SESSION['lastName'];
        $user = $_SESSION['usuario'];

        $sql = "INSERT INTO user (proyecto, equipo, anexo, comentario, horaEntrada, fecha, firstName, lastName, user) 
        VALUES ('$proyecto', ?, ?, ?, '$horaEntrada', ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssssss", $equipoSeleccionadoString, $anexo_contenido, $comentarios, $fecha, $nombre, $apellidos, $user);

            if ($stmt->execute()) {
                header("Location:../html/user.php");
            } else {
                echo "Error al registrar la entrada: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}
?>
