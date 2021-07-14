<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Formulario Contrato</h3>
            </div>
        </div>
        <br>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tabla de contratos de la empresa</h2>
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
                                <button class="btn btn-success" id='btn-nuevo' type="button" data-toggle="modal" data-target='#modal-cargo'>Agregar</button>
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
                                        <table class="table table-striped table-bordered nowrap" id="tablaEmpleados" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Ci</th>
                                                    <th>Empleado</th>
                                                    <th>Contrato</th>
                                                    <th>Sueldo mensual</th>
                                                    <th>Sueldo Hora</th>
                                                    <th>Hora extra</th>
                                                    <th>Hora feriada</th>
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

<div class="modal fade" id="modal-cargo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulario empleado</h4>
            </div>
            <form action="" id="formCargo">
                <div class="modal-body">
                    <p>Los campos con * son obligatorios</p>
                    <div class="error_formulario">
                    </div>
                    <div class="form-group">
                        <label for="id_empleado" class="control-label">Empleado *:</label>
                        <div class="">
                            <select id="id_empleado" name="id_empleado" class="form-control" required>
                                <option value=""></option>
                                <?php foreach ($empleados as $row) : ?>
                                    <option value="<?php echo $row['id_empleado'] ?>"><?php echo $row['apellidos'] . ' ' . $row['nombres']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_cargo" class="control-label">Cargo *:</label>
                        <div class="">
                            <select id="id_cargo" name="id_cargo" class="form-control" required>
                                <option value=""></option>
                                <?php foreach ($cargos as $row) : ?>
                                    <option value="<?php echo $row['id_cargo'] ?>"><?php echo $row['nombre'] . ' sueldo: ' . $row['sueldo_mensual'] . 'Bs hora: ' . $row['sueldo_hora'] . 'Bs'; ?></option>
                                <?php endforeach; ?>
                            </select>
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