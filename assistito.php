<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";
?>


<?php

if ($_POST['action'] == 'register_update') {
  $page_mode='REGISTRA_MODIFICA';
} else if ($_POST['action'] == 'register_insert') {
  $page_mode='REGISTRA_INSERISCI';
} else if (isset($_GET['id_assistito'])) {
  $page_mode='VISUALIZZA_MODIFICA';
} else {
  $page_mode='VISUALIZZA_INSERISCI';
}


if ($page_mode=='VISUALIZZA_MODIFICA') {

  $id_assistito=$_GET['id_assistito'];
	$chi_lo_invia_assistito_array = get_chi_lo_invia_assistito($id_assistito);


  $page_title='Modifica';
  $send_button_title='Modifica';
  $form_action='register_update';

  //caricamento dati anagrafici
  $assistito = get_assistito($id_assistito);
//  print_r($assistito);
  $sesso_F = 0;
  $sesso_M = 0;
  if ("F"==$assistito["sesso"]) {
    $sesso_F = 1;
    $sesso_M = 0;
  } else if ("M"==$assistito["sesso"]) {
    $sesso_F = 0;
    $sesso_M = 1;
  }
  $stato_civile_is_CELIBE=0;        //value=1
  $stato_civile_is_NUBILE=0;        //value=2
  $stato_civile_is_CONVIVENTE=0;    //value=3
  $stato_civile_is_CONIUGATO=0;     //value=4
  $stato_civile_is_VEDOVO=0;        //value=5
  $stato_civile_is_SEPARATO=0;      //value=6
  $stato_civile_is_DIVORZIATO=0;    //value=7
  if ("1"==$assistito["stato_civile"]) {
    $stato_civile_is_CELIBE=1;
  } else if ("1"==$assistito["stato_civile"]) {
    $stato_civile_is_NUBILE=1;
  } else if ("2"==$assistito["stato_civile"]) {
    $stato_civile_is_CONVIVENTE=1;
  } else if ("3"==$assistito["stato_civile"]) {
    $stato_civile_is_CONIUGATO=1;
  } else if ("4"==$assistito["stato_civile"]) {
    $stato_civile_is_CELIBE=1;
  } else if ("5"==$assistito["stato_civile"]) {
    $stato_civile_is_VEDOVO=1;
  } else if ("6"==$assistito["stato_civile"]) {
    $stato_civile_is_SEPARATO=1;
  } else if ("7"==$assistito["stato_civile"]) {
    $stato_civile_is_DIVORZIATO=1;
  }

  //caricamento documenti
  $documenti_assistito_array = get_documenti_assistito($id_assistito);
//  print_r("numero documenti caricati: ".count($documenti_assistito_array));
//  print_r($documenti_assistito_array);
  foreach ($documenti_assistito_array as $loaded_doc) {
//    echo "documento caricato:";print_r($loaded_doc);echo "\n";

    $variable_name = "enabled_".$loaded_doc["TIPO_DOC"];
    $$variable_name = "1";

    $variable_name = "numero_".$loaded_doc["TIPO_DOC"];
    $$variable_name = $loaded_doc["NUMERO_DOC"];

    $variable_name = "rilascio_".$loaded_doc["TIPO_DOC"];
    $$variable_name = $loaded_doc["DATA_RILASCIO_DOC"];

    $variable_name = "scadenza_".$loaded_doc["TIPO_DOC"];
    $$variable_name = $loaded_doc["DATA_SCADENZA_DOC"];

    $variable_name = "fotocopia_".$loaded_doc["TIPO_DOC"];
    $$variable_name = $loaded_doc["FOTOCOPIA"];
  }
/*  
  echo "enabled_identita: ".$enabled_identita;
  echo "numero_identita: ".$numero_identita;
  echo "rilascio_identita: ".$rilascio_identita;
  echo "scadenza_identita: ".$scadenza_identita;
  echo "fotocopia_identita: ".$fotocopia_identita;
*/
  $var_name = "enabled_".$loaded_doc["TIPO_DOC"];
//  echo "var_name=".$var_name;
//  if (${$var_name}==1) echo "si identita"; else "no identita";



} else if ($page_mode=='VISUALIZZA_INSERISCI') {
  $page_title='Inserisci';
  $send_button_title='Inserisci';
  $form_action='register_insert';
}
?>

<!-- page content -->
            <div class="right_col" role="main">
				<div class="page-title">
					<div class="title_left">
						<h3>Assistito <?php echo $assistito["cognome"]." ".$assistito["nome"]; ?></h3>
					</div>
					<div class="title_right">
						<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
							<div class="input-group">

							</div>
						</div>
					</div>
				</div>

<?php
if ($page_mode=='VISUALIZZA_INSERISCI' or $page_mode=='VISUALIZZA_MODIFICA') {
    if ($page_mode=='VISUALIZZA_MODIFICA') {
?>
				<div class="x_content" style="height:46px;">	
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class=""><a href="visualizza_assistito.php?id_assistito=<?php echo $id_assistito; ?>" id="home-tab" aria-expanded="true">Visualizza</a>
							</li>
							<li role="presentation" class="active"><a href="assistito.php?id_assistito=<?php echo $id_assistito; ?>" id="profile-tab" aria-expanded="false">Modifica</a>
							</li>
							<li role="presentation" class=""><a href="servizio.php?id_assistito=<?php echo $id_assistito; ?>" id="profile-tab2" aria-expanded="false">Inserisci servizio</a>
							</li>
						</ul>
					<!--	
						<div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
								<p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terr.</p>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
								<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip</p>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
								<p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk </p>
							</div>
						</div>
					-->	
					</div>
				</div>	
<?php
    }
?>					
				<div class="row">	
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2><?php echo $page_title;?><small>(i campi contrassegnati con * sono obbligatori)</small></h2>
                <!--
								<ul class="nav navbar-right panel_toolbox">
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
									</li>
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#">Settings 1</a>
											</li>
											<li><a href="#">Settings 2</a>
											</li>
										</ul>
									</li>
									<li><a class="close-link"><i class="fa fa-close"></i></a>
									</li>
								</ul>
              -->
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<br />
<!--
								<form class="form-horizontal form-label-left">

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nome <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" id="nome" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cognome <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" id="cognome" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Sesso</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div id="gender" class="btn-group" data-toggle="buttons">
												<label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
													<input type="radio" name="sesso" value="maschio"> &nbsp; Maschio &nbsp;
												</label>
												<label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
													<input type="radio" name="sesso" value="femmina" checked=""> Femmina
												</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email * :</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="email" id="email" class="form-control col-md-7 col-xs-12" name="email" data-parsley-trigger="change" required />
										</div>
									</div>
									<div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender *:</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												M:
												<input type="radio" class="flat" name="gender" id="genderM" value="M" checked="" required /> F:
												<input type="radio" class="flat" name="gender" id="genderF" value="F" />
											</p>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Data di nascita <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="data_di_nascita" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Select Custom</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<select name="stato_civile" class="select2_single form-control" tabindex="-1">
												<option value="1">Celibe</option>
												<option value="2">Nubile</option>
												<option value="3">Convivente</option>
												<option value="4">Coniugato/a</option>
												<option value="5">Vedevo/a</option>
												<option value="6">Separato/a</option>
												<option value="7">Divorziato</option>
											</select>
										</div>
									</div>
									<div class="ln_solid"></div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
											<button type="submit" class="btn btn-primary">Cancella</button>
											<button type="submit" class="btn btn-success">Inserisci</button>
										</div>
									</div>
								</form>
-->
								<form action="assistito.php" method="post" class="form-horizontal form-label-left" novalidate>
									<input type="hidden" name="action" value="<?php echo $form_action;?>" />
                  <input type="hidden" name="id_assistito" value="<?php echo $id_assistito;?>" />
									<span class="section">Dati personali</span>

									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nome">Nome <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="nome" class="form-control col-md-7 col-xs-12" name="nome" required="required" type="text" value="<?php echo $assistito["nome"];?>">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="cognome">Cognome <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="cognome" class="form-control col-md-7 col-xs-12" name="cognome" required="required" type="text" value="<?php echo $assistito["cognome"];?>">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="data_di_nascita">Data di nascita </label>
										<div class="controls">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="data_di_nascita" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4" value="<?php echo $assistito["data_di_nascita"];?>">
												<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status4" class="sr-only">(success)</span>
											</div>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="luogo_di_nascita">Luogo di nascita </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="luogo_di_nascita" class="form-control col-md-7 col-xs-12" name="luogo_di_nascita" type="text"  value="<?php echo $assistito["luogo_di_nascita"];?>">
										</div>
									</div>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sesso </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												M:
												<input type="radio" class="flat" name="sesso" id="sessoM" value="M" <?php if ($sesso_M==1) echo("checked");?> /> F:
												<input type="radio" class="flat" name="sesso" id="sessoF" value="F" <?php if ($sesso_F==1) echo("checked");?>/>
											</p>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nazionalita">Nazionalità </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="nazionalita" class="form-control col-md-7 col-xs-12" name="nazionalita" type="text" value="<?php echo $assistito["nazionalita"];?>">
										</div>
									</div>
<!--
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email  </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12">
										</div>
									</div>
-->
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Cellulare </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="phone" id="cellulare" name="cellulare" class="form-control col-md-7 col-xs-12" value="<?php echo $assistito["cellulare"];?>">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Stato civile </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select name="stato_civile" class="select2_single form-control" tabindex="-1">
												<option>Seleziona uno stato</option>
												<option value="1" <?php if ($stato_civile_is_CELIBE==1) echo("selected");?>>Celibe</option>
												<option value="2" <?php if ($stato_civile_is_NUBILE==1) echo("selected");?>>Nubile</option>
												<option value="3" <?php if ($stato_civile_is_CONVIVENTE==1) echo("selected");?>>Convivente</option>
												<option value="4" <?php if ($stato_civile_is_CONIUGATO==1) echo("selected");?>>Coniugato/a</option>
												<option value="5" <?php if ($stato_civile_is_VEDOVO==1) echo("selected");?>>Vedevo/a</option>
												<option value="6" <?php if ($stato_civile_is_SEPARATO==1) echo("selected");?>>Separato/a</option>
												<option value="7" <?php if ($stato_civile_is_DIVORZIATO==1) echo("selected");?>>Divorziato</option>
											</select>
										</div>
									</div>
									
<?php
//	foreach ($i=0; i<=20; $i++; as $key=>$value) {
?>									
									<div id="familiari">
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Familiare 1 </label>
										<div class="col-md-3 col-sm-3 col-xs-6">
											<input id="parentela_1" name="parentela_1" class="form-control col-md-7 col-xs-12" placeholder="Grado di parentela" value="<?php echo $assistito["cellulare"];?>">
										</div>
										<div class="col-md-3 col-sm-3 col-xs-6">
											<input id="anno_nascita_1" name="anno_nascita_1" class="form-control col-md-7 col-xs-12" placeholder="Anno di nascita" value="<?php echo $assistito["cellulare"];?>">
										</div>
										<div>
											<button class="btn btn-primary button_familiare" type="button" id="button_familiare_1">Aggiungi familiare</button>
										</div>
									</div>
									</div>

									<span class="section">Residenza</span>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="citta_residenza">Città </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="citta_residenza" class="form-control col-md-7 col-xs-12" name="citta_residenza" type="text" value="<?php echo $assistito["residenza"];?>">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="via_residenza">Via </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="via_residenza" class="form-control col-md-7 col-xs-12" name="via_residenza" type="text" value="<?php echo $assistito["via_residenza"];?>">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="numero_residenza">Numero civico </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="numero_residenza" class="form-control col-md-7 col-xs-12" name="numero_residenza" type="text" value="<?php echo $assistito["numero_residenza"];?>">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nazione_residenza">Nazione </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="nazione_residenza" class="form-control col-md-7 col-xs-12" name="nazione_residenza" type="text"  value="<?php echo $assistito["nazione_residenza"];?>">
										</div>
									</div>

									<span class="section">Documenti</span>
<?php
$docs=array("identita"=>"Carta d'identità",
			"passaporto"=>"Passaporto",
			"patente"=>"Patente",
			"smarrimento"=>"Denuncia di smarrimento",
			"pds"=>"PDS (permesso di soggiorno)",
			"stp"=>"STP (rifugiato politico)",
			"sanitaria"=>"Tessera sanitaria",
			"turistico"=>"Permesso turistico",
			"identita_straniera"=>"Carta d'identità straniera",
			"nessuno"=>"Nessun documento"
			);
foreach ($docs as $key=>$value) {

  $enabled_var_name = "enabled_".$key;
  //echo "var_name=".$var_name;
  //if (${$enabled_var_name}==1) echo "si identita"; else "no identita";


?>

                  <!-- documenti categorizzati -->
									<div class="item form-group" style="min-height:34px;">
										<div class="col-md-3 col-sm-3 col-xs-12" style="float:left;">
											<div class="checkbox">
												<span id="<?php echo $key;?>">
														<input type="checkbox" class="flat" name="documenti[]" value="<?php echo $key;?>" <?php if (${$enabled_var_name}==1) echo("checked");?>>
														<label style="cursor:default;"><?php echo $value;?></label>
												</span>
											</div>
										</div>
										<div id="info_<?php echo $key;?>" class="col-md-9 col-sm-9 col-xs-12" style="display:none;">
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input id="numero_<?php echo $key;?>" placeholder="numero" name="numero_<?php echo $key;?>" class="form-control" type="text">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input type="text" placeholder="data di rilascio" name="rilascio_<?php echo $key;?>" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4">
												<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status4" class="sr-only">(success)</span>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input type="text" placeholder="data di scadenza" name="scadenza_<?php echo $key;?>" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4">
												<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status4" class="sr-only">(success)</span>
											</div>
											<div class="checkbox col-md-2 col-sm-2 col-xs-12">
												<label>
													<input type="checkbox" class="flat" name="fotocopia_<?php echo $key;?>"> Fotocopia
												</label>
											</div>
										</div>
									</div>

<?php
}
?>
                  <!-- altro -->
									<div class="item form-group" style="min-height:34px;">
										<div class="col-md-3 col-sm-3 col-xs-12">
											<div class="checkbox" >
												<span id="altro">
													<div style="float:left; width:24px;">
													<input type="checkbox" class="flat" name="documenti[]" value="altro" >
													</div>
													<label id="label_altro">Altro</label>
													<div id="div_descrizione_altro" style="display:none; margin-left:35px; margin-top:-7px;">
														<input type="text" placeholder="tipo documento" name="descrizione_altro" class="form-control checkbox" id="descrizione_altro">
													</div>
												</span>

											</div>


										</div>

										<div id="info_altro" class="col-md-9 col-sm-9 col-xs-12" style="display:none;">
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input id="numero_altro" placeholder="numero" name="numero_altro" class="form-control" type="text">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input type="text" placeholder="data di rilascio" name="rilascio_altro" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4">
												<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status4" class="sr-only">(success)</span>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input type="text" placeholder="data di scadenza" name="scadenza_altro" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4">
												<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status4" class="sr-only">(success)</span>
											</div>
											<div class="checkbox col-md-2 col-sm-2 col-xs-12">
												<label>
													<input type="checkbox" class="flat" name="fotocopia_altro"> Fotocopia
												</label>
											</div>
										</div>
									</div>

<!--
									<div class="item form-group" style="min-height:34px;">
										<div class="col-md-3 col-sm-3 col-xs-12" style="float:left;">
											<div class="checkbox">
												<span id="identita">
													<label>
														<input type="checkbox" class="flat" name="documenti[]" value="identita"> Carta di identità
													</label>
												</span>
											</div>
										</div>
										<div id="info_identita" class="col-md-9 col-sm-9 col-xs-12" style="display:none;">
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input type="text" name="rilascio_identita" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4">
												<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status4" class="sr-only">(success)</span>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input type="text" name="scadenza_identita" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4">
												<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status4" class="sr-only">(success)</span>
											</div>
											<div class="checkbox">
												<label>
													<input type="checkbox" class="flat" name="fotocopia_identita" value="conoscenti"> Fotocopia
												</label>
											</div>
										</div>
									</div>
-->

									<span class="section">Chi lo invia</span>
									<div class="item form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Conoscenti"> Conoscenti/connazionali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Spontaneo"> Spontaneo
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="ASL"> Asl/ospedali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Attori di stazioni"> Attori di stazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Caritas"> Caritas
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Ufficio immigrazioni"> Ufficio immigrazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Enti"> Enti/associazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Servizi sociali"> Servizi sociali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Sert"> SERT
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Privati"> Privati cittadini
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Polfer"> Polfer
											</label>
										</div>
									</div>

									<span class="section">Alloggio</span>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dimora stabile </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												<input type="radio" class="flat" name="alloggio" id="dimora_stabile" value="Dimora stabile" checked="" />
											</p>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Centro accoglienza </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												<input type="radio" class="flat" name="alloggio" id="centro_accoglienza" value="Centro accoglienza" checked="" />
											</p>
										</div>
									</div>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Casa occupata </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												<input type="radio" class="flat" name="alloggio" id="casa_occupata" value="Casa occupata" checked="" />
											</p>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Stazione </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												<input type="radio" class="flat" name="alloggio" id="stazione" value="Stazione" checked="" />
											</p>
										</div>
									</div>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Strada</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												<input type="radio" class="flat" name="alloggio" id="strada" value="Strada" checked="" />
											</p>
										</div>
									</div>

									<span class="section">Lingue conosciute</span>
									<div class="item form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Inglese"> Inglese
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Francese"> Francese
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Spagnolo"> Spagnolo
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Tedesco"> Tedesco
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Russo"> Russo
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Arabo"> Arabo
											</label>
										</div>
										<div class="item form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lingua_madre">Lingua madre </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input id="lingua_madre" class="form-control col-md-7 col-xs-12" name="lingua_madre" type="text">
											</div>
										</div>
									</div>

									<span class="section">Vulnerabilità</span>
									<div class="item form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Disabilità fisica"> Disabilità fisica
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Disabilità psicologica"> Disabilità psicologica
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Disagio abitativo"> Disagio abitativo
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Fragilità lavorativa"> Fragilità lavorativa
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Dipendenza droghe"> Dipendenza droghe
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Dipendenza alcool"> Dipendenza alcool
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Ex detenuto"> Ex detenuto
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Rifugiato politico"> Rifugiato politico
											</label>
										</div>
									</div>

									<span class="section">Risposte indirette</span>
									<div class="item form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Caritas"> Caritas
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Politiche sociali"> Politiche sociali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="SERT"> SERT
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="DSM"> DSM
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Privati"> Privati
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Associazioni"> Associazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Parrocchie"> Parrocchie
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Antoniano"> Antoniano
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Padre Marella"> Padre Marella
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Suore M. Teresa di Calcutta"> Suore M. Teresa di Calcutta
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Giovanni XXIII"> Giovanni XXIII
											</label>
										</div>
									</div>

									<span class="section">Situazione lavorativa</span>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ha lavorato </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												Si <input type="radio" class="flat" name="ha_lavorato" id="ha_lavorato_si" value="Si" checked="" />
												No <input type="radio" class="flat" name="ha_lavorato" id="ha_lavorato_no" value="No" />
											</p>
										</div>
									</div>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lavora </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												Si <input type="radio" class="flat" name="lavora" id="lavora_si" value="Si" checked="" />
												No <input type="radio" class="flat" name="lavora" id="lavora_no" value="No" />
												<div class="item form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="dove_lavora">Dove lavora </label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<input id="dove_lavora" class="form-control col-md-7 col-xs-12" name="dove_lavora" type="text">
													</div>
												</div>
											</p>
										</div>
									</div>

									<div class="ln_solid"></div>
									<div class="form-group">
										<div class="col-md-6 col-md-offset-3">
											<button type="submit" class="btn btn-primary">Annulla</button>
											<button id="send" type="submit" class="btn btn-success"><?php echo $send_button_title;?></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

</div>

<!--
<form action="assistito.php" method="post">
	<div class="mandatory">I campi contrassegnati con * sono obbligatori</div><br />
	<input type="hidden" name="action" value="register" />

    <label for="user">Nome<i>*</i></label>
    <input type="text" name="nome" id="nome" class="input" value="" autocomplete="off" /><br />

	<label for="user">Cognome<i>*</i></label>
    <input type="text" name="cognome" id="cognome" class="input" value="" autocomplete="off" /><br />

	<label for="phone">Cellulare<i>*</i></label>
	<input type="text" name="cellulare" id="cellulare" class="input" maxlength="10" value="" /><br />


<label for="stato_civile">Stato civile<i>*</i></label>
<div class="input">
	    <select name="stato_civile" id="stato_civile" class="stato_civile">
			<option value="">Selezionare</option>
		    				<option value="1">Celibe</option>
							<option value="2">Nubile</option>
							<option value="3">Convivente</option>
							<option value="4">Coniugato/a</option>
							<option value="5">Vedevo/a</option>
							<option value="6">Separato/a</option>
							<option value="7">Divorziato</option>
					</select>
    </div><br />
    </div>

<input type="submit" name="submit" value="Inserisci assistito" class="bluebutton rad3" />
</form>
-->
<?php
} else { //siamo in fase registrazione

  if ($page_mode=='REGISTRA_INSERISCI') {
    echo "chiamata a inserisci_assistito...";
  	$ins = inserisci_assistito($_POST);
  	echo "Assistito inserito correttamente";
  }
  else {
    echo "chiamata a modifica_assistito...";
    $ins = modifica_assistito($_POST);
  	echo "Assistito modificato correttamente";
  }
}
?>



<!--
<?php
$assistiti = get_assistiti();
print_r($assistiti);
?>
-->

<!-- page content -->
	   <!-- /datepicker -->
    <script type="text/javascript">
        
			$(document).on('click', '.button_familiare', function (event) {
//				alert(event.target.id);
				$('#'+event.target.id+'').hide();
				number=parseInt(event.target.id.slice(-1))+1;
//				alert(number);
				
				new_html='<div class="item form-group">' +
										'<label class="control-label col-md-3 col-sm-3 col-xs-12">Familiare '+number+' </label>' +
										'<div class="col-md-3 col-sm-3 col-xs-6">' +
											'<input id="parentela_'+number+'" name="parentela_'+number+'" class="form-control col-md-7 col-xs-12" placeholder="Grado di parentela" value="<?php echo $assistito["cellulare"];?>">' +
										'</div>' +
										'<div class="col-md-3 col-sm-3 col-xs-6">' +
											'<input id="anno_nascita_'+number+'" name="anno_nascita_'+number+'" class="form-control col-md-7 col-xs-12" placeholder="Anno di nascita" value="<?php echo $assistito["cellulare"];?>">' +
										'</div>' +
										'<div>' +
											'<button class="btn btn-primary button_familiare" type="button" id="button_familiare_'+number+'">Aggiungi familiare</button>' +
										'</div>' +
									'</div>';
				$('#familiari').append(new_html);
				
			});	
		
		$(document).ready(function () {	
            $('#single_cal1').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_1"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#single_cal2').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_2"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#single_cal3').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_3"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#single_cal4').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });




        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#reservation').daterangepicker(null, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });
    </script>
    <!-- /datepicker -->




    <!-- form validation -->
    <script src="js/validator/validator.js"></script>
    <script>
        // initialize the validator function
        validator.message['date'] = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select.required', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required')
            .on('keyup blur', 'input', function () {
                validator.checkField.apply($(this).siblings().last()[0]);
            });

        // bind the validation to the form submit event
        //$('#send').click('submit');//.prop('disabled', true);

        $('form').submit(function (e) {
            e.preventDefault();
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit)
                this.submit();
            return false;
        });

        /* FOR DEMO ONLY */
        $('#vfields').change(function () {
            $('form').toggleClass('mode2');
        }).prop('checked', false);

        $('#alerts').change(function () {
            validator.defaults.alerts = (this.checked) ? false : true;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);

    </script>

<?php
include "footer.php";
?>
