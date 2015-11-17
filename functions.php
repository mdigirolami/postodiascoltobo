<?php
function get_assistiti() {
	global $db,$config;
	$result = array();

	$sql="SELECT assistiti.*, elenco_nazioni.nome as nazione FROM assistiti join elenco_nazioni on elenco_nazioni.id=assistiti.id_nazionalita where valid=1";
	$res=mysql_query($sql) or die(mysql_error());
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

	$sql="insert into richieste (`id`, `id_assistito`, `richiesta_alloggio`,`richiesta_primari`,`richiesta_lavoro`,`richiesta_beni_servizi`,`richiesta_contatti_servizi`,`richiesta_burocratica`,`richiesta_sanitaria`) VALUES ('', ".$id_assistito.", '".$params["richiesta_alloggio"]."','".$params["richiesta_primari"]."','".$params["richiesta_lavoro"]."','".$params["richiesta_beni_servizi"]."','".$params["richiesta_contatti_servizi"]."','".$params["richiesta_burocratica"]."','".$params["richiesta_sanitaria"]."')";
	echo "<br>".$sql;
	$res9=mysql_query($sql);

    return $id_assistito;
}


function modifica_assistito($params) {

	echo("modifica_assistito - params=".print_r($params,true));

  modifica_dati_anagrafici_assistito($params);
	modifica_familiari_assistito($params);
	modifica_documenti_assistito($params);
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


function modifica_documenti_assistito($params) {

	global $db,$config;
  echo "documenti:"."\r\n";
	$documento_index = 0;
	foreach ($params as $key => $value) {

		if (substr($key, 0, 10)=="documento_") {

			$number=substr($key, -1);
			$documento_pk="documento_".$documento_index."_pk";
			$tipodoc_key="tipodoc_".$documento_index;
			$numero_key="numero_".$documento_index;
			$rilascio_key="rilascio_".$documento_index;
			$scadenza_key="scadenza_".$documento_index;
			$fotocopia_key="fotocopia_".$documento_index;
			$rimuovi_key="documento_".$documento_index."_rimuovi";
			echo "documento_pk=".$params[$documento_pk]." numero=".$params[$numero_key]." rilascio=".$params[$rilascio_key]." scadenza=".$params[$scadenza_key]." fotocopia=".$params[$fotocopia_key]." numero=".$params[$numero_key]."\n";

			$data_rilascio_formatted=NULL;
			if ($params[$rilascio_key]!="") {
				$data_rilascio_pieces=split("/", $params[$rilascio_key]);
				$data_rilascio_formatted=$data_rilascio_pieces[2]."-".$data_rilascio_pieces[0]."-".$data_rilascio_pieces[1];
			}

			$data_scadenza_formatted=NULL;
			if ($params[$scadenza_key]!="") {
				$data_scadenza_pieces=split("/", $params[$scadenza_key]);
				$data_scadenza_formatted=$data_scadenza_pieces[2]."-".$data_scadenza_pieces[0]."-".$data_scadenza_pieces[1];
			}

			if ($params[$documento_pk]=="") {
				//insert
				if ( ($params[$tipodoc_key]!="") OR ($params[$numero_key]!="") OR ($params[$rilascio_key]!="") OR ($params[$scadenza_key]!="") OR ($params[$fotocopia_key]!="") ) {
					$sql="insert into DOCUMENTI_ASSISTITO (`id`, `id_assistito`, `tipo_doc`,`numero_doc`,`data_rilascio_doc`,`data_scadenza_doc`,`fotocopia`) VALUES ('', ".$params["id_assistito"].", '".$params[$tipodoc_key]."', '".$params[$numero_key]."', '".$data_rilascio_formatted."', '".$data_scadenza_formatted."', '".$params[$fotocopia_key]."')";
					echo $sql;
					mysql_query($sql);
				}

			} else {
				$flag_to_remove = 0;
				if ($params[$rimuovi_key]=="1") {

					$sql='delete from DOCUMENTI_ASSISTITO where id='.$params[$documento_pk];
					echo $sql;
					mysql_query($sql);
				} else {
					//update
					$sql='update DOCUMENTI_ASSISTITO set `tipo_doc`="'.$params[$tipodoc_key].'", `numero_doc`="'.$params[$numero_key].'", `data_rilascio_doc`="'.$data_rilascio_formatted.'", `data_scadenza_doc`="'.$data_scadenza_formatted.'", `fotocopia`="'.$params[$fotocopia_key].'" where id='.$params[$documento_pk];
					echo $sql;
					mysql_query($sql);
				}
			}
			$documento_index++;
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
	$res=mysql_query($sql) or die(mysql_error());
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
	$sql="UPDATE assistiti SET valid=0, data_invalidazione='".date("Y-m-d H:i:s")."', data_modifica='".date("Y-m-d H:i:s")."' where id=".$id;

	$res=mysql_query($sql);
}


function delete_servizio($id) {
	global $db,$config;
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

	$sql="SELECT * FROM elenco_nazioni order by nome asc";

	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}
	return $result;
}


function get_scuole($anno) {
	global $db,$config;
	$result = array();

	$sql="SELECT * FROM scuole where anno=".$anno;
	$res=mysql_query($sql);
	while($r=mysql_fetch_array($res)) {
			$result[]=$r;
	}

	return $result;
}


function modifica_scuole($params) {

	global $db,$config;
  echo "scuole:"."\r\n";
	$familiare_index = 0;
	foreach ($params as $key => $value) {

		if (substr($key, 0, 10)=="familiare_") {

			$number=substr($key, -1);
			$familiare_pk="familiare_".$familiare_index."_pk";
			$nazionalita_key="nazionalita_".$familiare_index;
			$sesso_key="sesso_".$familiare_index;
			$numero_key="numero_".$familiare_index;
			$rimuovi_key="familiare_".$familiare_index."_rimuovi";
//			echo "familiare_pk=".$params[$familiare_pk]." nazionalita=".$params[$nazionalita_key]." sesso=".$params[$sesso_key]." numero=".$params[$numero_key]."\n";

			if ($params[$familiare_pk]=="") {
				//insert
				if ( ($params[$nazionalita_key]!="0") AND ($params[$numero_key]!="") ) {
					$sql="insert into scuole (`id`, `anno`, `id_nazionalita`, `sesso`, `numero`) VALUES ('', ".$params["anno"].", ".$params[$nazionalita_key].", '".$params[$sesso_key]."', ".$params[$numero_key].")";
					echo $sql;
					mysql_query($sql);
				}

			} else {
				$flag_to_remove = 0;
				if ($params[$rimuovi_key]=="1") {

					$sql='delete from scuole where id='.$params[$familiare_pk];
//					echo $sql;
					mysql_query($sql);
				} else {
					//update
					$sql='update scuole set `id_nazionalita`='.$params[$nazionalita_key].', `sesso`="'.$params[$sesso_key].'", `numero`='.$params[$numero_key].' where id='.$params[$familiare_pk];
					//$sql="update familiari (`id`, `id_capofamiglia`, `anno_di_nascita`, `parentela`) VALUES ('', ".$id_assistito.", ".$params[$anno_nascita_key].", '".$params[$parentela_key].'" where id='.$params["id_assistito"];
//					echo $sql;
					mysql_query($sql);
				}
			}
			$familiare_index++;
	 }

 }

}


function get_cat_servizi() {
	global $db,$config;
	$result = array();

	$sql="SELECT id, nome FROM cat_servizi";
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function inserisci_servizio($params) {
	global $db,$config;
	$date_pieces=split("/", $params['data']);
	$data=$date_pieces[2]."-".$date_pieces[0]."-".$date_pieces[1];
	$sql="INSERT INTO servizi_erogati VALUES ('', ".$params['id_servizio'].", ".$params['id_assistito'].", '".$data."', '".$params['note']."', 1, '', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";

	$res=mysql_query($sql);

	$sql2="select id from servizi_erogati order by id desc limit 1";
	$res2=mysql_query($sql2);
	$r=mysql_fetch_object($res2);
	$id_servizio=$r->id;

	return $id_servizio;
}


function get_stat_banco_alimentare($anno) {
	global $db,$config;
	$result = array();

	$sql="SELECT mese, count(*) as pacchi FROM banco_alimentare where anno=".$anno." group by mese";
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function get_stat_scuole($anno) {
	global $db,$config;
	$result = array();

	$sql="SELECT sesso, numero, elenco_nazioni.nome as nazione, continenti.nome as continente FROM scuole join elenco_nazioni on id_nazionalita=elenco_nazioni.id join continenti on elenco_nazioni.id_continente=continenti.id where anno=".$anno;
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function get_richieste($id_assistito) {
 global $db,$config;
 $result = array();

 $sql="SELECT * FROM richieste where id_assistito=".$id_assistito;
 $res=mysql_query($sql);
 while($r=mysql_fetch_assoc($res)) {
   $result[]=$r;
 }
 return $result;
}


?>
