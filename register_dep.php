<?php
/*
 * Creado el 15/10/2015 17:38:03
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: register_dep
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$limdep=$glo->getGETPOST("limdep");

if($limdep=="")
    $limdep=0;
$_SESSION["limdep"]=$limdep;

//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="departamento_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>

