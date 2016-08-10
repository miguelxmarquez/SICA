<?php
require "../../seguridad.php";

setlocale(LC_TIME, 'spanish');
$fecha = utf8_encode(ucfirst(strftime("%d/%m/%Y", time())));
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
        <title>SICA: Reportes</title>
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
        <script type="text/javascript">
            $(document).ready(function(){
                $("#datepicker").datepicker({
                    changeMonth: true ,
                    changeYear: true ,
                    showAnim: 'fadeIn' ,
                    dateFormat: 'dd/mm/yy' ,
                    maxDate: new Date(2000, 11, 30) ,
                    minDate: new Date(1912, 11, 30)
                });
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
                        <li>
                            <a href="index.php">Panel de Administración</a>
                            <ul>
                                <li><a href="buscar_registro.php">Buscar Profesor</a></li>
                                <li><a href="horarios.php">Horarios</a></li>
                                <li><a href="materias.php">Materias</a></li>
                                <li><a href="asistencias.php">Asistencias</a></li>

                            </ul>
                        </li>
                        <li class="active">
                            <a href="#">Reportes</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main pagesize"> <!-- *** mainpage layout *** -->
            <div class="main-wrap">

                <div class="page clear">
                    <h1>Reportes</h1>
                    <div class="content-box">
                        <div class="box-body">
                            <div class="box-header clear">
                                <ul class="tabs clear">
                                    <li><a href="#tab1">Reportes</a></li>
                                </ul>
                                <h2>Control de Asistencias (Reportes)</h2>
                            </div>
                            <div class="box-wrap clear">
                                <input type="hidden" name="fecha" id="fecha" value="<?php echo $fecha; ?>"></input>
                                <input type="hidden" name="id_usuario" id="fecha" value="<?php echo $_SESSION["id"]; ?>"></input>

                                <!--   Tab1    -->
                                <div id="tab1">

                                    <div class="box-wrap clear">
                                        <h2>Disponibilidad de Reportes</h2>
                                        <table class="style1">
                                            <thead>
                                                <tr>
                                                    <th>Descripción del Reporte</th>
                                                    <th>PDF</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th>1. Todos los Docentes Activos</th>
                                                    <td><a href="reportes_todos.php" target="_blank">Generar PDF</a></td>

                                                </tr>
                                                <tr>

                                                    <th>2. Todos los Docentes Inativos</th>
                                                    <td> <a href="reportes_todos_inactivos.php" target="_blank">Generar PDF</a></td>

                                                </tr>
                                                <tr>
                                                    <th>3. Todos los Docentes (Activos - Inactivos)</th>
                                                    <td><a href="reportes_todos.php" target="_blank">Generar PDF</a></td>

                                                </tr>
                                                <tr>
                                                    <th>4. Marcaje Horas Docentes (Rango de Fecha)</th>
                                                    <td> <a href="reportes_todos_fecha.php" target="_blank">Generar Reporte</a></td>

                                                </tr>
                                                <tr>
                                                    <th>5. Todos los Docentes Horas Total Trabajadas Hoy</th>
                                                    <td> <a href="reportes_horas_hoy.php" target="_blank">Generar PDF</a></td>

                                                </tr>
                                                <tr>
                                                    <th>6. Todos los Docentes por Escuela</th>
                                                    <td> <a href="reportes_todos_escuela.php" target="_blank">Generar PDF</a></td>

                                                </tr>
                                                <tr>
                                                    <th>7. Todos los Docentes Horas Total Trabajadas</th>
                                                    <td> <a href="reportes_horas.php" target="_blank">Generar PDF</a></td>

                                                </tr>
                                                <tr>
                                                    <th>8. Todos los Docentes Total Horas Asignadas</th>
                                                    <td> <a href="reportes_horas_asignadas.php" target="_blank">Generar PDF</a></td>

                                                </tr>
                                   


                                            </tbody>
                                        </table>

                                        <div class="tab-footer clear">
                                            <span class="required">(*) Solo Lectura (PDF)</span>
                                        </div>
                                        <div class="rule"></div>

                                    </div><!-- end of box-wrap --> 

                                </div>
                                <!--   Fin Tab1    -->
                                <!--   Tab2    -->
                            </div> <!-- end of box-wrap -->
                        </div> <!-- end of box-body -->
                    </div> <!-- end of content-box -->
                </div> <!-- end of box-body -->

            </div><!-- end of page -->
        </div>


        <div class="footer">
            <div class="pagesize clear">
                <p class="bt-space15"><span class="copy"><strong>© <?php echo date("Y") ?> Todos los Derechos Reservados <a href="http://www.SICA.com/">SICA</a></strong></span> Desarrollado por <a href="http://www.psmporlamar.edu.ve">IUPSM</a></p>
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
