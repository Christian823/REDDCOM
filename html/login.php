<?php
    require '../php/login.php';

    if (isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) {
        if ($_SESSION['account_type'] === 'admin') {
            header("location: ../html/admin.php");
            exit;
        } elseif ($_SESSION['account_type'] === 'user') {
            header("location: ../html/user.php");
            exit;
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <img class="logo" src="../img/logo.png" alt="logo de la empresa">
        </header>
        <form action="../php/login.php" method="post" id="login-form">
            <fieldset>
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required/>
                <label for="password">Contraseña:</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,15}$"
                    title="La contraseña debe contener al menos 1 letra mayúscula, 1 letra minúscula, 1 número, 1 carácter especial y tener entre 8 y 15 caracteres."
                    required
                />
            </fieldset>

            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>
</body>
</html>