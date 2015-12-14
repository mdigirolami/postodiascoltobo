<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";

$anno = (isset($_GET['anno']) ? $_GET['anno'] : date('Y'));
$fasce_banco_alimentare = get_fasce_banco_alimentare($anno);
$stat_banco_alimentare = get_stat_banco_alimentare($anno);
$nome_mese=array("Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre");
?>

<!-- page content -->
            <div class="right_col" role="main">
				<div class="page-title">
					<div class="title_left">
						<h3>Statistiche banco alimentare <h4>(visualizza dati dell'anno 
									<select name="anno" id="anno">
										<?php
											$earliest_year=2014;
											foreach(range(date('Y'), $earliest_year) as $year) {
												echo '<option value="'.$year.'" '.($year == $anno ? " selected=selected" : "").'>'.$year.'</option>';
											}	
										?>
									</select>)</h4></h3>
					</div>
          <!--
					<div class="title_right">
						<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
							<div class="input-group">

							</div>
						</div>
					</div>
        -->
				</div>

                <div class="row">

					<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
								<div class="x_title">
                                    <h2>Assistiti per fasce d'età (almeno un pacco ritirato nel <?php echo $anno;?>)</h2>
                                    <div class="clearfix"></div>
                                </div>
								<div class="x_content">
                                    <table class="table table-striped responsive-utilities jambo_table">
										<thead>
												<tr class="headings">
														<th>Fascia d'età</th>
														<th>Numero assistiti</th>
												</tr>
										</thead>
									  <tbody>
									<?php
									foreach ($fasce_banco_alimentare as $key => $value) {
										echo '<tr class="even pointer">';
										echo '<td class=" ">'.$key.'</td>';
										echo '<td class=" ">'.$value.'</td>';
										echo '</tr>';
									}
									?>
									   </tbody>
								    </table>
                                </div>
								<br />
							
                                <div class="x_title">
                                    <h2>Distribuzione pacchi per mese</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table table-striped responsive-utilities jambo_table">
										<thead>
												<tr class="headings">
														<th>Mese</th>
														<th>Pacchi consegnati</th>
												</tr>
										</thead>
									  <tbody>
									<?php
									foreach ($stat_banco_alimentare as $stat) {
										echo '<tr class="even pointer">';
										echo '<td class=" ">'.$nome_mese[$stat["mese"]-1].'</td>';
										echo '<td class=" ">'.$stat["pacchi"].'</td>';
										echo '</tr>';
									}
									?>
									   </tbody>
								    </table>
                                </div>
                            </div>
                        </div>

                        <br />
                        <br />
                        <br />

                    </div>
                </div>

<!-- Datatables -->

        <script src="js/datatables/js/jquery.dataTables.js"></script>
        <!--<script src="js/datatables/tools/js/dataTables.tableTools.js"></script>-->
        <script>
            $(document).ready(function () {
				$('#anno').change(function() {
					window.location = "stat_banco_alimentare.php?anno=" + $(this).val();
				});
				
                $('input.tableflat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
            });

            var asInitVals = new Array();
            $(document).ready(function () {
                var oTable = $('#example').dataTable({
                    "oLanguage": {
                        "sSearch": "Cerca su tutte le colonne:"
                    },
                    "aoColumnDefs": [
                        {
                            'bSortable': false,
                            'aTargets': [0]
                        } //disables sorting for column one
            ],
                    'iDisplayLength': 10,
                    "sPaginationType": "full_numbers",
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "<?php //echo base_url('assets2/js/Datatables/tools/swf/copy_csv_xls_pdf.swf'); ?>"
                    }
                });
                $("tfoot input").keyup(function () {
                    /* Filter on the column based on the index of this element's parent <th> */
                    oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
                });
                $("tfoot input").each(function (i) {
                    asInitVals[i] = this.value;
                });
                $("tfoot input").focus(function () {
                    if (this.className == "search_init") {
                        this.className = "";
                        this.value = "";
                    }
                });
                $("tfoot input").blur(function (i) {
                    if (this.value == "") {
                        this.className = "search_init";
                        this.value = asInitVals[$("tfoot input").index(this)];
                    }
                });
            });
        </script>
		

<?php
include "footer.php";
?>