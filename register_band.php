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
$limband=$glo->getGETPOST("limband");
$proveedorband=$glo->getGETPOST("proveedorband");
$fechainiband=$glo->getGETPOST("fechainiband");
$fechafinband=$glo->getGETPOST("fechafinband");

if($limband=="")
    $limband=0;
$_SESSION["limband"]=$limband;
$_SESSION["fechainiband"]=$fechainiband;
$_SESSION["fechafinband"]=$fechafinband;
$_SESSION["proveedorband"]=$proveedorband;
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_band_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


