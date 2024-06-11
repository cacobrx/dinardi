<?php
/*
 * creado el 02/06/2016 14:42:40
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: register_mcj
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainimcj=$glo->getGETPOST("fechainimcj");
$fechafinmcj=$glo->getGETPOST("fechafinmcj");
$cajamcj=$glo->getGETPOST("cajamcj");
$textomcj=$glo->getGETPOST("textomcj");
$paginarmcj=$glo->getGETPOST("paginarmcj");
$descriptor1mcj=$glo->getGETPOST("descriptor1mcj");
$descriptor2mcj=$glo->getGETPOST("descriptor2mcj");
$descriptor3mcj=$glo->getGETPOST("descriptor3mcj");
$descriptor4mcj=$glo->getGETPOST("descriptor4mcj");
$segmento1mcj=$glo->getGETPOST("segmento1mcj");
$segmento2mcj=$glo->getGETPOST("segmento2mcj");
$segmento3mcj=$glo->getGETPOST("segmento3mcj");
$segmento4mcj=$glo->getGETPOST("segmento4mcj");
$oficinamcj=$glo->getGETPOST("oficinamcj");
$tipopagomcj=$glo->getGETPOST("tipopagomcj");
$tipomovmcj=$glo->getGETPOST("tipomovmcj");
$vistamcj=$glo->getGETPOST("vistamcj");
$limmcj=$glo->getGETPOST("limmcj");
if($limmcj=="")
    $limmcj=0;

$_SESSION["fechainimcj"]=$fechainimcj;
$_SESSION["fechafinmcj"]=$fechafinmcj;
$_SESSION["cajamcj"]=$cajamcj;
$_SESSION["textomcj"]=$textomcj;
$_SESSION["limmcj"]=$limmcj;
$_SESSION["descriptor1mcj"]=$descriptor1mcj;
$_SESSION["descriptor2mcj"]=$descriptor2mcj;
$_SESSION["descriptor3mcj"]=$descriptor3mcj;
$_SESSION["descriptor4mcj"]=$descriptor4mcj;
$_SESSION["segmento1mcj"]=$segmento1mcj;
$_SESSION["segmento2mcj"]=$segmento1mcj;
$_SESSION["segmento3mcj"]=$segmento1mcj;
$_SESSION["segmento4mcj"]=$segmento1mcj;
$_SESSION["oficinamcj"]=$oficinamcj;
$_SESSION["tipopagomcj"]=$tipopagomcj;
$_SESSION["paginarmcj"]=$paginarmcj;
$_SESSION["tipomovmcj"]=$tipomovmcj;
$_SESSION["vistamcj"]=$vistamcj;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_mov_caja_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
