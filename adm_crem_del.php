
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
require_once "clases/adm_crem.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$id=$glo->getGETPOST("id");
$cpe=new adm_crem_1($id);
$ssql="delete from adm_crem where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Elimina Remitos",$usr->getId(),"Elimina Remitos del Cliente: ".$cpe->getCliente(),$centrosel);
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_crem_main.php">
 <input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
