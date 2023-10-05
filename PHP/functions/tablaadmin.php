<?php
    require 'conn.php';
    $db = $conn;
    $tableName = "registros";
    $columns = ['id','firstName','user', 'lastName','proyecto','equipo','fecha','horaEntrada',
    'horaSalida','comentario','comentario2','hextra','anexo','anexo2'];
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
        $msg= "No hay registros"; 
        }
    }else{
        $msg= mysqli_error($db);
    }
    }
    return $msg;
    }
?>