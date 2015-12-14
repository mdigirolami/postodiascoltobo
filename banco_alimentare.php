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

	
	$id_assistito=$_GET['id_assistito'];
	$assistito = get_assistito($id_assistito);
	$anno = (isset($_GET['anno']) ? $_GET['anno'] : date('Y'));
	$banco_alimentare = get_banco_alimentare_assistito($id_assistito,$anno);
	
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
//    print_r($banco_alimentare);
?>
				<div class="x_content" style="height:46px;">	
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class=""><a href="visualizza_assistito.php?id_assistito=<?php echo $id_assistito; ?>" id="home-tab" aria-expanded="true">Visualizza</a>
							</li>
							<li role="presentation" class=""><a href="assistito.php?id_assistito=<?php echo $id_assistito; ?>" id="profile-tab" aria-expanded="false">Modifica</a>
							</li>
							<li role="presentation" class=""><a href="servizio.php?id_assistito=<?php echo $id_assistito; ?>" id="profile-tab2" aria-expanded="false">Inserisci servizio</a>
							</li>
							<li role="presentation" class="active"><a href="banco_alimentare.php?id_assistito=<?php echo $id_assistito; ?>" id="profile-tab2" aria-expanded="false">Banco alimentare</a>
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
			
				<div class="row">	
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Banco alimentare<small>(visualizza dati dell'anno 
									<select name="anno" id="anno">
										<?php
											$earliest_year=2014;
											foreach(range(date('Y'), $earliest_year) as $year) {
												echo '<option value="'.$year.'" '.($year == $anno ? " selected=selected" : "").'>'.$year.'</option>';
											}	
										?>
									</select>)</small></h2>
              
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<br />

								<form action="aggiorna_banco_alimentare.php" method="post" class="form-horizontal form-label-left" novalidate>
									<input type="hidden" name="action" value="aggiorna" />
									<input type="hidden" name="id_assistito" id="id_assistito" value="<?php echo $id_assistito;?>" />
									<input type="hidden" name="anno" value="<?php echo $anno;?>" />
									<span class="section">Anno <?php echo $anno; ?></span>
									
									<?php
//echo strftime("%A %d %B %Y");
									?>
									<table class="table table-striped responsive-utilities jambo_table">
										<thead>
										<tr class="headings">
											<?php
												setlocale(LC_TIME, 'it_IT');
												for ($m=1; $m<=12; $m++) {
													echo '<th style="text-align:center;">'.ucfirst(substr(strftime("%B", mktime(0,0,0,$m)), 0, 3)).'</th>';
												}	
											?>
										</tr>
										</thead>
										<tbody>
										<tr class="" pointer"="" even="">
											<?php
												for ($m=1; $m<=12; $m++) {
													$checked="";
													if (in_array($m, $banco_alimentare)) {
														$checked="checked";
													}
													echo '<td style="text-align:center;"><input type="checkbox" class="flat" name="ritiri[]" value="'.$m.'" '.$checked.'></td>';
												}	
											?>
										</tr>
										</tbody>
									</table>
									
									<div class="ln_solid"></div>
									<div class="form-group">
										<div class="col-md-6 col-md-offset-3">
											<button type="submit" class="btn btn-primary">Annulla</button>
											<button id="send" type="submit" class="btn btn-success">Aggiorna</button>
										</div>
									</div>
                  <!-- altro -->
									
								</form>
							</div>
						</div>
					</div>

</div>


<?php
} else { //siamo in fase registrazione

  if ($page_mode=='REGISTRA_INSERISCI') {
    echo "chiamata a aggiorna_ritiri...";
//  	$ins = aggiorna_ritiri($_POST);
  	echo "Assistito inserito correttamente";
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
        $(document).ready(function () {
			$('#anno').change(function() {
				window.location = "banco_alimentare.php?id_assistito=" + $('#id_assistito').val() + "&anno=" + $(this).val();
			});
			
			
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
