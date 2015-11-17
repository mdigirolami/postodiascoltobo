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
	
	$anno = (isset($_GET['anno']) ? $_GET['anno'] : date('Y'));
//	$scuole = get_scuole($anno);
    $elenco_nazioni = get_elenco_nazioni();
	$familiari_assistito_array = get_scuole($anno);
	
?>

<!-- page content -->
            <div class="right_col" role="main">
				<div class="page-title">
					<div class="title_left">
						<h3>Gestione scuole</h3>
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
								<h2>Partecipanti per nazione e sesso<small>(visualizza dati dell'anno 
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

								<form action="aggiorna_scuole.php" method="post" class="form-horizontal form-label-left" novalidate>
									<input type="hidden" name="action" value="aggiorna" />
									<input type="hidden" name="anno" value="<?php echo $anno;?>" />
									<span class="section">Anno <?php echo $anno; ?></span>
									
									<?php
//echo strftime("%A %d %B %Y");
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Gruppo <?php echo ($i+1);?> </label>
						
						<div class="col-md-2 col-sm-2 col-xs-6">
											<select id="nazionalita" name="nazionalita_<?php echo $i;?>" class="select2_single form-control" tabindex="-1">
												<option value="">Nazionalità</option>
                        <?php
                          foreach ($elenco_nazioni as $key=>$nazione) {
                            if ($nazione[id]==$familiare["id_nazionalita"]) $is_selected_html = "selected";
                            else $is_selected_html = "";
                            echo '<option value="'.$nazione[id].'" '.$is_selected_html.' >'.$nazione[nome].'</option>';
                          }
                        ?>
                       
											</select>
						</div>
						
						
                        <div class="col-md-2 col-sm-2 col-xs-6" style="text-align:center;">
                            <p style="margin-top:5px;">
								M:
								<input type="radio" class="flat" name="sesso_<?php echo $i;?>" id="sessoM" value="M" <?php if ($familiare["sesso"]==M) echo("checked");?> /> F:
								<input type="radio" class="flat" name="sesso_<?php echo $i;?>" id="sessoF" value="F" <?php if ($familiare["sesso"]==F) echo("checked");?>/>
							</p>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                          <input id="numero_<?php echo $i;?>" name="numero_<?php echo $i;?>" class="form-control col-md-7 col-xs-12" placeholder="Numero" value="<?php echo $familiare["numero"];?>">
                        </div>
                        <?php
                        if ($i==count($familiari_assistito_array))
                        {
                        ?>
                          <div>
                            <button class="btn btn-primary button_remove_familiare" type="button" id="button_remove_familiare_<?php echo $i;?>" style="display:none;">X</button>
                          </div>
                          <div>
                            <button class="btn btn-primary button_familiare" type="button" id="button_familiare_<?php echo $i;?>">Aggiungi gruppo</button>
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


<!-- page content -->
	   <!-- /datepicker -->
    <script type="text/javascript">
	
				$(document).on('click', '.button_familiare', function (event) {
//				alert(event.target.id);
				$('#'+event.target.id+'').hide();
				//idx_familiare_clicked = parseInt(event.target.id.slice(-1));
        idx_familiare_clicked = parseInt(event.target.id.substring(event.target.id.lastIndexOf('_') + 1));
        idx_new_familiare = idx_familiare_clicked +1;
//				alert(number);

				options= "";
				$("#nazionalita").find('option').each(function()
				{
					options = options + '<option value="' + $(this).val() + '">' + $(this).text() + '</option>';
				});

				new_html='<div class="item form-group" id="familiare_input_'+idx_new_familiare+'">' +
                    '<input type="hidden" name="familiare_'+idx_new_familiare+'_pk"/>' +
										'<label class="control-label col-md-3 col-sm-3 col-xs-12">Gruppo '+(idx_new_familiare+1)+' </label>' +
										'<div class="col-md-2 col-sm-2 col-xs-6">' +
											'<select id="nazionalita" name="nazionalita_'+idx_new_familiare+'" class="select2_single form-control" tabindex="-1">' +
												options +
											'</select>' +
										'</div>' +	
										'<div class="col-md-2 col-sm-2 col-xs-6" style="text-align:center;">' +
										'<p style="margin-top:5px;">' +
											'M: <input type="radio" class="flat" name="sesso_'+idx_new_familiare+'" id="sessoM" value="M"/>' +
											'F: <input type="radio" class="flat" name="sesso_'+idx_new_familiare+'" id="sessoF" value="F" />' +
										'</p></div>' +
										'<div class="col-md-2 col-sm-2 col-xs-6">' +
											'<input id="numero_'+idx_new_familiare+'" name="numero_'+idx_new_familiare+'" class="form-control col-md-7 col-xs-12" placeholder="Numero" >' +
										'</div>' +
                    '<div>' +
                      '<button class="btn btn-primary button_remove_familiare" type="button" id="button_remove_familiare_'+idx_new_familiare+'" style="display:none;">X</button>' +
                    '</div>'+
										'<div>' +
											'<button class="btn btn-primary button_familiare" type="button" id="button_familiare_'+idx_new_familiare+'">Aggiungi gruppo</button>' +
										'</div>' +
									'</div>';
				$('#familiari').append(new_html);
/*				
$('input[type="radio"].flat').iCheck({
       checkboxClass: 'icheckbox_minimal-red',
         radioClass: 'iradio_minimal-red',
         increaseArea: '10%' // optional
     });				
*/
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
	
	
        $(document).ready(function () {
			$('#anno').change(function() {
				window.location = "scuole.php?anno=" + $(this).val();
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
