<?php
/*
 * Creado el 03/07/2019 18:54:37
 * Autor: gus
 * Archivo: register_fis.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainifis=$glo->getGETPOST("fechainifis");
$fechafinfis=$glo->getGETPOST("fechafinfis");
$detallefis=$glo->getGETPOST("detallefis");
$clientefis=$glo->getGETPOST("clientefis");
$tipocomfis=$glo->getGETPOST("tipocomfis");
$numerofis=$glo->getGETPOST("numerofis");
$limfis=$glo->getGETPOST("limfis");
if($limfis=="") $limfis=0;
$_SESSION["fechainifis"]=$fechainifis;
$_SESSION["fechafinfis"]=$fechafinfis;
$_SESSION["detallefis"]=$detallefis;
$_SESSION["clientefis"]=$clientefis;
$_SESSION["limfis"]=$limfis;
$_SESSION["tipocomfis"]=$tipocomfis;
$_SESSION["numerofis"]=$numerofis;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_fis_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
