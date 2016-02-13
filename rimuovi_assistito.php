<?php
require_once "config.php";
require_once "functions.php";

if (isset($_GET['id_assistito'])) {
	$id_assistito = $_GET['id_assistito'];
	$rimozione = delete_assistito($id_assistito);
	$assistito = get_assistito($id_assistito);
//	print_r($assistito);
	if (sizeof($assistito)!=0) {
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
		header('Location: lista_assistiti.php');
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
				<h3>Nessun assistito selezionato</h3>
			</div>
		</div>
	</div>
<?php
}
include "footer.php";
?>
