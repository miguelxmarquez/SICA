<?php
require "../../seguridad.php";
require_once "../../includes/funciones.php";

setlocale(LC_TIME, 'spanish');
$fecha = utf8_encode(ucfirst(strftime("%d/%m/%Y", time())));

// Recojemos los parametros por url
$id = $_GET["id"];
$ci = $_GET["ci"];

include '../../conex.php';
$sql = "SELECT * FROM registros WHERE id = '$id'";
$result = mysql_query($sql);
$A = mysql_fetch_array($result);

$sql2 = "SELECT * FROM eva_general WHERE ci = '$ci' ORDER BY id DESC LIMIT 1";
$result2 = mysql_query($sql2);
$A2 = mysql_fetch_array($result2);

$sql3 = "SELECT * FROM eva_odonto WHERE ci = '$ci' ORDER BY id DESC LIMIT 1";
$result3 = mysql_query($sql3);
$A3 = mysql_fetch_array($result3);

$sql4 = "SELECT * FROM eva_psico WHERE ci = '$ci' ORDER BY id DESC LIMIT 1";
$result4 = mysql_query($sql4);
$A4 = mysql_fetch_array($result4);

mysql_close();
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
        <title>SICA: Historia</title>
        <script type="text/javascript" src="../../js/jquery.js"></script>
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
                            <a href="nueva_orden.php">Registros</a>
                            <ul>
                                <li class="active"><a href="nuevo_registro.php">Nuevo Registro</a></li>
                                <li><a href="buscar_registro.php">Buscar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="breadcrumb">
            <div class="bread-links pagesize">
                <ul class="clear">
                    <li class="first">Estás en:</li>
                    <li><a href="#">Registros</a><span>&raquo;</span></li>
                    <li><a href="#">Historia</a></li>
                </ul>
            </div>
        </div>
        <div class="main pagesize"> <!-- *** mainpage layout *** -->
            <div class="main-wrap">

                <div class="page clear">
                    <h1>Sistema de Registro</h1>
                    <p><?php echo utf8_encode(ucfirst(strftime("%A, %d de %B del %Y", time()))); ?></p>
                    <div class="content-box">
                        <div class="box-body">
                            <div class="box-header clear">
                                <ul class="tabs clear">
                                    <li><a href="#tab1">Datos Personales</a></li>
                                    <li><a href="#tab2">Examen General</a></li>
                                    <li><a href="#tab3">Odontológico</a></li>
                                    <li><a href="#tab4">Psicológico</a></li>
                                </ul>
                                <h2>Inscripción del Registro Militar</h2>
                            </div>
                            <div class="box-wrap clear">
                                <input type="hidden" name="fecha" id="fecha" value="<?php echo $fecha; ?>"></input>
                                <input type="hidden" name="id_usuario" id="fecha" value="<?php echo $_SESSION["id"]; ?>"></input>

                                <!--   Tab1    -->
                                <div id="tab1">
                                    <h2>Datos de Registro</h2>
                                    <div class="box-wrap clear">
                                        <table class="style1">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Fotografía</th>
                                                    <th>Descripción</th>
                                                    <th class="full">Valor</th>
                                                    <th>Descripción</th>
                                                    <th class="full">Valor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td rowspan="7" style="text-align: center;">
                                                        <img src="../../data/fotos/<?php echo $A["ci"] ?>.jpg" class="thumb" width=150 height=170/>
                                                    </td>
                                                </tr>

                                                <tr>

                                                    <th>Primer Nombre</th>
                                                    <td> <input disabled="yes" readonly="yes" type="text" name="p_nombre" id="p_nombre" class="required text fl-space2" value="<?php echo $A["p_nombre"] ?>"></input></td>
                                                    <th>Segundo Nombre</th>
                                                    <td><input disabled="yes" readonly="yes" type="text" name="s_nombre" id="s_nombre" class="required text fl-space2" value="<?php echo $A["s_nombre"] ?>"></input></td>
                                                </tr>
                                                <tr>
                                                    <th>Primer Apellido</th>
                                                    <td> <input disabled="yes" readonly="yes" type="text" name="p_apellido" id="p_apellido" class="required text fl-space2" value="<?php echo $A["p_apellido"] ?>"></input></td>
                                                    <th>Segundo Segundo</th>
                                                    <td><input disabled="yes" readonly="yes" type="text" name="s_apellido" id="s_apellido" class="required text fl-space2" value="<?php echo $A["s_apellido"] ?>"></input></td>
                                                </tr>
                                                <tr>
                                                    <th>C.I.</th>
                                                    <td><input disabled="yes" readonly="yes" type="text" name="cedula" id="cedula" class="required text fl-space2" value="<?php echo $A["ci"] ?>"></input></td>
                                                    <th>Edad</th>
                                                    <td><input disabled="yes" readonly="yes" name="edad" id="edad" type="text" class="required text fl-space2" value="<?php echo CalculaEdad($A["fecha_n"])  ?>"></input></td>
                                                </tr>
                                                <tr>
                                                    <th>Lugar de Nacimiento (Estado)</th>
                                                    <td><input disabled="yes" readonly="yes" type="text" name="l_nac" id="l_nac" class="required text fl-space2" value="<?php echo $A["lugar_n"] ?>"></input></td>
                                                    <th>Fecha de Nacimiento</th>
                                                    <td><input disabled="yes" readonly="yes" type="text" name="f_nac" id="f_nac" class="datepicker-inline required text fl-space2" value="<?php echo $A["fecha_n"] ?>"></input></td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    if ($A["sexo"] == "M") {
                                                        $sexo = "Masculino";
                                                    }
                                                    if ($A["sexo"] == "F") {
                                                        $sexo = "Femenino";
                                                    }
                                                    ?>
                                                    <th>Sexo</th>
                                                    <td><input disabled="yes" readonly="yes" type="text" name="sexo" id="sexo" class="required text fl-space2" value="<?php echo $sexo; ?>"></input></td>
                                                    <th>Grado de Instrucción </th>
                                                    <td><input disabled="yes" readonly="yes" type="text" name="g_inst" id="g_inst" class="required text fl-space2" value="<?php echo $A["instruccion"] ?>"></input></td>

                                                </tr>
                                                <tr>
                                                    <th>Capacitación</th>
                                                    <td><input disabled="yes" readonly="yes" type="text" name="capacitacion" id="capacitacion" class="required text fl-space2" value="<?php echo $A["capacitacion"] ?>"></input></td>
                                                    <th>Ocupación Principal</th>
                                                    <td><input disabled="yes" readonly="yes" type="text" name="o_principal" id="o_principal" class="required text fl-space2" value="<?php echo $A["ocupacion"] ?>"></input></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <div class="rule"></div>
                                        <span class="required">(*) No posee privilegios para editar</span>
                                        <div class="tab-footer clear">
                                            <div class="fr">
                                                <a href="index.php" class="button red">Volver</a>
                                            </div>
                                        </div>
                                    </div><!-- end of box-wrap --> 

                                </div>
                                <!--   Fin Tab1    -->

                                <!--   Tab2    -->
                                <div id="tab2">

                                    <h2>Evaluación General</h2>
                                    <div class="box-wrap clear">
                                        <div id="data-table">
                                            <center><h2>Historial de Exámenes</h2></center>
                                            <table class="style1 datatable">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Nro. de Registro</th>
                                                        <th>C.I Conscrito</th>
                                                        <th>Nombre</th>
                                                        <th>Apellido</th>
                                                        <th>Fecha de Registro</th>
                                                        <th>Creado por</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $ci = $_GET["ci"];
                                                    $id = $_GET["id"];
                                                    $id_usuario = $_SESSION["id"];
                                                    include '../../conex.php';
                                                    $sql = "SELECT e.id, e.ci, r.p_nombre,r.p_apellido, e.fecha, u.usuario FROM registros as r, eva_general as e, usuarios as u WHERE e.ci = $ci AND r.id = $id AND u.rol = 2";
                                                    $result = mysql_query($sql);
                                                    while ($A = mysql_fetch_array($result)) {
                                                        ?>
                                                        <tr>
                                                            <td style="text-align: center;"><?php echo $A["id"] ?></td>
                                                            <td><a href="ver_registro.php?id=<?php echo $A["id"] ?>"><?php echo $A["ci"] ?></a></td>
                                                            <td><?php echo $A["p_nombre"] ?></td>
                                                            <td><?php echo $A["p_apellido"] ?></td>
                                                            <td><?php echo $A["fecha"] ?></td>
                                                            <td><?php echo $A["usuario"] ?></td>
                                                            <td>
                                                                <a href="general.php?id=<?php echo $A["id"] ?>"><img src="../../images/ico_edit_16.png" width="18" height="18" class="icon16 fl-space2" alt="" title="Ver" /></a>
                                                                <a onclick="return confirm('El registro será eliminado. Está seguro que desea continuar..?');" href="elimina_general.php?id=<?php echo $A["id"] ?>"><img src="../../images/ico_delete_16.png   " class="icon16 fl-space2"  width="18" height="18"  title="Eliminar Registro" /></a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div></div>
                                    <div class="rule"></div>
                                    <span class="required">(*) No posee privilegios para editar</span>
                                    <div class="tab-footer clear">
                                        <div class="fr">
                                            <a href="index.php" class="button red">Volver</a>
                                        </div>
                                    </div>
                                </div><!--   Fin Tab2    -->

                                <!--   Tab3    -->
                                <div id="tab3">

                                    <h2>Evaluación Odontológica</h2>
                                    <div class="box-wrap clear">
                                        <div id="data-table">
                                            <center><h2>Historial de Exámenes</h2></center>
                                            <table class="style1 datatable">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Nro. de Registro</th>
                                                        <th>C.I Conscrito</th>
                                                        <th>Nombre</th>
                                                        <th>Apellido</th>
                                                        <th>Fecha de Registro</th>
                                                        <th>Creado por</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $ci = $_GET["ci"];
                                                    $id = $_GET["id"];
                                                    $id_usuario = $_SESSION["id"];
                                                    include '../../conex.php';
                                                    $sql = "SELECT e.id, e.ci, r.p_nombre,r.p_apellido, e.fecha, u.usuario FROM registros as r, eva_odonto as e, usuarios as u WHERE e.ci = $ci AND r.id = $id AND u.rol = 2";
                                                    $result = mysql_query($sql);
                                                    while ($A = mysql_fetch_array($result)) {
                                                        ?>
                                                        <tr>
                                                            <td style="text-align: center;"><?php echo $A["id"] ?></td>
                                                            <td><a href="ver_registro.php?id=<?php echo $A["id"] ?>"><?php echo $A["ci"] ?></a></td>
                                                            <td><?php echo $A["p_nombre"] ?></td>
                                                            <td><?php echo $A["p_apellido"] ?></td>
                                                            <td><?php echo $A["fecha"] ?></td>
                                                            <td><?php echo $A["usuario"] ?></td>
                                                            <td>
                                                                <a href="odontologico.php?id=<?php echo $A["id"] ?>"><img src="../../images/ico_edit_16.png" width="18" height="18" class="icon16 fl-space2" alt="" title="Ver" /></a>
                                                                <a onclick="return confirm('El registro será eliminado. Está seguro que desea continuar..?');" href="elimina_odonto.php?id=<?php echo $A["id"] ?>"><img src="../../images/ico_delete_16.png   " class="icon16 fl-space2"  width="18" height="18"  title="Eliminar Registro" /></a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div></div>
                                    <div class="rule"></div>
                                    <span class="required">(*) No posee privilegios para editar</span>
                                    <div class="tab-footer clear">
                                        <div class="fr">
                                            <a href="index.php" class="button red">Volver</a>
                                        </div>
                                    </div>
                                </div><!--   Fin Tab3    -->

                                <!--   Tab4    -->
                                <div id="tab4">

                                    <h2>Evaluación Psicológica</h2>
                                    <div class="box-wrap clear">
                                        <div id="data-table">
                                            <center><h2>Historial de Exámenes</h2></center>
                                            <table class="style1 datatable">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Nro. de Registro</th>
                                                        <th>C.I Conscrito</th>
                                                        <th>Nombre</th>
                                                        <th>Apellido</th>
                                                        <th>Fecha de Registro</th>
                                                        <th>Creado por</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $ci = $_GET["ci"];
                                                    $id = $_GET["id"];
                                                    $id_usuario = $_SESSION["id"];
                                                    include '../../conex.php';
                                                    $sql = "SELECT e.id, e.ci, r.p_nombre,r.p_apellido, e.fecha, u.usuario FROM registros as r, eva_psico as e, usuarios as u WHERE e.ci = $ci AND r.id = $id AND u.rol = 2";
                                                    $result = mysql_query($sql);
                                                    while ($A = mysql_fetch_array($result)) {
                                                        ?>
                                                        <tr>
                                                            <td style="text-align: center;"><?php echo $A["id"] ?></td>
                                                            <td><a href="ver_registro.php?id=<?php echo $A["id"] ?>"><?php echo $A["ci"] ?></a></td>
                                                            <td><?php echo $A["p_nombre"] ?></td>
                                                            <td><?php echo $A["p_apellido"] ?></td>
                                                            <td><?php echo $A["fecha"] ?></td>
                                                            <td><?php echo $A["usuario"] ?></td>
                                                            <td>
                                                                <a href="psicologico.php?id=<?php echo $A["id"] ?>"><img src="../../images/ico_edit_16.png" width="18" height="18" class="icon16 fl-space2" alt="" title="Ver" /></a>
                                                                <a onclick="return confirm('El registro será eliminado. Está seguro que desea continuar..?');" href="elimina_psico.php?id=<?php echo $A["id"] ?>"><img src="../../images/ico_delete_16.png   " class="icon16 fl-space2"  width="18" height="18"  title="Eliminar Registro" /></a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div></div>
                                    <div class="rule"></div>
                                    <span class="required">(*) No posee privilegios para editar</span>
                                    <div class="tab-footer clear">
                                        <div class="fr">
                                            <a href="index.php" class="button red">Volver</a>
                                        </div>
                                    </div>
                                </div><!--   Fin Tab4    -->

                            </div> <!-- end of box-wrap -->
                        </div> <!-- end of box-body -->
                    </div> <!-- end of content-box -->
                </div> <!-- end of box-body -->

            </div><!-- end of page -->
        </div>


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

        <script type="text/javascript" src="../../js/excanvas.js"></script>
        <script type="text/javascript" src="../../js/cufon.js"></script>
        <script type="text/javascript" src="../../js/Zurich_Condensed_Lt_Bd.js"></script>
        <script type="text/javascript" src="../../js/script.js"></script>

    </body>
</html>
