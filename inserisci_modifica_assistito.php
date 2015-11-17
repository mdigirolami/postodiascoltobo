<?php
require_once "config.php";
require_once "functions.php";

if ($_POST['action'] == 'register_update') {
//  echo "chiamata a modifica_assistito...";
  modifica_assistito($_POST);
//  echo "Dati assistito modificati correttamente";
  $id_assistito=$_POST['id_assistito'];
} else if ($_POST['action'] == 'register_insert') {
//  echo "chiamata a inserisci_assistito...";
  $id_assistito=inserisci_assistito($_POST);
//  echo "Assistito inserito correttamente";
}

//header('Location: visualizza_assistito.php?id_assistito='.$id_assistito);

?>
