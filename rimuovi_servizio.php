<?php
require_once "config.php";
require_once "functions.php";

if (isset($_GET['id_servizio'])) {
	$id_servizio = $_GET['id_servizio'];
	$rimozione = delete_servizio($id_servizio);
	$servizio = get_servizio($id_servizio);
//	print_r($servizio);
	if (sizeof($servizio)!=0) {
		include "header.php";
		include "menu.php";
		include "top_nav.php";
?>		
		<div class="right_col" role="main">
			<div class="page-title">
				<div class="title_left">
					<h3>Rimozione non riuscita</h3>
				</div>
			</div>
		</div>			
<?php
	} else {		
		header('Location: lista_servizi.php');
	}
?>

<?php
} else {
	include "header.php";
	include "menu.php";
	include "top_nav.php";
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
