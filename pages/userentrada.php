<?php
    require '../php/functions/empleados.php';
    require '../php/functions/proyectos.php';
    require '../php/forms/entrada.php';

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
    <link rel="stylesheet" href="../css/styleentrada.css">
    <script src="../js/searchjs.js"></script>
    <script src="../js/validation.js"></script>
    <script src="../js/ubicacion.js"></script>
    <title>Pagina de Entrada</title>
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
        <form action="../php/forms/entrada.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" >
            <fieldset class="informacion">
                <label for="proyectos">Elegir proyecto: </label>
                <select name="op-proyectos" id="op-proyectos" required>
                    <?php
                        if (is_array($fetchData2)) {
                            foreach ($fetchData2 as $proyecto) {
                                ?>
                                    <option value="<?php echo $proyecto['nombre']; ?>"><?php echo $proyecto['nombre']; ?></option>     
                                <?php
                                }
                            } 
                            ?>
                </select>
                <fieldset>
                    <label for="equipo">Equipo de trabajo</label>
                    <form class="buscar">
                        Buscar <input class="searchTerm" id="searchTerm" type="text" onkeyup="doSearch()" />
                    </form>
                    <div class="scrollable-table">                        
                    <table id="datos">
                            <thead class ="encabezados">
                                <th class="nombres">Nombre</th>
                                <th>Seleccionar</th>
                            </thead>
                            <tbody>
                            <?php
                                if (is_array($fetchData)) {
                                    foreach ($fetchData as $data) {
                                        ?>
                                        <tr>
                                            <td class="nombres-equipo"><?php echo $data['empleados'] ?? ''; ?></td>
                                            <td><input type="checkbox" name="seleccionar[]" value="<?php echo $data['empleados'] ?? ''; ?>"></td>                                           
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <?php echo $fetchData; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                        </tbody>
                    </table>
                    </div>  
                </fieldset> 
                <label for="anexo">Inserte aqui el anexo:</label>
                <input id="anexo" type="file" accept="image/*" capture="camera" name="anexo" required/>
                <label for="comentarios">Comentarios:</label>
                  <textarea
                    id="comentarios"
                    name="comentarios"
                    rows="3"
                    cols="30"
                    placeholder="Ingresa alguna observacion"
                  ></textarea>
                    <input type="hidden" name="latitud" id="latitud">
                    <input type="hidden" name="longitud" id="longitud">
                    <input class="sumbit" type="submit" value="Marcar Entrada"  onclick="obtenerUbicacion()" required>
                    </fieldset>
        </form>
        <a href="../php/functions/logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>