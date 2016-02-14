<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";

$id_assistito=$_GET['id_assistito'];
$assistito = get_assistito($id_assistito);

if (isset($_GET['id_servizio_erogato'])) {
	$id_servizio_erogato = $_GET['id_servizio_erogato'];
	$servizio = get_servizio($id_servizio_erogato);
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
					<li role="presentation" class=""><a href="dettagli_servizio.php?id_servizio_erogato=<?php echo $id_servizio_erogato; ?>" id="home-tab" aria-expanded="true">Visualizza servizio</a>
					</li>
					<li role="presentation" class=""><a href="modifica_servizio.php?id_assistito=<?php echo $id_assistito; ?>&id_servizio_erogato=<?php echo $id_servizio_erogato; ?>" id="profile-tab" aria-expanded="false">Modifica servizio</a>
					</li>
				</ul>
			</div>
		</div>

    <div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Visualizza servizio</h2>
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
						<div style="text-align:center">
						<a href="servizi_assistito.php?id_assistito=<?php echo $id_assistito?>" class="btn btn-info" role="button">Apri lista servizi dell'assistito corrente</a>
						</div>
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
