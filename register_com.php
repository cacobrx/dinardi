<?php
/*
 * Creado el 15/09/2015 13:24:58
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: register_com
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainicom=$glo->getGETPOST("fechainicom");
$fechafincom=$glo->getGETPOST("fechafincom");
$proveedorcom=$glo->getGETPOST("proveedorcom");
$campofechacom=$glo->getGETPOST("campofechacom");
$movimientocom=$glo->getGETPOST("movimientocom");
//$descriptor1cva=$glo->getGETPOST("descriptor1cva");
//$descriptor2cva=$glo->getGETPOST("descriptor2cva");
//$descriptor3cva=$glo->getGETPOST("descriptor3cva");
//$descriptor4cva=$glo->getGETPOST("descriptor4cva");
$numerocom=$glo->getGETPOST("numerocom");


$limcom=$glo->getGETPOST("limcom");
if($limcom=="")
    $limcom=0;
$_SESSION["fechainicom"]=$fechainicom;
$_SESSION["fechafincom"]=$fechafincom;
$_SESSION["proveedorcom"]=$proveedorcom;
$_SESSION["campofechacom"]=$campofechacom;
$_SESSION["movimientocom"]=$movimientocom;
//$_SESSION["descriptor1cva"]=$descriptor1cva;
//$_SESSION["descriptor2cva"]=$descriptor2cva;
//$_SESSION["descriptor3cva"]=$descriptor3cva;
//$_SESSION["descriptor4cva"]=$descriptor4cva;
$_SESSION["numerocom"]=$numerocom;
$_SESSION["limcom"]=$limcom;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_com_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


