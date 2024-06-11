<?php
/*
 * creado el 07/11/2017 19:45:31
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: register_mov
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainimov=$glo->getGETPOST("fechainimov");
$fechafinmov=$glo->getGETPOST("fechafinmov");
$textomov=$glo->getGETPOST("textomov");
$asientomov=$glo->getGETPOST("asientomov");
$detallemov=$glo->getGETPOST("detallemov");
$limmov=$glo->getGETPOST("limmov");
if($limmov=="") $limmov=0;

$_SESSION["fechainimov"]=$fechainimov;
$_SESSION["fechafinmov"]=$fechafinmov;
$_SESSION["textomov"]=$textomov;
$_SESSION["asientomov"]=$asientomov;
$_SESSION["detallemov"]=$detallemov;
$_SESSION["limmov"]=$limmov;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_mov_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
