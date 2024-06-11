<?php
/*
 * Creado el 19/05/2018 12:24:59
 * Autor: gus
 * Archivo: register_hor.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();

$limhor=$glo->getGETPOST("limhor");
$fechainihor=$glo->getGETPOST("fechainihor");
$fechafinhor=$glo->getGETPOST("fechafinhor");
$iddephor=$glo->getGETPOST("iddephor");
$idemphor=$glo->getGETPOST("idemphor");
if($limhor=="")
    $limhor=0;
$_SESSION["limhor"]=$limhor;
$_SESSION["fechainihor"]=$fechainihor;
$_SESSION["fechafinhor"]=$fechafinhor;
$_SESSION["iddephor"]=$iddephor;
$_SESSION["idemphor"]=$idemphor;
?>
<html>
<body>
    <form name="form1" id="form1" action="horarios_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


