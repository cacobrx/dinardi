
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
require_once "clases/adm_rem_exp.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$adm=new adm_rem_exp_1($id);
$ssql="delete from adm_rem_exp_det where idrem=$id";
$conx->getConsulta($ssql);
$ssql="delete from adm_rem_exp where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Remito Exportacion",$usr->getId(),"Elimina Remito de Exportación: ".$adm->getNumero(),$centrosel);
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_rem_exp_main.php">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
