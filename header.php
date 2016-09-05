<!DOCTYPE html>
<?php include 'mivar.php'; ?>
<html>
    <head>
        <!--        <link rel="shortcut icon" href="i.ico"/>-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" charset="utf-8" content="width=500, initial-scale=0.6, user-scalable=no" />






        <title>Compras</title>
        <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>

        <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.js" type="text/javascript"></script>

        <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>

        <style type="text/css">
            body {padding-top: 70px;}
            table{font-size: 11px;}
            .glyphicon {
                padding-right: 8px;
            } 
            
            .table-condensed > thead > tr > th,
            .table-condensed > tbody > tr > th,
            .table-condensed > tfoot > tr > th,
            .table-condensed > thead > tr > td,
            .table-condensed > tbody > tr > td,
            .table-condensed > tfoot > tr > td {
                padding: 2px;
                font-size: small;
            }
        </style>

    </head>

    <body>



        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container col-xs-12">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php"> <strong><?php echo $miapp?></strong></a>
                </div>
                <div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="pagos.php"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"> </span>PAGOS</a></li>

                    </ul> 
                    <ul class="nav navbar-nav navbar-right">
                        
                        
                        
                        

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span><?php echo "OPCIONES DE $_SESSION[username]" ?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                
                                <li><a href="acercade.php"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"> </span>Acerca de</a></li>
                                
                                <li role="separator" class="divider"></li>
                                <li class="active"><a href="users.php"><span class="glyphicon glyphicon-user" aria-hidden="true"> </span>USUARIO</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"> </span>CERRAR SESION</a></li>
                            </ul>
                        </li>

                        

                        
                        
                    </ul>

                </div>
            </div>
        </nav>


        <div class="container">
            <img src="img/logo.jpg" width="200px" alt=""/>
            <br />






