<?php
include 'secure.php';
include 'conection.php';

if (isset($_POST['aceptar'])) {

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


    //if (isset()) {
    $query = "insert into pagos"
            . "(userid,     reqpor,     deptoid,    monto,   moneda,    iva,     inguat,    combustible, totalpagoq,    totalpagox, paguesea,    just,    infoad,    epepid,    ccostid,    cmayorid,   metodopagoid,      ordencomp,    recepbienes) values "
            . "('$userid', '$reqpor', '$deptoid', '$monto', '$moneda', '$iva',   '0.00',    '0.00',      '$totalpagoq', '0.00',     '$paguesea', '$just', '$infoad', '$epepid', '$ccostid', '$cmayorid', '$metodopagoid', '$ordencomp', '$recepbienes')";
    //} else {
    //    $query = "INSERT INTO PAGOS "
    //            . "(USERID,     REQPOR,     DEPTOID,    MONTO,   MONEDA,    IVA,     INGUAT,    COMBUSTIBLE, TOTALPAGOQ,    TOTALPAGOX, PAGUESEA,    JUST,    INFOAD,    EPEPID,    CCOSTID,    CMAYORID,   METODOPAGOID) VALUES "
    //           . "('$userid', '$reqpor', '$deptoid', '$monto', '$moneda', '$iva',   '0.00',    '0.00',      '$totalpagoq', '0.00',     '$paguesea', '$just', '$infoad', '$epepid', '$ccostid', '$cmayorid', '$metodopagoid')";
    //}

    $result = mysqli_query($link, $query);
    if ($result) {
        echo "<p>New record created successfully $query</p>";
    } else {
        echo "<p>>Ha ocurrido un error $query</p>";
    }
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
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
            "pageLength": 10,
            "order": [[0, "desc"]],
            "scrollX": true,
            "info": false
        });

        $('.editar').click(function () {
            //$.post( "pagos.php", { name: "John", time: "2pm" } );
            //alert ('editar '+ $(this).closest('tr').find('td:eq(0)').text());
        });

        $('.imprimir').click(function () {
            //alert('imprimir ' + $(this).closest('tr').find('td:eq(0)').text());
        });

        $('#monto').keyup(function () {
            upda();
        });

        $('#iva').keyup(function () {
            //upda();
        });



//        var upda = function () {
//            var iva = ((+$('#monto').val() / 1.12) * 0.12);
//            $('#iva').val(iva.toFixed(2));
//
//            var tot = (+$('#monto').val() - +iva);
//            $('#totalpagoq').val(tot.toFixed(2));
//        };

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

    });
</script>


<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <h1>Requerimiento de pago</h1>
            <h4>Requerimiento de pago.</h4>   

            <a href="#" data-target="#modalagregar" class="btn btn-sm btn-success" data-toggle="modal"><span class='glyphicon glyphicon-plus'> </span>CREAR NUEVO</a>
            <br />
            <br />
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="glyphicon glyphicon-paperclip" aria-hidden="true">  </span></div>
                <div class="panel-body">  

                    <table id="tablapagos" class="table table-condensed table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>FECHA</th>
        <!--                        <th>UP|DEPTO</th>-->
                                <th>USUARIO</th>
        <!--                        <th>METODO</th>-->
                                <th>A FAVOR DE</th>
                                <th align='right'>MONTO</th>  
                                <th align='right'>IVA</th> 
                                <th>ELEMENTO PEP</th>
<!--                                <th>COST</th>
                                <th>MAYOR</th>      
                                <th align='right'>O COMPRA</th>
                                <th align='right'>RECEP BIENES</th>      -->
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "select p.id, date_format(p.fecha,'%Y-%m-%d') as fecha, d.depto as depto, u.username as por, p.metodopagoid as metodo, left(p.paguesea,50) as beneiciario, concat(p.moneda,'',p.monto) as monto, p.iva, p.epepid as pep, c.costo as centrocosto, m.cuentamayor as mayor, p.ordencomp, p.recepbienes  from pagos p, susua u, sdepto d, ccosto c, cmayor m  where p.userid=u.id and p.deptoid=d.id and p.cmayorid=m.id and p.ccostid=c.id "
                                    . " and (p.deptoid=" . $_SESSION['deptoid'] . ")";
                            $result = mysqli_query($link, $query);
//                            echo mysql_errno($link) . ": " . mysql_error($link) . "\n";

                            mysqli_data_seek($result, 0);
                            while ($row = mysqli_fetch_row($result)) {
                                echo"<tr>"
                                . "<td>$row[0]</td>" 
                                . "<td>$row[1]</td>"
//                        . "<td>$row[2]</td>"
                                . "<td>$row[3]</td>"
//                        . "<td>$row[4]</td>"
                                . "<td>$row[5]</td>"
                                . "<td align='right'>$row[6]</td>"
                                . "<td align='right'>$row[7]</td>"
                                . "<td>$row[8]</td>"
//                                . "<td>$row[9]</td>"
//                                . "<td>$row[10]</td>"
//                                . "<td align='right'>$row[11]</td>"
//                                . "<td align='right'>$row[12]</td>"
                                . "<td>"
                                . "<a href='report.php?id=$row[0]' target='_blank'><span class='glyphicon glyphicon-print text-success'> </span> </a>"
                                . "<a href='pagose.php?id=$row[0]'><span class='glyphicon glyphicon-pencil text-primary'></span></a>"
                                . "<a href='#'><span class='glyphicon glyphicon-remove text-danger' ></span></a>"
                                . "</td>"
                                . "</tr>";
                            }
                            ?>         
                        <span class="text-warning"></span>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal AGREGAR -->
<div id="modalagregar" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #80B3FF">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-paperclip" aria-hidden="true">  </span>Requerimiento de Pago</h4>
            </div> 
            <div class="modal-body">
                <div class="container-fluid">
                    <form role="form" action="pagos.php" method="post" class="form-horizontal" id="frmpago">
                        <div class="form-group">
                            <div class="col-xs-offset-6 col-xs-3">
                                <label for="fecha">Fecha:</label>
                                <input type="text" class="form-control input-sm" id="fecha" value="<?php echo date('d-m-Y'); ?>" required="required" disabled>
                            </div>
                            <div class="col-xs-3">
                                <label for="username">Usuario:</label>
                                <input type="text" class="form-control input-sm" id="username" name="username" placeholder="username" value="<?php echo $_SESSION['username']; ?>" required="required" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="reqpor">Requerido por:</label>
                                <input type="text" class="form-control input-sm" id="reqpor" name="reqpor" placeholder="REQUERIDO POR" value="<?php echo $_SESSION['nombrecomp']; ?>" required="required">
                            </div>
                            <div class="col-xs-3">
                                <label for="deptoid">Departamento:</label>
                                <select class="form-control input-sm" id="deptoid" name="deptoid" required="required" disabled>
                                    <option value="" selected>selecciona</option>
                                    <?php
                                    $query = "select * from sdepto order by 2";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_row($result)) {
                                        echo "<option value='" . $row[0] . "' " . ($_SESSION['deptoid'] == $row[0] ? "selected" : "") . ">" . $row[1] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <label for="ordencomp">Orden compra:</label>
                                <input type="text" class="form-control input-sm" id="ordencomp" name="ordencomp" placeholder="ORDEN COMP" value="" required="required">
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="paguesea">Paguese a favor de:</label>
<!--                                <input type="text" class="form-control input-sm" id="paguesea" name="paguesea" placeholder="PAGUESE A FAVOR DE" required="required">-->
                                <input list="paguesea" name="paguesea" class="form-control input-sm" placeholder="PAGUESE A FAVOR DE"  autocomplete="off" required="required">
                                <datalist id="paguesea">
                                    <?php
                                    $query = "select distinct paguesea from pagos order by 1";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_row($result)) {
                                        echo'<option value="' . $row[0] . '">' . $row[0] . '</option>';
                                    }
                                    ?>                                    
                                </datalist>

                            </div>
                            <div class="col-xs-3">
                                <label for="metodopagoid">Método de pago:</label>
                                <select class="form-control input-sm" id="metodopagoid" name="metodopagoid">
                                    <option value="Cheque" selected>Cheque</option>
                                    <option value="Efectivo">Efectivo</option>                                  
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <label for="recepbienes">Recepción bienes:</label>
                                <input type="text" class="form-control input-sm" id="recepbienes" name="recepbienes" placeholder="RECEP BIENES" value="" required="required">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <div class="col-xs-offset-1 col-xs-2">
                                <label for="moneda">Moneda:</label>
                                <select class="form-control input-sm" id="moneda" name="moneda">
                                    <option value="Q" selected>Q</option>
                                    <option value="$">$</option>
                                </select>                               
                            </div>
                            <div class="col-xs-3">
                                <label for="monto">MONTO:</label>
                                <input type="number" min="0" id="monto" name="monto" step="any" value="0" required="required" class="form-control input-sm">
                            </div>
                            <div class="col-xs-3">
                                <label for="iva">IVA:</label>
                                <input type="number" min="0" id="iva" name="iva"  step="any" value="0" required="required" class="form-control input-sm">
                            </div>
                            <div class="col-xs-3">
                                <label for="totalpagoq">TOTAL:</label>
                                <input type="number" min="0" id="totalpagoq" name="totalpagoq" step="any" value="0" required="required" class="form-control input-sm">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="epepid">Elemento PEP:</label>

                                <input list="epepid" name="epepid" class="form-control input-sm" placeholder="seleccione" autocomplete="off" required="required">
                                <datalist id="epepid">
                                    <?php
                                    $query = "select distinct epepid from pagos order by 1";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_row($result)) {
                                        echo'<option value="' . $row[0] . '">' . $row[0] . '</option>';
                                    }
                                    ?>                                    
                                </datalist>


                            </div>
                            <div class="col-xs-4">
                                <label for="metodopagoid">Centro de costo:</label>
                                <select class="form-control input-sm" id="ccostid" name="ccostid" required="required">
                                    <option value="" selected>selecciona</option>
                                    <?php
                                    $query = "select c.id, concat(c.costo) from ccosto c order by 2";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_row($result)) {
                                        echo'<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label for="metodopagoid">Cuenta mayor:</label>
                                <select class="form-control input-sm" id="cmayorid" name="cmayorid" required="required">
                                    <option value="" selected>selecciona</option>
                                    <?php
                                    $query = "select m.id, concat(m.cuentamayor) from cmayor m order by 2";
                                    $result2 = mysqli_query($link, $query);
                                    mysqli_data_seek($result2, 0);
                                    while ($row = mysqli_fetch_row($result2)) {
                                        echo'<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>                           
                        </div>

                        <hr />
                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea class="form-control input-sm" rows="1" placeholder="JUSTIFICACION DEL PAGO" id="just" name="just" required="required"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea class="form-control input-sm" rows="1" placeholder="INFORMACION ADICIONAL" id="infoad" name="infoad"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success" name="aceptar"><span class='glyphicon glyphicon-ok'> </span> Aceptar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class='glyphicon glyphicon-remove'> </span> Cancelar</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>