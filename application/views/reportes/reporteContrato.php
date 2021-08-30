<div class="row">
    <div class="col-xs-12 text-left">
        <b>Balance de contrato</b><br>
        Nombre : <?php echo $contrato['nombre_completo']; ?> <br>
        CI : <?php echo $contrato['ci']; ?><br>
        Fecha : <?php echo date('Y-m-d'); ?><br>
    </div>
</div>
<br>
</br>
<div class="row">
    <div class="col-lg-6 col-md-6 col-xs-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="20%">Detalle</th>
                    <th width="60%">Horas</th>
                    <th width="20%">Ingresos Bs</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (count($pago_empleado) > 0) {
                    foreach ($pago_empleado as $row) {
                        $fecha = new DateTime($row['Fecha']);
                ?>
                        <tr>
                            <td><?php echo date_format($fecha, 'Y-M-d') ?></td>
                            <td><?php echo $row['Descripcion'] ?></td>
                            <td ALIGN="center"><?php echo number_format($row['Monto'], 2) ?></td>

                        </tr>
                <?php }
                }

                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total de Ingresos</td>
                    <td><?php ?> Bs</td>
                </tr>
            </tfoot>

        </table>
    </div>
</div>