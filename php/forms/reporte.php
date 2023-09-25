<?php
    require '../functions/tablaadmin.php';

            $data = $fetchData ;
            $empleado = $data['user'];
            $fecha = $data['fecha'];
            $reporte = $_POST["reporte"];

            $sql = "UPDATE user SET reporte = ? WHERE fecha = ? AND user = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sss", $reporte, $fecha, $empleado);

                if ($stmt->execute()) {
                    echo $empleado;
                    echo $fecha;
                } else {
                    echo "Error al registrar la salida: " . $stmt->error;
                }

                $stmt->close();
            }
?>
