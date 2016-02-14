<?php
require_once "config.php";
require_once "functions.php";

$id_assistito=$_POST['id_assistito'];
$id_servizio_erogato=$_POST['id_servizio_erogato'];
modifica_servizio($_POST);
//header('Location: dettagli_servizio.php?id_servizio='.$id_servizio);
header('Location: dettagli_servizio.php?id_assistito='.$id_assistito.'&id_servizio_erogato='.$id_servizio_erogato);

?>
