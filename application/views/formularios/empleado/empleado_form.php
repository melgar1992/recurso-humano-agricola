<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Formulario Empleado</h3>
            </div>
        </div>
        <br>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tabla de empleados</h2>
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
                                <button class="btn btn-success" id='btn-nuevo' type="button" data-toggle="modal" data-target='#modal-empleados'>Agregar</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Empleados registrados</h2>
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
                                                    <th>CI</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos </th>
                                                    <th>Teléfono 01</th>
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

<div class="modal fade" id="modal-empleados">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulario empleado</h4>
            </div>
            <form action="" id="formEmpleados">
                <div class="modal-body">
                    <p>Los campos con * son obligatorios</p>
                    <div class="error_formulario">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="ci">ci
                        </label>
                        <div class="">
                            <input type="number" id="ci" maxlength="8" oninput="this.value=this.value.slice(0,this.maxLength)" name="ci" class="form-control col-md-7 col-xs-12" placeholder="Número de Carnet de Identidad">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="nombres">Nombres <span class="required">*</span>
                        </label>
                        <div class="">
                            <input type="text" id="nombres" onkeyup="mayus(this);" minlength="0" maxlength="45" name="nombres" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="apellidos">Apellidos <span class="required">*</span>
                        </label>
                        <div class="">
                            <input type="text" minlength="0" onkeyup="mayus(this);" maxlength="45" id="apellidos" name="apellidos" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="control-label">Telefono<span class="required">*</span>
                        </label>
                        <div class="">
                            <input id="telefono" maxlength="8" oninput="this.value=this.value.slice(0,this.maxLength)" class="form-control col-md-7 col-xs-12" type="number" name="telefono" required="required" placeholder="77800975-34622503">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="control-label">Dirección
                        </label>
                        <div class="">
                            <textarea name="direccion" id="direccion" class="form-control" rows="2" placeholder="Dirección"></textarea>
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