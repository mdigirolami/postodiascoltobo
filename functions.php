<?php
function get_assistiti() {
	global $db,$config;
	$result = array();

	$sql="SELECT * FROM assistiti";
	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result=$r;
	}

	return $result;
}

function inserisci_assistito($params) {

	echo("inserisci_assistito - params=".print_r($params,true));

	global $db,$config;
	$date_pieces=split("/", $params['data_di_nascita']);
	$new_date=$date_pieces[2]."-".$date_pieces[0]."-".$date_pieces[1];
    $sql="insert into assistiti (`id`, `nome`, `cognome`, `data_di_nascita`, `luogo_di_nascita`, `sesso`, `nazionalita`, `cellulare`, `stato_civile`, `citta_residenza`, `via_residenza`, `numero_residenza`, `nazione_residenza`) VALUES ('', '".$params['nome']."', '".$params['cognome']."', '".$new_date."', '".$params['luogo_di_nascita']."', '".$params['sesso']."', '".$params['nazionalita']."', '".$params['cellulare']."', '".$params['stato_civile']."', '".$params['citta_residenza']."', '".$params['via_residenza']."', '".$params['numero_residenza']."', '".$params['nazione_residenza']."')";
    echo $sql;
	$res=mysql_query($sql);

	$sql2="select id from assistiti order by id desc limit 1";
	$res2=mysql_query($sql2);
	$r=mysql_fetch_object($res2);
	$id_assistito=$r->id;
	echo "id_assistito ".$id_assistito;

	foreach ($params['chi_lo_invia'] as $chi) {
		$sql3="insert into inviato (`id`, `id_assistito`, `chi`) VALUES ('', ".$id_assistito.", '".$chi."')";
		echo $sql3;
		$res3=mysql_query($sql3);
	}

	foreach ($params['documenti'] as $doc) {

		if ($doc=="altro") {
			$tipo_doc = $params["descrizione_altro"];
		}
		else {
			$tipo_doc = $doc;
		}

		$data_rilascio_pieces=split("/", $params["rilascio_".$doc]);
		$data_rilascio_formatted=$data_rilascio_pieces[2]."-".$data_rilascio_pieces[0]."-".$data_rilascio_pieces[1];

		$data_scadenza_pieces=split("/", $params["scadenza_".$doc]);
		$data_scadenza_formatted=$data_scadenza_pieces[2]."-".$data_scadenza_pieces[0]."-".$data_scadenza_pieces[1];

		$fotocopia = ($params["fotocopia_".$doc] == "on" ? true : false);

		$sql4="insert into DOCUMENTI_ASSISTITO (`id`, `id_assistito`, `tipo_doc`,`numero_doc`,`data_rilascio_doc`,`data_scadenza_doc`,`fotocopia`) VALUES ('', ".$id_assistito.", '".$tipo_doc."','".$params["numero_".$doc]."','".$data_rilascio_formatted."','".$data_scadenza_formatted."','".$fotocopia."')";
		echo "<br>".$sql4;
		$res4=mysql_query($sql4);
	}


}
?>
