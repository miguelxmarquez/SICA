<?php

// Registro de Usuarios
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$username = $_POST["username"];
$pass = md5($_POST["pass"]);
$repass = md5($_POST["repass"]);
$email = $_POST["email"];
$rol = $_POST["rol"];
if ($pass == $repass) {
    //Abrir Conexion
    include '../../conex.php';
//Consulta SQL
    $sql = "INSERT INTO usuarios VALUES('','$username','$pass','$nombre','$apellido','$email','$rol','1','')";

    if ($agregar = @mysql_query($sql)) { // Execute
        $log = "Usuario Agregado correctamente en la base de datos";
        header("Location: usuarios.php?saved=yes");
    } else {
        $log = "Error inesperado en la insercion del Usuario en la base de datos";
        header("Location: usuarios.php?saved=no");
    }
//echo $log;
    @mysql_close($conexion); // Close db
}else {
    header("Location: nuevo_usuario.php?nombre=".$nombre."&apellido=".$apellido."&username=".$username."&email=".$email);
}
?>




