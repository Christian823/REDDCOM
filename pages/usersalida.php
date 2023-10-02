<?php
        require '../php/forms/salida.php';

    if (isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) {
        if ($_SESSION['account_type'] === 'admin' || $_SESSION['account_type'] === 'mod') {
            header("location: admin.php");
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
    <link rel="stylesheet" href="../css/stylesalida.css">
    <title>Pagina de Salida</title>
</head>
<body>
    <?php if (!empty($mensaje)) : ?>
        <div class="ventana">
        <h3>Comentario </h3>
        <?php echo $mensaje; ?>
        <a href="user.php"><button class="cerrar">&times;</button></a>                                
        </div>
        <div class="overlay"></div>
    <?php endif; ?>
    <div class="container">
        <header>
            <img class="logo" src="../img/logo.png" alt="logo de la empresa">
            <h3>Bienvenido <?php echo $nombre," ", $apellidos; ?></h3>
        </header>
        <form action="../php/forms/salida.php" method="post" enctype="multipart/form-data">
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
            <input class= "sumbit" type="submit" value="Marcar Salida">
        </fieldset>           
        </form>
        <a href="../php/functions/logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>