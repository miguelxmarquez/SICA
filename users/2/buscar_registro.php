<?php require "../../seguridad.php"; ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description"  content=""/>
        <meta name="keywords" content=""/>
        <meta name="robots" content="ALL,FOLLOW"/>
        <meta name="Author" content="AIT"/>
        <meta http-equiv="imagetoolbar" content="no"/>
        <title>Sistema de Control: Busqueda de Registro Persona</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" href="../../css/reset.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/screen.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/fancybox.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.wysiwyg.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/jquery.ui.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/visualize-light.css" type="text/css"/>
        <link rel="stylesheet" type="../../text/css" href="css/ie7.css" />
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
                        <a href="index.php" title="Ver Panel de Administración">
                            <img src="../../images/logo.png" alt="" class="picture" />
                            <span class="textlogo">
                                <span class="title">Sistema de Control</span>
                                <span class="text">Panel de Administración</span>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="menu">
                    <ul class="clear">
                        <li>
                            <a href="index.php">Panel de Administración</a>
                            <ul>
                                <li><a href="nuevo_profesor.php">Nuevo Profesor</a></li>
                                <li><a href="reportes.php">Reportes</a></li>
                                <li><a href="horarios.php">Horarios</a></li>
                                <li><a href="materias.php">Materias</a></li>
                                <li><a href="asistencias.php">Asistencias</a></li>

                            </ul>
                        </li>
                        <li  class="active">
                            <a href="#">Buscar Personas</a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="main pagesize"> <!-- *** mainpage layout *** -->
            <div class="main-wrap">

                <div class="page clear">

                    <!-- CONTENT BOX - DATATABLE -->
                    <div class="content-box">
                        <div class="box-body">
                            <div class="box-header clear">
                                <h2>Sistema de Busqueda del Personal</h2>
                            </div>

                            <div class="box-wrap clear">

                                <!-- TABLE -->
                                <div id="data-table">
                                    <p>Tabla de contenido de las todas las entradas insertadas al personal</p> 

                                    <form method="post" action="#">

                                        <table class="style1 datatable">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Nro. de Registro</th>
                                                    <th>C.I. Conscrito</th>
                                                    <th>Nombre</th>
                                                    <th>Apellido</th>
                                                    <th>Fecha N.</th>
                                                    <th >Título</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include '../../conex.php';
                                                $sql = "SELECT id, ci, nombre, apellido, fecha_n, g_inst 
                                                        FROM personas
                                                        ORDER BY id DESC";
                                                $result = mysql_query($sql);
                                                while (@$A = mysql_fetch_array($result)) {
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: center; "><?php echo $A["id"] ?></td>
                                                        <td><?php echo $A["ci"] ?></td>
                                                        <td><?php echo $A["nombre"] ?></td>
                                                        <td><?php echo $A["apellido"] ?></td>
                                                        <td><a href="registro.php?id=<?php echo $A["id"] . "&ci=" . $A["ci"]; ?>"><?php echo $A["fecha_n"] ?></a></td>
                                                        <td><?php echo $A["g_inst"] ?></td>
                                                        <td><a href="registro.php?id=<?php echo $A["id"] . "&ci=" . $A["ci"]; ?>"><img src="../../images/ico_edit_16.png" width="18" height="18" class="icon16 fl-space2" alt="" title="Ver Registro" /></a>
                                                            <a href="edita_profesor.php?id=<?php echo $A["id"] . "&ci=" . $A["ci"]; ?>"><img src="../../images/document.png" width="18" height="18" class="icon16 fl-space2" alt="" title="Modificar" /></a>
                                                            <a href="buscar_materia.php?id=<?php echo $A["id"] ?>" ><img src="../../images/anadir.png" height="18" width="18"class="icon16 fl-space2" alt="" title="Agregar Horas" /></a>
                                                            <a href="ver_horario_profesor.php?id=<?php echo $A["id"] ?>" ><img src="../../images/horarios.png" height="18" width="18"class="icon16 fl-space2" alt="" title="Ver Horario" /></a>

        <!--                                                            <a onclick="return confirm('ADVERTENCIA, ESTA A PUNTO DE ELIMINAR UN PROFESOR. También se eliminarán todos los registros asociados a la persona. Está seguro que desea continuar..?');" href="elimina_profesor.php?id=<?php echo $A["id"] ?>"><img src="../../images/ico_delete_16.png   " class="icon16 fl-space2"  width="18" height="18"  title="Eliminar Registro" /></a>-->
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>

                                    </form>
                                </div><!-- /#table -->


                            </div><!-- end of box-wrap --><div class="rule"></div>
                        </div> <!-- end of box-body -->
                    </div> <!-- end of content-box -->

                </div><!-- end of page -->
            </div>
        </div>

        <div class="footer">
            <div class="pagesize clear">
                <p class="bt-space15"><span class="copy"><strong>© <?php echo date("Y"); ?> Todos los Derechos Reservados <a href="http://www.SICA.com/">SICA</a></strong></span> Desarrollado por <a href="http://www.psmporlamar.edu.ve">IUPSM</a></p>
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
