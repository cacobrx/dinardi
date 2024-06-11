
<?
/*
 * Creado el ".$hoy."
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: ".$archivodel."
 */

require("user.php");
require_once "clases/conexion.php";
require_once "clases/globalson.php";
require_once "clases/auditoria.php";
require_once "clases/adm_mov_caja.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$id=$glo->getGETPOST("id");
$adm=new adm_mov_caja_1($id);
$ssql="delete from adm_mov_caja where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Movimientos de Caja",$usr->getId(),"Elimina Movimientos de Caja: ".$adm->getFecha()." | ".$adm->getDetalle()." | ".$adm->getImporte()." | ".$adm->getTipomovdes(),$centrosel);
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_mov_caja_main.php">
 <input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
