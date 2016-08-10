<?php
require "../../seguridad.php";

$id = $_GET["id"];
include '../../conex.php';
$sql = "SELECT * FROM usuarios WHERE id = '$id'";
$result = mysql_query($sql);
$A = mysql_fetch_array($result);
$op = $A["rol"];

switch ($op) {
    case 1:
        $rol = "Operador";

        break;
    case 2:
        $rol = "Admin";

        break;
    default:
        break;
}

// Editar Usuario

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description"  content=""/>
        <meta name="keywords" content=""/>
        <meta name="robots" content="ALL,FOLLOW"/>
        <meta name="ALTERNETICA" content="ALTERNETICA"/>
        <meta http-equiv="imagetoolbar" content="no"/>
        <title>SICA: Editar Usuario</title>
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" href="../../css/reset.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/screen.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/fancybox.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.wysiwyg.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.ui.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize-light.css" type="text/css"/>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#datos").validate();
            });
        </script>

    </head>
    <body onload="document.datos.estado.selectedIndex=<?php echo $A["estado"] ?>">

        <div class="pagetop">
            <div class="head pagesize"> <!-- *** head layout *** -->
                <div class="head_top">
                    <div class="topbuts">
                        <ul class="clear">
                            <li><a href="#">Opciones</a></li>
                            <li><a href="../../salir.php" class="red">Salir</a></li>
                        </ul>

                        <div class="user clear">
                            <img src="../../images/avatar.jpg" class="avatar" alt="" />
                            <span class="user-detail">
                                <span class="name">Bienvenido, <?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido"]; ?></span>
                                <span class="text">Logueado como <a href="#"><?php echo $_SESSION["usuario"]; ?></a></span>
                                <span class="text">Ultimo Acceso <a href="#"><?php echo $_SESSION["ultimo_acceso"]; ?></a></span>
                            </span>
                        </div>
                    </div>

                    <div class="logo clear">
                        <a href="index.php" title="Inicio">
                            <img src="../../images/logo.png" alt="" class="picture" />
                            <span class="textlogo">
                                <span class="title">Panel de Administración</span>
                                <span class="text">Sistema de Información para el Control de Asistencias</span>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="menu">
                    <ul class="clear">
                        <li>                            <a href="index.php">Panel de Administración</a>                            <ul>                                <li><a href="buscar_registro.php">Buscar Profesor</a></li>                                <li><a href="reportes.php">Reportes</a></li>                                <li><a href="horarios.php">Horarios</a></li>                                <li><a href="materias.php">Materias</a></li>                                <li><a href="asistencias.php">Asistencias</a></li>                            </ul>                        </li>
                        <li class="active">
                            <a href="#">Usuarios</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <form id="datos" name="datos" method="POST" class="validate-form form bt-space15" action="actualiza_usuario.php">
            <div class="main pagesize"> <!-- *** mainpage layout *** -->
                <div class="main-wrap">
                    <?php
                    if ($_GET["claves"] == "no") {
                        echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Cerrar notificación\"><span>Cerrar</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> Las claves deben coincidir, intentelo de nuevo.</p>
		  </div>";
                    }
                    ?>
                    <div class="page clear">
                        <h1>Editar Usuario</h1>
                        <p>
                            <?php
                            // Fecha
                            setlocale(LC_TIME, 'spanish');
                            $fecha = utf8_encode(ucfirst(strftime("%d/%m/%Y", time())));
                            ?>
                        </p>
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>"></input>
                        <div class="content-box">
                            <div class="box-body">
                                <div class="box-header clear">
                                    <h2>Registro Nuevo Usuario</h2>
                                </div>
                                <div class="box-wrap clear">
                                    <div>
                                        <div class="box-wrap clear">
                                            <table class="style1">
                                                <thead>
                                                    <tr>
                                                        <th>Descripción</th>
                                                        <th class="full">Valor</th>
                                                        <th>Descripción</th>
                                                        <th class="full">Valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Nombre<span class="required"> *</span></th>
                                                        <td> <input size="40" onkeypress="return permite(event, 'l')" type="text" name="nombre" id="nombre" class="required text fl-space2" value="<?php echo $A["nombre"] ?>" ></input></td>
                                                        <th>Apellido<span class="required"> *</span></th>
                                                        <td><input size="40" onkeypress="return permite(event, 'l')" type="text" name="apellido" id="apellido" class="required text fl-space2" value="<?php echo $A["apellido"] ?>" ></input></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nombre de Usuario<span class="required"> *</span></th>
                                                        <td> <input size="40" type="text" name="username" id="username" class="required text" value="<?php echo $A["usuario"] ?>" disabled="yes"></input></td>
                                                        <th>Rol de Usuario<span class="required"> *</span></th>
                                                        <td><input size="40" type="text" name="rol" id="rol" class="required text " value="<?php echo $rol ?>" disabled="yes"></input></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contraseña<span class="required"> *</span></th>
                                                        <td><input size="40" type="password" name="pass" id="pass" class="required text "></input></td>
                                                        <th>Confirmar Contraseña<span class="required"> *</span></th>
                                                        <td><input size="40" name="repass" id="repass" type="password" class="required text "></input></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Correo Electrónico<span class="required"> *</span></th>
                                                        <td><input size="40" type="trext" name="email" id="email" class="required text" value="<?php echo $A["email"] ?>"></input></td>
                                                        <th>Estado<span class="required"> *</span></th>
                                                        <td>
                                                            <select name="estado" id="estado">
                                                                <option value="0">Inactivo</option>
                                                                <option value="1">Activo</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <span class="required">(*) Campos requeridos</span>
                                            <div class="tab-footer clear">
                                                <div class="fr">
                                                    <input type="submit" value="Guardar Cambios" id="guardar" class="submit" />
                                                    <a href="usuarios.php" class="button red">Cancelar</a>
                                                </div>
                                            </div>
                                        </div><!-- end of box-wrap -->  

                                        <div id="result"></div>
                                    </div>
                                </div> <!-- end of box-wrap -->
                            </div> <!-- end of box-body -->
                        </div> <!-- end of content-box -->
                    </div> <!-- end of box-body -->

                </div><!-- end of page -->
            </div>
        </form>

        <div class="footer">
            <div class="pagesize clear">
                <p class="bt-space15"><span class="copy"><strong>© 2011 Todos los Derechos Reservados <a href="http://www.SICA.com/">SICA</a></strong></span> Desarrollado por <a href="http://www.psmporlamar.edu.ve">IUPSM</a></p>
            </div>
        </div>

        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/jquery.visualize.js"></script>
        <script type="text/javascript" src="../../js/jquery.wysiwyg.js"></script>
        <script type="text/javascript" src="../../js/tiny_mce/jquery.tinymce.js"></script>
        <script type="text/javascript" src="../../js/jquery.fancybox.js"></script>
        <script type="text/javascript" src="../../js/jquery.idtabs.js"></script>
        <script type="text/javascript" src="../../js/jquery.datatables.js"></script>
        <script type="text/javascript" src="../../js/jquery.jeditable.js"></script>
        <script type="text/javascript" src="../../js/jquery.ui.js"></script>
        <script type="text/javascript" src="../../js/jquery.jcarousel.js"></script>
        <script type="text/javascript" src="../../js/jquery.validate.js"></script>
        <script type="text/javascript" src="../../js/validaciones.js"></script>

        <script type="text/javascript" src="js/excanvas.js"></script>
        <script type="text/javascript" src="js/cufon.js"></script>
        <script type="text/javascript" src="js/Zurich_Condensed_Lt_Bd.js"></script>
        <script type="text/javascript" src="js/script.js"></script>

    </body>
</html>
