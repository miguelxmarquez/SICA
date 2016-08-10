


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
                        <li>
                            <a href="index.php">Panel de Administración</a>
                            <ul>
                                <li><a href="buscar_registro.php">Buscar Profesor</a></li>
                                <li><a href="reportes.php">Reportes</a></li>
                                <li><a href="horarios.php">Horarios</a></li>
                                <li><a href="materias.php">Materias</a></li>

                            </ul>
                        </li>
                        <li>
                            <li class="active"><a href="#">Asistencias</a></li>

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
		    <p><strong>Notificación:</strong> El Departamento ha sido eliminado exitosamente!</p>
		  </div>";
                }
                if ($_GET["saved"] == "no") {
                    echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> El Departamento no ha sido guardado, intentelo de nuevo o verifique que el nombre no exista </p>
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
                                        <li><a href="buscar_asistencia.php"><img src="../../images/10.png" class="icon" /><span class="text">Buscar Marcaje</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT BOX - DATATABLE -->
                    <div class="content-box">
                        <div class="box-body">

                            <div class="box-header clear">
                                <h2>Últimos 100 Marcajes Registrados en el Sistema</h2>
                            </div>

                            <div class="box-wrap clear">

                                <!-- TABLE -->
                                <div id="data-table">
                                    <p>Tabla de contenido de los últimos 100 marcajes de asistencias registrados en el sistema. Para una busqueda rápida escriba su criterio en el campo: Buscar en Todas las columnas</p> 

                                    <table class="style1 datatable">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Id. de Registro</th>
                                                <th>C.I. de Registro</th>
                                                <th>Asignatura</th>
                                                <th>Fecha</th>
                                                <th>H. Entrada</th>
                                                <th>H. Salida</th>
                                                <th style="text-align: center;">H. Trabajadas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include '../../conex.php';
                                            $sql = "SELECT a.id as id_asistencia, p.ci, a.fecha, m.materia, a.h_entrada, a.h_salida, a.h_trabajadas, p.id as id_persona
FROM asistencias AS a, personas AS p, materias AS m, horarios AS h
WHERE a.id_persona = p.id AND a.id_materia = m.id AND a.id_horario = h.id
GROUP BY a.id
ORDER BY a.id DESC
";
                                            $result = mysql_query($sql);
                                            while (@$A = mysql_fetch_array($result)) {
                                                ?>
                                                <tr>
                                                    <td style="text-align: center; "><?php echo $A["id_asistencia"] ?></td>
                                                    <td><a href="registro.php?ci=<?php echo $A["ci"] ?>&id=<?php echo $A["id_persona"] ?>"><?php echo $A["ci"] ?></a></td>
                                                    <td><?php echo $A["materia"] ?></td>
                                                    <td><?php echo $A["fecha"] ?></td>
                                                    <td><?php echo $A["h_entrada"] ?></td>
                                                    <td><?php echo $A["h_salida"] ?></td>
                                                    <td style="text-align: center;"><?php echo $A["h_trabajadas"] ?></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>

                                </div><!-- /#table -->


                            </div><!-- end of box-wrap --><div class="rule"></div>
                        </div> <!-- end of box-body -->
                    </div> <!-- end of content-box -->

                </div><!-- end of page -->
            </div>
        </div>

        <div class="footer">
            <div class="pagesize clear">
                <p class="bt-space15"><span class="copy"><strong>© 2011 Todos los Derechos Reservados <a href="http://www.psmporlamar.edu.ve/">IUPSM</a></strong></span> Desarrollado por <a href="mailto:miguelxmarquez@gmail.com">Miguel Márquez</a></p>
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
