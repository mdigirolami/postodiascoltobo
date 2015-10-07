<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";
?>

<!-- page content -->
            <div class="right_col" role="main">
				<div class="page-title">
					<div class="title_left">
						<h3>Scheda assistito</h3>
					</div>
					<div class="title_right">
						<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
							<div class="input-group">

							</div>
						</div>
					</div>
				</div>

                <div class="row">



<?php
if ($_POST['action'] != 'register') {

  if (isset($_GET['id_assistito'])) {
  	$id_assistito = $_GET['id_assistito'];
  	$assistito = get_assistito($id_assistito);
  }

?>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Inserisci <small>(i campi contrassegnati con * sono obbligatori)</small></h2>
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
									<input type="hidden" name="action" value="register" />
									<span class="section">Dati personali</span>

									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nome">Nome <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="nome" class="form-control col-md-7 col-xs-12" name="nome" required="required" type="text">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="cognome">Cognome <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="cognome" class="form-control col-md-7 col-xs-12" name="cognome" required="required" type="text">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="data_di_nascita">Data di nascita </label>
										<div class="controls">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="data_di_nascita" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4">
												<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status4" class="sr-only">(success)</span>
											</div>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="luogo_di_nascita">Luogo di nascita </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="luogo_di_nascita" class="form-control col-md-7 col-xs-12" name="luogo_di_nascita" type="text">
										</div>
									</div>
									<div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sesso </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<p>
												M:
												<input type="radio" class="flat" name="sesso" id="sessoM" value="M" checked="" /> F:
												<input type="radio" class="flat" name="sesso" id="sessoF" value="F" />
											</p>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nazionalita">Nazionalità </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="nazionalita" class="form-control col-md-7 col-xs-12" name="nazionalita" type="text">
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
											<input type="phone" id="cellulare" name="cellulare" class="form-control col-md-7 col-xs-12">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Stato civile </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select name="stato_civile" class="select2_single form-control" tabindex="-1">
												<option>Seleziona uno stato</option>
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

									<span class="section">Residenza</span>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="citta_residenza">Città </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="citta_residenza" class="form-control col-md-7 col-xs-12" name="citta_residenza" type="text">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="via_residenza">Via </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="via_residenza" class="form-control col-md-7 col-xs-12" name="via_residenza" type="text">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="numero_residenza">Numero civico </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="numero_residenza" class="form-control col-md-7 col-xs-12" name="numero_residenza" type="text">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nazione_residenza">Nazione </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="nazione_residenza" class="form-control col-md-7 col-xs-12" name="nazione_residenza" type="text">
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
?>
									<div class="item form-group" style="min-height:34px;">
										<div class="col-md-3 col-sm-3 col-xs-12" style="float:left;">
											<div class="checkbox">
												<span id="<?php echo $key;?>">
														<input type="checkbox" class="flat" name="documenti[]" value="<?php echo $key;?>">
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
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="conoscenti"> Conoscenti/connazionali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="spontaneo"> Spontaneo
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="asl"> Asl/ospedali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="attori_di_stazioni"> Attori di stazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="caritas"> Caritas
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="ufficio_immigrazioni"> Ufficio immigrazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="enti"> Enti/associazioni
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="servizi_sociali"> Servizi sociali
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="sert"> SERT
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="privati"> Privati cittadini
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="flat" name="chi_lo_invia[]" value="polfer"> Polfer
											</label>
										</div>
									</div>

									<div class="ln_solid"></div>
									<div class="form-group">
										<div class="col-md-6 col-md-offset-3">
											<button type="submit" class="btn btn-primary">Annulla</button>
											<button id="send" type="submit" class="btn btn-success">Inserisci</button>
										</div>
									</div>
								</form>
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
} else {
	$ins = inserisci_assistito($_POST);
	echo "Assistito inserito";
}
?>




<?php
$assistiti = get_assistiti();

print_r($assistiti);
?>

<!-- page content -->
	   <!-- /datepicker -->
    <script type="text/javascript">
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
