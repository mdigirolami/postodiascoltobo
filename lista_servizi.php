<?php
require_once "config.php";
require_once "functions.php";

include "header.php";
include "menu.php";
include "top_nav.php";

$servizi = get_servizi();
?>

<!-- page content -->
            <div class="right_col" role="main">
				<div class="page-title">
					<div class="title_left">
						<h3>Lista servizi</h3>
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
                                    <h2>Servizi erogati</h2>
                                    <!--
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a href="#"><i class="fa fa-chevron-up"></i></a>
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
                                        <li><a href="#"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
									-->
                                    <div class="clearfix"></div>
                                    
                                </div>

                                <div class="x_content">
                                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                                        <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" class="tableflat">
                                                </th>
                                                <th>Tipo</th>
                                                <th>Destinatario</th>
                                                <th>Data</th>
                                                <th class=" no-link last"><span class="nobr">Azione</span>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
										    <?php
												foreach ($servizi as $a) {
													echo '<tr class=""even pointer">';
													echo '<td class="a-center "><input type="checkbox" class="tableflat"></td>';
													echo '<td class=" ">'.$a["tipo"].'</td>';
													echo '<td class=" ">'.$a["cognome"]." ".$a["nome"].'</td>';
													echo '<td class=" ">'.$a["data"].'</td>';
													echo '<td class=" ">
                            <a href="dettagli_servizio.php?id_servizio='.$a["id_servizio_erogato"].'" title="Dettagli servizio"><span class="glyphicon glyphicon-assistiti-actions glyphicon-file" aria-hidden="true"></span></a>&nbsp;
                            <a href="servizi_assistito.php?id_assistito='.$a["id_assistito"].'" title="Servizi assistito '.$a["cognome"]." ".$a["nome"].'"><span class="glyphicon glyphicon-assistiti-actions glyphicon-edit" aria-hidden="true"></span></a>&nbsp;
							<a href="rimuovi_servizio.php?id_servizio='.$a["id_servizio_erogato"].'" title="Rimuovi servizio" onclick="return confirm(\'Si sta per rimuovere il servizio '.$a["tipo"].' per '.$a["cognome"].' '.$a["nome"].'. I dati relativi al servizio non saranno più disponibili. Proseguire?\');"><span class="glyphicon glyphicon-assistiti-actions glyphicon-remove-circle" aria-hidden="true"></span></a>
                            </td>';
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