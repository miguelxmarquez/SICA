<?php

session_start();
//include 'seguridad.php';
//
//if ($_SESSION["autentificado"] == "SI") {
//    header("Location : /users/" . $_SESSION["rol"] . "index.php");
//}

if (!$_GET) {
    include 'cookie.php';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description"  content=""/>
        <meta name="keywords" content=""/>
        <meta name="robots" content="ALL,FOLLOW"/>
        <meta name="Author" content="AIT"/>
        <meta http-equiv="imagetoolbar" content="no"/>
        <title>SICA: Ingreso de Usuarios</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" href="css/reset.css" type="text/css"/>
        <link rel="stylesheet" href="css/screen.css" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="css/ie7.css" />
    </head>
    <script type="text/javascript">
        $(document).ready(function() { 
            $('#login').click(function() { 
                $('#loginForm').hide();
                $.blockUI({ message: $('#loginForm') }); 
 
                setTimeout($.unblockUI, 2000); 
            }); 
        }); 
    </script>

    <body class="login" onload="document.login.usuario.focus()">

        <div class="login-box">
            <div class="login-border">
                <div class="login-style">
                    <div class="login-header">
                        <div class="logo clear">
                            <img src="images/logo.png" class="picture" />
                            <span class="textlogo">
                                <span class="title">Sistema de Información</span>
                                <span class="text">Control de Asistencias</span>
                            </span>
                        </div>
                    </div>

                    <form name="login" id="login" action="control.php" method="POST">

                        <div class="login-inside">
                            <div class="login-data">
                                <div class="row clear">
                                    <label for="user">Usuario:</label>
                                    <input type="text" size="25" class="text" id="usuario" name="usuario"/>
                                </div>
                                <div class="row clear">
                                    <label for="password">Contraseña:</label>
                                    <input type="password" size="25" class="text" id="clave" name="clave"/>
                                </div>
                                <input type="submit" id="entrar" class="button" value="Entrar" />
                            </div>
                            <?php
                            if ($_GET["guest"] == "yes") {
                                echo "<p style='color: #ffae00;font-weight: bold;'>Datos de Ingreso Incorrectos</p>";
                            }
                            if ($_GET["exit"] == "yes") {
                                echo "<p style='color: white;font-weight: bold;'>Sesión Cerrada Correctamente</p>";
                            }
                            ?>
                        </div>
                        <!--                        <div class="login-footer clear">
                                                    <input type="button" name="salir" id="salir" class="button blue fr-space" value="Salir" onclick="window.close()"/>
                                                </div>-->
                    </form>

                </div>
            </div>
        </div>

        <div class="login-links">
            <p><strong>&copy; <?php echo date('Y') ?> Copyright by <a href="mailto:iupsm@gmail.com">IUPSM</a></strong> Todos los Derechos Reservados.</p>
        </div>

        

    </body>
</html>
