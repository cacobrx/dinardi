<?
#
# elimina producto
#
//print_r($_POST);
require("user.php");
require_once("clases/conexion.php");
require_once("clases/globalson.php");
require_once("clases/auditoria.php");
require_once 'clases/tabla.php';
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$id=$glo->getGETPOST("id");
$tablasel=$glo->getGETPOST("tablasel");
$tab=new tabla_1($id);
$ssql="delete from tablas where id=$id";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$aud->regAud("Tablas",$usr->getId(),"Elimina tabla: ".$tab->getCodtab()." ".$tab->getDescripcion(),$centrosel);
//echo $ssql."<br>";
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="planb_tab_main.php">
 <input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
 <input name="tablasel" id="tablasel" type="hidden" value="<?= $tablasel?>" />
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
