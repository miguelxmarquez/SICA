<?php

// Eliminacion de materias 
session_start();
$id = $_GET["id"];

include '../../conex.php';

$sql_buscar = "SELECT * FROM usuarios WHERE id = '$id'";
$sql_eliminar = "DELETE FROM usuarios WHERE id = '$id'";
if ($result_buscar = mysql_query($sql_buscar)) {

    $A = mysql_fetch_array($result_buscar);

    $usuario = $A["usuario"];
    $nombre = $A["nombre"];
    $apellido = $A["apellido"];
    $email = $A["email"];
    $rol = $A["rol"];
    $ultimo_acceso = $A["ultimo_acceso"];

    // Datos de actualizacion para el log
    $descripcion = "Actualización de la tabla Usuarios (Eliminación del registro en la base de datos)";
    $cambios = "Campos eliminados: usuario=" . $usuario . ", nombre=" . $nombre . ", apellido=" . $apellido . ", email=" . $email . ", rol=" . $rol . ", ultimo_acceso=" . $ultimo_acceso;
    $fecha = date("D d-m-Y h:i:s A");
    $updated_by = $_SESSION["usuario"];

    // Consulta SQL
    $sql_log = "INSERT INTO logs VALUES(NULL,'$descripcion','$cambios','$fecha','$updated_by')";

    if (@mysql_query($sql_eliminar)) {
        if (@mysql_query($sql_log)) {
            header("Location: usuarios.php?deleted=yes&log=yes");
        }
    } else {
        header("Location: usuarios.php?deleted=yes&log=no");
    }
}
?>
