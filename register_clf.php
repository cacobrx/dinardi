<?php
/*
 * creado el 31/07/2016 17:30:53
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: register_clf
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$cajaclf=$glo->getGETPOST("cajaclf");
$tipoclf=$glo->getGETPOST("tipoclf");
$depenclf=$glo->getGETPOST("depenclf");
$ordenclf=$glo->getGETPOST("ordenclf");
$limclf=$glo->getGETPOST("limclf");
if($limclf=="")
    $limclf=0;
$_SESSION["cajaclf"]=$cajaclf;
$_SESSION["tipoclf"]=$tipoclf;
$_SESSION["limclf"]=$limclf;
$_SESSION["depenclf"]=$depenclf;
$_SESSION["ordenclf"]=$ordenclf;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_clasif_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
