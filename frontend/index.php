<?php
session_start();
if(isset($_SESSION['logueado']) && $_SESSION['logueado'] == TRUE) {
    header("Location: home.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Dogspotting</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css" type="text/css">
</head>
 
<body>

    <div id="wrapper">

        <div class="w-left">
            <img src="imagenes/perro.png"
                    align="left"
                    height="450"
                    width="450">
        </div>

        <div class="w-right">

            <?php 
                if(isset($_GET['error'])) {
                    echo "<center>Error: el usuario o contraseña no coinciden</center>";
                }
            ?>

            <?php
                if(isset($_POST['entrar'])) {

                    require("conexion.php");

                    $username = $mysqli->real_escape_string($_POST['usuario']);
                    $password = md5($_POST['password']);

                    $consulta = "SELECT username,password FROM users WHERE username = '$username' AND password = '$password'";

                    if($resultado = $mysqli->query($consulta)) {
                        while($row = $resultado->fetch_array()) {
                            $userok = $row['username'];
                            $passok = $row['password'];
                        }
                    $resultado->close();
                    }

                    $mysqli->close();

                    if(isset($username) && isset($password)) {

                        if($username == $userok && $password == $passok) {

                            session_start();
                            $_SESSION['logueado'] = TRUE;
                            header("Location: home.php");
                        }

                       else {
                            Header("Location: index.php?error=login");
                        }   

                    }
                }
            ?>

            <div class="main-content">

                <div class="header">
                    <img src="imagenes/logo.png">
                </div>

                <div class="l-part">
                    <form action="" method="post">
                        <input type="text" placeholder="Usuario" class="input" name="usuario" />
                
                        <div class="overlap-text">
                            <input type="password" placeholder="Contraseña" class="input" name="password" />
                        </div>
                
                        <input type="submit" value="Entrar" class="btn" name="entrar" />
                    </form>
                </div>

            </div>

            <div class="sub-content">
                <div class="s-part">
                    ¿No tienes una cuenta? <a href="registro.php">Regístrate</a>
                </div>
            </div>

            <center><img src="imagenes/aplicaciones.png"></center>

        </div>

    </div>

</body>
</html>