<?php
require "../../seguridad.php";

$ci = $_GET["ci"];
$id_materia = $_GET["id"];


$sql_profesor = "SELECT * FROM personas WHERE id=$ci";
$sql_materia = "SELECT materia FROM materias WHERE id=$id_materia";

if ($result_profesor = mysql_query($sql_profesor)) {
    $P = mysql_fetch_array($result_profesor);
}
if ($result_materia = mysql_query($sql_materia)) {
    $M = mysql_fetch_array($result_materia);
}
$id_profesor = $P["ci"];
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
        <title>SICA: Nuevo Horario</title>
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
    <body onload="document.datos.nombre.focus()">

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
                        <li class="active"><a href="index.php">Horarios</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <form id="datos" name="datos" method="POST" class="validate-form form bt-space15" action="guarda_horario.php">
            <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION["id"]; ?>"></input>
            <input type="hidden" name="materia" id="materia" value="<?php echo $id_materia ?>"></input>
            <input type="hidden" name="id_profesor" id="id_profesor" value="<?php echo $ci ?>"></input>

            <div class="main pagesize"> <!-- *** mainpage layout *** -->
                <div class="main-wrap">
                    <?php
                    if (($_GET["ci"] == '') && ($_GET["id"] == '')) {
                        echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Cerra notificación\"><span>cerrar</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> Ha ocurrido un problema, verifique el proceso de asignacion de horarios.</p>
		  </div>";
                    }
                    ?>
                    <div class="page clear">
                        <h1>  Nuevo Horario </h1><h2><?php echo $P["nombre"] . " " . $P["apellido"] . " (" . $M["materia"] . ")" ?></h2>
                        <p>
                            <?php
                            setlocale(LC_TIME, 'spanish');
                            echo utf8_encode(ucfirst(strftime("%A, %d de %B de %Y", time())));
                            $fecha = utf8_encode(ucfirst(strftime("%d/%m/%Y", time())));
                            ?>
                        </p>
                        <input type="hidden" name="fecha" id="fecha" value="<?php echo $fecha ?>"></input>
                        <div class="content-box">
                            <div class="box-body">
                                <div class="box-header clear">
                                    <h2>Registro de nuevo Horario</h2>
                                </div>
                                <div class="box-wrap clear">
                                    <div>
                                        <div class="box-wrap clear">
                                            <table class="style1">
                                                <thead>
                                                    <tr>
                                                        <th>Descripción</th>
                                                        <th>Valor</th>
                                                        <th>Valor</th>
                                                        <th>Descripción</th>
                                                        <th>Valor</th>
                                                        <th>Dia</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <th>Turno I<span class="required"> *</span></th>
                                                        <td>Hora de Entrada<span class="required"></span></td>
                                                        <td>
                                                            <select name="ehora" class="required">
                                                                <option></option>
                                                                <option value="01">01</option>
                                                                <option value="02">02</option>
                                                                <option value="03">03</option>
                                                                <option value="04">04</option>
                                                                <option value="05">05</option>
                                                                <option value="06">06</option>
                                                                <option value="07">07</option>
                                                                <option value="08">08</option>
                                                                <option value="09">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                            :
                                                            <select name="eminuto" class="required">
                                                                <option></option>
                                                                <option value="00">00</option>
                                                                <option value="05">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                            <select name="ezona" class="required">
                                                                <option></option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </td>
                                                        <td>Hora de Salida<span class="required"></span></td>
                                                        <td>
                                                            <select name="shora" class="required">
                                                                <option></option>
                                                                <option value="01">01</option>
                                                                <option value="02">02</option>
                                                                <option value="03">03</option>
                                                                <option value="04">04</option>
                                                                <option value="05">05</option>
                                                                <option value="06">06</option>
                                                                <option value="07">07</option>
                                                                <option value="08">08</option>
                                                                <option value="09">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                            :
                                                            <select name="sminuto" class="required">
                                                                <option></option>                                                                <option value="00">00</option>
                                                                <option value="05">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                            <select name="szona" class="required">
                                                                <option></option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="dia1" class="selected required">
                                                                <option></option>
                                                                <option value="1">Lunes</option>
                                                                <option value="2">Martes</option>
                                                                <option value="3">Miércoles</option>
                                                                <option value="4">Jueves</option>
                                                                <option value="5">Viernes</option>
                                                                <option value="6">Sábado</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Turno II</th>
                                                        <td>Hora de Entrada</td>
                                                        <td>
                                                            <select name="ehora2">
                                                                <option></option>
                                                                <option value="01">01</option>
                                                                <option value="02">02</option>
                                                                <option value="03">03</option>
                                                                <option value="04">04</option>
                                                                <option value="05">05</option>
                                                                <option value="06">06</option>
                                                                <option value="07">07</option>
                                                                <option value="08">08</option>
                                                                <option value="09">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                            :
                                                            <select name="eminuto2">
                                                                <option></option>
                                                                <option value="00">00</option>
                                                                <option value="05">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                            <select name="ezona2">
                                                                <option></option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </td>
                                                        <td>Hora de Salida<span></span></td>
                                                        <td>
                                                            <select name="shora2">
                                                                <option></option>
                                                                <option value="01">01</option>
                                                                <option value="02">02</option>
                                                                <option value="03">03</option>
                                                                <option value="04">04</option>
                                                                <option value="05">05</option>
                                                                <option value="06">06</option>
                                                                <option value="07">07</option>
                                                                <option value="08">08</option>
                                                                <option value="09">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                            :
                                                            <select name="sminuto2">
                                                                <option></option>                                                                <option value="00">00</option>
                                                                <option value="05">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                            <select name="szona2">
                                                                <option></option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="dia2" class="selected">
                                                                <option></option>
                                                                <option value="1">Lunes</option>
                                                                <option value="2">Martes</option>
                                                                <option value="3">Miércoles</option>
                                                                <option value="4">Jueves</option>
                                                                <option value="5">Viernes</option>
                                                                <option value="6">Sábado</option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Turno III<span></span></th>
                                                        <td>Hora de Entrada<span></span></td>
                                                        <td>
                                                            <select name="ehora3">
                                                                <option></option>
                                                                <option value="01">01</option>
                                                                <option value="02">02</option>
                                                                <option value="03">03</option>
                                                                <option value="04">04</option>
                                                                <option value="05">05</option>
                                                                <option value="06">06</option>
                                                                <option value="07">07</option>
                                                                <option value="08">08</option>
                                                                <option value="09">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                            :
                                                            <select name="eminuto3">
                                                                <option></option>
                                                                <option value="00">00</option>
                                                                <option value="05">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                            <select name="ezona3">
                                                                <option></option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </td>
                                                        <td>Hora de Salida<span></span></td>
                                                        <td>
                                                            <select name="shora3">
                                                                <option></option>
                                                                <option value="01">01</option>
                                                                <option value="02">02</option>
                                                                <option value="03">03</option>
                                                                <option value="04">04</option>
                                                                <option value="05">05</option>
                                                                <option value="06">06</option>
                                                                <option value="07">07</option>
                                                                <option value="08">08</option>
                                                                <option value="09">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                            :
                                                            <select name="sminuto3">
                                                                <option></option>                                                                <option value="00">00</option>
                                                                <option value="05">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                            <select name="szona3">
                                                                <option></option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="dia3" class="selected">
                                                                <option></option>
                                                                <option value="1">Lunes</option>
                                                                <option value="2">Martes</option>
                                                                <option value="3">Miércoles</option>
                                                                <option value="4">Jueves</option>
                                                                <option value="5">Viernes</option>
                                                                <option value="6">Sábado</option>
                                                            </select>
                                                        </td>

                                                    </tr>



                                                </tbody>
                                            </table>
                                            <span class="required">(*) Campos requeridos</span>
                                            <div class="tab-footer clear">
                                                <div class="fr">
                                                    <input type="submit" value="Guardar Cambios" id="guardar" class="submit" />
                                                    <a href="horarios.php" class="button red">Cancelar</a>

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
                <p class="bt-space15"><span class="copy"><strong>&copy; <?php echo date('Y') ?> Todos los Derechos Reservados <a href="http://www.SICA.com/">SICA</a></strong></span> Desarrollado por <a href="http://www.psmporlamar.edu.ve">IUPSM</a></p>
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

        <script type="text/javascript" src="../../js/excanvas.js"></script>
        <script type="text/javascript" src="../../js/cufon.js"></script>
        <script type="text/javascript" src="../../js/Zurich_Condensed_Lt_Bd.js"></script>
        <script type="text/javascript" src="../../js/script.js"></script>

    </body>
</html>
