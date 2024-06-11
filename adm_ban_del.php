<?php
/*
 * Creado el 27/09/2018 13:45:57
 * Autor: gus
 * Archivo: hpa_ban_del.php
 * planbsistemas.com.ar
 */

require("user.php");
require_once("clases/conexion.php");
require_once("clases/globalson.php");
require_once("clases/auditoria.php");
require_once 'clases/adm_ban.php';
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$adm=new adm_ban_1($id);
$ssql="delete from adm_ban where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("ADM Bancos",$usr->getId(),"Elimina banco: ".$adm->getNombre(),$centrosel);
//echo $ssql."<br>";
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_ban_main.php">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
