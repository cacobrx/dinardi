<?
#
# elimina producto
#
//print_r($_POST);
require("user.php");
require_once("clases/conexion.php");
require_once("clases/globalson.php");
require_once("clases/auditoria.php");
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$id=$glo->getGETPOST("id");
$jug=new usuarios_1($id);
$ssql="delete from usuarios where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Usuarios",$usr->getId(),"Elimina usuario: ".$jug->getApellido().", ".$jug->getNombre(),$centrosel);
//echo $ssql."<br>";
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="planb_usr_main.php">
 <input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
