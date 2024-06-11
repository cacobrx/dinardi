
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
require_once "clases/adm_cli.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$id=$glo->getGETPOST("id");
$cli=new adm_cli_1($id);
$ssql="delete from adm_cli where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Proveedores",$usr->getId(),"Elimina Proveedores: ".$cli->getApellido(),$centrosel);
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_cli_main.php">
 <input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
