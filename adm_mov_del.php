<?php
/*
 * creado el 20/11/2017 15:52:35
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_mov_del
 */


require_once "user.php";
require_once "clases/conexion.php";
require_once "clases/globalson.php";
require_once "clases/auditoria.php";
require_once "clases/adm_mov.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$adm=new adm_mov_1($id);
$ssql="delete from adm_mov2 where idmov=$id";
$conx->getConsulta($ssql);
$ssql="delete from adm_mov1 where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Contabilidad",$usr->getId(),"Elimina Movimiento: ".$adm->getAsiento()."-".$adm->getDetalle()."-".$adm->getFecha(),$centrosel);
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_mov_main.php">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
