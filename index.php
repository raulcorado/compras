<?php
include 'secure.php';
include 'header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <br />
            <h1>Hola <?php echo $_SESSION['email']; ?>.</h1> 
            <hr />
            <p>Cuenta <?php echo $_SESSION['email']; ?></p>
            <p class="text-success">Haga clic en alguna opción</p>
            <br />
            <br />
            <br />
            <a href="logout.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-log-out" aria-hidden="true">  </span>  Salir</a>
        </div>
    </div>
</div>



<?php
include 'footer.php';
?>