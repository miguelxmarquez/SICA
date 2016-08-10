<?php

$id = $_GET["id"];

include '../../conex.php';

$registro = "DELETE FROM personas WHERE id = '$id'";

if (@mysql_query($registro)) {
    header("Location: index.php?id=deleted");
} else {
    header("Location: usuarios.php?saved=no");
}
?>
