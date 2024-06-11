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
$xmes=$glo->getGETPOST("xmes");
$xano=$glo->getGETPOST("xano");
$idempasi=$glo->getGETPOST("idempasi");
$anomesasi=$xano.$xmes;
$_SESSION["anomesasi"]=$anomesasi;
$_SESSION["idempasi"]=$idempasi;

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

