<?php
/*
 * Creado el 17/01/2019 18:43:45
 * Autor: gus
 * Archivo: register_crm.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainicrm=$glo->getGETPOST("fechainicrm");
$fechafincrm=$glo->getGETPOST("fechafincrm");
$detallecrm=$glo->getGETPOST("detallecrm");
$remitocrm=$glo->getGETPOST("remitocrm");
$proveedorcrm=$glo->getGETPOST("proveedorcrm");
$limcrm=$glo->getGETPOST("limcrm");
if($limcrm=="") $limcrm=0;
$_SESSION["fechainicrm"]=$fechainicrm;
$_SESSION["fechafincrm"]=$fechafincrm;
$_SESSION["detallecrm"]=$detallecrm;
$_SESSION["remitocrm"]=$remitocrm;
$_SESSION["limcrm"]=$limcrm;
$_SESSION["proveedorcrm"]=$proveedorcrm;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_crm_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
