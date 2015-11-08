<?php
function get_assistiti() {
	global $db,$config;
	$result = array();

	$sql="SELECT * FROM assistiti where valid=1";
	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function inserisci_assistito($params) {

	echo("inserisci_assistito - params=".print_r($params,true));

	global $db,$config;
	$date_pieces=split("/", $params['data_di_nascita']);
	$new_date=$date_pieces[2]."-".$date_pieces[0]."-".$date_pieces[1];
    $sql='insert into assistiti (`id`, `valid`, `data_creazione`, `nome`, `cognome`, `data_di_nascita`, `luogo_di_nascita`, `sesso`, `id_nazionalita`, `cellulare`, `stato_civile`, `citta_residenza`, `via_residenza`, `numero_residenza`, `nazione_residenza`, `alloggio`, `lingua_madre`, `ha_lavorato`, `lavora`, `dove_lavora`)
	VALUES ("", 1,now(),"'.$params["nome"].'", "'.$params["cognome"].'", "'.$new_date.'", "'.$params["luogo_di_nascita"].'", "'.$params["sesso"].'", "'.$params["nazionalita"].'", "'.$params["cellulare"].'", "'.$params["stato_civile"].'", "'.$params["citta_residenza"].'", "'.$params["via_residenza"].'", "'.$params["numero_residenza"].'", "'.$params["nazione_residenza"].'", "'.$params["alloggio"].'", "'.$params["lingua_madre"].'", "'.$params["ha_lavorato"].'", "'.$params["lavora"].'", "'.$params["dove_lavora"].'")';
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

	foreach ($params['lingue'] as $lingua) {
		$sql5="insert into lingue VALUES ('', ".$id_assistito.", '".$lingua."')";
		echo $sql5;
		$res5=mysql_query($sql5);
	}

	foreach ($params['vulnerabilita'] as $vulnerabilita) {
		$sql6="insert into vulnerabilita VALUES ('', ".$id_assistito.", '".$vulnerabilita."')";
		echo $sql6;
		$res6=mysql_query($sql6);
	}

	foreach ($params['risposte_indirette'] as $risposta) {
		$sql7="insert into risposte_indirette VALUES ('', ".$id_assistito.", '".$risposta."')";
		echo $sql7;
		$res7=mysql_query($sql7);
	}

	foreach ($params as $key => $value) {
		if (substr($key, 0, -1)=="anno_nascita_" && $value!="") {
			$number=substr($key, -1);
			$parentela_key="parentela_".$number;
			$sql8="insert into familiari (`id`, `id_capofamiglia`, `anno_di_nascita`, `parentela`) VALUES ('', ".$id_assistito.", ".$value.", '".$params[$parentela_key]."')";
			echo $sql8;
			$res8=mysql_query($sql8);
		}
	}

}


function modifica_assistito($params) {

	echo("modifica_assistito - params=".print_r($params,true));

  modifica_dati_anagrafici_assistito($params);
	modifica_familiari_assistito($params);
}



function modifica_dati_anagrafici_assistito($params) {

	global $db,$config;
	$date_pieces=split("/", $params['data_di_nascita']);
	$new_date=$date_pieces[2]."-".$date_pieces[0]."-".$date_pieces[1];
  $sql='update assistiti set `data_modifica`=now(), `nome`="'.$params["nome"].'", `cognome`="'.$params["cognome"].'", `data_di_nascita`="'.$params["data_di_nascita"].'", `luogo_di_nascita`="'.$params["luogo_di_nascita"].'", `sesso`="'.$params["sesso"].'", `id_nazionalita`="'.$params["nazionalita"].'", `cellulare`="'.$params["cellulare"].'", `stato_civile`="'.$params["stato_civile"].'", `citta_residenza`="'.$params["citta_residenza"].'", `via_residenza`="'.$params["via_residenza"].'", `numero_residenza`="'.$params["numero_residenza"].'", `nazione_residenza`="'.$params["nazione_residenza"].'", `alloggio`="'.$params["alloggio"].'", `lingua_madre`="'.$params["lingua_madre"].'", `ha_lavorato`="'.$params["ha_lavorato"].'" where id='.$params["id_assistito"];
  echo $sql;
	$res=mysql_query($sql);
}

function modifica_familiari_assistito($params) {

	global $db,$config;
  echo "familiari:"."\r\n";
	$familiare_index = 0;
	foreach ($params as $key => $value) {

		if (substr($key, 0, 10)=="familiare_") {

			$number=substr($key, -1);
			$familiare_pk="familiare_".$familiare_index."_pk";
			$anno_nascita_key="anno_nascita_".$familiare_index;
			$parentela_key="parentela_".$familiare_index;
			$rimuovi_key="familiare_".$familiare_index."_rimuovi";
			echo "familiare_pk=".$params[$familiare_pk]." anno_nascita=".$params[$anno_nascita_key]." parentela=".$params[$parentela_key]."\n";

			if ($params[$familiare_pk]=="") {
				//insert
				if ( ($params[$anno_nascita_key]!="") OR ($params[$parentela_key]!="") ) {
					$sql="insert into familiari (`id`, `id_capofamiglia`, `anno_di_nascita`, `parentela`) VALUES ('', ".$params["id_assistito"].", ".$params[$anno_nascita_key].", '".$params[$parentela_key]."')";
					echo $sql;
					mysql_query($sql);
				}

			} else {
				$flag_to_remove = 0;
				if ($params[$rimuovi_key]=="1") {

					$sql='delete from familiari where id='.$params[$familiare_pk];
					echo $sql;
					mysql_query($sql);
				} else {
					//update
					$sql='update familiari set `id_capofamiglia`="'.$params["id_assistito"].'", `anno_di_nascita`="'.$params[$anno_nascita_key].'", `parentela`="'.$params[$parentela_key].'" where id='.$params[$familiare_pk];
					//$sql="update familiari (`id`, `id_capofamiglia`, `anno_di_nascita`, `parentela`) VALUES ('', ".$id_assistito.", ".$params[$anno_nascita_key].", '".$params[$parentela_key].'" where id='.$params["id_assistito"];
					echo $sql;
					mysql_query($sql);
				}
			}
			$familiare_index++;
	 }

 }

}


function get_servizi() {
	global $db,$config;
	$result = array();

	$sql="SELECT cat_servizi.nome AS tipo, servizi_erogati.data, servizi_erogati.id as id_servizio_erogato, assistiti.nome AS nome, assistiti.cognome, assistiti.id as id_assistito
FROM cat_servizi
JOIN servizi_erogati ON cat_servizi.id = servizi_erogati.id_servizio
JOIN assistiti ON servizi_erogati.id_assistito = assistiti.id where servizi_erogati.valid=1 order by data desc, tipo";
	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function get_servizi_assistito($id) {
	global $db,$config;
	$result = array();

	$sql="SELECT cat_servizi.nome AS tipo, servizi_erogati.data, servizi_erogati.id as id_servizio_erogato, assistiti.nome AS nome, assistiti.cognome, assistiti.id as id_assistito
FROM cat_servizi
JOIN servizi_erogati ON cat_servizi.id = servizi_erogati.id_servizio
JOIN assistiti ON servizi_erogati.id_assistito = assistiti.id where assistiti.id=".$id." and servizi_erogati.valid=1 order by data desc, tipo";
	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function get_servizio($id) {
	global $db,$config;
	$result = array();

	$sql="SELECT cat_servizi.nome AS tipo, servizi_erogati.data, servizi_erogati.note, assistiti.nome AS nome, assistiti.cognome, assistiti.id as id_assistito
FROM cat_servizi
JOIN servizi_erogati ON cat_servizi.id = servizi_erogati.id_servizio
JOIN assistiti ON servizi_erogati.id_assistito = assistiti.id where servizi_erogati.id=".$id." and servizi_erogati.valid=1";
	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result=$r;
	}

	return $result;
}


function get_assistito($id) {
	global $db,$config;
	$result = array();

	$sql="SELECT a.*, n.nome as nome_nazionalita FROM assistiti a INNER JOIN elenco_nazioni n ON n.id = a.id_nazionalita where a.id=".$id." and a.valid=1";
	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result=$r;
	}

	return $result;
}


function get_documenti_assistito($id_assistito) {
	global $db,$config;
	$result = array();

	$sql="SELECT * FROM DOCUMENTI_ASSISTITO where id_assistito=".$id_assistito;

	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}
	return $result;
}


function get_lingue_assistito($id_assistito) {
		global $db,$config;
		$result = array();

		$sql="SELECT * FROM lingue where id_assistito=".$id_assistito;
		$res=mysql_query($sql);
		while($r=mysql_fetch_assoc($res)) {
				$result[]=$r;
		}

	return $result;
}


function get_vulnerabilita_assistito($id_assistito) {
		global $db,$config;
		$result = array();

		$sql="SELECT * FROM vulnerabilita where id_assistito=".$id_assistito;
		$res=mysql_query($sql);
		while($r=mysql_fetch_assoc($res)) {
				$result[]=$r;
		}

	return $result;
}


function get_risposte_indirette_assistito($id_assistito) {
		global $db,$config;
		$result = array();

		$sql="SELECT * FROM risposte_indirette where id_assistito=".$id_assistito;
		$res=mysql_query($sql);
		while($r=mysql_fetch_assoc($res)) {
				$result[]=$r;
		}

	return $result;
}


function get_chi_lo_invia_assistito($id_assistito) {
	global $db,$config;
	$result = array();

	$sql="SELECT * FROM inviato where id_assistito=".$id_assistito;
	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function get_banco_alimentare_assistito($id_assistito,$anno) {
	global $db,$config;
	$result = array();

	$sql="SELECT mese FROM banco_alimentare where id_assistito=".$id_assistito." and anno=".$anno;
	$res=mysql_query($sql);
	while($r=mysql_fetch_array($res)) {
			$result[]=$r['mese'];
	}

	return $result;
}


function delete_assistito($id) {
	global $db,$config;
	$result = array();
	$sql="UPDATE assistiti SET valid=0, data_invalidazione='".date("Y-m-d H:i:s")."', data_modifica='".date("Y-m-d H:i:s")."' where id=".$id;

	$res=mysql_query($sql);
}


function delete_servizio($id) {
	global $db,$config;
	$result = array();
	$sql="UPDATE servizi_erogati SET valid=0, data_invalidazione='".date("Y-m-d H:i:s")."', data_modifica='".date("Y-m-d H:i:s")."' where id=".$id;

	$res=mysql_query($sql);
}


function delete_ritiro($id_assistito,$mese,$anno) {
	global $db,$config;
	$result = array();
	$sql="DELETE FROM banco_alimentare where id_assistito=".$id_assistito." and mese=".$mese." and anno=".$anno;

	$res=mysql_query($sql);
}


function inserisci_ritiro($id_assistito,$mese,$anno) {
	global $db,$config;
	$result = array();
	$sql="INSERT INTO banco_alimentare VALUES ('', ".$id_assistito.", ".$anno.", ".$mese.")";

	$res=mysql_query($sql);
}

function get_familiari_assistito($id_assistito) {
	global $db,$config;
	$result = array();

	$sql="SELECT * FROM familiari where id_capofamiglia=".$id_assistito;

	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}
	return $result;
}

function get_elenco_nazioni() {
	global $db,$config;
	$result = array();

	$sql="SELECT * FROM elenco_nazioni where valid=1 order by nome asc";

	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}
	return $result;
}


?>
