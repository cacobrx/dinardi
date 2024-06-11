<?php
/*
 * Creado el 21/01/2016 13:24:16
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: register_dfae
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainiasi=$glo->getGETPOST("fechainiasi");
$fechafinasi=$glo->getGETPOST("fechafinasi");
$idperasi=$glo->getGETPOST("idperasi");
$limasi=$glo->getGETPOST("limasi");
if($limasi=="")
    $limasi=0;

$_SESSION["fechainiasi"]=$fechainiasi;
$_SESSION["fechafinasi"]=$fechafinasi;
$_SESSION["limasi"]=$limasi;
$_SESSION["idperasi"]=$idperasi;

//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_asistencias_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>

