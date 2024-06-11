
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
require_once "clases/adm_empleados.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$adm=new adm_empleados_1($id);
$ssql="delete from adm_empleados where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Empleados",$usr->getId(),"Elimina Empleados: [$id]",$centrosel);
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_empleados_main.php">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
