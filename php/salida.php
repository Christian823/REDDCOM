<?php
require 'login.php';
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('America/El_Salvador');
    $horaSalida = date("H:i");
    $fecha = date("Y-m-d");
    $anexo_contenido = file_get_contents($_FILES['anexo2']['tmp_name']);
    $comentarios = $_POST["comentarios2"];
    $nombre = $_SESSION['firstName'];
    $apellidos = $_SESSION['lastName'];

    $sql = "UPDATE user 
            SET anexo2 = ?, comentario2 = ?, horaSalida = ? 
            WHERE fecha = ? AND firstName = ? AND lastName = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $anexo_contenido, $comentarios, $horaSalida, $fecha, $nombre, $apellidos);

        if ($stmt->execute()) {
            header("Location:../html/user.php");
        } else {
            echo "Error al registrar la entrada: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>