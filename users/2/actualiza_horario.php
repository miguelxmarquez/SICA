<?php

// Tomamos las variables
$id = $_POST["horario"];
$h_diurna = strtotime("07:00:00");
$h_nocturna = strtotime("18:45:00");
$h_nocturna_fin = strtotime("22:30:00");


if ($_POST["ehora"] != "" && $_POST["shora"] != "") {

    $ehora = date('H:i:s', strtotime($_POST["ehora"]));
    $shora = date('H:i:s', strtotime($_POST["shora"]));
    $dia1 = $_POST["dia1"];

    $str_entrada = strtotime($ehora);
    $str_salida = strtotime($shora);

    // Condicion hora diurna
    if (($str_entrada >= $h_diurna) && ($str_salida <= $h_nocturna)) {
        $h_diurna_t = (($str_salida - $str_entrada) / 60) / 45;
    } else
    // Condicion hora nocturna
    if (($str_entrada >= $h_nocturna) && ($str_salida <= $h_nocturna_fin)) {
        $h_nocturna_t = (($str_salida - $str_entrada) / 60) / 45;
    }
    // Condicion hora diurna - nocturna
    else {
        $h_nocturna_t = (($str_salida - $h_nocturna) / 60) / 45;
        $h_diurna_t = (($h_nocturna - $str_entrada) / 60) / 45;
    }
}






if ($_POST["ehora2"] != "" && $_POST["shora2"] != "") {

    $ehora2 = date('H:i:s', strtotime($_POST["ehora2"]));
    $shora2 = date('H:i:s', strtotime($_POST["shora2"]));
    $dia2 = $_POST["dia2"];

    $str_entrada2 = strtotime($ehora2);
    $str_salida2 = strtotime($shora2);

    // Condicion hora diurna
    if (($str_entrada2 >= $h_diurna) && ($str_salida2 <= $h_nocturna)) {
        $h_diurna_t2 = (($str_salida2 - $str_entrada2) / 60) / 45;
    } else
    // Condicion hora nocturna
    if (($str_entrada2 >= $h_nocturna) && ($str_salida2 <= $h_nocturna_fin)) {
        $h_nocturna_t2 = (($str_salida2 - $str_entrada2) / 60) / 45;
    }
    // Condicion hora diurna - nocturna
    else {
        $h_nocturna_t2 = (($str_salida2 - $h_nocturna) / 60) / 45;
        $h_diurna_t2 = (($h_nocturna - $str_entrada2) / 60) / 45;
    }
}



if ($_POST["ehora3"] != "" && $_POST["shora3"] != "") {

    $ehora3 = date('H:i:s', strtotime($_POST["ehora3"]));
    $shora3 = date('H:i:s', strtotime($_POST["shora3"]));
    $dia3 = $_POST["dia3"];

    $str_entrada3 = strtotime($ehora3);
    $str_salida3 = strtotime($shora3);

    // Condicion hora diurna
    if (($str_entrada3 >= $h_diurna) && ($str_salida3 <= $h_nocturna)) {
        $h_diurna_t3 = (($str_salida3 - $str_entrada3) / 60) / 45;
    } else
    // Condicion hora nocturna
    if (($str_entrada3 >= $h_nocturna) && ($str_salida3 <= $h_nocturna_fin)) {
        $h_nocturna_t3 = (($str_salida3 - $str_entrada3) / 60) / 45;
    }
    // Condicion hora diurna - nocturna
    else {
        $h_nocturna_t3 = (($str_salida3 - $h_nocturna) / 60) / 45;
        $h_diurna_t3 = (($h_nocturna - $str_entrada3) / 60) / 45;
    }
}

// Actualizacion de Horarios

$created_by = $_POST["created_by"];

//Abrir Conexion
include '../../conex.php';
//Consulta SQL
$sql = "UPDATE horarios 
        SET 1ini='$ehora', 1fin='$shora', 1dia='$dia1', 1hd='$h_diurna_t', 1hn='$h_nocturna_t', 2ini='$ehora2',
        2fin='$shora2', 2dia='$dia2', 2hd='$h_diurna_t2', 2hn='$h_nocturna_t2', 3ini='$ehora3', 3fin='$shora3',
        3dia='$dia3', 3hd='$h_diurna_t3', 3hn='$h_nocturna_t3'  
        WHERE id='$id'";

if (@$agregar = @mysql_query($sql)) { // Execute
    $log = "horario Agregado correctamente en la base de datos";
    header("Location: horarios.php?saved=yes");
} else {
    $log = "Error inesperado en la insercion del Usuario en la base de datos";
    header("Location: horarios.php?saved=no");
}
//echo $log;
@mysql_close($conexion); // Close db
?>

