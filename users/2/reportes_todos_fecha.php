<?php
if (!$_POST) {
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
            <title>SICA: Nuevo Reporte</title>
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
                        dateFormat: 'yy-mm-dd',
                        maxDate: new Date(2025, 11, 30),
                        minDate: new Date(2013, 01, 01)
                    });
                });
                $(document).ready(function() {
                    $("#datepicker2").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showAnim: 'fadeIn',
                        dateFormat: 'yy-mm-dd',
                        maxDate: new Date(2025, 11, 30),
                        minDate: new Date(2013, 01, 01)
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
                            <li>                            <a href="index.php">Panel de Administración</a>                            <ul>                                <li><a href="buscar_registro.php">Buscar Profesor</a></li>                                <li><a href="reportes.php">Reportes</a></li>                                <li><a href="horarios.php">Horarios</a></li>                                <li><a href="materias.php">Materias</a></li>                                <li><a href="asistencias.php">Asistencias</a></li>                            </ul>                        </li>
                            <li class="active">
                                <a href="#">Reportes</a>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <form id="datos" name="datos" method="POST" class="validate-form form bt-space15" action="reportes_todos_fecha.php">
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
                            <h1>Reporte de Docentes por Rango de Fecha</h1>
                            <p>
                                <?php
                                setlocale(LC_TIME, 'spanish');
                                echo utf8_encode(ucfirst(strftime("%A, %d de %B de %Y", time())));
                                $fecha = utf8_encode(ucfirst(strftime("%d/%m/%Y", time())));
                                ?>
                            </p>
                            <input type="hidden" name="fecha" id="fecha" value="<?php echo $fecha ?>"></input>
                            <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION["id"]; ?>"></input>
                            <div class="content-box">
                                <div class="box-body">
                                    <div class="box-header clear">
                                        <h2>Reporte Docentes</h2>
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
                                                            <th>Fecha Inicio<span class="required"> *</span></th>
                                                            <td> <input size="40" value="" type="text" name="fecha_ini" id="datepicker" class="required text" readonly="yes"></input></td>
                                                            <th>Fecha Fin<span class="required"> *</span></th>
                                                            <td><input size="40" value="" type="text" name="fecha_fin" id="datepicker2" class="text required" readonly="yes"></input></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <span class="required">(*) Campos requeridos</span>
                                                <div class="tab-footer clear">
                                                    <div class="fr">
                                                        <input type="submit" value="Generar Reporte" id="guardar" class="submit" />
                                                        <a href="index.php" class="button red">Cancelar</a>

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
            <script type="text/javascript" src="../../js/excanvas.js"></script>
            <script type="text/javascript" src="../../js/cufon.js"></script>
            <script type="text/javascript" src="../../js/Zurich_Condensed_Lt_Bd.js"></script>
            <script type="text/javascript" src="../../js/script.js"></script>

        </body>
    </html>
    <?php
} else {

    require ('../../includes/tcpdf/config/lang/spa.php');
    require ('../../includes/tcpdf/tcpdf.php');

// extend TCPF with custom functions
    class MYPDF extends TCPDF {
        
    }

// create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Miguel Márquez');
    $pdf->SetTitle('Reporte Todos');
    $pdf->SetSubject('Asunto');
    $pdf->SetKeywords('SICA');
    $pdf->setPrintHeader(true);
    $pdf->setPrintFooter(true);
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->setLanguageArray($l);
    $pdf->SetFont('courier', 'N', 9);
    $pdf->AddPage();

    $fecha_ini = $_POST["fecha_ini"];
    $fecha_fin = $_POST["fecha_fin"];

//Data loading
    include '../../conex.php';
    
    $sql = "CALL test(\"$fecha_ini\",\"$fecha_fin\")";
    
    
    $tbl = '<table style="width: 638px;" cellspacing="1">
<tr>
    <td colspan="5">Reporte de todos los registros de marcaje de asistencia (Del ' . $fecha_ini . ' Al ' . $fecha_fin . ')</td>
</tr>
    </table>';
    $tbl .= '<table style="width: 638px;">';
    $tbl .= '<thead>
            <tr style="background-color:#efefef;font-weight: bold;" >
                <th style="border: 0px solid #000000; width: 30px; text-align: center;">N</th>
                <th style="border: 0px solid #000000; width: 70px; text-align: center;">CI</th>
                <th style="border: 0px solid #000000; width: 160px; text-align: center;">APELLIDO</th>
                <th style="border: 0px solid #000000; width: 160px; text-align: center;">NOMBRE</th>
                <th style="border: 0px solid #000000; width: 50px; text-align: center;">HD</th>
                <th style="border: 0px solid #000000; width: 50px; text-align: center;">HN</th>
                <th style="border: 0px solid #000000; width: 70px; text-align: center;">TOTAL D/N</th>
                <th style="border: 0px solid #000000; width: 69px; text-align: center;">HORAS</th>
            </tr>
            
        </thead>';
    if ($result = mysql_query($sql)) {
        $num_rw = mysql_num_rows($result);

        if ($num_rw > 0) {
            while ($A = mysql_fetch_array($result)) {
                $count++;
                $ci = $A["ci"];
                $nombre = $A["nombre"];
                $apellido = $A["apellido"];
                $hd = $A["h_diurnas"];
                $hn = $A["h_nocturnas"];
                $ht = $A["h_trabajadas"];
                $ha = $A["h_asignadas"];
// -----------------------------------------------------------------------------
                $tbl .= '
                    <tr>
                        <td style="border: 0px solid #000000; width: 30px;">' . $count . '</td>
                        <td style="border: 0px solid #000000; width: 70px;">' . $ci . '</td>
                        <td style="border: 0px solid #000000; width: 160px;text-align:left">' . $apellido . '</td>
                        <td style="border: 0px solid #000000; width: 160px;text-align:left ">' . $nombre . '</td>
                        <td style="border: 0px solid #000000; width: 50px;text-align:center">' . $hd . '</td>
                        <td style="border: 0px solid #000000; width: 50px;text-align:center">' . $hn . '</td>
                        <td style="border: 0px solid #000000; width: 70px; text-align:center">' . $ht . '</td>
                        <td style="border: 0px solid #000000; width: 69px; text-align:center">' . $ha . '</td>
                    </tr>';
            }
        }
    }
    $tbl .= '</table>';
    $pdf->writeHTML($tbl, true, false, false, false, '');

// ---------------------------------------------------------
//Close and output PDF document
    $pdf->Output('fechas.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}
?>
