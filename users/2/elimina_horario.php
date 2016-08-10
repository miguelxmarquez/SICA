<?php

$id = $_GET["id"];

include '../../conex.php';

$query = "DELETE FROM horarios WHERE id = '$id'";

if (@mysql_query($query)) {

    header("Location: horarios.php?deleted=yes");
}
?>
