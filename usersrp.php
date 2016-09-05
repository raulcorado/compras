<?php
// include 'secure.php';
include 'mivar.php';
include 'conection.php';


if (isset($_POST['enviar'])) {

    $email = strchr($_POST['email'], "@plan-international.org", true) . "@plan-international.org";
    $np = mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9) . mt_rand(1, 9);

    $query = "update susua set password=MD5('$np') where email='$email'";
    $result = mysqli_query($link, $query);


    $query = "select username, password, email from susua where email='$email'";
    $result = mysqli_query($link, $query);


    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);

        $username = $row['username'];
        $password = $np;
        $email = $row['email'];
        $subject = $miapp;
        $message = "
<html>
<head>
<title>$miapp</title>
</head>
<body>

<h4>$miapp</h4>

<p>Usuario: $username</p>
<p>Contraseña: <font color='red'> $password</font></p>
<h4>Por seguridad cambia tu contraseña en las opciones del programa</h4>

</body>
</html>
";

// Always set content-type when sending HTML email 
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
        $headers .= "From: $miapp <infoit@plan-international.org>" . "\r\n";

        mail($email, $subject, $message, $headers);
    }

    header('Location:index.php');
}
include 'header.php'; 
?>


<div class="container">
    <div class="row">

        <div class="col-xs-12 col-lg-7">


            <h4>Recuperación de contraseña</h4>

            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-user" aria-hidden="true">  </span>
                </div>
                <div class="panel-body">


                    <form role="form" action="usersrp.php" method="post"  class="form-horizontal" id="frmusuario">


                        <div class="form-group">


                            <div class="col-xs-offset-2 col-xs-8">
                                <h4>Tienes problemas para recordar tu contraseña?</h4>
                                <hr />
                                <p>Has venido al lugar correcto para recuperar tu contraseña olvidada. </p>
                                <p>Por favor ingresa tu correo electronico corporativo para verificar.</p>
                                <hr />
                                <label for="email">CORREO:</label>

                                <input type="email" class="form-control" id="email" name="email" placeholder="nombre.apellido@plan-international.org" value="<?php echo $row[6]; ?>" required="required">
                                <br />
                                <p> Te enviaremos a tu correo las instrucciones de como ingresar y como cambiar una nueva contraseña</p>
                            </div>
                        </div>                       

                        <hr />

                        <button type="submit" class="btn btn-success" name="enviar"><span class='glyphicon glyphicon-ok'> </span>Enviar contraseña al correo</button>
                        <a href="index.php" class="btn btn-danger"><span class='glyphicon glyphicon-remove'> </span>Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'footer'; ?>