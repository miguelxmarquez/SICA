<?php

// Iniciamos la session para recojer los datos del usuario

session_start();
$created_by = $_SESSION["id"];
// Registro de Datos Personales
$codigo = $_POST["codigo"];

// Se formatea la fecha actual para fines practicos
$fechaIni = date("Y-m-d H:i:s N");
list($iniFecha, $iniHora, $iniDia) = explode(" ", $fechaIni);
list($anyo, $mes, $dia) = explode("-", $iniFecha);
list($hora, $min, $seg) = explode(":", $iniHora);
$dia_horario = $iniDia;
$hora_horario = $iniHora;

$ahora = date("H:i:s");
$hoy = date("Y-m-d");
$media_hora = 1859;
$tiempoIni = mktime($hora, $min, $seg, $mes, $dia, $anyo);

$h_diurna = strtotime("07:00:00");
$h_nocturna = strtotime("18:45:00");
$h_nocturna_fin = strtotime("22:30:00");


//Abrir Conexion
include '../../conex.php';
//Consulta SQL

$sql_valida = "SELECT * FROM personas WHERE ci='$codigo' AND activo=1;"; // Existe y está activo

if ($result_valida = mysql_query($sql_valida)) { // Ejecutamos la consulta
    if (mysql_numrows($result_valida) != 1) { // Si la consulta no arroja resultados
        // Se redirecciona al index con el mensaje de error
        header("Location: index.php?guest=El registro no existe o esta inactivo, consulte con el administrador del sistema");
    } else { // Sino, Tomamos el id_profesor y buscamos un horario
        $A = @mysql_fetch_array($result_valida);
        $id_profesor = $A["id"];


        // SQL Para buscar el horario que corresponda con el dia actual
        $sql_horario = "SELECT * 
                        FROM horarios 
                        WHERE id_profesor='$id_profesor'
                        AND (1dia='$dia_horario' OR 2dia='$dia_horario' OR 3dia='$dia_horario')";

        // SQL para buscar la asistencia del profesor
        if ($result_horario = @mysql_query($sql_horario)) { // Ejecutamos la consulta 
            if (@mysql_numrows($result_horario) == 0) { // Si, no arroja resultados no posee horario asignado ese dia
                // Se redirecciona al index con el mensaje de error
                header("Location: index.php?schedule=El profesor no posee un horario asignado el dia de hoy, verifique su carga horaria.");
            } else {
                //Sino, se meten los horarios en un arreglo y se verifican los datos
                while ($row = @mysql_fetch_array($result_horario)) {

                    $id_materia = $row["materia"];
                    $id_horario = $row["id"];

                    $ini1 = $row["1ini"];
                    $ini2 = $row["2ini"];
                    $ini3 = $row["3ini"];

                    $fin1 = $row["1fin"];
                    $fin2 = $row["2fin"];
                    $fin3 = $row["3fin"];



                    // Inserta marca de entrada 1
                    $sql_entrada1 = "INSERT INTO asistencias 
                    VALUES('','$id_horario','$id_profesor','$id_materia','$ini1',1,'$fin1','','','','$hoy','$h_trabajas','$created_by')";
                    // Inserta marca de entrada 2
                    $sql_entrada2 = "INSERT INTO asistencias 
                    VALUES('','$id_horario','$id_profesor','$id_materia','$ini2',1,'$fin2','','','','$hoy','$h_trabajas','$created_by')";
                    // Inserta marca de entrada 3
                    $sql_entrada3 = "INSERT INTO asistencias 
                    VALUES('','$id_horario','$id_profesor','$id_materia','$ini3',1,'$fin3','','','','$hoy','$h_trabajas','$created_by')";

                    // Verifica marcaje anterior
                    $sql_asistencia = "SELECT *
                                       FROM asistencias
                                       WHERE fecha = '$hoy'
                                       AND id_persona = '$id_profesor'
                                       AND id_materia = '$id_materia'
                                       ORDER BY id ASC LIMIT 1";

                    // Formato str para hora actual
                    $str_marcaje = strtotime($hora_horario);

// 1** ENTRADA ************** Si marcaje está dentro del rango aceptado, entra.. ***********************
                    // Si 1dia es igual a hoy
                    if ($row["1dia"] == $dia_horario) {

                        $str_entrada = strtotime($row["1ini"]);
                        $str_salida = strtotime($row["1fin"]);
                        $str_salida_retardo = strtotime($row["1fin"]) + 900;
                        $str_retardo = strtotime($row["1ini"]) + 1800;

// ENTRADA ************** Si marcaje está dentro del rango aceptado, entra.. ***********************
                        if (($str_marcaje >= $str_entrada) && ($str_marcaje <= $str_retardo)) {

                            // En Hora.. Ejecutamos la consulta 
                            if ($result_asistencia = @mysql_query($sql_asistencia)) {

                                // Verificamos que no existan registros en la tabla asistencias
                                $asistencias = @mysql_numrows($result_asistencia);
                                $h_entrada = $row["1ini"];
                                if ($asistencias == 0) {

                                    // "Sale marcaje porque no hay asistencias anteriores hoy!!! Se ejecuta la consulta de marcaje";
                                    if ($result_entrada1 = @mysql_query($sql_entrada1)) {

                                        if ($result_entrada1 != "") {

                                            header("Location: index.php?ini1=El marcaje ha sido realizado con exito..!!&ci=" . $codigo . "&time=" . $h_entrada);
                                            $true_marcaje = 1;
                                        }
                                        // 
                                    } else {
                                        header("Location: index.php?guest=Ocurrió un problema, intentelo nuevamente o consulte con el administrador del sistema!!!!");
                                    }
                                }

                                if ($asis_array = mysql_fetch_array($result_asistencia)) {

                                    if (($asis_array["h_2"] == 0) && ($asis_array["h_1"] == 1)) {

                                        $hora_entrada = strtotime($ini1);
                                        $hora_salida = strtotime($ahora);

                                        $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                        $h_trabajadas = number_format($number, 2);

                                        // Condicion hora diurna
                                        if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                            $h_diurna_t = $h_trabajadas;
                                        } else
                                        // Condicion hora nocturna
                                        if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                            $h_nocturna_t = $h_trabajadas;
                                        }
                                        // Condicion hora diurna - nocturna
                                        else {
                                            $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                            $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                            $h_nocturna_t = number_format($num_n, 2);
                                            $h_diurna_t = number_format($num_d, 2);
                                        }

                                        $sql_salida1 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, 
                                                            hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";

                                        // Ejecutamos la consulta de salida
                                        $resultado_salida1 = mysql_query($sql_salida1);

                                        if ($resultado_salida1 != "") {
                                            // Consulta ejecutada correctamente
                                            header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!" . "&time=" . $ahora);
                                        }
                                    }


                                    if ($asis_array["h_2"] == 1) {
                                        header("Location: index.php?ci=" . $codigo . "&repeat=El marcaje de salida ya ha sido realizado anteriormente!!");
                                    }
                                    if (($asis_array["h_2"] == 1) && ($asis_array["h_1"] == 1)) {
                                        header("Location: index.php?ci=" . $codigo . "&repeat=El marcaje de salida ya ha sido realizado anteriormente!!");
                                    }
                                } else {
                                    if (($asis_array["h_2"] == 0) && ($asis_array["h_1"] == 1)) {

                                        $hora_entrada = strtotime($ini1);
                                        $hora_salida = strtotime($ahora);

                                        $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                        $h_trabajadas = number_format($number, 2);

                                        // Condicion hora diurna
                                        if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                            $h_diurna_t = $h_trabajadas;
                                        } else
                                        // Condicion hora nocturna
                                        if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                            $h_nocturna_t = $h_trabajadas;
                                        }
                                        // Condicion hora diurna - nocturna
                                        else {
                                            $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                            $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                            $h_nocturna_t = number_format($num_n, 2);
                                            $h_diurna_t = number_format($num_d, 2);
                                        }

                                        $sql_salida1 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";


                                        if ($resultado_salida1 = mysql_query($sql_salida1)) {

                                            header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!");
                                        }
                                    }
                                    //header("Location: index.php?ci=" . $codigo . "&repeat=El marcaje ya ha sido realizado anteriormente, recuerde marcar su salida!!");
                                }
                            }
                        } else

// SALIDA ***************************** Si marcaje está despues del rango aceptado, marco la salida
                        if (($str_marcaje > $str_retardo) && ($str_marcaje <= $str_salida) && ($asis_array["h_2"] == 0)) {

                            // Verificamos la asistencia anterior
                            $result_asistencia = mysql_query($sql_asistencia);
                            $asis_array = mysql_fetch_array($result_asistencia);
                            $asistencias = @mysql_numrows($result_asistencia);

                            if ($result_asistencia != "") {

                                if ($asistencias == 0) {
                                    header("Location: index.php?guest=El marcaje no ha sido realizado, ha excedido el límite de tiempo reglamentario!!!!");
                                } else {

                                    $hora_entrada = strtotime($ini1);
                                    $hora_salida = strtotime($ahora);

                                    $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                    $h_trabajadas = number_format($number, 2);

                                    // Condicion hora diurna
                                    if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                        $h_diurna_t = $h_trabajadas;
                                    } else
                                    // Condicion hora nocturna
                                    if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                        $h_nocturna_t = $h_trabajadas;
                                    }
                                    // Condicion hora diurna - nocturna
                                    else {
                                        $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                        $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                        $h_nocturna_t = number_format($num_n, 2);
                                        $h_diurna_t = number_format($num_d, 2);
                                    }

                                    $sql_salida1 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";


                                    $result_salida1 = mysql_query($sql_salida1);
                                    if ($result_salida1 != "") {

                                        header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!");
                                    } else {
                                        echo "No se ha podido realizar el marcaje de salida";
                                    }
                                }
                            }
                        }
                        
                        if (($str_marcaje > $str_salida) && ($str_marcaje <= $str_salida_retardo) && ($asis_array["h_2"] == 0)) {

                            // Verificamos la asistencia anterior
                            $result_asistencia = mysql_query($sql_asistencia);
                            $asis_array = mysql_fetch_array($result_asistencia);
                            $asistencias = @mysql_numrows($result_asistencia);

                            if ($result_asistencia != "") {

                                if ($asistencias == 0) {
                                    header("Location: index.php?guest=El marcaje no ha sido realizado, ha excedido el límite de tiempo reglamentario!!!!");
                                } else {

                                    $hora_entrada = strtotime($ini1);
                                    $hora_salida = strtotime($asis_array["h_salida"]);
                                    $ahora = $asis_array["h_salida"];

                                    $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                    $h_trabajadas = number_format($number, 2);

                                    // Condicion hora diurna
                                    if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                        $h_diurna_t = $h_trabajadas;
                                    } else
                                    // Condicion hora nocturna
                                    if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                        $h_nocturna_t = $h_trabajadas;
                                    }
                                    // Condicion hora diurna - nocturna
                                    else {
                                        $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                        $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                        $h_nocturna_t = number_format($num_n, 2);
                                        $h_diurna_t = number_format($num_d, 2);
                                    }

                                    $sql_salida1 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";


                                    $result_salida1 = mysql_query($sql_salida1);
                                    if ($result_salida1 != "") {

                                        header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!");
                                    } else {
                                        echo "No se ha podido realizar el marcaje de salida";
                                    }
                                }
                            }
                        }


                        if ($str_marcaje < $str_entrada) {
                            header("Location: index.php?ini1=El Marcaje ha sido realizado con éxito!!&ci=" . $codigo . "&time=" . $ahora);
                        }
                        if ($str_marcaje > $str_entrada) {
                            header("Location: index.php?ini1=El Marcaje ha sido realizado con éxito!!&ci=" . $codigo . "&time=" . $ahora);
                        }
                    } // Fin dia 1 **********************************************************************************
                    //
                    //
                    //
                    // Si 2dia es igual a hoy ***********************************************************************
                    if ($row["2dia"] == $dia_horario) {

                        $str_entrada = strtotime($row["2ini"]);
                        $str_salida = strtotime($row["2fin"]);
                        $str_salida_retardo = strtotime($row["2fin"]) + 900;
                        $str_retardo = strtotime($row["2ini"]) + 1800;

                        if (($str_marcaje >= $str_entrada) && ($str_marcaje <= $str_retardo)) {

                            // En Hora.. Ejecutamos la consulta 
                            if ($result_asistencia = mysql_query($sql_asistencia)) {

                                // Verificamos que no existan registros en la tabla asistencias
                                $asistencias = mysql_numrows($result_asistencia);
                                $h_entrada = $row["2ini"];
                                if ($asistencias == 0) {

                                    // "Sale marcaje porque no hay asistencias anteriores hoy!!! Se ejecuta la consulta de marcaje";
                                    if ($result_entrada2 = mysql_query($sql_entrada2)) {

                                        if ($result_entrada2 = !"") {

                                            header("Location: index.php?ini1=El marcaje ha sido realizado con exito..!!&ci=" . $codigo . "&time=" . $h_entrada);
                                            $true_marcaje = 1;
                                        }
                                        // 
                                    } else {
                                        header("Location: index.php?guest=Ocurrió un problema, intentelo nuevamente o consulte con el administrador del sistema!!!!");
                                    }
                                }

                                if ($asis_array = mysql_fetch_array($result_asistencia)) {

                                    if (($asis_array["h_2"] == 0) && ($asis_array["h_1"] == 1)) {

                                        $hora_entrada = strtotime($ini1);
                                        $hora_salida = strtotime($ahora);

                                        $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                        $h_trabajadas = number_format($number, 2);

                                        // Condicion hora diurna
                                        if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                            $h_diurna_t = $h_trabajadas;
                                        } else
                                        // Condicion hora nocturna
                                        if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                            $h_nocturna_t = $h_trabajadas;
                                        }
                                        // Condicion hora diurna - nocturna
                                        else {
                                            $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                            $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                            $h_nocturna_t = number_format($num_n, 2);
                                            $h_diurna_t = number_format($num_d, 2);
                                        }

                                        $sql_salida1 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";

                                        // Ejecutamos la consulta de salida
                                        $resultado_salida1 = mysql_query($sql_salida1);

                                        if ($resultado_salida1 != "") {
                                            // Consulta ejecutada correctamente
                                            header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!" . "&time=" . $ahora);
                                        }
                                    }


                                    if ($asis_array["h_2"] == 1) {
                                        header("Location: index.php?ci=" . $codigo . "&repeat=El marcaje de salida ya ha sido realizado anteriormente!!");
                                    }
                                    if (($asis_array["h_2"] == 1) && ($asis_array["h_1"] == 1)) {
                                        header("Location: index.php?ci=" . $codigo . "&repeat=El marcaje de salida ya ha sido realizado anteriormente!!");
                                    }
                                } else {
                                    if (($asis_array["h_2"] == 0) && ($asis_array["h_1"] == 1)) {

                                        $hora_entrada = strtotime($ini1);
                                        $hora_salida = strtotime($ahora);

                                        $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                        $h_trabajadas = number_format($number, 2);

                                        // Condicion hora diurna
                                        if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                            $h_diurna_t = $h_trabajadas;
                                        } else
                                        // Condicion hora nocturna
                                        if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                            $h_nocturna_t = $h_trabajadas;
                                        }
                                        // Condicion hora diurna - nocturna
                                        else {
                                            $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                            $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                            $h_nocturna_t = number_format($num_n, 2);
                                            $h_diurna_t = number_format($num_d, 2);
                                        }

                                        $sql_salida2 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";

                                        // Ejecutamos la consulta de salida
                                        if ($resultado_salida2 = mysql_query($sql_salida2)) {

                                            header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!");
                                        }
                                    }
                                    //header("Location: index.php?ci=" . $codigo . "&repeat=El marcaje ya ha sido realizado anteriormente, recuerde marcar su salida!!");
                                }
                            }
                        } else

// SALIDA ***************************** Si marcaje está despues del rango aceptado, marco la salida
                        if (($str_marcaje > $str_retardo) && ($str_marcaje <= $str_salida) && ($asis_array["h_2"] == 0)) {

                            // Verificamos la asistencia anterior
                            $result_asistencia = mysql_query($sql_asistencia);
                            $asis_array = mysql_fetch_array($result_asistencia);
                            $asistencias = @mysql_numrows($result_asistencia);

                            if ($result_asistencia != "") {

                                if ($asistencias == 0) {
                                    header("Location: index.php?guest=El marcaje no ha sido realizado, ha excedido el límite de tiempo reglamentario!!!!");
                                } else {

                                    $hora_entrada = strtotime($ini1);
                                    $hora_salida = strtotime($ahora);

                                    $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                    $h_trabajadas = number_format($number, 2);

                                    // Condicion hora diurna
                                    if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                        $h_diurna_t = $h_trabajadas;
                                    } else
                                    // Condicion hora nocturna
                                    if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                        $h_nocturna_t = $h_trabajadas;
                                    }
                                    // Condicion hora diurna - nocturna
                                    else {
                                        $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                        $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                        $h_nocturna_t = number_format($num_n, 2);
                                        $h_diurna_t = number_format($num_d, 2);
                                    }

                                    $sql_salida2 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";

                                    // Ejecutamos la consulta de salida
                                    $result_salida2 = mysql_query($sql_salida2);
                                    if ($result_salida2 != "") {

                                        header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!");
                                    } else {
                                        echo "No se ha podido realizar el marcaje de salida";
                                    }
                                }
                            }
                        }
                    }

                    if (($str_marcaje > $str_salida) && ($str_marcaje <= $str_salida_retardo) && ($asis_array["h_2"] == 0)) {

                            // Verificamos la asistencia anterior
                            $result_asistencia = mysql_query($sql_asistencia);
                            $asis_array = mysql_fetch_array($result_asistencia);
                            $asistencias = @mysql_numrows($result_asistencia);

                            if ($result_asistencia != "") {

                                if ($asistencias == 0) {
                                    header("Location: index.php?guest=El marcaje no ha sido realizado, ha excedido el límite de tiempo reglamentario!!!!");
                                } else {

                                    $hora_entrada = strtotime($ini1);
                                    $hora_salida = strtotime($asis_array["h_salida"]);
                                    $ahora = $asis_array["h_salida"];

                                    $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                    $h_trabajadas = number_format($number, 2);

                                    // Condicion hora diurna
                                    if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                        $h_diurna_t = $h_trabajadas;
                                    } else
                                    // Condicion hora nocturna
                                    if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                        $h_nocturna_t = $h_trabajadas;
                                    }
                                    // Condicion hora diurna - nocturna
                                    else {
                                        $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                        $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                        $h_nocturna_t = number_format($num_n, 2);
                                        $h_diurna_t = number_format($num_d, 2);
                                    }

                                    $sql_salida1 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";


                                    $result_salida1 = mysql_query($sql_salida1);
                                    if ($result_salida1 != "") {

                                        header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!");
                                    } else {
                                        echo "No se ha podido realizar el marcaje de salida";
                                    }
                                }
                            }
                        }

                    // Si 3dia es igual a hoy
                    if ($row["3dia"] == $dia_horario) {
                        $str_entrada = strtotime($row["3ini"]);
                        $str_salida = strtotime($row["3fin"]);
                        $str_salida_retardo = strtotime($row["3fin"]) + 900;
                        $str_retardo = strtotime($row["3ini"]) + 1800;

                        if (($str_marcaje >= $str_entrada) && ($str_marcaje <= $str_retardo)) {

                            // En Hora.. Ejecutamos la consulta 
                            if ($result_asistencia = mysql_query($sql_asistencia)) {

                                // Verificamos que no existan registros en la tabla asistencias
                                $asistencias = mysql_numrows($result_asistencia);
                                $h_entrada = $row["3ini"];
                                if ($asistencias == 0) {

                                    // "Sale marcaje porque no hay asistencias anteriores hoy!!! Se ejecuta la consulta de marcaje";
                                    if ($result_entrada3 = mysql_query($sql_entrada3)) {

                                        if ($result_entrada3 = !"") {

                                            header("Location: index.php?ini1=El marcaje ha sido realizado con exito..!!&ci=" . $codigo . "&time=" . $h_entrada);
                                            $true_marcaje = 1;
                                        }
                                        // 
                                    } else {
                                        header("Location: index.php?guest=Ocurrió un problema, intentelo nuevamente o consulte con el administrador del sistema!!!!");
                                    }
                                }

                                if ($asis_array = mysql_fetch_array($result_asistencia)) {

                                    if (($asis_array["h_2"] == 0) && ($asis_array["h_1"] == 1)) {

                                        $hora_entrada = strtotime($ini1);
                                        $hora_salida = strtotime($ahora);

                                        $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                        $h_trabajadas = number_format($number, 2);

                                        // Condicion hora diurna
                                        if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                            $h_diurna_t = $h_trabajadas;
                                        } else
                                        // Condicion hora nocturna
                                        if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                            $h_nocturna_t = $h_trabajadas;
                                        }
                                        // Condicion hora diurna - nocturna
                                        else {
                                            $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                            $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                            $h_nocturna_t = number_format($num_n, 2);
                                            $h_diurna_t = number_format($num_d, 2);
                                        }

                                        $sql_salida3 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";

                                        // Ejecutamos la consulta de salida
                                        $resultado_salida3 = mysql_query($sql_salida3);

                                        if ($resultado_salida3 != "") {
                                            // Consulta ejecutada correctamente
                                            header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!" . "&time=" . $ahora);
                                        }
                                    }


                                    if ($asis_array["h_2"] == 1) {
                                        header("Location: index.php?ci=" . $codigo . "&repeat=El marcaje de salida ya ha sido realizado anteriormente!!");
                                    }
                                    if (($asis_array["h_2"] == 1) && ($asis_array["h_1"] == 1)) {
                                        header("Location: index.php?ci=" . $codigo . "&repeat=El marcaje de salida ya ha sido realizado anteriormente!!");
                                    }
                                } else {
                                    if (($asis_array["h_2"] == 0) && ($asis_array["h_1"] == 1)) {

                                        $hora_entrada = strtotime($ini1);
                                        $hora_salida = strtotime($ahora);

                                        $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                        $h_trabajadas = number_format($number, 2);

                                        // Condicion hora diurna
                                        if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                            $h_diurna_t = $h_trabajadas;
                                        } else
                                        // Condicion hora nocturna
                                        if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                            $h_nocturna_t = $h_trabajadas;
                                        }
                                        // Condicion hora diurna - nocturna
                                        else {
                                            $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                            $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                            $h_nocturna_t = number_format($num_n, 2);
                                            $h_diurna_t = number_format($num_d, 2);
                                        }

                                        $sql_salida3 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";

                                        // Ejecutamos la consulta de salida
                                        if ($resultado_salida3 = mysql_query($sql_salida3)) {

                                            header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!");
                                        }
                                    }
                                    //header("Location: index.php?ci=" . $codigo . "&repeat=El marcaje ya ha sido realizado anteriormente, recuerde marcar su salida!!");
                                }
                            }
                        } else

// SALIDA ***************************** Si marcaje está despues del rango aceptado, marco la salida
                        if (($str_marcaje > $str_retardo) && ($str_marcaje <= $str_salida) && ($asis_array["h_2"] == 0)) {

                            // Verificamos la asistencia anterior
                            $result_asistencia = mysql_query($sql_asistencia);
                            $asis_array = mysql_fetch_array($result_asistencia);
                            $asistencias = @mysql_numrows($result_asistencia);

                            if ($result_asistencia != "") {

                                if ($asistencias == 0) {
                                    header("Location: index.php?guest=El marcaje no ha sido realizado, ha excedido el límite de tiempo reglamentario!!!!");
                                } else {
                                    $hora_entrada = strtotime($ini1);
                                    $hora_salida = strtotime($ahora);

                                    $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                    $h_trabajadas = number_format($number, 2);

                                    // Condicion hora diurna
                                    if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                        $h_diurna_t = $h_trabajadas;
                                    } else
                                    // Condicion hora nocturna
                                    if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                        $h_nocturna_t = $h_trabajadas;
                                    }
                                    // Condicion hora diurna - nocturna
                                    else {
                                        $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                        $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                        $h_nocturna_t = number_format($num_n, 2);
                                        $h_diurna_t = number_format($num_d, 2);
                                    }

                                    $sql_salida3 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";

                                    // Ejecutamos la consulta de salida
                                    $result_salida3 = mysql_query($sql_salida3);
                                    if ($resultado_salida3 != "") {

                                        header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!");
                                    } else {
                                        header("Location: index.php?db=El Marcaje de SALIDA no ha sido realizado con éxito!!!");
                                    }
                                }
                            }
                        }
                        
                        if (($str_marcaje > $str_salida) && ($str_marcaje <= $str_salida_retardo) && ($asis_array["h_2"] == 0)) {

                            // Verificamos la asistencia anterior
                            $result_asistencia = mysql_query($sql_asistencia);
                            $asis_array = mysql_fetch_array($result_asistencia);
                            $asistencias = @mysql_numrows($result_asistencia);

                            if ($result_asistencia != "") {

                                if ($asistencias == 0) {
                                    header("Location: index.php?guest=El marcaje no ha sido realizado, ha excedido el límite de tiempo reglamentario!!!!");
                                } else {

                                    $hora_entrada = strtotime($ini1);
                                    $hora_salida = strtotime($asis_array["h_salida"]);
                                    $ahora = $asis_array["h_salida"];

                                    $number = (($hora_salida - $hora_entrada) / 60) / 45;
                                    $h_trabajadas = number_format($number, 2);

                                    // Condicion hora diurna
                                    if (($hora_entrada >= $h_diurna) && ($hora_salida <= $h_nocturna)) {
                                        $h_diurna_t = $h_trabajadas;
                                    } else
                                    // Condicion hora nocturna
                                    if (($hora_entrada >= $h_nocturna) && ($hora_salida <= $h_nocturna_fin)) {
                                        $h_nocturna_t = $h_trabajadas;
                                    }
                                    // Condicion hora diurna - nocturna
                                    else {
                                        $num_n = (($hora_salida - $h_nocturna) / 60) / 45;
                                        $num_d = (($h_nocturna - $hora_entrada) / 60) / 45;

                                        $h_nocturna_t = number_format($num_n, 2);
                                        $h_diurna_t = number_format($num_d, 2);
                                    }

                                    $sql_salida1 = "UPDATE asistencias SET h_salida= '$ahora',
                                                            h_2=1, hd = '$h_diurna_t',
                                                            hn = '$h_nocturna_t',
                                                            h_trabajadas = '$h_trabajadas'
                                                            WHERE id_persona = '$id_profesor'
                                                            AND id_horario = '$id_horario'
                                                            AND id_materia = '$id_materia'
                                                            AND fecha = '$hoy'";


                                    $result_salida1 = mysql_query($sql_salida1);
                                    if ($result_salida1 != "") {

                                        header("Location: index.php?h_1=" . $h_1 . "&h_2=" . $h_2 . "&ci=" . $codigo . "&db=El Marcaje de SALIDA ha sido realizado con éxito!!!");
                                    } else {
                                        echo "No se ha podido realizar el marcaje de salida";
                                    }
                                }
                            }
                        } // Fin Retardo Salida
                        
                        
                    }
                } // Fin While Existe Horario
            }
        }
    }
    @mysql_close($conexion); // Close db    
} else {
    @mysql_close($conexion); // Close db
    header("Location: index.php?db=Error inesperado en la inserción de registros en la base de datos, intentelo de nuevo o consulte con el administrador del sistema.");
}
// Si tiene clases mas tarde en el dia
if ($str_marcaje < $str_entrada) {
    header("Location: index.php?ini1=El Marcaje ha sido realizado con éxito!!&ci=" . $codigo . "&time=" . $ahora);
}
if ($str_marcaje > $str_entrada) {
    header("Location: index.php?ini1=El Marcaje ha sido realizado con éxito!!&ci=" . $codigo . "&time=" . $ahora);
}
@mysql_close($conexion); // Close db
?>