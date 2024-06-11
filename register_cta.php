<?php
/*
 * creado el 06/04/2017 11:33:34
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: register_cta
 */
session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$limcta=$glo->getGETPOST("limcta");
$textocta=$glo->getGETPOST("textocta");
if($limcta=="") $limcta=0;
$_SESSION["textocta"]=$textocta;
$_SESSION["limcta"]=$limcta;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_cta_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
