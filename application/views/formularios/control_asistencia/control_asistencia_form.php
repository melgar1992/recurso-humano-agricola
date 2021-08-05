<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Formulario Asistencia</h3>
            </div>
        </div>
        <br>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tabla de Asistencia de la empresa</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <button class="btn btn-success" id='btn-nuevo' type="button" data-toggle="modal" data-target='#modal-asistencia'>Agregar</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Contrato registrados</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="card-box table-responsive">
                                        <table class="table table-striped table-bordered nowrap" id="tablaAsistencia" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Empleado</th>
                                                    <th>Cargo</th>
                                                    <th>Fecha Hora entrada</th>
                                                    <th>Fecha Hora salida</th>
                                                    <th>Observaciones</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Tabla responsiva-->
                                </div>
                                <!-- contenedor Tabla -->
                            </div>
                        </div>
                        <!-- Contenedor de toda la tabla -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-asistencia">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulario empleado</h4>
            </div>
            <form action="" id="formasistencia">
                <div class="modal-body">
                    <p>Los campos con * son obligatorios</p>
                    <div class="error_formulario">
                    </div>
                    <div class="form-group">
                        <label for="id_contrato" class="control-label">Empleado contrato *:</label>
                        <div class="">
                            <select id="id_contrato" name="id_contrato" class="form-control" required>
                                <option value=""></option>
                                <?php foreach ($contratos as $row) : ?>
                                    <option value="<?php echo $row['id_contrato'] ?>"><?php echo $row['nombre_completo']
                                                                                            . ' Cargo: ' . $row['cargo_nombre']
                                                                                            . ' Hora: ' . $row['sueldo_hora'] . ' Bs'; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="fecha_hora_ingreso">Fecha hora ingreso <span class="required">*</span>
                        </label>
                        <div class="">
                            <input type="datetime-local" id="fecha_hora_ingreso" name="fecha_hora_ingreso" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="fecha_hora_salida">Fecha hora salida <span class="required">*</span>
                        </label>
                        <div class="">
                            <input type="datetime-local" id="fecha_hora_salida" name="fecha_hora_salida" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="observaciones" class="control-label">Observaciones
                        </label>
                        <div class="">
                            <textarea name="observaciones" id="observaciones" class="form-control" rows="2" placeholder="Observaciones en el trabajo"></textarea>
                        </div>
                    </div>

                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" id="btn-cerrar" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary pull-right" type="reset">Borrar</button>
                    <button type="submit" class="btn btn-success pull-right" id="btn-guardar">Guardar</button>
                </div>
            </form>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->