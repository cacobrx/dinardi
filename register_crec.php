<?php
/*
 * Creado el 29/08/2019 11:50:27
 * Autor: gus
 * Archivo: register_crec.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainicrec=$glo->getGETPOST("fechainicrec");
$fechafincrec=$glo->getGETPOST("fechafincrec");
$detallecrec=$glo->getGETPOST("detallecrec");
$clientecrec=$glo->getGETPOST("clientecrec");
$numerocrec=$glo->getGETPOST("numerocrec");
$limcrec=$glo->getGETPOST("limcrec");
if($limcrec=="") $limcrec=0;
$_SESSION["fechainicrec"]=$fechainicrec;
$_SESSION["fechafincrec"]=$fechafincrec;
$_SESSION["detallecrec"]=$detallecrec;
$_SESSION["clientecrec"]=$clientecrec;
$_SESSION["numerocrec"]=$numerocrec;
$_SESSION["limcrec"]=$limcrec;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_crec_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
