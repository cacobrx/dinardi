<?php
/*
 * Creado el 15/10/2015 17:38:03
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: register_emp
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$detalleemp=$glo->getGETPOST("detalleemp");
$limemp=$glo->getGETPOST("limemp");
if($limemp=="") $limemp=0;
$_SESSION["limemp"]=$limemp;
$_SESSION["detalleemp"]=$detalleemp;

//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_empleados_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>

