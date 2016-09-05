<?php
include 'secure.php';
include 'header.php';
?>





<h1>Acerca de</h1>
<hr />
<h3>Aplicación de <?php echo $oficina ?></h3>
<p> <strong><?php echo $miapp ?></strong> es una aplicación preliminar para regisro en <?php echo $oficina ?></p>
<small>
    <address>
        <?php echo $miapp ." ". $version ?><br>
        si quieres ayudar contacta a <a href= <?php echo "mailto:$contacto" ?> ><?php echo $contacto ?></a> con tus sugerencias de mejora o reporte de falla<br> 
    </address>
</small>








<?php include 'footer.php'; ?>
