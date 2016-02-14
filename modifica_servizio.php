<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";
?>


<?php


	$id_assistito=$_GET['id_assistito'];
	$assistito = get_assistito($id_assistito);

	$id_servizio_erogato = $_GET['id_servizio_erogato'];
	$servizio = get_servizio($id_servizio_erogato);

	$cat_servizi = get_cat_servizi();
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
					<li role="presentation" class=""><a href="dettagli_servizio.php?id_assistito=<?php echo $id_assistito; ?>&id_servizio_erogato=<?php echo $id_servizio_erogato; ?>" id="home-tab" aria-expanded="true">Visualizza servizio</a>
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
						<h2>Modifica servizio<small>(i campi contrassegnati con * sono obbligatori)</small></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form action="modifica_servizio_call.php" method="post" class="form-horizontal form-label-left" novalidate>
							<!--<input type="hidden" name="action" value="<?php echo $form_action;?>" />-->
							<input type="hidden" name="id_assistito" value="<?php echo $id_assistito;?>" />
							<input type="hidden" name="id_servizio_erogato" value="<?php echo $id_servizio_erogato;?>" />
							<span class="section">Dati servizio</span>

							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipo">Tipo
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select id="id_servizio" name="id_servizio" class="select2_single form-control" tabindex="-1" >
										<option value="">Seleziona un servizio</option>
									<?php
									  foreach ($cat_servizi as $categoria) {

											if ($categoria[id]==$servizio["id_categoria"]) $is_selected_html = "selected";
											else $is_selected_html = "";
											//echo '<option value="'.$nazione[id].'" '.$is_selected_html.' >'.$nazione[nome].'</option>';

											echo '<option value="'.$categoria["id"].'" '.$is_selected_html.' >'.$categoria["nome"].'</option>';
									  }
									?>

									</select>
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="data_di_nascita">Data </label>
								<div class="controls">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="data" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4" value="<?php echo $servizio["data"];?>">
										<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
										<span id="inputSuccess2Status4" class="sr-only">(success)</span>
									</div>
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Note </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea id="luogo_di_nascita" class="form-control col-md-7 col-xs-12" name="note" rows="5"><?php echo $servizio["note"];?></textarea>
								</div>
							</div>

							<div class="ln_solid"></div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-3">
									<button type="submit" class="btn btn-primary">Annulla</button>
									<button id="send" type="submit" class="btn btn-success">Modifica</button>
								</div>
							</div>
              <!-- altro -->

						</form>
					</div>
				</div>
			</div>

</div>


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
