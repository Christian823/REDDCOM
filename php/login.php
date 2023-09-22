<?php
require 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($usuario) && !empty($password)) {
        $q = "SELECT password, firstName, lastName, account_type FROM registration WHERE usuario = '$usuario'";
        $consulta = mysqli_query($conn, $q);
        $result = mysqli_fetch_assoc($consulta);

        if ($result && $password === $result['password']) { 
            $_SESSION['usuario'] = $usuario;
            $_SESSION['firstName'] = $result['firstName'];
            $_SESSION['lastName'] = $result['lastName'];
            $_SESSION['account_type'] = $result['account_type']; 
        
            if ($result['account_type'] === 'admin') {
                header("location: ../html/admin.php");
                exit;
            } elseif ($result['account_type'] === 'user') {
                header("location: ../html/user.php");
                exit;
            }
        } else {
            header("location: ../html/login.php");  // Corrección aquí
            exit;
        }
    }
}     
?>
