<?php
    require '../php/forms/log.php';

    if (isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) {
        if ($_SESSION['account_type'] === 'admin') {
            header("location: admin.php");
            exit;
        }
    }

    if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName'])) {
        header("Location: login.php"); 
        exit;
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
    <link rel="stylesheet" href="../css/styleuser.css">
    <title>Pagina de Usuario</title>
</head>
<body>
    <div class="container">
        <header>
            <img class="logo" src="../img/logo.png" alt="logo de la empresa">
            <h3>Bienvenido <?php echo $nombre," ", $apellidos; ?></h3>
        </header>
        <a href="userentrada.php"><button>Marcar Entrada</button></a>
        <a href="usersalida.php"><button>Marcar Salida</button></a>
        <a href="../php/functions/logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>