<?php
    require 'conn.php';
    $db = $conn;
    $tableName = "user";
    $columnName = "proyecto"; 
    $enumOptions = get_enum_options($db, $tableName, $columnName);

    function get_enum_options($db, $tableName, $columnName)
    {
        if (empty($db)) {
            $msg = "Database connection error";
        } elseif (empty($columnName)) {
            $msg = "Column Name is empty";
        } elseif (empty($tableName)) {
            $msg = "Table Name is empty";
        } else {
            $query = "SHOW COLUMNS FROM $tableName WHERE Field = '$columnName'";
            $result = $db->query($query);
            if ($result == true) {
                $row = $result->fetch_assoc();
                if (preg_match('/^enum\((.*)\)$/', $row['Type'], $matches)) {
                    $enumOptions = explode(',', str_replace("'", '', $matches[1]));
                    $msg = $enumOptions;
                } else {
                    $msg = "No es una columna ENUM";
                }
            } else {
                $msg = mysqli_error($db);
            }
        }
        return $msg;
    }
?>
