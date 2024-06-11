<?php
/*
 * creado el 25 nov. 2021 11:22:34
 * Usuario: gus
 * Archivo: register_tr
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$limtr=$glo->getGETPOST("limtr");
$fechainitr=$glo->getGETPOST("fechainitr");
$fechafintr=$glo->getGETPOST("fechafintr");
$tipotr=$glo->getGETPOST("tipotr");
if($tipotr=="") $tipotr=0;
if($limtr=="")
    $limtr=0;
$_SESSION["limre"]=$limtr;
$_SESSION["fechainitr"]=$fechainitr;
$_SESSION["fechafintr"]=$fechafintr;
$_SESSION["tipotr"]=$tipotr;
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_trans_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
