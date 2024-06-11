<?php
/*
 * Creado el 15/03/2016 17:17:55
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: register_ela
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainiela=$glo->getGETPOST("fechainiela");
$fechafinela=$glo->getGETPOST("fechafinela");
$limela=$glo->getGETPOST("limela");
$proveedorela=$glo->getGETPOST("proveedorela");
$verdetalleela=$glo->getGETPOST("verdetalleela");
if($limela=="")
    $limela=0;
$_SESSION["fechainiela"]=$fechainiela;
$_SESSION["fechafinela"]=$fechafinela;
$_SESSION["limela"]=$limela;
$_SESSION["proveedorela"]=$proveedorela;
$_SESSION["verdetalleela"]=$verdetalleela;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_ela_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
