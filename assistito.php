<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";
?>


<?php

if (isset($_GET['id_assistito'])) {
  $page_mode='VISUALIZZA_MODIFICA';
} else {
  $page_mode='VISUALIZZA_INSERISCI';
}


if ($page_mode=='VISUALIZZA_MODIFICA') {

  $id_assistito=$_GET['id_assistito'];
  $chi_lo_invia_assistito_array = get_chi_lo_invia_assistito($id_assistito);
  $lingue_assistito_array = get_lingue_assistito($id_assistito);
  $vulnerabilita_assistito_array = get_vulnerabilita_assistito($id_assistito);
  $risposte_indirette_assistito_array = get_risposte_indirette_assistito($id_assistito);

  $page_title='Modifica';
  $send_button_title='Modifica';
  $form_action='register_update';

  //caricamento dati anagrafici
  $assistito = get_assistito($id_assistito);



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
  } else if ("2"==$assistito["stato_civile"]) {
    $stato_civile_is_NUBILE=1;
  } else if ("3"==$assistito["stato_civile"]) {
    $stato_civile_is_CONVIVENTE=1;
  } else if ("4"==$assistito["stato_civile"]) {
    $stato_civile_is_CONIUGATO=1;
  } else if ("5"==$assistito["stato_civile"]) {
    $stato_civile_is_VEDOVO=1;
  } else if ("6"==$assistito["stato_civile"]) {
    $stato_civile_is_SEPARATO=1;
  } else if ("7"==$assistito["stato_civile"]) {
    $stato_civile_is_DIVORZIATO=1;
  }

  //caricamento documenti
  $documenti_assistito_array = get_documenti_assistito($id_assistito);
  $familiari_assistito_array = get_familiari_assistito($id_assistito);

  //caricamento richieste
  $richieste = get_richieste($id_assistito);
  //print_r($richieste);

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
//if ($page_mode=='VISUALIZZA_INSERISCI' or $page_mode=='VISUALIZZA_MODIFICA') {

  $elenco_nazioni = get_elenco_nazioni();
  //echo "page_mode: ".$page_mode;
  //echo "id_assistito: ".$id_assistito;
  //print_r($assistito);
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
							<li role="presentation" class=""><a href="banco_alimentare.php?id_assistito=<?php echo $id_assistito; ?>" id="profile-tab2" aria-expanded="false">Banco alimentare</a>
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
								<form action="inserisci_modifica_assistito.php" method="post" class="form-horizontal form-label-left" novalidate>
									<input type="hidden" name="action" value="<?php echo $form_action;?>" />
                  <input type="hidden" name="id_assistito" value="<?php echo $id_assistito;?>" />

                  <span class="section">Primo ascolto</span>

									<div class="item form-group" style="text-align:left">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="data_primo_ascolto">Data primo ascolto</label>
										<div class="controls">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="data_primo_ascolto" class="form-control has-feedback-left" id="data_primo_ascolto_calendar" aria-describedby="inputSuccess2Status4" value="<?php echo $assistito["data_primo_ascolto"];?>">
												<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status4" class="sr-only">(success)</span>
											</div>
										</div>
									</div>

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
												<input type="text" name="data_di_nascita" class="form-control has-feedback-left" id="data_nascita_calendar" aria-describedby="inputSuccess2Status4" value="<?php echo $assistito["data_di_nascita"];?>">
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
                  <!--
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nazionalita">Nazionalità </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="nazionalita" class="form-control col-md-7 col-xs-12" name="nazionalita" type="text" value="<?php echo $assistito["nazionalita"];?>">
										</div>
									</div>-->
                  <div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Nazionalità </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select name="nazionalita" class="select2_single form-control" tabindex="-1">
												<option>Seleziona una nazionalità</option>
                        <?php
                          foreach ($elenco_nazioni as $key=>$nazione) {
                            if ($nazione[id]==$assistito["id_nazionalita"]) $is_selected_html = "selected";
                            else $is_selected_html = "";
                            echo '<option value="'.$nazione[id].'" '.$is_selected_html.' >'.$nazione[nome].'</option>';
                          }
                        ?>
                        <!--<option value="2" <?php if ($stato_civile_is_NUBILE==1) echo("selected");?>>Nubile</option>-->
											</select>
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
                    <?php
                    if (!is_null($familiari_assistito_array)) {
                      $keys  = array_keys($familiari_assistito_array);
                    }

                    for ($i = 0; $i < count($familiari_assistito_array)+1; ++$i) {
                      $index = $keys[$i];
                      $familiare = $familiari_assistito_array[$index];
                    ?>
                      <div class="item form-group" id="familiare_input_<?php echo $i;?>">
                        <input type="hidden" name="familiare_<?php echo $i;?>_pk" value="<?php echo $familiare["id"];?>" />
                        <!--<input type="hidden" id="familiare_toremove_<?php echo $i;?>" name="familiare_toremove_<?php echo $i;?>" value="0" />-->
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Familiare <?php echo ($i+1);?> </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <input id="parentela_<?php echo $i;?>" name="parentela_<?php echo $i;?>" class="form-control col-md-7 col-xs-12" placeholder="Grado di parentela" value="<?php echo $familiare["parentela"];?>">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <input id="anno_nascita_<?php echo $i;?>" name="anno_nascita_<?php echo $i;?>" class="form-control col-md-7 col-xs-12" placeholder="Anno di nascita" value="<?php echo $familiare["anno_di_nascita"];?>">
                        </div>
                        <?php
                        if ($i==count($familiari_assistito_array))
                        {
                        ?>
                          <div>
                            <button class="btn btn-primary button_remove_familiare" type="button" id="button_remove_familiare_<?php echo $i;?>" style="display:none;">X</button>
                          </div>
                          <div>
                            <button class="btn btn-primary button_familiare" type="button" id="button_familiare_<?php echo $i;?>">Aggiungi familiare</button>
                          </div>
                        <?php
                        }
                        else {
                        ?>
                          <div>
                            <button class="btn btn-primary button_remove_familiare" type="button" id="button_remove_familiare_<?php echo $i;?>">X</button>
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                    <?php
                    }
                    ?>


									</div>

									<br />
									<span class="section">Residenza</span>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="citta_residenza">Città </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="citta_residenza" class="form-control col-md-7 col-xs-12" name="citta_residenza" type="text" value="<?php echo $assistito["citta_residenza"];?>">
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

									<br />
									<span class="section">Documenti</span>
                  <div id="documenti">
                    <?php
                    if (!is_null($documenti_assistito_array)) {
                      $keys  = array_keys($documenti_assistito_array);
                    }

                    for ($i = 0; $i < count($documenti_assistito_array)+1; ++$i) {
                      $index = $keys[$i];
                      $documento = $documenti_assistito_array[$index];
					  $data_rilascio_pieces=split("-", $documento['DATA_RILASCIO_DOC']);
					  $data_rilascio_formatted=$data_rilascio_pieces[1]."/".$data_rilascio_pieces[2]."/".$data_rilascio_pieces[0];
					  $data_scadenza_pieces=split("-", $documento['DATA_SCADENZA_DOC']);
					  $data_scadenza_formatted=$data_scadenza_pieces[1]."/".$data_scadenza_pieces[2]."/".$data_scadenza_pieces[0];
                    ?>
                      <div class="item form-group" id="documento_input_<?php echo $i;?>">
                        <input type="hidden" name="documento_<?php echo $i;?>_pk" value="<?php echo $documento["ID"];?>" />
                        <label class="control-label col-md-1 col-sm-1 col-xs-1">Documento <?php echo ($i+1);?> </label>

                        <div class="col-md-2 col-sm-2 col-xs-2">
    											<select name="tipodoc_<?php echo $i;?>" class="select2_single form-control" tabindex="-1">
                            <option value="">Tipologia</option>
    												<option value="identita" <?php if ($documento["TIPO_DOC"]=="identita") echo("selected");?>>Carta d'identità</option>
    												<option value="passaporto" <?php if ($documento["TIPO_DOC"]=="passaporto") echo("selected");?>>Passaporto</option>
    												<option value="patente" <?php if ($documento["TIPO_DOC"]=="patente") echo("selected");?>>Patente</option>
    												<option value="smarrimento" <?php if ($documento["TIPO_DOC"]=="smarrimento") echo("selected");?>>Denuncia di smarrimento</option>
    												<option value="pds" <?php if ($documento["TIPO_DOC"]=="pds") echo("selected");?>>PDS (permesso di soggiorno)</option>
    												<option value="stp" <?php if ($documento["TIPO_DOC"]=="stp") echo("selected");?>>STP (rifugiato politico)</option>
    												<option value="sanitaria" <?php if ($documento["TIPO_DOC"]=="sanitaria") echo("selected");?>>Tessera sanitaria</option>
                            <option value="turistico" <?php if ($documento["TIPO_DOC"]=="turistico") echo("selected");?>>Permesso turistico</option>
                            <option value="identita_straniera" <?php if ($documento["TIPO_DOC"]=="identita_straniera") echo("selected");?>>Carta d'identità straniera</option>
                            <option value="altro" <?php if ($documento["TIPO_DOC"]=="altro") echo("selected");?>>Altro</option>
    											</select>
    										</div>
                        <div class="col-md-1 col-sm-1 col-xs-1">
                          <input id="numero_<?php echo $i;?>" name="numero_<?php echo $i;?>" class="form-control col-md-7 col-xs-12" placeholder="N° doc" value="<?php echo $documento["NUMERO_DOC"];?>">
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-2">
                           <input type="text" placeholder="data di rilascio" name="rilascio_<?php echo $i;?>" class="form-control has-feedback-left" id="rilascio_<?php echo $i;?>" aria-describedby="inputSuccess2Status4" value="<?php if ($data_rilascio_formatted!="//") echo $data_rilascio_formatted;?>">
 												   <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												   <span id="inputSuccess2Status4" class="sr-only">(success)</span>
											  </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                           <input type="text" placeholder="data di scadenza" name="scadenza_<?php echo $i;?>" class="form-control has-feedback-left" id="scadenza_<?php echo $i;?>" aria-describedby="inputSuccess2Status4" value="<?php if ($data_scadenza_formatted!="//") echo $data_scadenza_formatted;?>">
 												   <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												   <span id="inputSuccess2Status4" class="sr-only">(success)</span>
											  </div>
                        <div class="checkbox col-md-2 col-sm-2 col-xs-2">
												<label>
													<input type="checkbox" class="flat" name="fotocopia_<?php echo $i;?>" value=1 <?php if ($documento["FOTOCOPIA"]==1) echo 'checked="checked"'; ?> > Fotocopia
												</label>
											</div>

                        <?php
                        if ($i==count($documenti_assistito_array))
                        {
                        ?>
                          <div>
                            <button class="btn btn-primary button_remove_documento" type="button" id="button_remove_documento_<?php echo $i;?>" style="display:none;">X</button>
                          </div>
                          <div>
                            <button class="btn btn-primary button_add_documento" type="button" id="button_add_documento_<?php echo $i;?>">Agg. documento</button>
                          </div>
                        <?php
                        }
                        else {
                        ?>
                          <div>
                            <button class="btn btn-primary button_remove_documento" type="button" id="button_remove_documento_<?php echo $i;?>">X</button>
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                    <?php
                    }
                    ?>


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
									<br />
									<span class="section">Chi lo invia</span>
									<div class="item form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Conoscenti" <?php if (in_array("Conoscenti", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> Conoscenti/connazionali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Spontaneo" <?php if (in_array("Spontaneo", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> Spontaneo
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="ASL" <?php if (in_array("ASL", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> Asl/ospedali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Attori di stazioni" <?php if (in_array("Attori di stazioni", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> Attori di stazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Caritas" <?php if (in_array("Caritas", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> Caritas
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Ufficio immigrazioni" <?php if (in_array("Ufficio immigrazioni", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> Ufficio immigrazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Enti" <?php if (in_array("Enti", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> Enti/associazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Servizi sociali" <?php if (in_array("Servizi sociali", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> Servizi sociali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Sert" <?php if (in_array("Sert", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> SERT
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Privati" <?php if (in_array("Privati", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> Privati cittadini
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="Polfer" <?php if (in_array("Polfer", $chi_lo_invia_assistito_array)) echo 'checked="checked"'; ?>> Polfer
											</label>
										</div>
									</div>

									<br />
									<span class="section">Alloggio</span>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dimora stabile </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												<input type="radio" class="flat" name="alloggio" id="dimora_stabile" value="Dimora stabile" <?php if ($assistito["alloggio"]=="Dimora stabile") echo("checked");?> />
											</p>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Centro accoglienza </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												<input type="radio" class="flat" name="alloggio" id="centro_accoglienza" value="Centro accoglienza" <?php if ($assistito["alloggio"]=="Centro accoglienza") echo("checked");?> />
											</p>
										</div>
									</div>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Casa occupata </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												<input type="radio" class="flat" name="alloggio" id="casa_occupata" value="Casa occupata" <?php if ($assistito["alloggio"]=="Casa occupata") echo("checked");?> />
											</p>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Stazione </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												<input type="radio" class="flat" name="alloggio" id="stazione" value="Stazione" <?php if ($assistito["alloggio"]=="Stazione") echo("checked");?> />
											</p>
										</div>
									</div>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Strada</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												<input type="radio" class="flat" name="alloggio" id="strada" value="Strada" <?php if ($assistito["alloggio"]=="Strada") echo("checked");?> />
											</p>
										</div>
									</div>

									<br />
									<span class="section">Lingue conosciute</span>
									<div class="item form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Italiano" <?php if (in_array("Italiano", $lingue_assistito_array)) echo 'checked="checked"'; ?>> Italiano
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Inglese" <?php if (in_array("Inglese", $lingue_assistito_array)) echo 'checked="checked"'; ?>> Inglese
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Francese" <?php if (in_array("Francese", $lingue_assistito_array)) echo 'checked="checked"'; ?>> Francese
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Spagnolo" <?php if (in_array("Spagnolo", $lingue_assistito_array)) echo 'checked="checked"'; ?>> Spagnolo
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Tedesco" <?php if (in_array("Tedesco", $lingue_assistito_array)) echo 'checked="checked"'; ?>> Tedesco
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Russo" <?php if (in_array("Russo", $lingue_assistito_array)) echo 'checked="checked"'; ?>> Russo
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="lingue[]" value="Arabo" <?php if (in_array("Arabo", $lingue_assistito_array)) echo 'checked="checked"'; ?>> Arabo
											</label>
										</div>
										<div class="item form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lingua_madre">Lingua madre </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input id="lingua_madre" class="form-control col-md-7 col-xs-12" name="lingua_madre" type="text" value="<?php echo $assistito["lingua_madre"];?>">
											</div>
										</div>
									</div>

									<br />
									<span class="section">Vulnerabilità</span>
									<div class="item form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Disabilità fisica" <?php if (in_array("Disabilità fisica", $vulnerabilita_assistito_array)) echo 'checked="checked"'; ?>> Disabilità fisica
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Disabilità psicologica" <?php if (in_array("Disabilità psicologica", $vulnerabilita_assistito_array)) echo 'checked="checked"'; ?>> Disabilità psicologica
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Disagio abitativo" <?php if (in_array("Disagio abitativo", $vulnerabilita_assistito_array)) echo 'checked="checked"'; ?>> Disagio abitativo
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Fragilità lavorativa" <?php if (in_array("Fragilità lavorativa", $vulnerabilita_assistito_array)) echo 'checked="checked"'; ?>> Fragilità lavorativa
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Dipendenza droghe" <?php if (in_array("Dipendenza droghe", $vulnerabilita_assistito_array)) echo 'checked="checked"'; ?>> Dipendenza droghe
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Dipendenza alcool" <?php if (in_array("Dipendenza alcool", $vulnerabilita_assistito_array)) echo 'checked="checked"'; ?>> Dipendenza alcool
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Ex detenuto" <?php if (in_array("Ex detenuto", $vulnerabilita_assistito_array)) echo 'checked="checked"'; ?>> Ex detenuto
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="vulnerabilita[]" value="Rifugiato politico" <?php if (in_array("Rifugiato politico", $vulnerabilita_assistito_array)) echo 'checked="checked"'; ?>> Rifugiato politico
											</label>
										</div>
									</div>
				  <br />
                  <span class="section">Richieste</span>
                  <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="richiesta_alloggio">Richiesta di alloggio</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="richiesta_alloggio" rows="3" ><?php echo $richieste["richiesta_alloggio"]; ?></textarea>
                      </div>
                  </div>

                  <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="richiesta_primari">Richiesta beni primari</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="richiesta_primari" rows="3" ><?php echo $richieste["richiesta_primari"];?></textarea>
                      </div>
                  </div>

                  <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="richiesta_lavoro">Richiesta lavoro</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="richiesta_lavoro" rows="3" ><?php echo $richieste["richiesta_lavoro"];?></textarea>
                      </div>
                  </div>

                  <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="richiesta_beni_servizi">Richiesta beni e servizi</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="richiesta_beni_servizi" rows="3" ><?php echo $richieste["richiesta_beni_servizi"];?></textarea>
                      </div>
                  </div>

                  <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="richiesta_contatti_servizi">Richiesta contatti con altri servizi</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="richiesta_contatti_servizi" rows="3" ><?php echo $richieste["richiesta_contatti_servizi"];?></textarea>
                      </div>
                  </div>

                  <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="richiesta_burocratica">Richiesta burocratica</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="richiesta_burocratica" rows="3" ><?php echo $richieste["richiesta_burocratica"];?></textarea>
                      </div>
                  </div>

                  <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="richiesta_sanitaria">Richiesta sanitaria</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="richiesta_sanitaria" rows="3" ><?php echo $richieste["richiesta_sanitaria"];?></textarea>
                      </div>
                  </div>

				  <br />
									<span class="section">Risposte indirette</span>
									<div class="item form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Caritas" <?php if (in_array("Caritas", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> Caritas
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Politiche sociali" <?php if (in_array("Politiche sociali", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> Politiche sociali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="SERT" <?php if (in_array("SERT", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> SERT
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="DSM" <?php if (in_array("DSM", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> DSM
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Privati" <?php if (in_array("Privati", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> Privati
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Associazioni" <?php if (in_array("Associazioni", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> Associazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Parrocchie" <?php if (in_array("Parrocchie", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> Parrocchie
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Antoniano" <?php if (in_array("Antoniano", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> Antoniano
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Padre Marella" <?php if (in_array("Padre Marella", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> Padre Marella
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Suore M. Teresa di Calcutta" <?php if (in_array("Suore M. Teresa di Calcutta", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> Suore M. Teresa di Calcutta
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="risposte_indirette[]" value="Giovanni XXIII" <?php if (in_array("Giovanni XXIII", $risposte_indirette_assistito_array)) echo 'checked="checked"'; ?>> Giovanni XXIII
											</label>
										</div>
									</div>

									<br />
									<span class="section">Situazione lavorativa</span>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ha lavorato </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												Si <input type="radio" class="flat" name="ha_lavorato" id="ha_lavorato_si" value=1 <?php if ($assistito["ha_lavorato"]==1) echo("checked");?> />
												No <input type="radio" class="flat" name="ha_lavorato" id="ha_lavorato_no" value=0 <?php if ($assistito["ha_lavorato"]==0) echo("checked");?> />
											</p>
										</div>
									</div>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lavora </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												Si <input type="radio" class="flat" name="lavora" id="lavora_si" value=1 <?php if ($assistito["lavora"]==1) echo("checked");?> />
												No <input type="radio" class="flat" name="lavora" id="lavora_no" value=0 <?php if ($assistito["lavora"]==0) echo("checked");?> />
												<div class="item form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="dove_lavora">Dove lavora </label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<input id="dove_lavora" class="form-control col-md-7 col-xs-12" name="dove_lavora" type="text" value="<?php echo $assistito["dove_lavora"];?>" />
													</div>
												</div>
											</p>
										</div>
									</div>

                  <br />
									<span class="section">Note</span>
                  <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Note</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="note" rows="3" ><?php echo $assistito["note"];?></textarea>
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
//} else { //siamo in fase registrazione
//}
?>



<!--
<?php
$assistiti = get_assistiti();
//print_r($assistiti);
?>
-->

<!-- page content -->
	   <!-- /datepicker -->
    <script type="text/javascript">

			$(document).on('click', '.button_familiare', function (event) {
				$('#'+event.target.id+'').hide();
        idx_familiare_clicked = parseInt(event.target.id.substring(event.target.id.lastIndexOf('_') + 1));
        idx_new_familiare = idx_familiare_clicked +1;

				new_html='<div class="item form-group" id="familiare_input_'+idx_new_familiare+'">' +
                    '<input type="hidden" name="familiare_'+idx_new_familiare+'_pk"/>' +
										'<label class="control-label col-md-3 col-sm-3 col-xs-12">Familiare '+(idx_new_familiare+1)+' </label>' +
										'<div class="col-md-3 col-sm-3 col-xs-6">' +
											'<input id="parentela_'+idx_new_familiare+'" name="parentela_'+idx_new_familiare+'" class="form-control col-md-7 col-xs-12" placeholder="Grado di parentela" >' +
										'</div>' +
										'<div class="col-md-3 col-sm-3 col-xs-6">' +
											'<input id="anno_nascita_'+idx_new_familiare+'" name="anno_nascita_'+idx_new_familiare+'" class="form-control col-md-7 col-xs-12" placeholder="Anno di nascita" >' +
										'</div>' +
                    '<div>' +
                      '<button class="btn btn-primary button_remove_familiare" type="button" id="button_remove_familiare_'+idx_new_familiare+'" style="display:none;">X</button>' +
                    '</div>'+
										'<div>' +
											'<button class="btn btn-primary button_familiare" type="button" id="button_familiare_'+idx_new_familiare+'">Aggiungi familiare</button>' +
										'</div>' +
									'</div>';
				$('#familiari').append(new_html);

        var elem = document.getElementById('button_remove_familiare_'+idx_familiare_clicked);
        elem.setAttribute("style", "display: inline;");

			});
      $(document).on('click', '.button_remove_familiare', function (event) {

        idx_familiare_clicked = parseInt(event.target.id.substring(event.target.id.lastIndexOf('_') + 1));

        //set the remove flag
				new_html='<input type="hidden" name="familiare_'+idx_familiare_clicked+'_rimuovi" value="1" />';
				$('#familiare_input_'+idx_familiare_clicked).append(new_html);

        //$('#familiare_input_'+idx_familiare_clicked).setAttribute("style", "display: none;");

        var elem = document.getElementById('familiare_input_'+idx_familiare_clicked);
        elem.setAttribute("style", "display: none;");

        //familiare_toremove_

        //var d = document.getElementById('familiari');
        //var olddiv = document.getElementById('familiare_input_'.$index);
        //d.removeChild(olddiv);

			});

      $(document).on('click', '.button_add_documento', function (event) {
				$('#'+event.target.id+'').hide();
        idx_documento_clicked = parseInt(event.target.id.substring(event.target.id.lastIndexOf('_') + 1));
        idx_new_documento = idx_documento_clicked +1;

				new_html='<div class="item form-group" id="documento_input_'+idx_new_documento+'">' +
                    '<input type="hidden" name="documento_'+idx_new_documento+'_pk"/>' +
										'<label class="control-label col-md-1 col-sm-1 col-xs-1">Documento '+(idx_new_documento+1)+' </label>' +

                    '<div class="col-md-2 col-sm-2 col-xs-2">'+
                      '<select name="tipodoc_'+idx_new_documento+'" class="select2_single form-control" tabindex="-1">'+
                        '<option value="">Tipologia</option>'+
                        '<option value="identita">Carta identità</option>'+
                        '<option value="passaporto">Passaporto</option>'+
                        '<option value="patente">Patente</option>'+
                        '<option value="smarrimento">Denuncia di smarrimento</option>'+
                        '<option value="pds">PDS (permesso di soggiorno)</option>'+
                        '<option value="stp">STP (rifugiato politico)</option>'+
                        '<option value="sanitaria">Tessera sanitaria</option>'+
                        '<option value="turistico">Permesso turistico</option>'+
                        '<option value="identita_straniera">Carta identità straniera</option>'+
                        '<option value="altro">Altro</option>'+
                      '</select>'+
                    '</div>'+
                    '<div class="col-md-1 col-sm-1 col-xs-1">'+
                      '<input id="numero_'+idx_new_documento+'" name="numero_'+idx_new_documento+'" class="form-control col-md-7 col-xs-12" placeholder="N° doc">'+
                    '</div>'+
                    '<div class="col-md-2 col-sm-2 col-xs-2">'+
                      '<input type="text" placeholder="data di rilascio" name="rilascio_'+idx_new_documento+'" class="form-control has-feedback-left" id="rilascio_'+idx_new_documento+'" aria-describedby="inputSuccess2Status4">'+
                      '<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>'+
                      '<span id="inputSuccess2Status4" class="sr-only">(success)</span>'+
                    '</div>'+
                    '<div class="col-md-2 col-sm-2 col-xs-2">'+
                      '<input type="text" placeholder="data di scadenza" name="scadenza_'+idx_new_documento+'" class="form-control has-feedback-left" id="scadenza_'+idx_new_documento+'" aria-describedby="inputSuccess2Status4">'+
                      '<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>'+
                      '<span id="inputSuccess2Status4" class="sr-only">(success)</span>'+
                      '</div>'+
                      '<div class="checkbox col-md-2 col-sm-2 col-xs-2">'+
                        '<label>'+
                        '<input type="checkbox" class="flat" name="fotocopia_'+idx_new_documento+'" value="<?php echo $documento["FOTOCOPIA"];?>"> Fotocopia'+
                        '</label>'+
                      '</div>'+
                    '<div>' +
                      '<button class="btn btn-primary button_remove_documento" type="button" id="button_remove_documento_'+idx_new_documento+'" style="display:none;">X</button>' +
                    '</div>'+
										'<div>' +
											'<button class="btn btn-primary button_add_documento" type="button" id="button_add_documento_'+idx_new_documento+'">Aggiungi documento</button>' +
										'</div>' +
									'</div>';
				$('#documenti').append(new_html);

        var elem = document.getElementById('button_remove_documento_'+idx_documento_clicked);
        elem.setAttribute("style", "display: inline;");

			});
      $(document).on('click', '.button_remove_documento', function (event) {
        idx_documento_clicked = parseInt(event.target.id.substring(event.target.id.lastIndexOf('_') + 1));
        //set the remove flag
				new_html='<input type="hidden" name="documento_'+idx_documento_clicked+'_rimuovi" value="1" />';
				$('#documento_input_'+idx_documento_clicked).append(new_html);
        var elem = document.getElementById('documento_input_'+idx_documento_clicked);
        elem.setAttribute("style", "display: none;");
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
            $('#data_primo_ascolto_calendar').daterangepicker({
              locale: {
                  format: 'DD/MM/YYYY',
                  monthNames: ['Gennaio',
                        'Febbraio',
                        'Marzo',
                        'Aprile',
                        'Maggio',
                        'Giugno',
                        'Luglio',
                        'Agosto',
                        'Settembre',
                        'Ottobre',
                        'Novembre',
                        'Dicembre'],
                },
                showDropdowns: true,
                minDate: '01-01-2000',
                maxDate: '31-12-2020',
                startDate: new Date(),
                endDate: new Date(),
                singleDatePicker: true,
                calender_style: "picker_4"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#data_nascita_calendar').daterangepicker({
              locale: {
                  format: 'DD/MM/YYYY',
                  monthNames: ['Gennaio',
                        'Febbraio',
                        'Marzo',
                        'Aprile',
                        'Maggio',
                        'Giugno',
                        'Luglio',
                        'Agosto',
                        'Settembre',
                        'Ottobre',
                        'Novembre',
                        'Dicembre'],
                },
                showDropdowns: true,
                minDate: '01-01-1920',
                maxDate: '31-12-2020',
                startDate: '01-01-1950',
                endDate: '01-01-1950',
                singleDatePicker: true,
                calender_style: "picker_4"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#rilascio_0').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#scadenza_0').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#rilascio_1').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#scadenza_1').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#rilascio_2').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#scadenza_2').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker"
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
