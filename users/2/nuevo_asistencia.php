<?php
require "../../seguridad.php";
include '../../conex.php';

$id = $_GET["id"];
$id_usuario = $_SESSION["id"];
$sql_horario = "SELECT h.id, m.id as id_materia, s.dia, h.2dia, h.3dia, p.id as id_profesor, p.nombre, p.apellido, m.materia, h.1ini, h.1fin, h.1dia, h.2ini, h.2fin, h.2dia, h.3ini, h.3fin, h.3dia
                FROM horarios AS h, personas AS p, materias AS m, semana AS s
                WHERE h.id='$id' 
                AND p.id=h.id_profesor 
                AND h.materia = m.id 
                AND h.1dia=s.id";

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
        <title>SICA: Nuevo Marcaje Manual</title>
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" href="../../css/reset.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/screen.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/fancybox.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.wysiwyg.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.ui.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize-light.css" type="text/css"/>

        <script>
            function checkbox(esto){
                valido=0;
                for(a=0; a < esto.elements.length; a++){
                    if(esto[a].type=="checkbox" && esto[a].checked==true){
                        valido+=1;
                    }

                }
                if(valido != 1){
                    alert("Debe chequear una casilla..!!");
                    return false;
                }

            } 


        </script>
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
                    dateFormat: 'yy-mm-dd' ,
                    maxDate: new Date() ,
                    minDate: new Date(2013, 01, 01)
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

        <form id="datos" name="datos" method="POST" class="validate-form form bt-space15" onsubmit="return checkbox(this)" action="guarda_asistencia.php">
            <div class="main pagesize"> <!-- *** mainpage layout *** -->
                <div class="main-wrap">

                    <div class="page clear">
                        <h1>Nuevo Marcaje Manual</h1>
                        <p>
                            <?php
// Fecha
                            setlocale(LC_TIME, 'spanish');
                            echo utf8_encode(ucfirst(strftime("%A, %d de %B de %Y", time())));
                            $fecha = utf8_encode(ucfirst(strftime("%d/%m/%Y", time())));
                            ?>
                        </p>
                        <input type="hidden" name="created_by" id="id" value="<?php echo $id_usuario ?>"></input>
                        <input type="hidden" name="id_profesor" id="id" value="<?php echo $A["id_profesor"] ?>"></input>
                        <input type="hidden" name="id_materia" id="id" value="<?php echo $A["id_materia"] ?>"></input>
                        <input type="hidden" name="id_horario" id="id" value="<?php echo $_GET["id"] ?>"></input>

                        <input type="hidden" name="ehora1" value="<?php echo $A["1ini"]; ?>"></input>
                        <input type="hidden" name="shora1" value="<?php echo $A["1fin"]; ?>"></input>

                        <input type="hidden" name="ehora2" value="<?php echo $A["2ini"]; ?>"></input>
                        <input type="hidden" name="shora2" value="<?php echo $A["2fin"]; ?>"></input>

                        <input type="hidden" name="ehora3" value="<?php echo $A["3ini"]; ?>"></input>
                        <input type="hidden" name="shora3" value="<?php echo $A["3fin"]; ?>"></input>

                        <div class="content-box">
                            <div class="box-body">
                                <div class="box-header clear">
                                    <h2>Marcaje Manual</h2>
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
                                                        <td colspan="2"> <?php echo $A["nombre"] . " " . $A["apellido"] ?></td>
                                                        <th>Asignatura<span class="required">*</span></th>
                                                        <td><?php echo $A["materia"] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <?php
                                                            if ($A["dia"] != "") {
                                                                echo "<input type=\"checkbox\" name=\"turno\" id=\"turno\" value=\"1\"/>";
                                                            }
                                                            ?>
                                                            Turno I (<?php echo $A["dia"] ?>)<span class="required"></span></th>
                                                        <td>Hora Entrada<span class="required"></span></td>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="ehora1" value="<?php echo $A["1ini"]; ?>"></input>
                                                        </td>
                                                        <th>Hora Salida<span class="required"></span></th>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="shora1" value="<?php echo $A["1fin"]; ?>"></input>                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <?php
                                                            if ($R2["dia"] != "") {
                                                                echo "<input type=\"checkbox\" name=\"turno\" id=\"turno\" value=\"2\"/>";
                                                            }
                                                            ?>
                                                            Turno II (<?php echo $R2["dia"]; ?>)<span class="required"></span></th>
                                                        <td>Hora Entrada<span class="required"></span></td>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="ehora2" value="<?php echo $A["2ini"]; ?>"></input>
                                                        </td>
                                                        <th>Hora Salida<span class="required"></span></th>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="shora2" value="<?php echo $A["2fin"]; ?>"></input>                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th> 
                                                            <?php
                                                            if ($R3["dia"] != "") {
                                                                echo "<input type=\"checkbox\" name=\"turno\" id=\"turno\" value=\"3\"/>";
                                                            }
                                                            ?>
                                                            Turno III (<?php echo $R3["dia"]; ?>)<span class="required"></span></th>
                                                        <td>Hora Entrada<span class="required"></span></td>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="ehora3" value="<?php echo $A["3ini"]; ?>"></input>
                                                        </td>
                                                        <th>Hora Salida<span class="required"></span></th>
                                                        <td>
                                                            <input type="text" disabled="yes" size="10" name="shora3" value="<?php echo $A["3fin"]; ?>"></input>                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fecha del Marcaje Manual</th>
                                                        <td colspan="4"><input type="text" name="fecha_marcaje" id="datepicker" class="fl-space text datepicker required" readonly="yes"></input></td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                            <span class="required">(*) Solo Lectura</span>
                                            <div class="tab-footer clear">
                                                <div class="fr">
                                                    <input type="submit" value="Generar Marcaje Manual" id="guardar" class="submit"/>
                                                    <a href="javascript:history.go(-1)" class="button red">Volver</a>
                                                </div>
                                            </div>
                                            <div class="rule"></div>

                                        </div><!-- end of box-wrap -->  

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
