<?php
/*
 * Creado el 21/01/2016 13:24:16
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: register_ext
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainiext=$glo->getGETPOST("fechainiext");
$fechafinext=$glo->getGETPOST("fechafinext");
$empleadoext=$glo->getGETPOST("empleadoext");
$limext=$glo->getGETPOST("limext");
if($limext=="")
    $limext=0;

$_SESSION["fechainiext"]=$fechainiext;
$_SESSION["fechafinext"]=$fechafinext;
$_SESSION["empleadoext"]=$empleadoext;
$_SESSION["limext"]=$limext;

//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_extras_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>

