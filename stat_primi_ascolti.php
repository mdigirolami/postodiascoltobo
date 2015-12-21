<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";

$anno = (isset($_GET['anno']) ? $_GET['anno'] : date('Y'));
$assistiti_list = get_assistiti_list($anno, true);

if (sizeof($assistiti_list)>0) {
	$fasce_assistiti = get_fasce_assistiti($anno, $assistiti_list);
	foreach ($fasce_assistiti as $key => $value) {
		if (substr($key, 0, 1)=='M') {
			$fasce[substr($key, 2)]['maschi'] = $value;
		} else if (substr($key, 0, 1)=='F') {
			$fasce[substr($key, 2)]['femmine'] = $value;
		}	
	}
	$stat_assistiti_nazionalita = get_stat_assistiti_nazionalita($anno, $assistiti_list);
	$stat_assistiti_nuclei = get_stat_assistiti_nuclei($anno, $assistiti_list);
}
?>

<!-- page content -->
            <div class="right_col" role="main">
				<div class="page-title">
					<div class="title_left" style="width:100%;">
						<h3>Statistiche sugli assistiti <h4>(visualizza assistiti con almeno un servizio ricevuto nell'anno 
									<select name="anno" id="anno">
										<?php
											$earliest_year=2014;
											foreach(range(date('Y'), $earliest_year) as $year) {
												echo '<option value="'.$year.'" '.($year == $anno ? " selected=selected" : "").'>'.$year.'</option>';
											}	
										?>
									</select>)</h4></h3>
					</div>
				</div>

				<div class="x_content" style="height:46px;">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class=""><a href="stat_assistiti.php?anno=<?php echo $anno; ?>" id="assistiti-tab" aria-expanded="true">Tutti gli assistiti</a>
							</li>
							<li role="presentation" class="active"><a href="stat_primi_ascolti.php?anno=<?php echo $anno; ?>" id="primi-ascolti-tab" aria-expanded="false">Primi ascolti</a>
							</li>
						</ul>
					</div>
				</div>
				
                <div class="row">

					<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
								<?php
									if (sizeof($assistiti_list)>0) { 
								?>
								<div class="x_title">
                                    <h2>Assistiti per fasce d'età</h2>
                                    <div class="clearfix"></div>
                                </div>
								<div class="x_content">
                                    <table class="table table-striped responsive-utilities jambo_table">
										<thead>
												<tr class="headings">
														<th>Fascia d'età</th>
														<th>Totale</th>
														<th>Maschi</th>
														<th>Femmine</th>
												</tr>
										</thead>
									  <tbody>
									<?php
									foreach ($fasce as $key => $value) {
										$totale=$value['maschi']+$value['femmine'];
										$tot_maschi+=$value['maschi'];
										$tot_femmine+=$value['femmine'];
										$tot_totale+=$totale;
										echo '<tr class="even pointer">';
										echo '<td class=" ">'.$key.'</td>';
										echo '<td class=" ">'.$totale.'</td>';
										echo '<td class=" ">'.$value['maschi'].'</td>';
										echo '<td class=" ">'.$value['femmine'].'</td>';
										echo '</tr>';
										
									}
									echo '<tr class="even pointer" style="font-weight:bold;">';
									echo '<td class=" ">Totale</td>';
									echo '<td class=" ">'.$tot_totale.'</td>';
									echo '<td class=" ">'.$tot_maschi.'</td>';
									echo '<td class=" ">'.$tot_femmine.'</td>';
									echo '</tr>';
									?>
										
									   </tbody>
								    </table>
                                </div>
								<br />
							
                                <div class="x_title">
                                    <h2>Assistiti per nazionalità</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table table-striped responsive-utilities jambo_table">
										<thead>
												<tr class="headings">
														<th>Nazionalità</th>
														<th>Numero assistiti</th>
												</tr>
										</thead>
									  <tbody>
									<?php
									foreach ($stat_assistiti_nazionalita as $stat) {
										echo '<tr class="even pointer">';
										echo '<td class=" ">'.$stat["nazionalita"].'</td>';
										echo '<td class=" ">'.$stat["num_assistiti"].'</td>';
										echo '</tr>';
									}
									?>
									   </tbody>
								    </table>
                                </div>
								<br />
								
								<div class="x_title">
                                    <h2>Nuclei familiari assistiti per numero di componenti</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table table-striped responsive-utilities jambo_table">
										<thead>
												<tr class="headings">
														<th>Componenti nucleo</th>
														<th>Numero nuclei</th>
												</tr>
										</thead>
									  <tbody>
									<?php
									foreach ($stat_assistiti_nuclei as $stat) {
										echo '<tr class="even pointer">';
										echo '<td class=" ">'.$stat["componenti"].'</td>';
										echo '<td class=" ">'.$stat["occorrenze"].'</td>';
										echo '</tr>';
									}
									?>
									   </tbody>
								    </table>
                                </div>
                            </div>
							<?php
								} else { 
									echo "<div>Non risultano primi ascolti con almeno un servizio ricevuto nell'anno ".$anno."</div>";
								}	
							?>
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
					window.location = "stat_primi_ascolti.php?anno=" + $(this).val();
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