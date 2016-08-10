<?php

//si es necesario cambiar la config. del php.ini desde tu script 
//ini_set("session.use_only_cookies", "1");
//ini_set("session.use_trans_sid", "0");
//iniciamos la sesión 

session_start();
//echo $_SESSION["autentificado"];
//antes de hacer los cálculos, compruebo que el usuario está logueado 
//utilizamos el mismo script que antes 

if ($_SESSION["id_sesion"] != session_id()) {
    //si no está logueado lo envío a la página de autentificación 
    header("Location: ../index.php");
} else {

    function string_to_array($url) {
        $largo = strlen($url); //Largo de cadena
        $final_array = array();
        for ($i = 0; $i < $largo; $i++) {
            $caracter = $url[$i];
            array_push($final_array, $caracter);
        }

        if ($final_array[12] != $_SESSION["rol"]) {
            header("Location: ../../index.php");
        }
        return $final_array;
    }

    $string = $_SERVER['REQUEST_URI'];
    string_to_array($string);

    //sino, calculamos el tiempo transcurrido 
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("Y-n-j h:i:s");
    $tiempo_transcurrido = (strtotime($ahora) - strtotime($fechaGuardada));

    //comparamos el tiempo transcurrido 2 horas para administrador
    if (($tiempo_transcurrido >= 900) && ($_SESSION["rol"] == "2")) {
        //si pasaron 10 minutos o más 
        session_unset();
        session_destroy(); // destruyo la sesión 
        header("Location: index.php"); //envío al usuario a la pag. de autenticación 
        //sino, actualizo la fecha de la sesión 
    } else {
        require 'conex.php';
        $_SESSION["ultimoAcceso"] = $ahora;
        $id = $_SESSION["id"];
        $ultimo_acceso = "UPDATE usuarios SET ultimo_acceso = '$ahora' WHERE id = '$id'";
        @mysql_query($ultimo_acceso);
    }
}
?>

