<?php
function get_assistiti() {
	global $db,$config;
	$result = array();

	$sql="SELECT assistiti.*, elenco_nazioni.nome as nazione FROM assistiti left join elenco_nazioni on elenco_nazioni.id=assistiti.id_nazionalita where valid=1";
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function inserisci_assistito($params) {

	echo("inserisci_assistito - params=".print_r($params,true));

	global $db,$config;

	$data_nascita = $params['data_di_nascita'];
	if ($data_nascita!="") {
		$data_nascita_formatted = convertDateFromItTo2Db($data_nascita);
		$data_nascita_sql="'".$data_nascita_formatted."'";
	}
	else {
		$data_nascita_sql="NULL";
	}
	$data_primo_ascolto = $params['data_primo_ascolto'];
	if ($data_primo_ascolto!="") {
		$data_primo_ascolto_formatted = convertDateFromItTo2Db($data_primo_ascolto);
		$data_primo_ascolto_sql="'".$data_primo_ascolto_formatted."'";
	}
	else {
		$data_primo_ascolto_sql="NULL";
	}


  $sql='insert into assistiti (`id`, `valid`, `data_creazione`,`data_modifica`, `nome`, `cognome`, `data_di_nascita`, `luogo_di_nascita`, `sesso`, `id_nazionalita`, `cellulare`, `stato_civile`, `citta_residenza`, `via_residenza`, `numero_residenza`, `nazione_residenza`, `alloggio`, `lingua_madre`, `ha_lavorato`, `lavora`, `dove_lavora`,`data_primo_ascolto`,`note`)
	VALUES ("", 1,now(),now(),"'.$params["nome"].'", "'.$params["cognome"].'", '.$data_nascita_sql.', "'.$params["luogo_di_nascita"].'", "'.$params["sesso"].'", "'.$params["nazionalita"].'", "'.$params["cellulare"].'", "'.$params["stato_civile"].'", "'.$params["citta_residenza"].'", "'.$params["via_residenza"].'", "'.$params["numero_residenza"].'", "'.$params["nazione_residenza"].'", "'.$params["alloggio"].'", "'.$params["lingua_madre"].'", "'.$params["ha_lavorato"].'", "'.$params["lavora"].'", "'.$params["dove_lavora"].'", '.$data_primo_ascolto_sql.',"'.$params["note"].'")';
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

 /*
	foreach ($params['documenti'] as $doc) {

		if ($doc=="altro") {
			$tipo_doc = $params["descrizione_altro"];
		}
		else {
			$tipo_doc = $doc;
		}

		$data_rilascio = $params["rilascio_".$doc];
		$data_rilascio_formatted=NULL;
		$data_rilascio_pieces=split("/", $data_rilascio);
		echo "data_rilascio: ".$data_rilascio;
		if ($data_rilascio=="") {
			echo "data_rilascio_1";
		} else if ($data_rilascio=='') {
			echo "data_rilascio_2";
		} else if ($data_rilascio==NULL) {
			echo "data_rilascio_3";
		}
		if ($data_rilascio!="") {
			$data_rilascio_formatted=$data_rilascio_pieces[2]."-".$data_rilascio_pieces[0]."-".$data_rilascio_pieces[1];
		}


		$data_scadenza_pieces=split("/", $params["scadenza_".$doc]);
		$data_scadenza_formatted=$data_scadenza_pieces[2]."-".$data_scadenza_pieces[0]."-".$data_scadenza_pieces[1];

		$fotocopia = ($params["fotocopia_".$doc] == "on" ? true : false);

		$sql4="insert into DOCUMENTI_ASSISTITO (`id`, `id_assistito`, `tipo_doc`,`numero_doc`,`data_rilascio_doc`,`data_scadenza_doc`,`fotocopia`) VALUES ('', ".$id_assistito.", '".$tipo_doc."','".$params["numero_".$doc]."','".$data_rilascio_formatted."','".$data_scadenza_formatted."','".$fotocopia."')";
		echo "<br>".$sql4;
		$res4=mysql_query($sql4);
	}
	*/
	modifica_documenti_assistito($params,$id_assistito);

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

	/*
	foreach ($params as $key => $value) {
		if (substr($key, 0, -1)=="anno_nascita_" && $value!="") {
			$number=substr($key, -1);
			$parentela_key="parentela_".$number;
			$sql8="insert into familiari (`id`, `id_capofamiglia`, `anno_di_nascita`, `parentela`) VALUES ('', ".$id_assistito.", ".$value.", '".$params[$parentela_key]."')";
			echo $sql8;
			$res8=mysql_query($sql8);
		}
	}
	*/
	modifica_familiari_assistito($params,$id_assistito);

	$sql="insert into richieste (`id`, `id_assistito`, `richiesta_alloggio`,`richiesta_primari`,`richiesta_lavoro`,`richiesta_beni_servizi`,`richiesta_contatti_servizi`,`richiesta_burocratica`,`richiesta_sanitaria`) VALUES ('', ".$id_assistito.", '".$params["richiesta_alloggio"]."','".$params["richiesta_primari"]."','".$params["richiesta_lavoro"]."','".$params["richiesta_beni_servizi"]."','".$params["richiesta_contatti_servizi"]."','".$params["richiesta_burocratica"]."','".$params["richiesta_sanitaria"]."')";
	$res9=mysql_query($sql);

    return $id_assistito;
}


function modifica_assistito($params) {

	//echo("modifica_assistito - params=".print_r($params,true));

    modifica_dati_anagrafici_assistito($params);
	modifica_familiari_assistito($params,NULL);
	modifica_documenti_assistito($params,NULL);
	modifica_chi_lo_invia_assistito($params);
	modifica_lingue_assistito($params);
	modifica_vulnerabilita_assistito($params);
	modifica_risposte_indirette_assistito($params);
	modifica_richieste_assistito($params);
}



function modifica_dati_anagrafici_assistito($params) {

	global $db,$config;

	$data_nascita = $params['data_di_nascita'];
	if ($data_nascita!="") {
		$data_nascita_formatted = convertDateFromItTo2Db($data_nascita);
		$data_nascita_sql="'".$data_nascita_formatted."'";
	}
	else {
		$data_nascita_sql="NULL";
	}

	$data_primo_ascolto = $params['data_primo_ascolto'];
	if ($data_primo_ascolto!="") {
	  $data_primo_ascolto_formatted = convertDateFromItTo2Db($data_primo_ascolto);
	  $data_primo_ascolto_sql="'".$data_primo_ascolto_formatted."'";
	}
	else {
	  $data_primo_ascolto_sql="NULL";
	}


	//echo("data_nascita_sql=".$data_nascita_sql);
  $sql='update assistiti set `data_modifica`=now(), `nome`="'.$params["nome"].'", `cognome`="'.$params["cognome"].'", `data_di_nascita`='.$data_nascita_sql.', `luogo_di_nascita`="'.$params["luogo_di_nascita"].'", `sesso`="'.$params["sesso"].'", `id_nazionalita`="'.$params["nazionalita"].'", `cellulare`="'.$params["cellulare"].'", `stato_civile`="'.$params["stato_civile"].'", `citta_residenza`="'.$params["citta_residenza"].'", `via_residenza`="'.$params["via_residenza"].'", `numero_residenza`="'.$params["numero_residenza"].'", `nazione_residenza`="'.$params["nazione_residenza"].'", `alloggio`="'.$params["alloggio"].'", `lingua_madre`="'.$params["lingua_madre"].'", `ha_lavorato`='.$params["ha_lavorato"].', `lavora`='.$params["lavora"].', `dove_lavora`="'.$params["dove_lavora"].'", `data_primo_ascolto`='.$data_primo_ascolto_sql.', `note`="'.$params["note"].'" where id='.$params["id_assistito"];
  echo $sql;
	$res=mysql_query($sql);
}

function modifica_familiari_assistito($params,$id_assistito) {

	global $db,$config;
  echo "familiari:"."\r\n";

	//quando chiamiamo questa funzione in caso di inserimento assistito id_assistito non è fra i parametri http, in caso di modifica assistito si.
	if ($id_assistito==NULL) {
		$id_assistito = $params["id_assistito"];
	}

	$familiare_index = 0;
	foreach ($params as $key => $value) {

		if (substr($key, 0, 10)=="familiare_") {

			$number=substr($key, -1);
			$familiare_pk="familiare_".$familiare_index."_pk";
			$anno_nascita_key="anno_nascita_".$familiare_index;
			$parentela_key="parentela_".$familiare_index;
			$rimuovi_key="familiare_".$familiare_index."_rimuovi";
			//echo "familiare_pk=".$params[$familiare_pk]." anno_nascita=".$params[$anno_nascita_key]." parentela=".$params[$parentela_key]."\n";

			$anno_nascita = $params[$anno_nascita_key];
			if ($anno_nascita!="") {
				$anno_nascita_sql="'".$anno_nascita."'";
			}
			else {
				$anno_nascita_sql = "NULL";
			}

			if ($params[$familiare_pk]=="") {
				//insert
				if ( ($params[$anno_nascita_key]!="") OR ($params[$parentela_key]!="") ) {
					$sql="insert into familiari (`id`, `id_capofamiglia`, `anno_di_nascita`, `parentela`) VALUES ('', ".$id_assistito.", ".$anno_nascita_sql.", '".$params[$parentela_key]."')";
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
					$sql='update familiari set `id_capofamiglia`="'.$params["id_assistito"].'", `anno_di_nascita`='.$anno_nascita_sql.', `parentela`="'.$params[$parentela_key].'" where id='.$params[$familiare_pk];
					//$sql="update familiari (`id`, `id_capofamiglia`, `anno_di_nascita`, `parentela`) VALUES ('', ".$id_assistito.", ".$params[$anno_nascita_key].", '".$params[$parentela_key].'" where id='.$params["id_assistito"];
					//echo $sql;
					mysql_query($sql);
				}
			}
			$familiare_index++;
	 }

 }

}


function modifica_documenti_assistito($params, $id_assistito) {

	global $db,$config;
  echo "documenti:"."\r\n";
	$documento_index = 0;

	//quando chiamiamo questa funzione in caso di inserimento assistito id_assistito non è fra i parametri http, in caso di modifica assistito si.
	if ($id_assistito==NULL) {
		$id_assistito = $params["id_assistito"];
	}
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

			$data_rilascio = $params[$rilascio_key];
			if ($data_rilascio!="") {
				$data_rilascio_formatted = convertDateFromItTo2Db($data_rilascio);
				$data_rilascio_sql="'".$data_rilascio_formatted."'";
			}
			else {
				$data_rilascio_sql="NULL";
			}

			$data_scadenza = $params[$scadenza_key];
			if ($data_scadenza!="") {
				$data_scadenza_formatted = convertDateFromItTo2Db($data_scadenza);
				$data_scadenza_sql="'".$data_scadenza_formatted."'";
			}
			else {
				$data_scadenza_sql="NULL";
			}

			if ($params[$documento_pk]=="") {
				//insert
				if ( ($params[$tipodoc_key]!="") OR ($params[$numero_key]!="") OR ($params[$rilascio_key]!="") OR ($params[$scadenza_key]!="") OR ($params[$fotocopia_key]!="") ) {
					$sql="insert into DOCUMENTI_ASSISTITO (`id`, `id_assistito`, `tipo_doc`,`numero_doc`,`data_rilascio_doc`,`data_scadenza_doc`,`fotocopia`) VALUES ('', ".$id_assistito.", '".$params[$tipodoc_key]."', '".$params[$numero_key]."', ".$data_rilascio_sql.", ".$data_scadenza_sql.", '".$params[$fotocopia_key]."')";
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
					$sql='update DOCUMENTI_ASSISTITO set `tipo_doc`="'.$params[$tipodoc_key].'", `numero_doc`="'.$params[$numero_key].'", `data_rilascio_doc`='.$data_rilascio_sql.', `data_scadenza_doc`='.$data_scadenza_sql.', `fotocopia`="'.$params[$fotocopia_key].'" where id='.$params[$documento_pk];
					echo $sql;
					mysql_query($sql);
				}
			}
			$documento_index++;
	 }

 }

}


function modifica_chi_lo_invia_assistito($params) {
	global $db,$config;

	$sql="SELECT * FROM inviato where id_assistito=".$params['id_assistito'];
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$inviati[]=$r;
	}
	$chi_lo_invia_assistito_array = get_chi_lo_invia_assistito($params['id_assistito']);
	foreach ($params['chi_lo_invia'] as $chi) {
		if (!in_array($chi, $chi_lo_invia_assistito_array)) {
			$sql2="insert into inviato (`id`, `id_assistito`, `chi`) VALUES ('', ".$params['id_assistito'].", '".$chi."')";
			$res=mysql_query($sql2);
		}
	}
	foreach ($inviati as $inviato) {
		if (!in_array($inviato['chi'], $params['chi_lo_invia'])) {
			$sql3="delete from inviato where id=".$inviato['id'];
			$res=mysql_query($sql3);
		}
	}
}

function modifica_lingue_assistito($params) {
	global $db,$config;

	$sql="SELECT * FROM lingue where id_assistito=".$params['id_assistito'];
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$lingue[]=$r;
	}
	$lingue_assistito_array = get_lingue_assistito($params['id_assistito']);
	foreach ($params['lingue'] as $lingua) {
		if (!in_array($lingua, $lingue_assistito_array)) {
			$sql2="insert into lingue (`id`, `id_assistito`, `lingua`) VALUES ('', ".$params['id_assistito'].", '".$lingua."')";
			$res=mysql_query($sql2);
		}
	}
	foreach ($lingue as $lingua) {
		if (!in_array($lingua['lingua'], $params['lingue'])) {
			$sql3="delete from lingue where id=".$lingua['id'];
			$res=mysql_query($sql3);
		}
	}
}

function modifica_vulnerabilita_assistito($params) {
	global $db,$config;

	$sql="SELECT * FROM vulnerabilita where id_assistito=".$params['id_assistito'];
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$vulnerabilitas[]=$r;
	}
	$vulnerabilita_assistito_array = get_vulnerabilita_assistito($params['id_assistito']);
	foreach ($params['vulnerabilita'] as $vulnerabilita) {
		if (!in_array($vulnerabilita, $vulnerabilita_assistito_array)) {
			$sql2="insert into vulnerabilita (`id`, `id_assistito`, `vulnerabilita`) VALUES ('', ".$params['id_assistito'].", '".$vulnerabilita."')";
			$res=mysql_query($sql2);
		}
	}
	foreach ($vulnerabilitas as $vuln) {
		if (!in_array($vuln['vulnerabilita'], $params['vulnerabilita'])) {
			$sql3="delete from vulnerabilita where id=".$vuln['id'];
			$res=mysql_query($sql3);
		}
	}
}

function modifica_risposte_indirette_assistito($params) {
	global $db,$config;

	$sql="SELECT * FROM risposte_indirette where id_assistito=".$params['id_assistito'];
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$risposte_indirette[]=$r;
	}
	$risposte_indirette_assistito_array = get_risposte_indirette_assistito($params['id_assistito']);
	foreach ($params['risposte_indirette'] as $risposta) {
		if (!in_array($risposta, $risposte_indirette_assistito_array)) {
			$sql2="insert into risposte_indirette (`id`, `id_assistito`, `risposta`) VALUES ('', ".$params['id_assistito'].", '".$risposta."')";
			$res=mysql_query($sql2);
		}
	}
	foreach ($risposte_indirette as $risposta) {
		if (!in_array($risposta['risposta'], $params['risposte_indirette'])) {
			$sql3="delete from risposte_indirette where id=".$risposta['id'];
			$res=mysql_query($sql3);
		}
	}
}


function modifica_richieste_assistito($params) {
	global $db,$config;

	$richieste = get_richieste($params['id_assistito']);
	//echo "RICHIESTE   ";
	//print_r($richieste);
	if (sizeof($richieste)==0) {
		$sql="insert into richieste (`id`, `id_assistito`, `richiesta_alloggio`,`richiesta_primari`,`richiesta_lavoro`,`richiesta_beni_servizi`,`richiesta_contatti_servizi`,`richiesta_burocratica`,`richiesta_sanitaria`) VALUES ('', ".$params["id_assistito"].", '".$params["richiesta_alloggio"]."','".$params["richiesta_primari"]."','".$params["richiesta_lavoro"]."','".$params["richiesta_beni_servizi"]."','".$params["richiesta_contatti_servizi"]."','".$params["richiesta_burocratica"]."','".$params["richiesta_sanitaria"]."')";
		$res=mysql_query($sql);
	} else {
		$sql2="update richieste set richiesta_alloggio='".$params["richiesta_alloggio"]."', richiesta_primari='".$params["richiesta_primari"]."', richiesta_lavoro='".$params["richiesta_lavoro"]."', richiesta_beni_servizi='".$params["richiesta_beni_servizi"]."', richiesta_contatti_servizi='".$params["richiesta_contatti_servizi"]."', richiesta_burocratica='".$params["richiesta_burocratica"]."', richiesta_sanitaria='".$params["richiesta_sanitaria"]."' where id_assistito=".$params["id_assistito"];
		//echo $sql2;
		$res=mysql_query($sql2);
	}
}


function get_servizi() {
	global $db,$config;
	$result = array();

	$sql="SELECT cat_servizi.nome AS tipo, servizi_erogati.data, servizi_erogati.id as id_servizio_erogato, assistiti.nome AS nome, assistiti.cognome, assistiti.id as id_assistito
					FROM cat_servizi
					JOIN servizi_erogati ON cat_servizi.id = servizi_erogati.id_servizio
					JOIN assistiti ON servizi_erogati.id_assistito = assistiti.id where servizi_erogati.valid=1 and assistiti.valid=1 order by data desc, tipo";
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

	$sql="SELECT a.*, n.nome as nome_nazionalita FROM assistiti a LEFT OUTER JOIN elenco_nazioni n ON n.id = a.id_nazionalita where a.id=".$id." and a.valid=1";
	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result=$r;
	}

	$result["data_primo_ascolto"] = convertDateFromDbTo2It($result["data_primo_ascolto"]);
	$result["data_di_nascita"] = convertDateFromDbTo2It($result["data_di_nascita"]);

	return $result;
}


function get_documenti_assistito($id_assistito) {
	global $db,$config;
	$result = array();

	$sql="SELECT * FROM DOCUMENTI_ASSISTITO where id_assistito=".$id_assistito;

	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
		  $r[DATA_RILASCIO_DOC] = convertDateFromDbTo2It($r[DATA_RILASCIO_DOC]);
			$r[DATA_SCADENZA_DOC] = convertDateFromDbTo2It($r[DATA_SCADENZA_DOC]);
			$result[]=$r;
	}
	return $result;
}


function get_lingue_assistito($id_assistito) {
		global $db,$config;
		$result = array();

		$sql="SELECT lingua FROM lingue where id_assistito=".$id_assistito;
		$res=mysql_query($sql);
		while($r=mysql_fetch_assoc($res)) {
				$result[]=$r['lingua'];
		}

	return $result;
}


function get_vulnerabilita_assistito($id_assistito) {
		global $db,$config;
		$result = array();

		$sql="SELECT vulnerabilita FROM vulnerabilita where id_assistito=".$id_assistito;
		$res=mysql_query($sql);
		while($r=mysql_fetch_assoc($res)) {
				$result[]=$r['vulnerabilita'];
		}

	return $result;
}


function get_risposte_indirette_assistito($id_assistito) {
		global $db,$config;
		$result = array();

		$sql="SELECT risposta FROM risposte_indirette where id_assistito=".$id_assistito;
		$res=mysql_query($sql);
		while($r=mysql_fetch_assoc($res)) {
				$result[]=$r['risposta'];
		}

	return $result;
}


function get_chi_lo_invia_assistito($id_assistito) {
	global $db,$config;
	$result = array();

	$sql="SELECT chi FROM inviato where id_assistito=".$id_assistito;
	$res=mysql_query($sql);
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r['chi'];
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
	$sql="INSERT INTO banco_alimentare VALUES ('', ".$id_assistito.", ".$anno.", ".$mese.",1)";

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

	$sql="SELECT * FROM scuole where valid=1 and anno=".$anno;
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
					$sql="insert into scuole (`id`, `anno`, `id_nazionalita`, `sesso`, `numero`, `valid`) VALUES ('', ".$params["anno"].", ".$params[$nazionalita_key].", '".$params[$sesso_key]."', ".$params[$numero_key].",1)";
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


function get_stat_banco_alimentare($anno, $assistiti) {
	global $db,$config;
	$result = array();

	$assistiti_string=implode(",", $assistiti);
	$sql="SELECT mese, count(*) as pacchi FROM banco_alimentare where banco_alimentare.valid=1 and anno=".$anno." group by mese";
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function get_stat_scuole($anno) {
	global $db,$config;
	$result = array();

	$sql="SELECT sesso, numero, elenco_nazioni.nome as nazione, continenti.nome as continente
		FROM scuole
			join elenco_nazioni on id_nazionalita=elenco_nazioni.id
			join continenti on elenco_nazioni.id_continente=continenti.id
		WHERE scuole.valid=1 and anno=".$anno." order by continente, nazione";
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
   $result=$r;
 }
 return $result;
}

//converte date da formato GG/MM/AAAA a formato AAAA-MM-GG
function convertDateFromItTo2Db($date) {
	$data_pieces=split("/", $date);
	if (count($data_pieces)==3) {
		$data_formatted=$data_pieces[2]."-".$data_pieces[1]."-".$data_pieces[0];
	  return $data_formatted;
	} else {
		return NULL;
	}


}

//converte date da formato AAAA-MM-GG a formato GG/MM/AAAA
function convertDateFromDbTo2It($date) {
	$data_pieces=split("-", $date);
	if (count($data_pieces)==3) {
		$data_formatted=$data_pieces[2]."/".$data_pieces[1]."/".$data_pieces[0];
		return $data_formatted;
	}
	else {
		return NULL;
	}
}


function get_assistiti_banco_list($anno) {
	global $db,$config;
	$result = array();

	$sql="SELECT distinct(id_assistito) from banco_alimentare where valid=1 and anno=".$anno;
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result=$r;
	}

	return $result;
}


function get_assistiti_list($anno, $primo_ascolto=false) {
	global $db,$config;
	$result = array();

	if ($primo_ascolto) {
		$sql="SELECT distinct(id_assistito) from servizi_erogati join assistiti on assistiti.id=servizi_erogati.id_assistito where servizi_erogati.valid=1 and YEAR(STR_TO_DATE(data, '%Y-%m-%d'))=".$anno." and YEAR(STR_TO_DATE(data, '%Y-%m-%d'))=".$anno;
	}  else {
		$sql="SELECT distinct(id_assistito) from servizi_erogati where valid=1 and YEAR(STR_TO_DATE(data, '%Y-%m-%d'))=".$anno;
	}
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result=$r;
	}

	return $result;
}


function get_fasce_banco_alimentare($anno, $assistiti) {
	global $db,$config;
	$result = array();

	$assistiti_string=implode(",", $assistiti);
	$sql="select SUM(IF(age < 5,1,0)) as '0 - 5',
    SUM(IF(age BETWEEN 5 and 18,1,0)) as '5 - 18',
    SUM(IF(age BETWEEN 18 and 60,1,0)) as '18 - 60',
    SUM(IF(age > 60,1,0)) as '> 60'
    from (select ".$anno."-substring(data_di_nascita, 1, 4) as age from assistiti
	where valid=1 and id in (".$assistiti_string.")
	union select ".$anno."-anno_di_nascita from familiari join assistiti on assistiti.id=familiari.id_capofamiglia
	where assistiti.valid=1 and assistiti.id in (".$assistiti_string.")) as eta_table";
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result=$r;
	}

	return $result;
}


function get_fasce_assistiti($anno, $assistiti) {
	global $db,$config;
	$result = array();

	$assistiti_string=implode(",", $assistiti);
	$sql="select SUM(IF(age < 18,1,0) and sesso='M') as 'M 0 - 18',
	SUM(IF(age < 18,1,0) and sesso='F') as 'F 0 - 18',
    SUM(IF(age BETWEEN 18 and 35,1,0) and sesso='M') as 'M 18 - 35',
	SUM(IF(age BETWEEN 18 and 35,1,0) and sesso='F') as 'F 18 - 35',
	SUM(IF(age BETWEEN 35 and 45,1,0) and sesso='M') as 'M 35 - 45',
	SUM(IF(age BETWEEN 35 and 45,1,0) and sesso='F') as 'F 35 - 45',
	SUM(IF(age BETWEEN 45 and 60,1,0) and sesso='M') as 'M 45 - 60',
	SUM(IF(age BETWEEN 45 and 60,1,0) and sesso='F') as 'F 45 - 60',
    SUM(IF(age > 60,1,0) and sesso='M') as 'M > 60',
	SUM(IF(age > 60,1,0) and sesso='F') as 'F > 60'
    from (select sesso, ".$anno."-substring(data_di_nascita, 1, 4) as age from assistiti
	where assistiti.valid=1 and id in (".$assistiti_string.")) as eta_table";
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result=$r;
	}

	return $result;
}


function get_stat_servizi($anno) {
	global $db,$config;
	$result = array();

	$sql="SELECT nome, count(*) as num_erogazioni FROM servizi_erogati
			join cat_servizi on servizi_erogati.id_servizio=cat_servizi.id
		WHERE servizi_erogati.valid=1 and YEAR(STR_TO_DATE(data, '%Y-%m-%d'))=".$anno." group by nome";
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function get_stat_assistiti_nazionalita($anno, $assistiti) {
	global $db,$config;
	$result = array();

	$assistiti_string=implode(",", $assistiti);
	$sql="SELECT nazionalita, count(*) as num_assistiti FROM assistiti WHERE assistiti.valid=1 and id in (".$assistiti_string.") group by nazionalita";
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


function get_stat_assistiti_nuclei($anno, $assistiti) {
	global $db,$config;
	$result = array();

	$assistiti_string=implode(",", $assistiti);
	$sql="SELECT count(*) as occorrenze, componenti from (SELECT id_capofamiglia, count(*) as componenti FROM familiari join assistiti on assistiti.id=familiari.id_capofamiglia where assistiti.valid=1 and id_capofamiglia in (".$assistiti_string.") group by id_capofamiglia) as dettaglio_nuclei group by componenti";
	$res=mysql_query($sql) or die(mysql_error());
	while($r=mysql_fetch_assoc($res)) {
			$result[]=$r;
	}

	return $result;
}


?>
