<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";

if (isset($_GET['id_servizio'])) {
	$id_servizio = $_GET['id_servizio'];
	$servizio = get_servizio($id_servizio);
?>

<!-- page content -->
            <div class="right_col" role="main">
				<div class="page-title">
					<div class="title_left">
						<h3>Dettagli servizio</h3>
					</div>
					<div class="title_right">
						<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
							<div class="input-group">

							</div>
						</div>
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
								
                  <div class="row">
                      <div class="col-md-3"><label>Tipo</label></div>
                      <div class="col-md-9"><?php echo $servizio["tipo"];?></div>
                  </div>
                  <div class="row">
                      <div class="col-md-3"><label>Destinatario</label></div>
                      <div class="col-md-9"><?php echo $servizio["cognome"]." ".$servizio["nome"];?></div>
                  </div>
                  <div class="row">
                      <div class="col-md-3"><label>Data</label></div>
                      <div class="col-md-9"><?php echo convertDateFromDbTo2It($servizio["data"]);?></div>
                  </div>
				
                  <?php
					  if($servizio["note"]!="") {
				  ?>
				  <div class="row">
                      <div class="col-md-3"><label>Note</label></div>
                      <div class="col-md-9"><?php echo $servizio["note"];?></div>
                  </div>
				  <?php
					  }
				  ?>

				  <br /><br />

		
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
				<h3>Nessun servizio selezionato</h3>
			</div>
		</div>
	</div>
<?php
}
include "footer.php";
?>
