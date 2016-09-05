<?php
include 'secure.php';
include 'header.php';
include 'conection.php';

if (isset($_POST['agregar'])) {
    $userid = $_SESSION['userid'];
    $username = $_POST['username'];
    $nombrecomp = $_POST['nombrecomp'];
    $password = md5($_POST['password']);
    $email = $_POST['email'];
    $deptoid = $_POST['deptoid'];
    $disabled = ((isset($_POST['disabled'])) ? 1 : 0);

    $rolid = $_POST['rolid'];


////UPDATE sUSUA SET nombrecomp='raul', password=md5('familia100%'), email='raul.corado@plan-international.org', deptoid=2, disabled=0 WHERE userID=3)
//UPDATE sROLESUSUA SET rolID=2 WHERE userID=3

    $query = "insert into susua "
            . "(username,     nombrecomp,    password,    email,   deptoid,  disabled) values "
            . "('$username', '$nombrecomp', '$password', '$email', $deptoid, $disabled)";
    $result = mysqli_query($link, $query);

//    $query = "UPDATE sROLESUSUA SET rolID=$rolid WHERE userID=3";
//    $result = mysqli_query($link, $query);
    // echo 'QUERY ' . $query;
    
  header("Location: users.php"); 
}

if (isset($_POST['cambiar'])) {
    echo 'imprimir';
    sleep(3);
    header("Location: userprofile.php");
}
?>

<script type="text/javascript">
    $(document).ready(function () {

        $('#tablapagos').DataTable({
            "paging": false,
            "lengthMenu": [[10, 25, -1], [10, 25, "Todo"]],
            "pageLength": 10,
            "order": [[0, "desc"]],
            "info": false
        });
    });
</script>


<div class="container">
    <div class="row">

        <div class="col-xs-12 col-lg-7">

            <h1>Mantenimiento de usuarios</h1>
            <h4>Mantenimiento de usuarios.</h4>

            <a href="#" data-target="#modalusuario" class="btn btn-sm btn-success" data-toggle="<?php echo ($_SESSION['userid'] == 1 ? 'modal' : '') ?>"><span class='glyphicon glyphicon-plus'> </span>CREAR NUEVO</a>
            <br />
            <br />
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="glyphicon glyphicon-user" aria-hidden="true">  </span></div>
                <div class="panel-body"> 
                    <table id="tablapagos" class="table table-condensed table-bordered table-hover">
                        <thead>
                            <tr>
                                <th align='right'>ID</th>
                                <th>USUARIO</th>
<!--                                <th>NOMBRE</th>-->
                                <th>EMAIL</th>
                                <th>DIS</th>
                                <th align='right'>LOGS</th>
                                <th align='right'>DIAS</th>
                                <th>OP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "select u.id, u.username, u.nombrecomp, u.email, u.disabled, u.logins, timestampdiff(day, u.ultimologin, now()) as ult from susua u"
                                    . ($_SESSION['username'] == 'admin' ? "" : " where u.username='" . $_SESSION['username'] . "'" );
                            $result = mysqli_query($link, $query);
                            mysqli_data_seek($result, 0);
                            while ($row = mysqli_fetch_row($result)) {
                                echo"<tr>"
                                . "<td align='right'>$row[0]</td>"
                                . "<td>$row[1]</td>"
                                //. "<td>". utf8_encode($row[2])."</td>"
                                . "<td>$row[3]</td>"
                                . "<td>$row[4]</td>"
                                . "<td>$row[5]</td>"
                                . "<td align='right'>$row[6]</td>"
                                . "<td>"
                                . "<a href='userse.php?id=$row[0]'><span class='glyphicon glyphicon-pencil text-primary'></span></a>"
                                . "<a href='#'><span class='glyphicon glyphicon-remove text-danger'></span></a>"
                                . "</td>"
                                . "</tr>";
                            }
                            ?>   


                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>



<!-- Modal AGREGAR -->
<div id="modalusuario" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #80B3FF">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Usuario</h4>
            </div> 
            <div class="modal-body">
                <div class="container-fluid">
                    <form role="form" action="users.php" method="post"  class="form-horizontal" id="frmusuario">
                        <div class="form-group">
                            <div class="col-xs-offset-4 col-xs-4">
                                <label for="username">USUARIO:</label>
                                <input type="text" class="form-control input-sm" id="username" name="username" placeholder="USUARIO" value="" required="required">
                            </div>
                            <div class="col-xs-4">
                                <label for="password">CONTRASEÑA:</label>
                                <input type="password" class="form-control input-sm" id="password" name="password" placeholder="CONTRASEÑA" value="" required="required">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-xs-offset-4 col-xs-4">
                                <label for="deptoid">Departamento:</label>
                                <select class="form-control input-sm" id="deptoid" name="deptoid" required="required">
                                    <option value="" selected>selecciona</option>
                                    <?php
                                    $query = "select * from sdepto order by 2";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_row($result)) {
                                        echo "<option value='" . $row[0] . "' " . ($_SESSION['deptoid'] == $row[0] ? "" : "") . ">" . $row[1] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label for="rolid">Rol:</label>
                                <select class="form-control input-sm" id="rolid" name="rolid" required="required">
                                    <option value="" selected>selecciona</option>
                                    <?php
                                    $query = "select * from sroles order by 2";
                                    $result = mysqli_query($link, $query);
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_row($result)) {
                                        echo "<option value='" . $row[0] . "'" . ($row[0] == 3 ? "selected" : "") . ">" . $row[1] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="nombrecomp">Nombre completo:</label>
                                <input type="text" class="form-control input-sm" id="nombrecomp" name="nombrecomp" placeholder="Nombre Completo" value="" required="required">
                            </div>
                            <div class="col-xs-6">
                                <label for="email">Correo electrónico:</label>
                                <input type="email" class="form-control input-sm" id="email" name="email" placeholder="Correo electrónico" value="" required="required">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox"  id="disabled" name="disabled">Deshabilitar</label>
                            </div>  

                        </div>

                        <hr />

                        <button type="submit" class="btn btn-success" name="agregar"><span class='glyphicon glyphicon-ok'> </span>Agregar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class='glyphicon glyphicon-remove'> </span>Cancelar</button>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<?php include 'footer'; ?>