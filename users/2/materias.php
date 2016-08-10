<?php require "../../seguridad.php"; ?> 
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
                            <a href="#">Materias</a>

                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="main pagesize"> <!-- *** mainpage layout *** -->
            <div class="main-wrap">
                <?php
                if ($_GET["saved"] == "yes") {
                    echo "<div class=\"notification note-success\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> La materia ha sido guardada exitosamente!</p>
		  </div>";
                }
                if ($_GET["deleted"] == "yes") {
                    echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> La materia ha sido eliminada exitosamente!</p>
		  </div>";
                }
                if ($_GET["saved"] == "no") {
                    echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> La materia no ha sido guardado, intentelo de nuevo o verifique que el nombre no exista </p>
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
                                        <li><a href="nuevo_materia.php"><img src="../../images/add.png" class="icon" /><span class="text">Nueva Materia</span></a></li>
<!--                                        <li><a href="buscar_materia.php"><img src="../../images/10.png" class="icon" /><span class="text">Buscar Materia</span></a></li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT BOX - DATATABLE -->
                    <div class="content-box">
                        <div class="box-body">
                            <div class="box-header clear">
                                <h2>Materias Registrados en el Sistema</h2>
                            </div>

                            <div class="box-wrap clear">

                                <!-- TABLE -->
                                <div id="data-table">
                                    <p>Tabla de contenido de todas las materias registradas en el sistema. Para una busqueda rápida escriba su criterio en el campo: Buscar en Todas las columnas</p> 

                                    <table class="style1 datatable">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">ID Registro</th>
                                                <th>Nombre</th>
                                                <th>Sección</th>
                                                <th>Especialidad</th>
                                                <th></th>
                                                <th style="padding-left: 16px;">Acciones</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT m.id, m.materia, e.especialidad, s.seccion
                                                    FROM materias AS m, escuelas AS e, secciones AS s
                                                    WHERE m.especialidad = e.codigo
                                                    AND m.seccion = s.id
                                                    ORDER BY m.id ASC";
                                            $result = mysql_query($sql);
                                            while ($A = @mysql_fetch_array($result)) {
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $A["id"] ?></td>
                                                    <td><?php echo $A["materia"] ?></td>
                                                    <td  style="padding-left: 20px;"><a href="#"><?php echo $A["seccion"] ?></a></td>
                                                    <td><?php echo $A["especialidad"] ?></td>
                                                    <td></td>
                                                    <td>
                                                        <a href="ver_materia.php?id=<?php echo $A["id"] ?>"><img src="../../images/ico_edit_16.png" height="18" width="18" class="icon16 fl-space2" alt="" title="Ver" /></a>
                                                        <a href="edita_materia.php?id=<?php echo $A["id"] ?>"><img src="../../images/document.png" height="18" width="18" class="icon16 fl-space2" alt="" title="Editar" /></a>
                                                        <a onclick="return confirm('ADVERTENCIA, está a punto de eliminar la materia: <?php echo $A["materia"] ?>. Está seguro que desea borrarla permanentemente del sistema..?');" href="elimina_materia.php?id=<?php echo $A["id"] ?>"><img src="../../images/ico_delete_16.png" height="18" width="18" class="icon16 fl-space2" alt="" title="Eliminar" /></a>
                                                    </td>

                                                    <td></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>

                                </div><!-- /#table -->


                            </div><!-- end of box-wrap -->  
                            <div class="rule"></div>

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
