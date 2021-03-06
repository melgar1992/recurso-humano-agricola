<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Registro de ingreso de los empleados</h3>
            </div>
        </div>
        <br>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tabla de ingresos</h2>
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
                                <button class="btn btn-success" id='btn-nuevo' type="button" data-toggle="modal" data-target='#modal-form'>Agregar</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Ingresos registrados</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <div class="card-box table-responsive">
                                        <table class="table table-striped table-bordered nowrap" id="tabla" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Fecha</th>
                                                    <th>Empleado</th>
                                                    <th>Contrato</th>
                                                    <th>Detalle</th>
                                                    <th>Horas</th>
                                                    <th>Pago</th>
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

<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulario pago de empleados</h4>
            </div>
            <form action="" id="formulario">
                <div class="modal-body">
                    <p>Los campos con * son obligatorios</p>
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
                        <label for="hora_trabajo" class="control-label">Horas Trabajadas<span class="required">*</span>
                        </label>
                        <div class="has-feedback">
                            <input id="hora_trabajo" class="form-control col-md-7 col-xs-12" type="number" step="0.01" name="hora_trabajo" placeholder="">
                            <span class="form-control-feedback right" aria-hidden="true">Hr</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="debe" class="control-label">Ingreso del empleado<span class="required">*</span>
                        </label>
                        <div class="has-feedback">
                            <input id="debe" class="form-control col-md-7 col-xs-12" type="number" step="0.01" name="debe" required="required" placeholder="">
                            <span class="form-control-feedback right" aria-hidden="true">Bs</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="detalle" class="control-label">Detalle
                        </label>
                        <div class="">
                            <textarea name="detalle" id="detalle" class="form-control" rows="2" placeholder="detalle de pago"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha" class="control-label">Fecha<span class="required">*</span>
                        </label>
                        <div>
                            <input id="fecha" class="form-control col-md-7 col-xs-12" type="date" name="fecha" required="required" placeholder="">
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