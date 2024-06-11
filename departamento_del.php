
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
require_once "clases/departamento.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$adm=new departamento_1($id);
$ssql="delete from departamento where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Departamento",$usr->getId(),"Elimina Departamento: ".$adm->getDescripcion(),$centrosel);
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
    
