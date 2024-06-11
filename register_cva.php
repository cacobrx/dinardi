<?php
/*
 * Creado el 15/09/2015 13:24:58
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: register_cva
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainicva=$glo->getGETPOST("fechainicva");
$fechafincva=$glo->getGETPOST("fechafincva");
$proveedorcva=$glo->getGETPOST("proveedorcva");
$campofechacva=$glo->getGETPOST("campofechacva");
$movimientocva=$glo->getGETPOST("movimientocva");
$descriptor1cva=$glo->getGETPOST("descriptor1cva");
$descriptor2cva=$glo->getGETPOST("descriptor2cva");
$descriptor3cva=$glo->getGETPOST("descriptor3cva");
$descriptor4cva=$glo->getGETPOST("descriptor4cva");
$ordencva=$glo->getGETPOST("ordencva");
$letracva=$glo->getGETPOST("letracva");
$numerocva=$glo->getGETPOST("numerocva");
$limcva=$glo->getGETPOST("limcva");
if($limcva=="")
    $limcva=0;
$_SESSION["fechainicva"]=$fechainicva;
$_SESSION["fechafincva"]=$fechafincva;
$_SESSION["proveedorcva"]=$proveedorcva;
$_SESSION["campofechacva"]=$campofechacva;
$_SESSION["movimientocva"]=$movimientocva;
$_SESSION["ordencva"]=$ordencva;
$_SESSION["limcva"]=$limcva;
$_SESSION["descriptor1cva"]=$descriptor1cva;
$_SESSION["descriptor2cva"]=$descriptor2cva;
$_SESSION["descriptor3cva"]=$descriptor3cva;
$_SESSION["descriptor4cva"]=$descriptor4cva;
$_SESSION["numerocva"]=$numerocva;
$_SESSION["letracva"]=$letracva;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_com_var_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


