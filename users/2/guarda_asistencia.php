<?php

// Registro de Usuarios
$id_profesor = $_POST["id_profesor"];
$id_materia = $_POST["id_materia"];
$id_horario = $_POST["id_horario"];
date("Y-m-d", $fecha = $_POST["fecha_marcaje"]);
$semestre = $_POST["semestre"];
$turno = $_POST["turno"];
$created_by = $_POST["created_by"];
$h_1 = 2;
$h_2 = 2;



if ($turno != "") {
    switch ($turno) {
        case 1:
            $h_entrada = $_POST["ehora1"];
            $h_salida = $_POST["shora1"];
            $horas = ((strtotime($h_salida) - strtotime($h_entrada)) / 60) / 45;
            $h_trabajadas = number_format($horas, 2);
            break;
        case 2:
            $h_entrada = $_POST["ehora2"];
            $h_salida = $_POST["shora2"];
            $horas = ((strtotime($h_salida) - strtotime($h_entrada)) / 60) / 45;
            $h_trabajadas = number_format($horas, 2);
            break;
        case 3:
            $h_entrada = $_POST["ehora3"];
            $h_salida = $_POST["shora3"];
            $horas = ((strtotime($h_salida) - strtotime($h_entrada)) / 60) / 45;
            $h_trabajadas = number_format($horas, 2);
            break;
        default:
            break;
    }
}
//Abrir Conexion
include '../../conex.php';
//Consulta SQL
$sql = "INSERT INTO asistencias 
VALUES('','$id_horario','$id_profesor','$id_materia','$h_entrada','$h_1','$h_salida','$h_2','0','0','$fecha','$h_trabajadas','$created_by')";

if ($agregar = @mysql_query($sql)) { // Execute
    $log = "El Marcaje de Asistencia Manual ha sido Agregado Correctamente en la Base de Datos";
    header("Location: index.php?db=" . $log);
} else {
    $log = "Error inesperado en la insercion del marcaje de asistencia en la base de datos";
    header("Location: index.php?db=" . $log);
}
//echo $log;
@mysql_close($conexion); // Close db
?>




