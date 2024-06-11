
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
require_once "clases/adm_prv.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$adm=new adm_prv_1($id);
$ssql="delete from adm_prv where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Proveedores",$usr->getId(),"Elimina Proveedores: $id | ".$adm->getApellido(),$centrosel);
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_prv_main.php">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
