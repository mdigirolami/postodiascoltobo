<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";

if (isset($_GET['id_assistito'])) {
	$id_assistito = $_GET['id_assistito'];
	$assistito = get_assistito($id_assistito);
	$documenti_assistito_array = get_documenti_assistito($id_assistito);
	$chi_lo_invia_assistito_array = get_chi_lo_invia_assistito($id_assistito);
	$lingue_assistito_array = get_lingue_assistito($id_assistito);
	$vulnerabilita_assistito_array = get_vulnerabilita_assistito($id_assistito);
	$risposte_indirette_assistito_array = get_risposte_indirette_assistito($id_assistito);
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
                      <div class="col-md-9"><?php echo $assistito["nazionalita"];?></div>
                  </div>
									<div class="row">
                      <div class="col-md-3"><label>Cellulare</label></div>
                      <div class="col-md-9"><?php echo $assistito["cellulare"];?></div>
                  </div>
									<div class="row">
                      <div class="col-md-3"><label>Stato civile</label></div>
                      <div class="col-md-9"><?php echo $assistito["stato_civile"];?></div>
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
										if ($documento_assistito["FOTOCOPIA"]=="") {
											$documento_assistito["FOTOCOPIA"]="NO";
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
											echo '<div><label>'.$chi_lo_invia["chi"].'</label></div>';
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
											echo '<div><label>'.$lingua["lingua"].'</label></div>';
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
											echo '<div><label>'.$vulnerabilita["vulnerabilita"].'</label></div>';
										}
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
											echo '<div><label>'.$risposta["risposta"].'</label></div>';
										}
									}
									?>
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
