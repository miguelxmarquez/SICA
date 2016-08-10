<?php

// Chequeo la existencia de cookies
//include 'cookie.php';
// Creación de Variables Provenientes del Método POST
$user = $_POST["usuario"];
$pass = md5($_POST["clave"]);

//Abrimos Conexión DB
include 'conex.php';
//Consulta SQL, Ejecución y puesta en Arreglo
$sql = "SELECT * FROM usuarios WHERE usuario = '$user' AND clave = '$pass' AND estado=1";
$result = @mysql_query($sql);
// Condicional para verificar los datos
if (@mysql_num_rows($result) == "1") {
    //TODO CORRECTO!! He detectado un usuario
    // Creo un objeto con el resultado de la consulta sql
    $persona = @mysql_fetch_object($result);
    // inicio la sesión 
    @session_start();
    //asigno un nombre a la sesión para poder guardar diferentes datos 
    session_name($persona->usuario);
    //defino la sesión que demuestra que el usuario está autorizado 
    $_SESSION["id_sesion"] = session_id();
    $_SESSION["id"] = $persona->id;
    $_SESSION["nombre"] = $persona->nombre;
    $_SESSION["apellido"] = $persona->apellido;
    $_SESSION["usuario"] = $persona->usuario;
    $_SESSION["rol"] = $persona->rol;
    $_SESSION["ultimo_acceso"] = $persona->ultimo_acceso;
    //defino la fecha y hora de inicio de sesión en formato aaaa-mm-dd hh:mm:ss 
    $_SESSION["ultimoAcceso"] = date("Y-n-j h:i:s");


    // Redirección al sitio restringido
    if ($persona->rol == 1) {
        header("Location: users/1/");
    }
    if ($persona->rol == 2) {
        header("Location: users/2/");
    }
} else {
    // Envío de variable por $_GET del usuario no Autenticado a la Página de Ingreso
    header("Location:index.php?guest=yes");
}
@mysql_free_result($result);
@mysql_close($conexion);
?>
