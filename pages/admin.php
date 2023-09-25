<?php
    require '../php/forms/log.php';

    if (isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) {
        if ($_SESSION['account_type'] === 'user') {
            header("location: user.php");
            exit;
        }
    }

    if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName'])) {
        header("Location: login.php"); 
        exit;
    }

    $nombre = $_SESSION['firstName'];
    $apellidos = $_SESSION['lastName'];

    include '../php/functions/tablaadmin.php'

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Administrador</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/styleadmin.css">
</head>
<body>
    <div class="container">
        <header>
            <img class="logo" src="../img/logo.png" alt="logo de la empresa">
            <h3>Bienvenido <?php echo $nombre," ", $apellidos; ?></h3>
        </header>
                        <?php echo $deleteMsg??''; ?>
                        <form class="buscar">
                            Buscar <input class="searchTerm" id="searchTerm" type="text" onkeyup="doSearch()" />
                        </form>
                        <div class="tabla">
                            <table id= "datos">
                            <thead class ="encabezados">
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Fecha</th>
                                <th>Reportes</th>
                                <th>Información</th>
                            </thead>     
                            <tbody>
                                <?php
                                if (is_array($fetchData)) {
                                    $sn = 1;
                                    foreach ($fetchData as $data) {
                                        ?>
                                        <tr>
                                            <td><?php echo $data['firstName'] ?? ''; ?></td>
                                            <td><?php echo $data['lastName'] ?? ''; ?></td>
                                            <td><?php echo date('H:i', strtotime($data['horaEntrada'])) ?? ''; ?></td>
                                            <td><?php echo date('H:i', strtotime($data['horaSalida'])) ?? ''; ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($data['fecha'])) ?? ''; ?></td>
                                            <td class="noSearch">
                                                <button class="button-report">Reporte</button>
                                                <div class="ventana oculta">
                                                    <button class="cerrar-ventana">&times;</button>
                                                    <div class="informacion-desc">
                                                        <h3 class="modaltitulo">REPORTE</h3>
                                                        <form method="post" action="../php/forms/reporte.php">
                                                            <label for="Reporte">Ingrese el reporte: </label>
                                                            <textarea
                                                                id="reporte"
                                                                name="reporte"
                                                                rows="3"
                                                                cols="30"
                                                                placeholder="Ingresa un reporte"
                                                            ></textarea>
                                                            <input class= "sumbit "type="submit" value="Enviar">
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="overlay oculta"></div>
                                            </td>
                                            <td class="noSearch">
                                                <button class="button-info">Información</button>
                                                <div class="ventana oculta">
                                                    <button class="cerrar-ventana">&times;</button>
                                                    <div class="informacion-desc">
                                                        <h3 class="modaltitulo">INFORMACION GENERAL</h3>
                                                        <div class="info-box">
                                                            <p><b>Proyecto: </b><?php echo $data['proyecto'] ?? ''; ?> </p>
                                                            <p><b>Nombre: </b><?php echo $data['firstName'] ?? ''; ?> </p>
                                                            <p>
                                                                <b>Equipo: </b>
                                                                <hr/><?php
                                                                $equipos = explode(',', $data['equipo']);
                                                                foreach ($equipos as $equipo) {
                                                                    echo $equipo . "<br>";
                                                                }
                                                                ?> 
                                                            </p>
                                                            <p><b>Comentario: </b><hr/><?php echo $data['comentario'] ?? ''; ?> </p>
                                                            <p><b>Comentario 2: </b><hr/><?php echo $data['comentario2'] ?? ''; ?>  </p>
                                                            <p><b>Descargar Anexos: <hr/></b>
                                                            <button class="button-anex" onclick="downloadImage('<?php echo base64_encode($data['anexo']) ?>')">Anexo 1</button>
                                                            <button class="button-anex" onclick="downloadImage('<?php echo base64_encode($data['anexo2']) ?>')">Anexo 2</button>
                                                            </p>
                                                        </div>
                                                    </div>                                   
                                                </div>
                                                <div class="overlay oculta"></div>
                                            </td>
                                        </tr>
                                        <?php
                                        $sn++; 
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5">
                                            <?php echo $fetchData; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                            <script src="../js/searchjs.js"></script>
                            <script src="../js/modal.js"></script>
                            <script src="../js/anexdesc.js"></script>
                            </table>
                    </div>
                    <div class="links">
                        <a href="../php/functions/logout.php">Cerrar Sesión</a>
                        <a href="../php/functions/descargarbase.php"><button class="button-base">Descargar Datos</button></a>
                    </div>
                    
    </div>
</body>                              
</html>


