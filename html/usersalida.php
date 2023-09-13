<?php
    require '../php/connect.php';
    require '../php/salida.php';
    require '../php/tablauser.php';
    require '../php/opcionesuser.php';

    if (isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) {
        if ($_SESSION['account_type'] === 'admin') {
            header("location: ../html/admin.php");
            exit;
        } 
    }
    $nombre = $_SESSION['firstName'];
    $apellidos = $_SESSION['lastName'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Pagina de Salida</title>
</head>
<body>
    <div class="container">
        <header>
            <img class="logo" src="../img/logo.png" alt="logo de la empresa">
            <h3>Bienvenido <?php echo $nombre," ", $apellidos; ?></h3>
        </header>
        <form action="../php/salida.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <label for="anexo2">Inserte aqui el anexo:</label>
            <input id="anexo2" type="file" name="anexo2" required />
            <label for="comentarios2">Comentarios:</label>
                <textarea
                    id="comentarios2"
                    name="comentarios2"
                    rows="3"
                    cols="30"
                    placeholder="Ingresa alguna observacion"
                ></textarea>
            <input type="submit" value="Marcar Salida">
        </fieldset>           
        </form>
        <a href="../php/logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>