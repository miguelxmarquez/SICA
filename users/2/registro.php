<?php
require "../../seguridad.php";
require_once "../../includes/funciones.php";

setlocale(LC_TIME, 'spanish');
$fecha = utf8_encode(ucfirst(strftime("%d/%m/%Y", time())));

// Recojemos los parametros por url
$id = $_GET["id"];
$ci = $_GET["ci"];

include '../../conex.php';
$sql = "SELECT * FROM personas WHERE id = '$id'";
if ($result = mysql_query($sql)) {
    $A = mysql_fetch_array($result);
    $escuela = $A["escuela"];
    $sql_escuela = "SELECT especialidad FROM escuelas WHERE codigo = '$escuela'";
    $result_escuela = mysql_query($sql_escuela);
    $B = @mysql_fetch_array($result_escuela);
}
if ($A["activo"] == 0) {
    $activo = "Inactivo";
}
if ($A["activo"] == 1) {
    $activo = "Activo";
}

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
        <title>SICA: Ver Registro</title>
        <link rel="stylesheet" href="../../css/reset.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/screen.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/fancybox.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.wysiwyg.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.ui.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize-light.css" type="text/css"/>
        <link rel="shortcut icon" href="favicon.ico" />


    </head>
    <body onload="generateBarcode()">
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
                            <a href="nuevo_profesor.php">Profesores</a>
                            <ul>
                                <li class="active"><a href="nuevo_profesor.php">Nuevo Profesor</a></li>
                                <li><a href="buscar_registro.php">Buscar Profesor</a></li>
                            </ul>
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
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>Cerrar</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> El Registro ha sido actualizado exitosamente.</p>
		  </div>";
                }
                if ($_GET["saved"] == "no") {
                    echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>Cerrar</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> El Registro no ha sido guardado, intentelo de nuevo. Error inesperado en la insercion del registro en la base de datos</p>
		  </div>";
                }
                ?>

                <div class="page clear">
                    <h1>Sistema para el control de Asistencias</h1>

                    <div class="content-box">
                        <div class="box-body">
                            <div class="box-header clear">
                                <ul class="tabs clear">
                                    <li><a href="#tab1">Datos de Registro</a></li>
                                </ul>
                                <h2>Sitema de Control de Asistencias</h2>
                            </div>
                            <div class="box-wrap clear">
                                <input type="hidden" name="fecha" id="fecha" value="<?php echo $fecha; ?>"></input>
                                <input type="hidden" name="id_usuario" id="fecha" value="<?php echo $_SESSION["id"]; ?>"></input>

                               
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
                                                        <?php if ($A["foto"] == 0) { ?>
                                                            <a href="tomar.php?id=<?php echo $A["ci"] ?>">Agregar Fotografía</a>
                                                            <?php
                                                        } else {
                                                            
                                                        }
                                                        ?>
                                                        <img src="../../data/fotos/<?php echo $A["ci"] ?>.jpg" class="thumb" width=170 height=170/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>C.I./ Pasaporte / R.I.F.<span class="required"> *</span></th>
                                                    <td> <input size="27" disabled="yes" readonly="yes" value="<?php echo $A["ci"] ?>" type="text" name="ci" id="ci" class="required text fl-space2"></input></td>
                                                    <th>Edad<span class="required"> *</span></th>
                                                    <td><input  size="27" disabled="yes" readonly="yes" value="<?php echo CalculaEdad($A["fecha_n"]) ?>" type="text" name="fecha_n" id="datepicker" class="fl-space text datepicker required" readonly="yes"></input></td>
                                                </tr>
                                                <tr>
                                                    <th>Nombre<span class="required"> *</span></th>
                                                    <td> <input  size="27" disabled="yes" readonly="yes" value="<?php echo $A["nombre"] ?>" type="text" name="nombre" id="nombre" class="required text fl-space2" ></input></td>
                                                    <th>Apellido<span class="required"> *</span></th>
                                                    <td><input  size="27" disabled="yes" readonly="yes" value="<?php echo $A["apellido"] ?>" type="text" name="apellido" id="apellido" class="required text fl-space2" ></input></td>
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
                                                    <td><input size="27"  disabled="yes" readonly="yes" type="text" name="sexo" id="sexo" class="required text fl-space2" value="<?php echo $sexo; ?>"></input></td>

                                                    <th>Edo. Nacimiento<span class="required"> *</span></th>
                                                    <td><input  size="27" disabled="yes" readonly="yes" type="text" name="sexo" id="sexo" class="required text fl-space2" value="<?php echo $A["edo_n"]; ?>"></input></td>


                                                </tr>
                                                <tr>
                                                    <th>Dirección<span class="required"> *</span></th>
                                                    <td> <input  size="27" disabled="yes" readonly="yes" value="<?php echo $A["direccion"] ?>" type="text" name="dir" id="dir" class="required text fl-space2" ></input></td>
                                                    <th>Fecha de Nacimiento<span class="required"> *</span></th>
                                                    <td><input  size="27" disabled="yes" readonly="yes" value="<?php echo $A["fecha_n"]; ?>" type="text" name="fecha_n" id="datepicker" class="fl-space text datepicker required" readonly="yes"></input></td>


                                                </tr>
                                                <tr>
                                                    <th>Correo Electrónico<span class="required"> *</span></th>
                                                    <td><input  size="27" disabled="yes" readonly="yes" value="<?php echo $A["email"] ?>" type="text" name="email" id="email" class="required text fl-space2"></input></td>
                                                    <th>Grado de Instrucción<span class="required"> *</span></th>
                                                    <td><input  size="27" disabled="yes" readonly="yes" value="<?php echo $A["g_inst"] ?>" type="text" name="g_inst" id="g_inst" class="required text fl-space2"></input></td>

                                                </tr>

                                                <tr>
                                                    <th>Estado<span class="required"> *</span></th>
                                                    <td colspan=""><input  size="27" disabled="yes" readonly="yes" value="<?php echo $activo ?>" type="text" name="email" id="email" class="required text fl-space2"></input></td>
                                                    <th>Escuela<span class="required"> *</span></th>
                                                    <td colspan=""><input  size="27" disabled="yes" readonly="yes" value="<?php echo $B["especialidad"];?>" type="text" name="g_inst" id="g_inst" class="required text fl-space2"></input></center></td>

                                                </tr>
                                                <tr>
                                                    <th colspan="1"></th>
                                                    <th colspan="">Barra<span class="required"> *</span></th>
                                                    <td colspan="4"><center><?php include 'barcode.php'; ?></center></td>

                                                </tr>

                                            </tbody>
                                        </table>

                                        <div class="tab-footer clear">
                                            <div class="fr">
                                                
                                                <a href="buscar_materia.php?id=<?php echo $id ?>" class="button green">Agregar Horas</a>
                                                <a href="ver_horario_profesor.php?id=<?php echo $id ?>" class="button blue">Ver Horario</a>
                                                <a href="edita_profesor.php?id=<?php echo $id ?>" class="button">Editar</a>
                                                <a href="javascript:history.go(-1)" class="button red">Volver</a>
                                            </div>
                                        <span class="required">(*) Solo Lectura</span>
                                        
                                        </div>
                                        
                                    </div><!-- end of box-wrap --> 

                                

                            </div> <!-- end of box-wrap -->
                        </div> <!-- end of box-body -->
                    </div> <!-- end of content-box -->
                </div> <!-- end of box-body -->

            </div><!-- end of page -->
        </div>


        <div class="footer">
            <div class="pagesize clear">
                <p class="bt-space15"><span class="copy"><strong>© <?php echo date('Y') ?>  Todos los Derechos Reservados <a href="http://www.SICA.com/">SICA</a></strong></span> Desarrollado por <a href="http://www.psmporlamar.edu.ve">IUPSM</a></p>
            </div>
        </div>

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
        <script type="text/javascript" src="../../js/jquery.blockUI.js"></script>
        <script type="text/javascript" src="../../js/excanvas.js"></script>

        <script type="text/javascript" src="../../js/cufon.js"></script>
        <script type="text/javascript" src="../../js/Zurich_Condensed_Lt_Bd.js"></script>
        <script type="text/javascript" src="../../js/script.js"></script>

    </body>
</html>
