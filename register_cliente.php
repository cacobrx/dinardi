<?php
session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$campocli=$glo->getGETPOST("campocli");
$criteriocli=$glo->getGETPOST("criteriocli");
$textocli=$glo->getGETPOST("textocli");
$ordencli=$glo->getGETPOST("ordencli");
$activosel=$glo->getGETPOST("activosel");
$limcli=$glo->getGETPOST("limcli");
if($limcli=="") $limcli=0;
$_SESSION["campocli"]=$campocli;
$_SESSION["criteriocli"]=$criteriocli;
$_SESSION["textocli"]=$textocli;
$_SESSION["ordencli"]=$ordencli;
$_SESSION["activosel"]=$activosel;
$_SESSION["limcli"]=$limcli;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_cli_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
