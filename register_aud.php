<?php

#----------------------------------------
# Autor: gus
# Fecha: 25/02/2015 13:47:40
# Archivo: register_aud.php
#----------------------------------------

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$centroaud=$glo->getGETPOST("centroaud");
$fechainiaud=$glo->getGETPOST("fechainiaud");
$fechafinaud=$glo->getGETPOST("fechafinaud");
$usuarioaud=$glo->getGETPOST("usuarioaud");
$textoaud=$glo->getGETPOST("textoaud");
$limaud=$glo->getGETPOST("limaud");
if($limaud=="")
    $limaud=0;
$_SESSION["centroaud"]=$centroaud;
$_SESSION["limaud"]=$limaud;
$_SESSION["fechainiaud"]=$fechainiaud;
$_SESSION["fechafinaud"]=$fechafinaud;
$_SESSION["usuarioaud"]=$usuarioaud;
$_SESSION["textoaud"]=$textoaud;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_aud_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
