<?php
/*
 * creado el 20 may. 2021 11:30:01
 * Usuario: gus
 * Archivo: register_des
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainides=$glo->getGETPOST("fechainides");
$fechafindes=$glo->getGETPOST("fechafindes");
$descriptor1des=$glo->getGETPOST("descriptor1des");
$descriptor2des=$glo->getGETPOST("descriptor2des");
$descriptor3des=$glo->getGETPOST("descriptor3des");
$descriptor4des=$glo->getGETPOST("descriptor4des");
$textodes=$glo->getGETPOST("textodes");

$_SESSION["fechainides"]=$fechainides;
$_SESSION["fechafindes"]=$fechafindes;
$_SESSION["descriptor1des"]=$descriptor1des;
$_SESSION["descriptor2des"]=$descriptor2des;
$_SESSION["descriptor3des"]=$descriptor3des;
$_SESSION["descriptor4des"]=$descriptor4des;
$_SESSION["textodes"]=$textodes;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_inf_descriptores.php" method="post">
    <input name="primero" id="primero" type="hidden" value="1" />
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


