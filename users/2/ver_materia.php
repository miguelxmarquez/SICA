<?php
require "../../seguridad.php";

$id = $_GET["id"];
$sql_materia = "SELECT m.materia, s.seccion, e.especialidad, m.semestre 
                FROM materias as m, escuelas as e, secciones as s
                WHERE m.id = '$id' AND e.codigo = m.especialidad AND m.seccion = s.id";
if ($result = mysql_query($sql_materia)) {
    $M = mysql_fetch_array($result);
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
        <title>SICA: Ver Materia</title>
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
                        <li class="active">
                            <a href="#">Materias</a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <form id="datos" name="datos" method="POST" class="validate-form form bt-space15" action="actualiza_horario.php">
            <div class="main pagesize"> <!-- *** mainpage layout *** -->
                <div class="main-wrap">

                    <div class="page clear">
                        <h1>Ver Materia</h1>
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
                                    <h2>Vista de Asignatura</h2>
                                </div>
                                <div class="box-wrap clear">
                                    <div>
                                        <div class="box-wrap clear">
                                            <table class="style1">
                                                <thead>
                                                    <tr>
                                                        <th>Descripción</th>
                                                        <th class="full">Valor</th>
                                                        <th>Descripción</th>
                                                        <th class="full" >Valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Nombre de la Materia<span class="required"> *</span></th>
                                                        <td> <input disabled="yes" size="45" value="<?php echo $M["materia"] ?>" type="text" name="nombre" id="nombre" class="required text fl-space2" ></input></td>
                                                        <th>Seccion<span class="required"> *</span></th>
                                                        <td>
                                                            <input  disabled="yes" type="text" size="34" value="<?php echo $M["seccion"] ?>"></input>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Especialidad a la que pertenece<span class="required"> *</span></th>
                                                        <td>
                                                            <input type="text"  disabled="yes" size="38" value="<?php echo $M["especialidad"] ?>"></input>                                                      </td>
                                                        <th>Semestre<span class="required"> *</span></th>
                                                        <td><input name="descripcion" disabled="yes"     size="40" id="descripcion" type="text" value="<?php echo $M["semestre"] ?>" class="required text fl-space2"></input></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <div class="rule"></div>
                                            <span class="required">(*) Solo Lectura</span>
                                            <div class="tab-footer clear">
                                                <div class="fr">
                                                    <a href="edita_materia.php?id=<?php echo $id ?>" class="button blue">Editar</a>
                                                    <a href="materias.php" class="button red">Volver</a>
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
