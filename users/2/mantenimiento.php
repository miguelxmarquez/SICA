<?php
require "../../seguridad.php";

function size($path, $formated = true, $retstring = null) {
    if (!is_dir($path) || !is_readable($path)) {
        if (is_file($path) || file_exists($path)) {
            $size = filesize($path);
        } else {
            return false;
        }
    } else {
        $path_stack[] = $path;
        $size = 0;

        do {
            $path = array_shift($path_stack);
            $handle = opendir($path);
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..' && is_readable($path . DIRECTORY_SEPARATOR . $file)) {
                    if (is_dir($path . DIRECTORY_SEPARATOR . $file)) {
                        $path_stack[] = $path . DIRECTORY_SEPARATOR . $file;
                    }
                    $size += filesize($path . DIRECTORY_SEPARATOR . $file);
                }
            }
            closedir($handle);
        } while (count($path_stack) > 0);
    }
    if ($formated) {
        $sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        if ($retstring == null) {
            $retstring = '%01.2f %s';
        }
        $lastsizestring = end($sizes);
        foreach ($sizes as $sizestring) {
            if ($size < 1024) {
                break;
            }
            if ($sizestring != $lastsizestring) {
                $size /= 1024;
            }
        }
        if ($sizestring == $sizes[0]) {
            $retstring = '%01d %s';
        } // los Bytes normalmente no son fraccionales
        $size = sprintf($retstring, $size, $sizestring);
    }
    return $size;
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
        <title>Sistema de Control: Panel de Administración</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" href="../../css/reset.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/screen.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/fancybox.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.wysiwyg.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.ui.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize-light.css" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="../../css/ie7.css" />
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
                        <a href="index.php" title="Ver Panel de Administración">
                            <img src="../../images/logo.png" alt="" class="picture" />
                            <span class="textlogo">
                                <span class="title">Sistema de Control</span>
                                <span class="text">Panel de Administración</span>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="menu">
                    <ul class="clear">
                        <li>                            <a href="index.php">Panel de Administración</a>                            <ul>                                <li><a href="buscar_registro.php">Buscar Profesor</a></li>                                <li><a href="reportes.php">Reportes</a></li>                                <li><a href="horarios.php">Horarios</a></li>                                <li><a href="materias.php">Materias</a></li>                                <li><a href="asistencias.php">Asistencias</a></li>                            </ul>                        </li>
                        <li class="active">
                            <a href="#">Mantenimiento</a>

                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="main pagesize"> <!-- *** mainpage layout *** -->
            <div class="main-wrap">
                <?php
                if ($message = $_GET["message"]) {
                    echo "<div class=\"notification note-success\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> $message</p>
		  </div>";
                }
                if ($message = $_GET["error"]) {
                    echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> $message</p>
		  </div>";
                }
                
                ?>
                <div class="page clear">
                    <!-- ICONBAR -->
                    <div class="content-box clear">
                        <div class="box-body iconbar">
                            <div class="box-wrap">
                                <div class="main-icons" id="iconbar">
                                    <ul class="clear">
                                        <li class="active"><a href="index.php"><img src="../../images/ico_settings_64.png" class="icon" alt="" /><span class="text">Inicio</span></a></li>
                                        <li><a href="backup_database.php"><img src="../../images/get.png" class="icon" /><span class="text">Realizar Backup</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT BOX - DATATABLE -->
                    <div class="content-box">
                        <div class="box-body">
                            <div class="box-header clear">
                                <h2>Respaldos realizados en el Sistema</h2>
                            </div>

                            <div class="box-wrap clear">

                                <!-- TABLE -->
                                <div id="data-table">
                                    <p>Tabla de contenido de todas los respaldos realizados en el sistema. Para una busqueda rápida escriba su criterio en el campo: Buscar en Todas las columnas</p> 

                                    <table class="style1 datatable">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Nombre del Archivo de Respaldo</th>
                                                <th>Ruta de Directorio</th>
                                                <th>Tamaño Total en Disco</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $dir = "../../data/db";
                                            $dir_handle = @opendir($dir) or die("No se pudo abrir $dir");


                                            while ($file = readdir($dir_handle)) {
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><a target="_blank" href="../../data/db/<?php echo $file ?>"><?php echo $file ?></a></td>
                                                    <td><?php echo $dir; ?></td>
                                                    <td><?php echo size($dir)?></td>
                                                    <td><?php ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                            }
                                            closedir($dir_handle);
                                            ?>

                                        </tbody>
                                    </table>

                                </div><!-- /#table -->


                            </div><!-- end of box-wrap -->
                        </div> <!-- end of box-body -->
                    </div> <!-- end of content-box -->

                </div><!-- end of page -->
            </div>
        </div>

        <div class="footer">
            <div class="pagesize clear">
                <p class="bt-space15"><span class="copy"><strong>© <?php echo date('Y') ?> Todos los Derechos Reservados  <a href="http://www.SICA.com/">SICA</a></strong></span> Desarrollado por <a href="http://www.psmporlamar.edu.ve">IUPSM</a></p>
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
