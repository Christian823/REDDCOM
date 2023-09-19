<?php
session_start();

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

?>
<?php
    require '../php/connect.php';
    $db = $conn;
    $tableName = "entrys";
    $columns = ['id','firstName', 'lastName','horaLlegada',
    'horaSalida','anexo','comentarios','reportes' ];
    $fetchData = fetch_data($db, $tableName, $columns);

    function fetch_data($db, $tableName, $columns){
        if(empty($db)){
         $msg= "Database connection error";
        }elseif (empty($columns) || !is_array($columns)) {
         $msg="columns Name must be defined in an indexed array";
        }elseif(empty($tableName)){
          $msg= "Table Name is empty";
       }else{
       $columnName = implode(", ", $columns);
       $query = "SELECT ".$columnName." FROM $tableName"." ORDER BY id DESC";
       $result = $db->query($query);
       if($result== true){ 
        if ($result->num_rows > 0) {
           $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
           $msg= $row;
        } else {
           $msg= "Sin entradas"; 
        }
       }else{
         $msg= mysqli_error($db);
       }
       }
       return $msg;
       }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <header>
                <img src="img/logo.png" alt="logo de la empresa">
            </header>
        </div>       
            <h3>Bienvenido <?php echo $nombre," ", $apellidos; ?></h3>
                        <?php echo $deleteMsg??''; ?>
                        <div class="tabla">
                            <table> 
                            <thead class ="encabezados">
                                <th>S.N</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Anexo</th>
                                <th>Comentarios</th>
                                <th>Autorización</th>
                                <th>Reportes</th>
                            </thead>
                            <tbody>
                            <?php
                                if (is_array($fetchData)) {
                                    $sn = 1;
                                    foreach ($fetchData as $data) {
                                        ?>
                                        <tr>
                                            <td><?php echo $sn; ?></td>
                                            <td><?php echo $data['firstName'] ?? ''; ?></td>
                                            <td><?php echo $data['lastName'] ?? ''; ?></td>
                                            <td><?php echo date('H:i', strtotime($data['horaLlegada'])) ?? ''; ?></td>
                                            <td><?php echo date('H:i', strtotime($data['horaSalida'])) ?? ''; ?></td>
                                            <td>
                                            <a href="Logica/descargar_archivo.php?id=<?php echo $data['id']; ?>" class="button-descargar">Descargar</a>
                                            </td>
                                            <td>
                                                <button class="button-comentario">Comentario</button>
                                                <div class="ventana oculta">
                                                    <button class="cerrar-ventana">&times;</button>
                                                    <h3>Comentario </h3>
                                                    <?php echo $data['comentarios'] ?? ''; ?>                                        
                                                </div>
                                                <div class="overlay oculta"></div>
                                            </td>
                                            <td>
                                                <button class="button-autorizacion">Autorizar</button>
                                                
                                            </td>
                                            <td>
                                                <button class="button-reportes">Reporte</button>
                                                <div class="ventana oculta">
                                                    <button class="cerrar-ventana">&times;</button>
                                                    <h3>Reporte</h3>
                                                     <?php 
                                                     if (empty($data['reportes'])) {
                                                     ?>
                                                     <form action="" method="post">
                                                        <textarea
                                                            id="reportes"
                                                            name="reportes"
                                                            rows="3"
                                                            cols="30"
                                                            placeholder="Ingresa alguna observacion"
                                                        ></textarea>
                                                    <input type="submit" value="Enviar" />
                                                     </form>
                                                    <?php
                                                    }else{
                                                        echo $data['id'];
                                                    }
                                                    ?>
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
                                        <td colspan="7">
                                            <?php echo $fetchData; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                            </table>

                            <script>
                                const botones = document.querySelectorAll(".button-comentario, .button-reportes");
                                const ventanas = document.querySelectorAll(".ventana");
                                const btnCerrarVentana = document.querySelectorAll('.cerrar-ventana');
                                const overlay = document.querySelectorAll('.overlay');
                                const botonesDescarga = document.querySelectorAll(".button-descargar");

                                const abrirVentana = function () {
                                    const index = Array.from(botones).indexOf(this);
                                    ventanas[index].classList.remove("oculta");
                                    overlay[index].classList.remove("oculta");
                                };

                                const cerrarVentana = function () {
                                    const index = Array.from(btnCerrarVentana).indexOf(this);
                                    ventanas[index].classList.add("oculta");
                                    overlay[index].classList.add("oculta");
                                };

                                botonesDescarga.forEach(button => {
                                button.addEventListener('click', function (e) {
                                    e.preventDefault();
                                    window.open(this.getAttribute('href'), '_blank');
                                    });
                                });

                                botones.forEach(button => button.addEventListener('click', abrirVentana));
                                btnCerrarVentana.forEach(btnCerrar => btnCerrar.addEventListener("click", cerrarVentana));
                            </script>

                            
                            
                    </div>
                    <a href="Logica/cerrarsesion.php">Cerrar Sesión</a>
    </div>
</body>
                                
</html>


