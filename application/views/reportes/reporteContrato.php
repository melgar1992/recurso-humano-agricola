<div class="row">
    <div class="col-xs-12 text-left">
        <b>Balance de contrato</b><br>
        Nombre : <?php echo $contrato['nombre_completo']; ?> <br>
        CI : <?php echo $contrato['ci']; ?><br>
        Fecha : <?php echo date('Y-m-d'); ?><br>
        Cargo : <?php echo $contrato['cargo_nombre']; ?><br>
        Horas normales : <?php echo $contrato['sueldo_hora']; ?> Bs<br>
        Horas Extras : <?php echo $contrato['hora_extra']; ?> Bs<br>
        Hora Feriado : <?php echo $contrato['hora_feriada']; ?> Bs<br>

    </div>
</div>
<br>
</br>
<div class="row">
    <div class="col-lg-6 col-md-6 col-xs-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th COLSPAN="3">
                        <h4>Ingresos</h4>
                    </th>
                </tr>
                <tr>
                    <th width=>Detalle</th>
                    <th width=>Dia trabajados</th>
                    <th width=>Ingresos Bs</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Dias Trabajadas</td>
                    <td><?php echo number_format($ingresosAsistenciaContrato['horaNormal'] / 8, 2)  ?></td>
                    <td ALIGN="center"><?php echo number_format($ingresosAsistenciaContrato['TotalHoraNormal'], 2)?> Bs</td>
                </tr>
                <tr>
                    <td>Horas Extras</td>
                    <td><?php echo number_format($ingresosAsistenciaContrato['horaExtras'],2)  ?></td>
                    <td ALIGN="center"><?php echo number_format($ingresosAsistenciaContrato['TotalHoraExtra'], 2) ?> Bs</td>
                </tr>
                <tr>
                    <td>Horas Feriados</td>
                    <td><?php echo number_format($ingresosAsistenciaContrato['horaFeriado'], 2)  ?></td>
                    <td ALIGN="center"><?php echo number_format($ingresosAsistenciaContrato['TotalHoraFeriado'], 2) ?> Bs</td>
                </tr>
                <?php
                $sumIngresoDirecto = 0;
                if (count($ingresosDirectoContrato) > 0) {
                    foreach ($ingresosDirectoContrato as $row) {
                        $sumIngresoDirecto = $sumIngresoDirecto +  $row['debe'];
                ?>
                        <tr>
                            <td><?php echo $row['detalle'] ?></td>
                            <td><?php echo $row['hora_trabajo'] ?></td>
                            <td ALIGN="center"><?php echo number_format($row['debe'], 2) ?> Bs</td>

                        </tr>
                <?php }
                }

                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total de Ingresos</td>
                    <td ALIGN="center"><?php echo number_format(($ingresosAsistenciaContrato['totalGanado'] + $sumIngresoDirecto), 2) ?> Bs</td>
                </tr>
            </tfoot>

        </table>
    </div>
    <div class="col-lg-6 col-md-6 col-xs-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th COLSPAN="3">
                        <h4>Egresos</h4>
                    </th>
                </tr>
                <tr>
                    <th width=>Detalle</th>
                    <th width=>fecha</th>
                    <th width=>Egreso Bs</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $pagosContratoDirecto = 0;
                if (count($pagosContrato) > 0) {
                    foreach ($pagosContrato as $row) {
                        $pagosContratoDirecto = $pagosContratoDirecto +  $row['haber'];
                ?>
                        <tr>
                            <td><?php echo $row['detalle'] ?></td>
                            <td><?php echo $row['fecha'] ?></td>
                            <td ALIGN="center"><?php echo number_format($row['haber'], 2) ?> Bs</td>

                        </tr>
                <?php }
                }

                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total de Egresos</td>
                    <td ALIGN="center"><?php echo number_format(($pagosContratoDirecto), 2) ?> Bs</td>
                </tr>
            </tfoot>

        </table>
    </div>

</div>
<br>
<hr>
<div class="row">
    <div class="col-xs-12 text-left">
        <h4>Balance : <?php echo (($ingresosAsistenciaContrato['totalGanado'] + $sumIngresoDirecto) - $pagosContratoDirecto) ?> Bs</h4><br>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-6 col-md-6 col-xs-6 text-center">
        <p>- - - - - - - - - - - - - - -</p><br>
        <p>Recibi conforme</p>
    </div>
    <div class="col-lg-6 col-md-6 col-xs-6 text-center">
        <p>- - - - - - - - - - - - - - -</p><br>
        <p>Entregue conforme</p>
    </div>
</div>