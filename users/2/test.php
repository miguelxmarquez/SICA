<?php
require("../../includes/class.php");
//date_default_timezone_set("America/Santiago");
/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */

$filename = $_GET["id"].'.jpg';
//$filename="cesar.jpg";
$result = file_put_contents( "../../data/fotos/".$filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}
$_SESSION["foto"]=$filename;


?>
