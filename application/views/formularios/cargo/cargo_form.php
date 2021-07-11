<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Formulario Cargo</h3>
            </div>
        </div>
        <br>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tabla de cargos de la empresa</h2>
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
                                    <h2>Cargos registrados</h2>
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
                                                    <th>Nombre</th>
                                                    <th>Tipo pago</th>
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
                        <label class="control-label" for="nombre">Nombre del cargo <span class="required">*</span>
                        </label>
                        <div class="">
                            <input type="text" id="nombre" onkeyup="mayus(this);" minlength="0" maxlength="45" name="nombre" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo_pago" class="control-label">Tipo pago *:</label>
                        <div class="">
                            <select id="tipo_pago" name="tipo_pago" class="form-control" required>
                                <option value=""></option>
                                <option value="Mensual">Mensual</option>
                                <option value="Hora">Hora</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sueldo" class="control-label">sueldo<span class="required">*</span>
                        </label>
                        <div class="has-feedback">
                            <input id="sueldo" class="form-control has-feedback col-md-7 col-xs-12" type="number" step="0.01" name="sueldo" required="required" placeholder="">
                            <span class="form-control-feedback right" aria-hidden="true">Bs</span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="sueldo_hora" class="control-label">hora<span class="required">*</span>
                        </label>
                        <div class="has-feedback">
                            <input id="sueldo_hora" class="form-control col-md-7 col-xs-12" type="number" step="0.01" name="sueldo_hora" required="required" placeholder="">
                            <span class="form-control-feedback right" aria-hidden="true">Bs</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hora_extra" class="control-label">hora extra<span class="required">*</span>
                        </label>
                        <div class="has-feedback">
                            <input id="hora_extra" class="form-control col-md-7 col-xs-12" type="number" step="0.01" name="hora_extra" required="required" placeholder="">
                            <span class="form-control-feedback right" aria-hidden="true">Bs</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hora_feriada" class="control-label">hora feriada<span class="required">*</span>
                        </label>
                        <div class="has-feedback">
                            <input id="hora_feriada" class="form-control col-md-7 col-xs-12" type="number" step="0.01" name="hora_feriada" required="required" placeholder="">
                            <span class="form-control-feedback right" aria-hidden="true">Bs</span>
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