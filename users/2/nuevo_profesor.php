<?php
require "../../seguridad.php";
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
        <title>SICA: Nuevo Registro de Profesor</title>
        <link rel="shortcut icon" href="favicon.ico" />
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
        <script type="text/javascript">
            $(document).ready(function() {
                $("#datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showAnim: 'fadeIn',
                    dateFormat: 'dd/mm/yy',
                    maxDate: new Date(2000, 11, 30),
                    minDate: new Date(1912, 11, 30)
                });
            });
        </script>

    </head>
    <body onload="document.datos.ci.focus()">

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
                        <li>
                            <a href="index.php">Panel de Administración</a>
                            <ul>
                                <li><a href="buscar_registro.php">Buscar Profesor</a></li>
                                <li><a href="reportes.php">Reportes</a></li>
                                <li><a href="horarios.php">Horarios</a></li>
                                <li><a href="materias.php">Materias</a></li>
                                <li><a href="asistencias.php">Asistencias</a></li>

                            </ul>
                        </li>

                        <li class="active">
                            <a href="#">Nuevo Registro</a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <form id="datos" name="datos" method="POST" class="validate-form form bt-space15" action="guarda_profesor.php">
            <div class="main pagesize"> <!-- *** mainpage layout *** -->
                <div class="main-wrap">
                    <?php
                    if ($_GET) {
                        echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Cerra notificación\"><span>cerrar</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> Las claves deben coincidir.</p>
		  </div>";
                    }
                    ?>
                    <div class="page clear">
                        <h1>Nuevo Profesor</h1>

                        <input type="hidden" name="fecha" id="fecha" value="<?php echo $fecha ?>"></input>
                        <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION["id"]; ?>"></input>
                        <div class="content-box">
                            <div class="box-body">
                                <div class="box-header clear">
                                    <h2>Registro Nuevo Profesor</h2>
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
                                                        <th class="full">Valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>C.I./ Pasaporte <span class="required"> *</span></th>
                                                        <td> <input size="35" value="<?php echo $_GET["ci"] ?>" type="text" name="ci" id="ci" class="required text fl-space2" maxlength="20" onkeypress="return permite(event, 'n')"></input></td>
                                                        <th>Fecha de Nacimiento<span class="required"> *</span></th>
                                                        <td><input size="35" value="<?php echo $_GET["fecha_n"] ?>" type="text" name="fecha_n" id="datepicker" class="fl-space text datepicker required" readonly="yes"></input></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nombre<span class="required"> *</span></th>
                                                        <td> <input size="35" value="<?php echo $_GET["nombre"] ?>" maxlength="50" type="text" name="nombre" id="nombre" class="required text fl-space2" ></input></td>
                                                        <th>Apellido<span class="required"> *</span></th>
                                                        <td><input size="35" value="<?php echo $_GET["apellido"] ?>" maxlength="50" type="text" name="apellido" id="apellido" class="required text fl-space2" ></input></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sexo<span class="required"> *</span></th>
                                                        <td>
                                                            <select name="sexo" id="sexo" class="required text fl-space2">
                                                                <option value="">Seleccionar</option>
                                                                <option value="M">Masculino</option>
                                                                <option value="F">Femenino</option>
                                                            </select>
                                                        </td>
                                                        <th>Edo. Nacimiento<span class="required"> *</span></th>
                                                        <td>
                                                            <select name="edo_n" id="edo_n" class="required text fl-space2">
                                                                <option value="">Seleccionar</option>
                                                                <option value="Amazonas">Amazonas</option>
                                                                <option value="Anzoátegui">Anzoátegui</option>
                                                                <option value="Apure">Apure</option>
                                                                <option value="Aragua">Aragua</option>
                                                                <option value="Barinas">Barinas</option>
                                                                <option value="Bolivar">Bolivar</option>
                                                                <option value="Carabobo">Carabobo</option>
                                                                <option value="Cojedes">Cojedes</option>
                                                                <option value="Delta Amacuro">Delta Amacuro</option>
                                                                <option value="Distrito Capital">Distrito Capital</option>
                                                                <option value="Falcón">Falcón</option>
                                                                <option value="Guárico">Guárico</option>
                                                                <option value="Lara">Lara</option>
                                                                <option value="Mérida">Mérida</option>
                                                                <option value="Miranda">Miranda</option>
                                                                <option value="Monagas">Monagas</option>
                                                                <option value="Nueva Esparta">Nueva Esparta</option>
                                                                <option value="Portuguesa">Portuguesa</option>
                                                                <option value="Sucre">Sucre</option>
                                                                <option value="Táchira">Táchira</option>
                                                                <option value="Trujillo">Trujillo</option>
                                                                <option value="Vargas">Vargas</option>
                                                                <option value="Yaracuy">Yaracuy</option>
                                                                <option value="Zulia">Zulia</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Dirección<span class="required"> *</span></th>
                                                        <td> <input size="35" value="<?php echo $_GET["username"] ?>" maxlength="150" type="text" name="dir" id="dir" class="required text fl-space2" ></input></td>
                                                        <th>Correo Electrónico<span class="required"> *</span></th>
                                                        <td><input size="35" maxlength="100" type="text" name="email" id="email" class="required text fl-space2"></input></td>


                                                    </tr>
                                                    <tr>

                                                        <th>Título Académico<span class="required"> *</span></th>
                                                        <td><input size="35" maxlength="100" type="text" name="g_inst" id="g_inst" class="required text fl-space2"></input></td>
                                                        <th>Escuela a la que pertenece<span class="required"> *</span></th>
                                                        <td>
                                                            <select name="escuela" class="required">
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
                                            <div class="rule"></div>
                                            <span class="required">(*) Campos requeridos</span>
                                            <div class="tab-footer clear">
                                                <div class="fr">
                                                    <input type="submit" value="Guardar Cambios" id="guardar" class="submit" />
                                                    <a href="index.php" class="button red">Cancelar</a>

                                                </div>
                                            </div>


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

        <script type="text/javascript" src="../../js/excanvas.js"></script>
        <script type="text/javascript" src="../../js/cufon.js"></script>
        <script type="text/javascript" src="../../js/Zurich_Condensed_Lt_Bd.js"></script>
        <script type="text/javascript" src="../../js/script.js"></script>

    </body>
</html>
