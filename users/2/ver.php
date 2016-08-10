<?php
require '../../seguridad.php';
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
        <title>SICA: Nuevo Registro</title>
        <script type="text/javascript" src="js/jquery.js"></script>
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" href="../../css/reset.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/screen.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/fancybox.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.wysiwyg.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.ui.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize-light.css" type="text/css"/>
        <script type="text/javascript" language="javascript" src="webcam.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#datos").validate();
            });
        </script>

    </head>
    <body>

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
                        <a href="index.php" title="Panel de Administración">
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
                            <a href="#">Registros</a>
                            <ul>
                                <li class="active"><a href="#">Nuevo Registro</a></li>
                                <li><a href="buscar_registro.php">Buscar</a></li>
                                <!--<li><a href="registros.html">Ver Todas</a></li>-->
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main pagesize"> <!-- *** mainpage layout *** -->
            <div class="main-wrap">
                <?php
                if ($_GET["id"]) {
                    // Actualizamos el registro con la marca (foto = 1)
                    include '../../conex.php';
                    $sql = "UPDATE personas SET foto = 1 WHERE ci =" . $_GET["id"];
                    mysql_query($sql);
                    // Imprimimos Notificacion
                    echo "<div class=\"notification note-success\">
                    <a href=\"#\" class=\"close\" title=\"Cerrar Notificacion\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> El Registro ha sido guardado exitosamente.</p>
		  </div>";
                }
                if ($_GET["id"] == "") {
                    // Imprimimos Notificacion
                    echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Cerrar Notificacion\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> El Registro no ha sido guardado.</p>
		  </div>";
                    ?>

                <?php } ?>
                <div class="content-box">

                    <form id="datos" name="datos" method="POST" class="validate-form form bt-space15" action="">

                        <div class="box-wrap clear" style="text-align: center;">       
                            <table>
                                <td>
                                    <tr style="text-align: center;">
                                        <img src="../../data/fotos/<?php echo $_SESSION["foto"]; ?>"/><br></br>
                                        <a href="index.php" class="button green">Ok</a>
                                    </tr>
                                </td>
                            </table>

                        </div><!-- end of box-wrap -->  
                    </form>


                </div> <!-- end of box-body -->
            </div> <!-- end of content-box -->

        </div><!-- end of page -->



        <div class="footer">
            <div class="pagesize clear">
                <p class="bt-space15"><span class="copy"><strong>© <?php echo date("Y") ?> Todos los Derechos Reservados | Desarrollado por <a href="http://www.psmporlamar.edu.ve/">IUPSM - Extensión Porlamar</a></strong></span></p>
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

        <script type="text/javascript" src="../../js/excanvas.js"></script>
        <script type="text/javascript" src="../../js/cufon.js"></script>
        <script type="text/javascript" src="../../js/Zurich_Condensed_Lt_Bd.js"></script>
        <script type="text/javascript" src="../../js/script.js"></script>

    </body>
</html>


