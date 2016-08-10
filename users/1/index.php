<?php
require "../../seguridad.php"; 
require '../../conex.php';
$ci = $_GET["ci"];
$sql = "SELECT ci,nombre,apellido FROM personas WHERE ci = '$ci'";
$result = mysql_query($sql);
$A = mysql_fetch_array($result);

setlocale(LC_TIME, 'spanish');
$fecha = utf8_encode(ucfirst(strftime("%d/%m/%Y", time())));
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description"  content=""/>
        <meta name="keywords" content=""/>
        <meta name="robots" content="ALL,FOLLOW"/>
        <meta name="Author" content="AIT"/>
        <meta http-equiv="imagetoolbar" content="no"/>
        <title>Sistema de Control: Panel de Administración</title>
        <link rel="stylesheet" href="../../css/reset.css" type="text/css"/>
        <link rel="stylesheet" href="../../css/screen.css" type="text/css"/>
        
    </head>

    <body onload="show5();document.fm.codigo.focus()">

        <script type="text/javascript">
            <!--

            function show5(){
                if (!document.layers&&!document.all&&!document.getElementById)
                    return
                var Digital=new Date()
                var hours=Digital.getHours()
                var minutes=Digital.getMinutes()
                var seconds=Digital.getSeconds()
                var dn="AM" 
                if (hours>12){
                    dn="PM"
                    hours=hours-12
                }
                if (hours==0)
                    hours=12
                if (minutes<=9)
                    minutes="0"+minutes
                if (seconds<=9)
                    seconds="0"+seconds
                //change font size here to your desire
                myclock=hours+":"+minutes+":"+seconds+" "+dn
                if (document.layers){
                    document.layers.liveclock.document.write(myclock)
                    document.layers.liveclock.document.close()
                }
                else if (document.all)
                    liveclock.innerHTML=myclock
                else if (document.getElementById)
                    document.getElementById("liveclock").innerHTML=myclock
                setTimeout("show5()",1000)
            }

            //-->
        </script>


        <div class="pagetop">
            <div class="head pagesize"> <!-- *** head layout *** -->
                <div class="head_top">
                    <div class="topbuts">
                        <ul class="clear">
                            <li><a href="reportes.php">Opciones</a></li>
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
                            <img src="../../images/logo.png" class="picture" />
                            <span class="textlogo">
                                <span class="title">Panel de Administración</span>
                                <span class="text">Sistema de Información para el Control de Asistencias</span>
                            </span>
                        </a>
                    </div>

                </div>
                <div class="menu">
                    <ul class="clear">
                        <li class="active"><a href="#">Bienvenidos</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main pagesize"> <!-- *** mainpage layout *** -->
            <div class="main-wrap">
                <?php
                if ($message = $_GET["schedule"]) {// No posee horario
                    echo "<div class=\"notification note-attention\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> " . $message . "</p>
		  </div>";
                }
                if ($message = $_GET["repeat"]) {//La entrada ha sido marcada
                    echo "<div class=\"notification note-info\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> " . $message . "</p>
		  </div>";
                }
                if ($message = $_GET["guest"]) {// Esta inactivo o no existe
                    echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> " . $message . "</p>
		  </div>";
                }
                if (($_GET["marcaje"] == "yes") && ($message = $_GET["message"])) {
                    echo "<div class=\"notification note-error\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> " . $message . "</p>
		  </div>";
                }
                if (($_GET["ini1"]) && ($message = $_GET["ini1"])) {
                    echo "<div class=\"notification note-success\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> " . $message . "</p>
		  </div>";
                }
                if ($message = $_GET["db"]) {
                    echo "<div class=\"notification note-attention\">
                    <a href=\"#\" class=\"close\" title=\"Close notification\"><span>close</span></a>
		    <span class=\"icon\"></span>
		    <p><strong>Notificación:</strong> " . $message . "</p>
		  </div>";
                }
                ?>
                <!-- CONTENT BOX - DATATABLE -->
                <div class="content-box">
                    <div class="box-body">
                        <div class="box-wrap clear">

                            <form method="POST" name="fm" id="fm" action="valida.php">

                                <center>
                                    <div class="box-wrap clear">

                                        <?php
                                        if ($id_asistencia = $_GET["ci"]) {
                                            echo "<img src=\"../../data/fotos/" . $id_asistencia . ".jpg\" class=\"thumb\" width=\"160\" height=\"150\"/>" . "<br>";
                                        }
                                        ?>
                                        <h2 style="color:red"><?php echo $A["nombre"] . " " . $A["apellido"]; if($_GET["time"]){echo " | ".$_GET["time"];} ?></h2>
                                        <span id="liveclock" style="font-family: bold ,sans-serif;font-size: 70px;color: #333333"></span>

                                        <!--                  Código de Entrada                      -->
                                        <input type="password" name="codigo" id="codigo" size="100"></input>
                                        <!--                  Fin Codigo de Entrada                      -->

                                    </div><!-- end of box-wrap -->  
                                    <p><?php echo utf8_encode(ucfirst(strftime("%A, %d de %B del %Y", time()))); ?></p>    
                                    <h3>Realice el marcaje de Asistencia</h3>
                                </center>

                            </form>

                        </div><!-- end of box-wrap -->
                    </div> <!-- end of box-body -->
                </div> <!-- end of content-box -->
            </div>
        </div>

        <div class="footer">
            <div class="pagesize clear">
                <p class="bt-space15"><span class="copy"><strong>© <?php echo date("Y")?> Todos los Derechos Reservados <a href="http://www.iupsm.com">SICA</a></strong></span> Desarrollado por <a href="mailto:miguelxmarquez@gmail.com">Miguel Márquez</a></p>
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
