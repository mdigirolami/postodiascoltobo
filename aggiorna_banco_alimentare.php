<?php
require_once "config.php";
require_once "functions.php";

if ($_POST['action'] == 'register_update') {
  $page_mode='REGISTRA_MODIFICA';
} else if ($_POST['action'] == 'register_insert') {
  $page_mode='REGISTRA_INSERISCI';
} else if (isset($_GET['id_assistito'])) {
  $page_mode='VISUALIZZA_MODIFICA';
} else {
  $page_mode='VISUALIZZA_INSERISCI';
}


$id_assistito=$_POST['id_assistito'];
$assistito = get_assistito($id_assistito);
$anno=$_POST['anno'];
$banco_alimentare = get_banco_alimentare_assistito($id_assistito,$anno);
print_r($banco_alimentare);

$ritiri=$_POST['ritiri'];

print_r($ritiri);

if (array_diff($banco_alimentare,$ritiri)){
	foreach (array_diff($banco_alimentare,$ritiri) as $mese) {
		delete_ritiro($id_assistito,$mese,$anno);	
	}
}

if (array_diff($ritiri,$banco_alimentare)){
	foreach (array_diff($ritiri,$banco_alimentare) as $mese) {
		inserisci_ritiro($id_assistito,$mese,$anno);	
	}
}

header('Location: banco_alimentare.php?id_assistito='.$id_assistito.'&anno='.$anno);
?>