<?php
/*
 * Creado el 19/05/2018 12:24:59
 * Autor: gus
 * Archivo: register_art.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainigas=$glo->getGETPOST("fechainigas");
$fechafingas=$glo->getGETPOST("fechafingas");
$idprvgas=$glo->getGETPOST("idprvgas");
$textogas=$glo->getGETPOST("textogas");
$limgas=$glo->getGETPOST("limgas");
$descriptor1gas=$glo->getGETPOST("descriptor1gas");
$descriptor2gas=$glo->getGETPOST("descriptor2gas");
$descriptor3gas=$glo->getGETPOST("descriptor3gas");
$descriptor4gas=$glo->getGETPOST("descriptor4gas");
if($limgas=="")
    $limgas=0;
$_SESSION["textogas"]=$textogas;
$_SESSION["limgas"]=$limgas;
$_SESSION["fechainigas"]=$fechainigas;
$_SESSION["fechafingas"]=$fechafingas;
$_SESSION["idprvgas"]=$idprvgas;
$_SESSION["descriptor1gas"]=$descriptor1gas;
$_SESSION["descriptor2gas"]=$descriptor2gas;
$_SESSION["descriptor3gas"]=$descriptor3gas;
$_SESSION["descriptor4gas"]=$descriptor4gas;
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_gas_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


