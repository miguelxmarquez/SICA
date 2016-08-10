<?php
require "../../seguridad.php";
require "../../conex.php";

$id = $_GET["id"];
$sql_persona = "SELECT * FROM personas WHERE id = '$id'";

if ($result_persona = mysql_query($sql_persona)) {

    $A = mysql_fetch_array($result_persona);
    $codigo = $A["escuela"];
    $sql_especialidad = "SELECT id FROM escuelas WHERE codigo = $codigo";

    $result_especialidad = mysql_query($sql_especialidad);
    $B = @mysql_fetch_array($result_especialidad);
    $id_especialidad = $B["id"];
    $activo = $A["activo"];
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
        <title>SICA: Editar Profesor</title>
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
    <body onload="document.datos.activo.selectedIndex=<?php echo $activo ?>;document.datos.escuela.selectedIndex=<?php echo $id_especialidad; ?>">

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
                            <li class="active"><a href="#">Profesores</a></li>

                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <!--    INICIO FORM    -->

        <form id="datos" name="datos" method="POST" class="validate-form form bt-space15" action="actualiza_profesor.php">
            <div class="main pagesize"> <!-- *** mainpage layout *** -->
                <div class="main-wrap">

                    <div class="page clear">
                       
                        <input type="hidden" name="fecha" id="fecha" value="<?php echo $fecha ?>"></input>
                        <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION["usuario"]; ?>"></input>
                        <input type="hidden" name="id_persona" id="id_persona" value="<?php echo $id ?>"></input>
                        <input type="hidden" name="ci" id="ci" value="<?php echo $A["ci"]; ?>"></input>
                        <div class="content-box">
                            <div class="box-body">
                                <div class="box-header clear">
                                    <h2>Edición de Profesores</h2>
                                </div>
                                <div class="box-wrap clear">
                                    <div>
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
                                                                <?php } if ($A["foto"] == 1) { ?>
                                                                <a href="tomar.php?id=<?php echo $A["ci"] ?>">Cambiar Fotografía</a>
                                                            <?php }
                                                            ?>
                                                            <img src="../../data/fotos/<?php echo $A["ci"] ?>.jpg" class="thumb" width=170 height=170/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>C.I./ Pasaporte / R.I.F.<span class="required"> *</span></th>
                                                        <td> <input size="26" disabled="yes" readonly="yes" value="<?php echo $A["ci"] ?>" type="text" name="ci" id="ci" class="required text fl-space2"></input></td>
                                                        <th>Edad<span class="required"> *</span></th>
                                                        <td><input  size="26" disabled="yes" readonly="yes" value="<?php echo CalculaEdad($A["fecha_n"]) ?>" type="text" name="fecha_n" id="datepicker" class="fl-space text datepicker required" readonly="yes"></input></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nombre<span class="required"> *</span></th>
                                                        <td> <input  size="26" value="<?php echo $A["nombre"] ?>" type="text" name="nombre" id="nombre" class="required text fl-space2" ></input></td>
                                                        <th>Apellido<span class="required"> *</span></th>
                                                        <td><input  size="26" value="<?php echo $A["apellido"] ?>" type="text" name="apellido" id="apellido" class="required text fl-space2" ></input></td>
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
                                                        <td><input size="26"  disabled="yes" readonly="yes" type="text" name="sexo" id="sexo" class="required text fl-space2" value="<?php echo $sexo; ?>"></input></td>

                                                        <th>Edo. Nacimiento<span class="required"> *</span></th>
                                                        <td><input  size="26" disabled="yes" readonly="yes" type="text" name="sexo" id="sexo" class="required text fl-space2" value="<?php echo $A["edo_n"]; ?>"></input></td>


                                                    </tr>
                                                    <tr>
                                                        <th>Dirección<span class="required"> *</span></th>
                                                        <td> <input  size="26" value="<?php echo $A["direccion"] ?>" type="text" name="direccion" id="direccion" class="required text fl-space2" ></input></td>
                                                        <th>Fecha de Nacimiento<span class="required"> *</span></th>
                                                        <td><input  size="26" disabled="yes" readonly="yes" value="<?php echo $A["fecha_n"]; ?>" type="text" name="fecha_n" id="datepicker" class="fl-space text datepicker required" readonly="yes"></input></td>


                                                    </tr>
                                                    <tr>
                                                        <th>Correo Electrónico<span class="required"> *</span></th>
                                                        <td><input  size="26" value="<?php echo $A["email"] ?>" type="text" name="email" id="email" class="required text fl-space2"></input></td>
                                                        <th>Título Académico<span class="required"> *</span></th>
                                                        <td><input  size="26" value="<?php echo $A["g_inst"] ?>" type="text" name="g_inst" id="g_inst" class="required text fl-space2"></input></td>

                                                    </tr>
                                                    <tr>
                                                        <th>Estado<span class="required"> *</span></th>
                                                        <td>
                                                            <select name="activo" id="activo">
                                                                <option value="0">Inactivo</option>
                                                                <option value="1">Activo</option>
                                                            </select>
                                                        </td>
                                                        <th>Escuela<span class="required"> *</span></th>
                                                        <td>

                                                            <select id="escuela" name="escuela" class="required">
                                                                <option></option>

                                                                <?php
                                                                $sql = "SELECT * FROM escuelas ORDER BY id";
                                                                $result = mysql_query($sql);
                                                                $i = 0;
                                                                while ($row = mysql_fetch_array($result)) {
                                                                    echo "<option value=\"" . $row["codigo"] . "\">" . $row["especialidad"] . "</option>\n";
                                                                }
                                                                echo "</select>";
                                                                ?>

                                                            </select>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>

                                            <div class="tab-footer clear">
                                                <div class="fr">
                                                    <input type="submit" value="Guardar Cambios" id="guardar" class="submit" />
                                                    <a href="javascript: history.go(-1)" class="button red">Cancelar</a>

                                                </div>


                                                <span class="required">(*) Campos requeridos</span>


                                            </div><!-- end of box-wrap -->  

                                            <div class="rule"></div>



                                        </div>
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


        <script type="text/javascript" src="../../js/jquery.validate.js"></script>
        <script type="text/javascript" src="../../js/validaciones.js"></script>


    </body>
</html>
