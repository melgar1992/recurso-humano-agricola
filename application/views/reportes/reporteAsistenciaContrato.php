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
<?php $sumaIngresos = 0; ?>
<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width=>Fecha</th>
                <th width=>Horas Trabajadas</th>
                <th width=>Horas Normal</th>
                <th width=>Horas Extras</th>
                <th width=>Horas Feriadas</th>
                <th width=>Ingresos Bs</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($asistencia as $row) { ?>
                <tr>
                    <td><?php echo $row['fecha'] ?></td>
                    <td><?php echo $row['hora_jornada'] ?></td>
                    <td><?php echo $row['horaNormal'] ?></td>
                    <td><?php echo $row['horaExtras'] ?></td>
                    <td><?php echo $row['horaFeriado'] ?></td>
                    <td ALIGN="center"><?php echo number_format($row['porPagarNormal'] + $row['porPagarHoraExtra'] + $row['porPagarFeriado'], 2) ?> Bs</td>
                    <?php $sumaIngresos += $row['porPagarNormal'] + $row['porPagarHoraExtra'] + $row['porPagarFeriado']; ?>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">Total de Ingresos</td>
                <td ALIGN="center"><?php echo number_format(($sumaIngresos), 2) ?> Bs</td>
            </tr>
        </tfoot>

    </table>
</div>