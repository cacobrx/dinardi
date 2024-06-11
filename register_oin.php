<?php
/*
 * Creado el 19/05/2018 12:24:59
 * Autor: gus
 * Archivo: register_oin.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$limoin=$glo->getGETPOST("limoin");
$fechainioin=$glo->getGETPOST("fechainioin");
$fechafinoin=$glo->getGETPOST("fechafinoin");
if($limoin=="")
    $limoin=0;
$_SESSION["limoin"]=$limoin;
$_SESSION["fechainioin"]=$fechainioin;
$_SESSION["fechafinoin"]=$fechafinoin;
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_oin_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


