<?php
/*
 * Creado el 19/05/2018 12:24:59
 * Autor: gus
 * Archivo: register_prd.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$textoprd=$glo->getGETPOST("textoprd");
$limprd=$glo->getGETPOST("limprd");
$ordenprd=$glo->getGETPOST("ordenprd");
$rubroprd=$glo->getGETPOST("rubroprd");
if($limprd=="")
    $limprd=0;
$_SESSION["textoprd"]=$textoprd;
$_SESSION["limprd"]=$limprd;
$_SESSION["ordenprd"]=$ordenprd;
$_SESSION["rubroprd"]=$rubroprd;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_prd_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


