<?php
require_once "config.php";
require_once "functions.php";

$anno=$_POST['anno'];
$scuole = get_scuole($anno);

modifica_scuole($_POST);

header('Location: scuole.php?anno='.$anno);

?>