<?php
/*
 * creado el 06/01/2018 14:03:40
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: register_per
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$limper=$glo->getGETPOST("limper");
if($limper=="") $limper=0;
$_SESSION["limper"]=$limper;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_per_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
