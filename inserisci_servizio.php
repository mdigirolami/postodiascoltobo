<?php
require_once "config.php";
require_once "functions.php";

$anno=$_POST['id_assistito'];
$id_assistito=$_POST['id_assistito'];

print_r($_POST);

$id_servizio = inserisci_servizio($_POST);

//header('Location: dettagli_servizio.php?id_servizio='.$id_servizio);
header('Location: servizi_assistito.php?id_assistito='.$id_assistito);

?>
