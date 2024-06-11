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
$limenv=$glo->getGETPOST("limenv");
$proveedorenv=$glo->getGETPOST("proveedorenv");
$articuloenv=$glo->getGETPOST("articuloenv");
$fechainienv=$glo->getGETPOST("fechainienv");
$fechafinenv=$glo->getGETPOST("fechafinenv");
$tunelenv=$glo->getGETPOST("tunelenv");

if($limenv=="")
    $limenv=0;
$_SESSION["limenv"]=$limenv;
$_SESSION["fechainienv"]=$fechainienv;
$_SESSION["fechafinenv"]=$fechafinenv;
$_SESSION["proveedorenv"]=$proveedorenv;
$_SESSION["articuloenv"]=$articuloenv;
$_SESSION["tunelenv"]=$tunelenv;
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_env_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


