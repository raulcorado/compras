<?php
include 'secure.php';
include 'conection.php';

if (isset($_GET[id])) {
//    if ($_GET[id] != $_SESSION['userid']) {
//        if ($_SESSION['username'] != 'admin') {
//            header("Location: users.php");
//        }
//    }
    $query = "select * from pagos where id = $_GET[id] "
            . " and deptoid =" . $_SESSION['deptoid'];
    $result = mysqli_query($link, $query);
    if (!$result) {
        echo mysqli_error();
    }
    $row = mysqli_fetch_row($result);
}



if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $userid = $_SESSION['userid'];
    $reqpor = $_POST['reqpor'];
    $deptoid = $_SESSION['deptoid']; //$_POST['deptoid'];
    $monto = $_POST['monto'];
    $moneda = $_POST['moneda'];
    $iva = $_POST['iva'];
    //$inguat = $_POST['inguat'];
    //$combustible = $_POST['combustible'];
    $totalpagoq = $_POST['totalpagoq'];
    //$totalpagox = $_POST['totalpagox'];
    $paguesea = $_POST['paguesea'];
    $just = $_POST['just'];
    $infoad = $_POST['infoad'];
    $epepid = $_POST['epepid'];
    $ccostid = $_POST['ccostid'];
    $cmayorid = $_POST['cmayorid'];
    $metodopagoid = $_POST['metodopagoid'];
    $ordencomp = $_POST['ordencomp'];
    $recepbienes = $_POST['recepbienes'];
    if (isset($_POST['aceptar'])) {
        $query = "update pagos set userid='$userid', reqpor='$reqpor', monto='$monto', moneda='$moneda', iva='$iva', totalpagoq='$totalpagoq', paguesea='$paguesea', just='$just', infoad='$infoad', epepid='$epepid', ccostid='$ccostid', cmayorid='$cmayorid', metodopagoid='$metodopagoid', ordencomp='$ordencomp', recepbienes='$recepbienes'"
                . " where  id=$id";
    } else if (isset($_POST['duplicar'])) {
        $query = "insert into pagos"
                . "(userid,     reqpor,     deptoid,    monto,   moneda,    iva,     inguat,    combustible, totalpagoq,    totalpagox, paguesea,    just,    infoad,    epepid,    ccostid,    cmayorid,   metodopagoid,      ordencomp,    recepbienes) values "
                . "('$userid', '$reqpor', '$deptoid', '$monto', '$moneda', '$iva',   '0.00',    '0.00',      '$totalpagoq', '0.00',     '$paguesea', '$just', '$infoad', '$epepid', '$ccostid', '$cmayorid', '$metodopagoid', '$ordencomp', '$recepbienes')";
    }
    $result = mysqli_query($link, $query);

    header("Location: pagos.php");
}


if (isset($_POST['imprimir'])) {
    echo 'imprimir';
}

if (isset($_POST['editar'])) {
    echo 'editar';
}
include 'header.php';
?>

<script type="text/javascript">
    $(document).ready(function () {

        $('#tablapagos').DataTable({
            "lengthMenu": [[10, 25, -1], [10, 25, "Todo"]],
            "pageLength": 10,
            "order": [[0, "desc"]],
            "info": false
        });

        $('#monto').keyup(function () {
            upda();
        });

        $('#iva').keyup(function () {
            //upda();
        });


        var upda = function () {
            function round2Fixed(value) {
                value = +value;

                if (isNaN(value))
                    return NaN;

                // Shift
                value = value.toString().split('e');
                value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + 2) : 2)));

                // Shift back
                value = value.toString().split('e');
                return (+(value[0] + 'e' + (value[1] ? (+value[1] - 2) : -2))).toFixed(2);
            };

            var iva = ((+$('#monto').val() / 1.12) * 0.12);
            $('#iva').val(round2Fixed(iva));

            var tot = (+$('#monto').val() - +iva);
            $('#totalpagoq').val(round2Fixed(tot));
        };




//        var upda = function () {
//            var iva = ((+$('#monto').val() / 1.12) * 0.12);
//            $('#iva').val(iva.toFixed(2));
//            
//            var tot = (+$('#monto').val() - +iva);
//            $('#totalpagoq').val(tot.toFixed(2));
//        };
    });
</script>


<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-md-7">

            <h4>Editar</h4>   
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="glyphicon glyphicon-paperclip" aria-hidden="true">  </span>
                </div>
                <div class="panel-body">
                    <form role="form" action="pagose.php" method="post"  class="form-horizontal" id="frmpago">
                        <div class="form-group">
                            <div class="col-xs-offset-4 col-xs-2">
                                <label for="fecha">ID:</label>
                                <input type="text" class="form-control input-sm" name="id" id="id" value="<?php echo $row[0]; ?>" required="required" readonly>
                            </div>
                            <div class="col-xs-3">
                                <label for="fecha">Fecha:</label>
                                <input type="text" class="form-control input-sm" id="fecha" value="<?php echo date_format(date_create($row[1]), 'd-m-Y'); ?>" required="required" readonly>
                            </div>
                            <div class="col-xs-3">
                                <label for="username">Usuario:</label>
                                <input type="text" class="form-control input-sm" id="username" name="username" placeholder="username" value="<?php echo $_SESSION['username']; ?>" required="required" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="reqpor">Requerido por:</label>
                                <input type="text" class="form-control input-sm" id="reqpor" name="reqpor" placeholder="REQUERIDO POR" value="<?php echo $row[3]; ?>" required="required">
                            </div>
                            <div class="col-xs-3">
                                <label for="deptoid">Departamento:</label>
                                <select class="form-control input-sm" id="deptoid" name="deptoid" required="required" disabled>
                                    <option value="" selected>selecciona</option>
                                    <?php
                                    $query = "select * from sdepto order by 2";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($rowd = mysqli_fetch_row($result)) {
                                        echo "<option value='" . $rowd[0] . "' " . ($row[4] == $rowd[0] ? "selected" : "") . ">" . $rowd[1] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <label for="ordencomp">Orden compra:</label>
                                <input type="text" class="form-control input-sm" id="ordencomp" name="ordencomp" placeholder="ORDEN COMP" value="<?php echo $row[18]; ?>" required="required">
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="paguesea">Paguese a favor de:</label>
        <!--                                <input type="text" class="form-control input-sm" id="paguesea" name="paguesea" placeholder="PAGUESE A FAVOR DE" required="required">-->
                                <input list="paguesea" name="paguesea" class="form-control input-sm" placeholder="PAGUESE A FAVOR DE"  value="<?php echo $row[12]; ?>" autocomplete="off" required="required">
                                <datalist id="paguesea">
                                    <?php
                                    $query = "select distinct paguesea from pagos order by 1";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($rowd = mysqli_fetch_row($result)) {
                                        echo'<option value="' . $rowd[0] . '">' . $rowd[0] . '</option>';
                                    }
                                    ?>                                    
                                </datalist>

                            </div>
                            <div class="col-xs-3">
                                <label for="metodopagoid">Método de pago:</label>
                                <select class="form-control input-sm" id="metodopagoid" name="metodopagoid">
                                    <option value="Cheque" selected>Cheque</option>
                                    <option value="Efectivo" <?php echo ($row[20] == 'Efectivo' ? 'selected' : ''); ?>>Efectivo</option>

                                </select>
                            </div>
                            <div class="col-xs-3">
                                <label for="recepbienes">Recepción bienes:</label>
                                <input type="text" class="form-control input-sm" id="recepbienes" name="recepbienes" placeholder="RECEP BIENES" value="<?php echo $row[19]; ?>" required="required">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <div class="col-xs-offset-1 col-xs-2">
                                <label for="moneda">Moneda:</label>
                                <select class="form-control input-sm" id="moneda" name="moneda">
                                    <option value="Q" selected>Q</option>
                                    <option value="$" <?php echo ($row[6] == '$' ? 'selected' : ''); ?>>$</option>
                                </select>                               
                            </div>
                            <div class="col-xs-3">
                                <label for="monto">MONTO:</label>
                                <input type="number" min="0" id="monto" name="monto" step="any" value="<?php echo $row[5]; ?>" required="required" class="form-control input-sm">
                            </div>
                            <div class="col-xs-3">
                                <label for="iva">IVA:</label>
                                <input type="number" min="0" id="iva" name="iva" step="any" value="<?php echo $row[7]; ?>" required="required" class="form-control input-sm">
                            </div>
                            <div class="col-xs-3">
                                <label for="totalpagoq">TOTAL:</label>
                                <input type="number" min="0" id="totalpagoq" name="totalpagoq" step="any" value="<?php echo $row[10]; ?>" required="required" class="form-control input-sm">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="epepid">Elemento PEP:</label>

                                <input list="epepid" name="epepid" class="form-control input-sm" placeholder="seleccione" value="<?php echo $row[15]; ?>"    autocomplete="off" required="required">
                                <datalist id="epepid">
                                    <?php
                                    $query = "select distinct epepid from pagos order by 1";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($rowd = mysqli_fetch_row($result)) {
                                        echo'<option value="' . $rowd[0] . '">' . $rowd[0] . '</option>';
                                    }
                                    ?>                                    
                                </datalist>


                            </div>
                            <div class="col-xs-4">
                                <label for="ccostid">Centro de costo:</label>
                                <select class="form-control input-sm" id="ccostid" name="ccostid" required="required">
                                    <option value="" selected>selecciona</option>
                                    <?php
                                    $query = "select c.id, concat(c.costo) from ccosto c order by 2";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($rowd = mysqli_fetch_row($result)) {
                                        echo "<option value='" . $rowd[0] . "' " . ($row[16] == $rowd[0] ? "selected" : "") . ">" . $rowd[1] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label for="metodopagoid">Cuenta mayor:</label>
                                <select class="form-control input-sm" id="cmayorid" name="cmayorid" required="required">
                                    <option value="" selected>selecciona</option>
                                    <?php
                                    $query = " select m.id, concat(m.cuentamayor) from cmayor m order by 2";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($rowd = mysqli_fetch_row($result)) {
                                        echo "<option value='" . $rowd[0] . "' " . ($row[17] == $rowd[0] ? "selected" : "") . ">" . $rowd[1] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>                           
                        </div>

                        <hr />
                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea class="form-control input-sm" rows="1" placeholder="JUSTIFICACION DEL PAGO" id="just" name="just" required="required"><?php echo $row[13]; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea class="form-control input-sm" rows="1" placeholder="INFORMACION ADICIONAL" id="infoad" name="infoad" ><?php echo $row[14]; ?></textarea>
                            </div>
                        </div> 


                        <button type="submit" class="btn btn-success" name="aceptar"><span class='glyphicon glyphicon-ok'> </span> Aceptar</button>                        
                        <a href="pagos.php" class="btn btn-danger"><span class='glyphicon glyphicon-remove'> </span>Cancelar</a>
                        <button type="submit" class="btn btn-default" name="duplicar"><span class='glyphicon glyphicon-duplicate'> </span>Duplicar esta orden</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>






<?php include 'footer.php'; ?>