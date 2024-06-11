
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
require_once "clases/adm_per.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$adm=new adm_per_1($id);
$ssql="delete from adm_per where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Periodos",$usr->getId(),"Elimina Periodos: [$id]",$centrosel);
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_per_main.php">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
