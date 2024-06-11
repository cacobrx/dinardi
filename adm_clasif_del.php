<?php
/*
 * creado el 31/07/2016 18:58:33
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_clasif_del
 */

require("user.php");
require_once "clases/conexion.php";
require_once "clases/globalson.php";
require_once "clases/auditoria.php";
require_once "clases/adm_clasif.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$adm=new adm_clasif_1($id);
$ssql="delete from adm_clasif where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Clasificacion",$usr->getId(),"Elimina Clasificacion: ".$adm->getTexto(),$centrosel);
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_clasif_main.php">
 <input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
