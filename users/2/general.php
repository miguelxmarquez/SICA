<?php
require "../../seguridad.php";
// Ver registro
$id = $_GET["id"];
include '../../conex.php';
$sql2 = "SELECT * FROM eva_general WHERE id = '$id'";
$result2 = mysql_query($sql2);
$A2 = mysql_fetch_array($result2);

$ci = $A2["ci"];
$sql = "SELECT * FROM registros WHERE ci = '$ci'";
$result = mysql_query($sql);
$A = mysql_fetch_array($result);
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
        <script type="text/javascript" src="js/jquery.js"></script>
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
        <div class="breadcrumb">
            <div class="bread-links pagesize">
                <ul class="clear">
                    <li class="first">Estás en:</li>
                    <li><a href="#">Registros</a><span>&raquo;</span></li>
                    <li><a href="#">Nuevo Registro</a></li>
                </ul>
            </div>
        </div>
        <div class="main pagesize"> <!-- *** mainpage layout *** -->
            <div class="main-wrap">

                <div class="page clear">
                    <h1>Sistema de Registro</h1>
                    <p>
                        <?php
                        // Fecha
                        setlocale(LC_TIME, 'spanish');
                        echo utf8_encode(ucfirst(strftime("%A, %d de %B de %Y", time())));
                        $fecha = utf8_encode(ucfirst(strftime("%d/%m/%Y", time())));
                        ?>
                    </p>
                    <div class="content-box">
                        <div class="box-body">
                            <div class="box-header clear">
                                <ul class="tabs clear">
                                    <li><a href="#tab1">Evaluación Médica</a></li>
                                </ul>
                                <h2>Inscripción del Registro Militar</h2>
                            </div>
                            <div class="box-wrap clear">
                                <form id="eval" name="eval" method="POST" class="validate-form form bt-space15" action="guarda_eval.php">
                                    <h3><?php echo $A["p_nombre"] . " " . $A["p_apellido"] . " CI: " . $A["ci"] . " (" . $A2["fecha"] . ")" ?></h3>
                                    <table class="style1">
                                        <tbody>
                                            <thead>
                                                <td><strong>Antecedentes Patológicos del Padre, Madre u Otro Familiar</strong></td>
                                                <td><strong>Antecedentes Patológicos Personales</strong></td>
                                            </thead>
                                            <tr>
                                                <td><input type="text" size="82" name="appm" id="appm" class="required text fl-space2" value="<?php echo $A2["appm"] ?>" disabled="yes"></input></td>
                                                <td><input type="text" size="82" name="app" id="app" class="required text fl-space2" value="<?php echo $A2["app"] ?>" disabled="yes"></input></td>                                            
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="style1">
                                        <tbody>
                                            <thead>
                                                <td><strong>Descripción</strong></td>
                                                <td><strong>Valor</strong></td>
                                                <td><strong>Descripción</strong></td>
                                                <td><strong>Valor</strong></td>
                                            </thead>
                                            <tr>
                                                <th>Peso (Kgs)</th>
                                                <td><input type="text" name="peso" id="peso" value="<?php echo $A2["peso"] ?>" disabled="yes" class="required text fl-space2"></input></td>
                                                <th>Presión Arterial (70-120)</th>
                                                <td><input type="text" name="p_arterial" id="p_arterial" value="<?php echo $A2["prea"] ?>" disabled="yes" class="required text fl-space2"></input></td>                                            </tr>
                                            <tr>
                                                <th>Pulso</th>
                                                <td><input type="text" name="pulso" id="pulso" value="<?php echo $A2["pulso"] ?>" disabled="yes" class="required text fl-space2"></input></td>
                                                <th>Agudeza Visual ( OI:10/10 OD:10/10 )</th>
                                                <td><input type="text" name="visual" id="visual" value="<?php echo $A2["visual"] ?>" disabled="yes" class="required text fl-space2"></input></td>
                                            </tr>
                                            <tr>
                                                <th>Estatura (Mts)</th>
                                                <td colspan="1"><input type="text" name="estatura" id="estatura" class="required text fl-space2" value="<?php echo $A2["estatura"] ?>" disabled="yes"></input></td>
                                                <th></th>
                                                <th></th>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <table class="style1">
                                        <tbody>
                                            <thead>
                                                <td><strong>Areas Exploradas</strong></td>
                                                <td><strong>Evaluacion</strong></td>
                                                <td><strong>Areas Exploradas</strong></td>
                                                <td><strong>Evaluacion</strong></td>
                                            </thead>
                                            <tr>
                                                <th>Cabeza y Cuello</th>
                                                <td><input type="text" name="cu" value="<?php echo $A2["cu"] ?>" disabled="yes"/></td>
                                                <th>Columna Vertebral</th>
                                                <td><input type="text" name="cv" value="<?php echo $A2["cv"] ?>" disabled="yes"/></td>
                                            </tr>
                                            <tr>
                                                <th>Ojos</th>
                                                <td><input type="text" name="ojos" value="<?php echo $A2["ojos"] ?>" disabled="yes"/></td>
                                                <th>Sistema Genito-Urinario</th>
                                                <td><input type="text" name="sgu" value="<?php echo $A2["sgu"] ?>" disabled="yes"/></td>
                                            </tr>
                                            <tr>
                                                <th>Oidos, Nariz y Garganta</th>
                                                <td><input type="text" name="ong" value="<?php echo $A2["ong"] ?>" disabled="yes"/></td>
                                                <th>Extremidades Inferiores (Capacidad Funcional)</th>
                                                <td><input type="text" name="ei" value="<?php echo $A2["ei"] ?>" disabled="yes"/></td>
                                            </tr>
                                            <tr>
                                                <th>Torax y Pulmones</th>
                                                <td><input type="text" name="tp" value="<?php echo $A2["tp"] ?>" disabled="yes"/></td>
                                                <th>Sistema Vascular (Varices)</th>
                                                <td><input type="text" name="sv" value="<?php echo $A2["sv"] ?>" disabled="yes"/></td>
                                            </tr>
                                            <tr>
                                                <th>Corazón (Ruidos y Ritmos)</th>
                                                <td><input type="text" name="crr" value="<?php echo $A2["crr"] ?>" disabled="yes"/></td>
                                                <th>Pies</th>
                                                <td><input type="text" name="pies" value="<?php echo $A2["pies"] ?>" disabled="yes"/></td>
                                            </tr>
                                            <tr>
                                                <th>Extremidades Superiores (Capacidad Funcional)</th>
                                                <td><input type="text" name="escf" value="<?php echo $A2["escf"] ?>" disabled="yes"/></td>
                                                <th>Piel</th>
                                                <td><input type="text" name="piel" value="<?php echo $A2["piel"] ?>" disabled="yes"/></td>
                                            </tr>
                                            <tr>
                                                <th>Abdomen</th>
                                                <td><input type="text" class="checkbox" name="abs" value="<?php echo $A2["abs"] ?>" disabled="yes"/></td>
                                                <th>Sistema Nervioso</th>
                                                <td><input type="text" class="checkbox" name="sn" value="<?php echo $A2["sn"] ?>" disabled="yes"/></td>
                                            </tr>
                                            <tr>
                                                <th>Aparato Digestivo (Transtornos Funcionales)</th>
                                                <td><input type="text" class="checkbox" name="adtf" value="<?php echo $A2["adtf"] ?>" disabled="yes"/></td>
                                                <th colspan="2"></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="style1">
                                        <tr>
                                            <td colspan="3"><h4 class="fl-space2 ln-22 size-300">Impresión Diagnóstica</h4><textarea name="impre" cols="85" rows="3" disabled="yes" class="required"><?php echo $A2["imp_diag"] ?></textarea></td>
                                            <td colspan="3"><h4 class="fl-space2 ln-22 size-300">Otras Areas Exploradas</h4><textarea name="otras" cols="85" disabled="yes" rows="3"><?php echo $A2["otras"] ?></textarea></td>

                                        </tr>
                                        <tr>
                                            <th colspan="3"><h4 class="fl-space2 ln-22 size-300">En Consecuencia, se recomienda sea declarado<span class="required">*</span></h4><br/><br/>
                                                <?php
                                                $apto = $A2["apto"];
                                                if ($apto == 1) {
                                                    $apto = "APTO";
                                                }
                                                if ($apto == 2) {
                                                    $apto = "APTO CONDICIONAL";
                                                }
                                                if ($apto == 3) {
                                                    $apto = "NO APTO TEMPORALMENTE";
                                                }
                                                if ($apto == 4) {
                                                    $apto = "NO APTO ABSOLUTO";
                                                }
                                                ?>

                                            </th>
                                            <td colspan="3">
                                                <label for="text6" class="fl-space2"><strong><?php echo $apto; ?></strong><span class="required"> *</span></label>

                                            </td>
                                        </tr>
                                    </table>
                                    <div class="rule"></div>
                                    <span class="required">(*) No posee privilegios para editar</span>
                                    <div class="tab-footer clear">
                                        <div class="fr">
                                            <a href="index.php" class="button red">Volver</a>
                                        </div>
                                    </div>
                                </form>
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
