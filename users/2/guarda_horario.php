<?php

// Registro de Horarios

$materia = $_POST["materia"];
$id_profesor = $_POST["id_profesor"];
$created_by = $_POST["created_by"];
$h_diurna = strtotime("07:00:00");
$h_nocturna = strtotime("18:45:00");
$h_nocturna_fin = strtotime("22:30:00");

// Turno I
$ehora = $_POST["ehora"];
$eminuto = $_POST["eminuto"];
$ezona = $_POST["ezona"];
$e_am_pm = $ehora . ":" . $eminuto . " " . $ezona;
$entrada = date('H:i:s', strtotime($e_am_pm));
$str_entrada = strtotime($entrada);

$shora = $_POST["shora"];
$sminuto = $_POST["sminuto"];
$szona = $_POST["szona"];
$s_am_pm = $shora . ":" . $sminuto . " " . $szona;
$salida = date('H:i:s', strtotime($s_am_pm));
$str_salida = strtotime($salida);

$dia1 = $_POST["dia1"];

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


// Turno II
if ($_POST["ehora2"] != "") {

    $ehora2 = $_POST["ehora2"];
    $eminuto2 = $_POST["eminuto2"];
    $ezona2 = $_POST["ezona2"];
    $e_am_pm2 = $ehora2 . ":" . $eminuto2 . " " . $ezona2;
    $entrada2 = date('H:i:s', strtotime($e_am_pm2));
    $str_entrada2 = strtotime($entrada2);

    $shora2 = $_POST["shora2"];
    $sminuto2 = $_POST["sminuto2"];
    $szona2 = $_POST["szona2"];
    $s_am_pm2 = $shora2 . ":" . $sminuto2 . " " . $szona2;
    $salida2 = date('H:i:s', strtotime($s_am_pm2));
    $str_salida2 = strtotime($salida2);

    $dia2 = $_POST["dia2"];

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


// Turno III
if ($_POST["ehora3"] != "") {

    $ehora3 = $_POST["ehora3"];
    $eminuto3 = $_POST["eminuto3"];
    $ezona3 = $_POST["ezona3"];
    $e_am_pm3 = $ehora3 . ":" . $eminuto3 . " " . $ezona3;
    $entrada3 = date('H:i:s', strtotime($e_am_pm3));
    $str_entrada3 = strtotime($entrada3);

    $shora3 = $_POST["shora3"];
    $sminuto3 = $_POST["sminuto3"];
    $szona3 = $_POST["szona3"];
    $s_am_pm3 = $shora3 . ":" . $sminuto3 . " " . $szona3;
    $salida3 = date('H:i:s', strtotime($s_am_pm3));
    $str_salida3 = strtotime($salida3);

    $dia3 = $_POST["dia3"];

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

include '../../conex.php';
    //Abrir Conexion
//Consulta SQL
    $sql = "INSERT INTO horarios VALUES('','$id_profesor','$materia','$entrada','$salida','$dia1','$h_diurna_t','$h_nocturna_t','$entrada2','$salida2','$dia2','$h_diurna_t2','$h_nocturna_t2','$entrada3','$salida3','$dia3','$h_diurna_t3','$h_nocturna_t3','$created_by')";

    if ($agregar = @mysql_query($sql)) { // Execute
        $log = "Usuario Agregado correctamente en la base de datos";
        header("Location: horarios.php?id=yes");
    } else {
        $log = "Error inesperado en la insercion en la base de datos";
        header("Location: horarios.php?id=no");
    }
//echo $log;
    @mysql_close($conexion); // Close db

?>




