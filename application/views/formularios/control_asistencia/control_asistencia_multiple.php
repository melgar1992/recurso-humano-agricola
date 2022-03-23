<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Formulario Asistencia multiple</h3>
            </div>
        </div>
        <br>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <form action="" method="" class="formasistencia" name="formasistencia" id="formasistencia">
                            <p>Los campos con * son obligatorios</p>
                            <div class="error_formulario">
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <label for="empleado" class="control-label">Empleado contrato *:</label>
                                            <select id="empleado" name="empleado" class="form-control" required>
                                                <option value=""></option>
                                                <?php foreach ($contratos as $row) : ?>
                                                    <option value="<?php echo $row['id_contrato'] . '.' . $row['nombre_completo'] . '.' . $row['cargo_nombre'];   ?>"><?php echo $row['nombre_completo']
                                                                                                                                                                            . ' Cargo: ' . $row['cargo_nombre']; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label" for="fecha">Fecha <span class="required">*</span>
                                        </label>
                                        <div class="">
                                            <input type="date" id="fecha" name="fecha" required="required" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <label for="agregar">&nbsp;</label>
                                        <button id="btn-agregar" type="button" class="btn btn-success btn-flat btn-block"><span class="fa fa-plus">Agregar</span></button>
                                    </div>
                                </div>
                            </div>

                            <br></br>
                            <table id="tablaAsistencia" class="table table-bordered table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
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
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning pull-left" id="btn-volver" onclick="window.location.href='<?php echo base_url(); ?>ControlAsistencia'">volver</button>
                                <button type="submit" class="btn btn-success pull-right" id="btn-guardar">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>