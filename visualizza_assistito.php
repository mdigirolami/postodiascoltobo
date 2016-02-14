<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";

if (isset($_GET['id_assistito'])) {
	$id_assistito = $_GET['id_assistito'];
	$assistito = get_assistito($id_assistito);
	$familiari_assistito_array = get_familiari_assistito($id_assistito);
	$documenti_assistito_array = get_documenti_assistito($id_assistito);
	$chi_lo_invia_assistito_array = get_chi_lo_invia_assistito($id_assistito);
	$lingue_assistito_array = get_lingue_assistito($id_assistito);
	$vulnerabilita_assistito_array = get_vulnerabilita_assistito($id_assistito);
	$risposte_indirette_assistito_array = get_risposte_indirette_assistito($id_assistito);
	$richieste = get_richieste($id_assistito);

  if ("1"==$assistito["stato_civile"]) {
    $stato_civile_str="Celibe";
  } else if ("2"==$assistito["stato_civile"]) {
    $stato_civile_str="Nubile";
  } else if ("3"==$assistito["stato_civile"]) {
    $stato_civile_str="Convivente";
  } else if ("4"==$assistito["stato_civile"]) {
    $stato_civile_str="Coniugato/a";
  } else if ("5"==$assistito["stato_civile"]) {
    $stato_civile_str="Vedovo/a";
  } else if ("6"==$assistito["stato_civile"]) {
    $stato_civile_str="Separato/a";
  } else if ("7"==$assistito["stato_civile"]) {
    $stato_civile_str="Divorziato/a";
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

				<div class="x_content" style="height:46px;">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="active"><a href="visualizza_assistito.php?id_assistito=<?php echo $id_assistito; ?>" id="home-tab" aria-expanded="true">Visualizza</a>
							</li>
							<li role="presentation" class=""><a href="assistito.php?id_assistito=<?php echo $id_assistito; ?>" id="profile-tab" aria-expanded="false">Modifica</a>
							</li>
							<li role="presentation" class=""><a href="servizio.php?id_assistito=<?php echo $id_assistito; ?>" id="profile-tab2" aria-expanded="false">Inserisci servizio</a>
							</li>
							<li role="presentation" class=""><a href="banco_alimentare.php?id_assistito=<?php echo $id_assistito; ?>" id="profile-tab2" aria-expanded="false">Banco alimentare</a>
							</li>
						</ul>
					</div>
				</div>

                <div class="row">

					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Visualizza</h2>
								<div class="clearfix"></div>

							</div>
							<div class="x_content">
								<span class="section">Primo ascolto</span>
								<div class="row">
										<div class="col-md-3"><label>Data primo ascolto</label></div>
										<div class="col-md-9"><?php echo $assistito["data_primo_ascolto"];?></div>
								</div>
								<br />
									<span class="section">Dati personali</span>
                  <div class="row">
                      <div class="col-md-3"><label>Nome</label></div>
                      <div class="col-md-9"><?php echo $assistito["nome"];?></div>
                  </div>
                  <div class="row">
                      <div class="col-md-3"><label>Cognome</label></div>
                      <div class="col-md-9"><?php echo $assistito["cognome"];?></div>
                  </div>
                  <div class="row">
                      <div class="col-md-3"><label>Data di nascita</label></div>
                      <div class="col-md-9"><?php echo $assistito["data_di_nascita"];?></div>
                  </div>
                  <div class="row">
                      <div class="col-md-3"><label>Luogo di nascita</label></div>
                      <div class="col-md-9"><?php echo $assistito["luogo_di_nascita"];?></div>
                  </div>
                  <div class="row">
                      <div class="col-md-3"><label>Sesso</label></div>
                      <div class="col-md-9"><?php echo $assistito["sesso"];?></div>
                  </div>
									<div class="row">
                      <div class="col-md-3"><label>Nazionalità</label></div>
                      <div class="col-md-9"><?php echo $assistito["nome_nazionalita"];?></div>
                  </div>
									<div class="row">
                      <div class="col-md-3"><label>Cellulare</label></div>
                      <div class="col-md-9"><?php echo $assistito["cellulare"];?></div>
                  </div>
									<div class="row">
                      <div class="col-md-3"><label>Stato civile</label></div>
                      <div class="col-md-9"><?php echo $stato_civile_str;?></div>
                  </div>
				  <br /><br />

									<span class="section">Dati residenza</span>
                  <div class="row">
                      <div class="col-md-3"><label>Città</label></div>
                      <div class="col-md-9"><?php echo $assistito["citta_residenza"];?></div>
                  </div>
									<div class="row">
                      <div class="col-md-3"><label>Via</label></div>
                      <div class="col-md-9"><?php echo $assistito["via_residenza"];?></div>
                  </div>
									<div class="row">
                      <div class="col-md-3"><label>Numero civico</label></div>
                      <div class="col-md-9"><?php echo $assistito["numero_residenza"];?></div>
                  </div>
									<div class="row">
                      <div class="col-md-3"><label>Nazione</label></div>
                      <div class="col-md-9"><?php echo $assistito["nazione_residenza"];?></div>
                  </div>
				  <br /><br />
									<span class="section">Familiari</span>

									<?php
									if (sizeof($familiari_assistito_array)==0) {
										echo '<div><label>Nessun familiare inserito</label></div>';
									} else {
									?>
									<table class="table table-striped responsive-utilities jambo_table">
										<thead>
												<tr class="headings">
														<th>Grado di parentela</th>
														<th>Anno di nascita</th>
												</tr>
										</thead>
									  <tbody>
									<?php
									foreach ($familiari_assistito_array as $familiari_assistito) {
										echo '<tr class="even pointer">';
										echo '<td class=" ">'.$familiari_assistito["parentela"].'</td>';
										echo '<td class=" ">'.$familiari_assistito["anno_di_nascita"].'</td>';
										echo '</tr>';
									}
									?>
									   </tbody>
								    </table>
									<?php
										}
									?>

						<br /><br />


									<span class="section">Documenti</span>
									<!--
									<?php
									foreach ($documenti_assistito_array as $documento_assistito) {

										echo '<div class="row">
												    <div class="col-md-2">'.$documento_assistito["TIPO_DOC"].'</div>
												    <div class="col-md-2">'.$documento_assistito["NUMERO_DOC"].'</div>
														<div class="col-md-2">'.$documento_assistito["DATA_RILASCIO_DOC"].'</div>
														<div class="col-md-2">'.$documento_assistito["DATA_SCADENZA_DOC"].'</div>
														<div class="col-md-2">'.$documento_assistito["FOTOCOPIA"].'</div>
														<div class="col-md-2"></div>
										      </div>';
									}
									?>
									-->

									<?php
									if (sizeof($documenti_assistito_array)==0) {
										echo '<div><label>Nessun documento inserito</label></div>';
									} else {
									?>
									<table class="table table-striped responsive-utilities jambo_table">
										<thead>
												<tr class="headings">
														<th>Tipo documento</th>
														<th>Numero</th>
														<th>Data di rilascio</th>
														<th>Data di scadenza</th>
														<th>Fotocopia</th>
												</tr>
										</thead>
									  <tbody>
									<?php
									foreach ($documenti_assistito_array as $documento_assistito) {
										if ($documento_assistito["FOTOCOPIA"]==0) {
											$documento_assistito["FOTOCOPIA"]="NO";
										}
										else {
											$documento_assistito["FOTOCOPIA"]="SI";
										}
										echo '<tr class=""even pointer">';
										echo '<td class=" ">'.$documento_assistito["TIPO_DOC"].'</td>';
										echo '<td class=" ">'.$documento_assistito["NUMERO_DOC"].'</td>';
										echo '<td class=" ">'.$documento_assistito["DATA_RILASCIO_DOC"].'</td>';
										echo '<td class=" ">'.$documento_assistito["DATA_SCADENZA_DOC"].'</td>';
										echo '<td class=" ">'.$documento_assistito["FOTOCOPIA"].'</td>';
										echo '</tr>';
									}
									?>
									   </tbody>
								    </table>
									<?php
										}
									?>

						<br /><br />
									<span class="section">Chi lo invia</span>
									<?php
									if (sizeof($chi_lo_invia_assistito_array)==0) {
										echo '<div><label>Nessuna scelta indicata</label></div>';
									} else {
										foreach ($chi_lo_invia_assistito_array as $chi_lo_invia) {
											echo '<div><label>'.$chi_lo_invia.'</label></div>';
										}
									}
									?>
									<div class="ln_solid"></div>
						<br />
									<span class="section">Alloggio</span>
									<div><label>
									<?php
										$alloggio = $assistito["alloggio"];
										if ($alloggio=="") $alloggio="Nessun alloggio indicato";
										echo $alloggio;
									?>
									</label></div>
									<div class="ln_solid"></div>
						<br />
									<span class="section">Lingue conosciute</span>
									<?php
									if (sizeof($lingue_assistito_array)==0) {
										echo '<div><label>Nessuna lingua indicata</label></div>';
									} else {
										foreach ($lingue_assistito_array as $lingua) {
											echo '<div><label>'.$lingua.'</label></div>';
										}
									}
									$lingua_madre = $assistito["lingua_madre"];
									if ($lingua_madre=="") {
										echo "Nessuna lingua madre inserita";
									} else {
									?>
									<div class="row">
										<div class="col-md-3"><label>Lingua madre</label></div>
										<div class="col-md-9"><?php echo $lingua_madre;?></div>
									</div>
									<?php
									}
									?>
									<div class="ln_solid"></div>
						<br />
									<span class="section">Vulnerabilità</span>
									<?php
									if (sizeof($vulnerabilita_assistito_array)==0) {
										echo '<div><label>Nessuna scelta indicata</label></div>';
									} else {
										foreach ($vulnerabilita_assistito_array as $vulnerabilita) {
											echo '<div><label>'.$vulnerabilita.'</label></div>';
										}
									}
									?>
									<div class="ln_solid"></div>
						<br />
									<span class="section">Richieste</span>
									<?php
									if ($richieste["richiesta_alloggio"]=="") {
										echo "<div>Nessuna richiesta di alloggio inserita</div>";
									} else {
									?>
									<div class="row">
										<div class="col-md-3"><label>Richiesta di alloggio</label></div>
										<div class="col-md-9"><?php echo $richieste["richiesta_alloggio"];?></div>
									</div>
									<?php
									}
									if ($richieste["richiesta_primari"]=="") {
										echo "<div>Nessuna richiesta di beni primari inserita</div>";
									} else {
									?>
									<div class="row">
										<div class="col-md-3"><label>Richiesta beni primari</label></div>
										<div class="col-md-9"><?php echo $richieste["richiesta_primari"];?></div>
									</div>
									<?php
									}
									if ($richieste["richiesta_lavoro"]=="") {
										echo "<div>Nessuna richiesta di lavoro inserita</div>";
									} else {
									?>
									<div class="row">
										<div class="col-md-3"><label>Richiesta lavoro</label></div>
										<div class="col-md-9"><?php echo $richieste["richiesta_lavoro"];?></div>
									</div>
									<?php
									}
									if ($richieste["richiesta_beni_servizi"]=="") {
										echo "<div>Nessuna richiesta di beni e servizi inserita</div>";
									} else {
									?>
									<div class="row">
										<div class="col-md-3"><label>Richiesta beni e servizi</label></div>
										<div class="col-md-9"><?php echo $richieste["richiesta_beni_servizi"];?></div>
									</div>
									<?php
									}
									if ($richieste["richiesta_contatti_servizi"]=="") {
										echo "<div>Nessuna richiesta contatti con altri servizi inserita</div>";
									} else {
									?>
									<div class="row">
										<div class="col-md-3"><label>Richiesta contatti con altri servizi</label></div>
										<div class="col-md-9"><?php echo $richieste["richiesta_contatti_servizi"];?></div>
									</div>
									<?php
									}
									if ($richieste["richiesta_burocratica"]=="") {
										echo "<div>Nessuna richiesta burocratica inserita</div>";
									} else {
									?>
									<div class="row">
										<div class="col-md-3"><label>Richiesta burocratica</label></div>
										<div class="col-md-9"><?php echo $richieste["richiesta_burocratica"];?></div>
									</div>
									<?php
									}
									if ($richieste["richiesta_sanitaria"]=="") {
										echo "<div>Nessuna richiesta sanitaria inserita</div>";
									} else {
									?>
									<div class="row">
										<div class="col-md-3"><label>Richiesta sanitaria</label></div>
										<div class="col-md-9"><?php echo $richieste["richiesta_sanitaria"];?></div>
									</div>
									<?php
									}
									?>
									<div class="ln_solid"></div>

						<br />
									<span class="section">Risposte indirette</span>
									<?php
									if (sizeof($risposte_indirette_assistito_array)==0) {
										echo '<div><label>Nessuna scelta indicata</label></div>';
									} else {
										foreach ($risposte_indirette_assistito_array as $risposta) {
											echo '<div><label>'.$risposta.'</label></div>';
										}
									}
									?>
									<div class="ln_solid"></div>

						<br />
									<span class="section">Situazione lavorativa</span>
									<div class="row">
									  <div class="col-md-3"><label>Ha lavorato</label></div>
									  <div class="col-md-9"><?php $ha_lavorato = ($assistito["ha_lavorato"]==0) ? 'No' : 'Si'; echo $ha_lavorato;?></div>
								    </div>
									<div class="row">
									  <div class="col-md-3"><label>Lavora</label></div>
									  <div class="col-md-9"><?php $lavora = ($assistito["lavora"]==0) ? 'No' : 'Si'; echo $lavora;?></div>
								    </div>
									<?php
									if ($lavora=="Si" and $assistito["dove_lavora"]!="") {
									?>
										<div class="row">
										  <div class="col-md-3"><label>Dove lavora</label></div>
										  <div class="col-md-9"><?php echo $assistito["dove_lavora"];?></div>
										</div>
									<?php
									}
									?>
									<div class="ln_solid"></div>

									<span class="section">Note</span>
									<div class="row">
										<div class="col-md-3"><label>Note</label></div>
										<div class="col-md-9"><?php echo $assistito["note"];?></div>
									</div>
									<div class="ln_solid"></div>
							</div>
						</div>
					</div>
				</div>

<?php
} else {
?>
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="title_left">
				<h3>Nessun assistito selezionato</h3>
			</div>
		</div>
	</div>
<?php
}
include "footer.php";
?>
