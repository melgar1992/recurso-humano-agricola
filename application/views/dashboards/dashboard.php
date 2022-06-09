<?php if ($this->session->userdata('permisos')['dashboard'] == '1') { ?>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Dashboard</h3>
                </div>
            </div>
            <br>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="" role="main">
                                <div class="row tile_count">
                                    <div class="tile_count">
                                        <div class="col-md-4 col-sm-12  tile_stats_count">
                                            <span class="count_top"><i class="fa fa-user"></i> Total empleados activos</span>
                                            <div class="count"><?php echo count($contratosVigentes) ?></div>
                                        </div>
                                        <div class="col-md-4 col-sm-12  tile_stats_count">
                                            <span class="count_top"><i class="fa fa-clock-o"></i> Horas trabajadas personal</span>
                                            <div class="count"><?php echo $BalanceEmpleados['hora_jornada']  + $BalanceEmpleados['horaFeriado'] ?></div>
                                        </div>
                                        <div class="col-md-4 col-sm-12  tile_stats_count">
                                            <span class="count_top"><i class="fa fa-user"></i> Total</span>
                                            <div class="count red"><?php echo $BalanceEmpleados['totalGanado'] ?> Bs</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Balance de empleados por contrato</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <form action="" id="reporte-contrato">
                                                    <div class="form-group">
                                                        <label for="id_contrato" class="col-md-1 col-xs-12 control-label text-right">Contrato: </label>
                                                        <div class="col-md-2 col-xs-12">
                                                            <select name="id_contrato" id="id_contrato" class="form-control" required>
                                                                <option value=""></option>
                                                                <?php foreach ($contratos as $row) : ?>
                                                                    <option value="<?php echo $row['id_contrato'] ?>"><?php echo $row['nombre_completo']
                                                                                                                            . ' Cargo: ' . $row['cargo_nombre']
                                                                                                                            . ' Hora: ' . $row['sueldo_hora'] . ' Bs'; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <label for="fechaIni" class="col-md-1 col-xs-12 control-label text-right">Desde: </label>
                                                        <div class="col-md-2 col-xs-12">
                                                            <input type="date" name="fechaIni" id="fechaIni" class="form-control" required>
                                                        </div>
                                                        <label for="fechaFin" class="col-md-1 col-xs-12 control-label text-right">Hasta: </label>
                                                        <div class="col-md-2 col-xs-12">
                                                            <input type="date" name="fechaFin" id="fechaFin" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-2 col-xs-12">
                                                            <button type="submit" data-toggle="modal" data-target="#modal-detalle" class="btn btn-block btn-success">Generar</button>
                                                        </div>
                                                    </div>
                                                    <br></br>
                                                </form>
                                                <hr style="border:2px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-bars"></i> Tablas de informacion general </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="display: none;">
                        <div class="row">
                            <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link" id="ControlAsistencia-tab" data-toggle="tab" href="#ControlAsistencia" role="tab" aria-controls="ControlAsistencia" aria-expanded="true">Control Asistencia</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Empleados-tab" data-toggle="tab" href="#Empleados" role="tab" aria-controls="Empleados" aria-expanded="false">Empleados activos</a>
                                </li>
                                <!-- <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                            </li> -->
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active in" id="ControlAsistencia" role="tabpanel" aria-labelledby="ControlAsistencia-tab">
                                    <div class="card-box table-responsive">
                                        <table id="tablaHorasMes" class="table table-bordered jambo_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Empleado</th>
                                                    <th>Carnet</th>
                                                    <th>Horas Trabajadas</th>
                                                    <th>Mes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class=" tab-pane fade" id="Empleados" role="tabpanel" aria-labelledby="Empleados-tab">
                                    <div class="card-box table-responsive">
                                        <table id="tablaEmpleadosActivos" class="table table-bordered jambo_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Empleado</th>
                                                    <th>Cargo</th>
                                                    <th>sueldo</th>
                                                    <th>Hora</th>
                                                    <th>Hora extra</th>
                                                    <th>Hora feriada</th>
                                                    <th>Pago</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                                booth letterpress, commodo enim craft beer mlkshk
                            </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-detalle">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reporte</h4>
                </div>
                <div class="modal-body ui-front">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-print"><span class="fa fa-print">Imprimir</span></button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <!-- /.modal -->
<?php } else { ?>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Dashboard</h3>
                </div>
            </div>
            <br>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php }; ?>