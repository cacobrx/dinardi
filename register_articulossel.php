<?php
/*
 * creado el 16 ago. 2023 15:36:30
 * Usuario: gus
 * Archivo: register_articulossel
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$urlvolver=$glo->getGETPOST("urlvolver");
$articulosselinf=$glo->getGETPOST("articulosselinf");
$_SESSION["articulosselinf"]=$articulosselinf;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="<?= $urlvolver?>" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
