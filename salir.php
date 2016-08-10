<?php

// Si existe se inicia, sino se crea..
session_start();
// Borro todos los datos de sesion
session_unset();
// Destruyo la sesion
session_destroy();

header("Location:index.php?exit=yes");

?>
