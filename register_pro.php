<?php
/*
 * Creado el 19/05/2018 12:24:59
 * Autor: gus
 * Archivo: register_prv.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$textopro=$glo->getGETPOST("textopro");
$limpro=$glo->getGETPOST("limpro");
if($limpro=="")
    $limpro=0;
$_SESSION["textopro"]=$textopro;
$_SESSION["limpro"]=$limpro;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_pro_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


