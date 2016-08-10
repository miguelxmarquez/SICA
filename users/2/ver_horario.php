<?php
require "../../seguridad.php";
include '../../conex.php';

$id = $_GET["id"];
$sql_horario = "SELECT h.id, s.dia, h.2dia, h.3dia, p.nombre, p.apellido, m.materia, h.1ini, h.1fin, h.1dia, h.2ini, h.2fin, h.2dia, h.3ini, h.3fin, h.3dia
                FROM horarios AS h, personas AS p, materias AS m, semana AS s
                WHERE h.id='$id' AND p.id=h.id_profesor AND h.materia = m.id AND h.1dia=s.id";

if ($result = mysql_query($sql_horario)) {
    $A = mysql_fetch_array($result);
    $turno2 = $A["2dia"];
    $turno3 = $A["3dia"];
    $sql_turno2 = "SELECT dia FROM semana WHERE id='$turno2'";
    $sql_turno3 = "SELECT dia FROM semana WHERE id='$turno3'";

    $result_2 = mysql_query($sql_turno2);
    $R2 = mysql_fetch_array($result_2);
    $result_3 = mysql_query($sql_turno3);
    $R3 = mysql_fetch_array($result_3);
}
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
        <title>SICA: Editar Horario</title>
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
                        <li>
                            <li class="active"><a href="#">Horarios</a></li>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <form id="datos" name="datos" method="POST" class="validate-form form bt-space15" action="actualiza_horario.php">
            <div class="main pagesize"> <!-- *** mainpage layout *** -->
                <div class="main-wrap">

                    <div class="page clear">
                        <h1>Ver Horario</h1>
                        <p>
                            <?php
// Fecha
                            setlocale(LC_TIME, 'spanish');
                            echo utf8_encode(ucfirst(strftime("%A, %d de %B de %Y", time())));
                            $fecha = utf8_encode(ucfirst(strftime("%d/%m/%Y", time())));
                            ?>
                        </p>
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>"></input>
                        <div class="content-box">
                            <div class="box-body">
                                <div class="box-header clear">
                                    <h2>Vista de Horario</h2>
                                </div>
                                <div class="box-wrap clear">
                                    <div>
                                        <div class="box-wrap clear">
                                            <table class="style1">
                                                <thead>
                                                    <tr>
                                                        <th>Descripción</th>
                                                        <th>Valor</th>
                                                        <th>Descripción</th>
                                                        <th>Valor</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Profesor<span class="required">*</span></th>
                                                        <td colspan="2"><?php echo $A["nombre"] . " " . $A["apellido"] ?></td>
                                                        <th>Asignatura<span class="required">*</span></th>
                                                        <td><?php echo $A["materia"] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Turno I (<?php echo $A["dia"] ?>)<span class="required"></span></th>
                                                        <td>Hora Entrada<span class="required"></span></td>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="ehora" value="<?php if ($A["1ini"]!=0) { echo date("h:i A", strtotime($A["1ini"])); } ?>"></input>
                                                        </td>
                                                        <th>Hora Salida<span class="required"></span></th>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="shora" value="<?php if ($A["1fin"]!=0) { echo date("h:i A", strtotime($A["1fin"])); } ?>"></input>                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Turno II (<?php echo $R2["dia"]; ?>)<span class="required"></span></th>
                                                        <td>Hora Entrada<span class="required"></span></td>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="ehora" value="<?php if ($A["2ini"]!=0) { echo date("h:i A", strtotime($A["2ini"])); } ?>"></input>
                                                        </td>
                                                        <th>Hora Salida<span class="required"></span></th>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="shora" value="<?php if ($A["2fin"]!=0) { echo date("h:i A", strtotime($A["2fin"])); } ?>"></input>                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Turno III (<?php echo $R3["dia"]; ?>)<span class="required"></span></th>
                                                        <td>Hora Entrada<span class="required"></span></td>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="ehora" value="<?php if ($A["3ini"]!=0) { echo date("h:i A", strtotime($A["3ini"])); }?>"></input>
                                                        </td>
                                                        <th>Hora Salida<span class="required"></span></th>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="shora" value="<?php if ($A["3fin"]!=0) { echo date("h:i A", strtotime($A["3fin"])); } ?>"></input>                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                            <div class="rule"></div>
                                            <span class="required">(*) Solo Lectura</span>
                                            <div class="tab-footer clear">
                                                <div class="fr">
                                                    <a href="nuevo_asistencia.php?id=<?php echo $id; ?>" class="button green">Marcaje Manual</a>
                                                    <a href="edita_horario.php?id=<?php echo $id; ?>" class="button">Editar</a>
                                                    <a href="javascript:history.go(-1)" class="button red">Volver</a>
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
                <p class="bt-space15"><span class="copy"><strong>© <?php echo date('Y') ?> Todos los Derechos Reservados <a href="http://www.SICA.com/">SICA</a></strong></span> Desarrollado por <a href="http://www.psmporlamar.edu.ve">IUPSM</a></p>
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
