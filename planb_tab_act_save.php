<?
require("user.php");

require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once("clases/auditoria.php");
$aud=new registra_auditoria();

$conx=new conexion();
$glo=new globalson();
$tablasel=$glo->getGETPOST("tablasel");
$codtab=$glo->getGETPOST("codtab");
$descripcion=$glo->getGETPOST("descripcion");
$activo=$glo->getGETPOST("activo");
if($activo=="") $activo=0;
$tarea=$glo->getGETPOST("tarea");
$lim=$glo->getGETPOST("lim");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
	$ssql="select * from tablas where codtab='$codtab' order by valor desc";
	if($conx->getCantidadReg($ssql)>0) {
		$rx=$conx->getConsulta($ssql);
		$rex=mysqli_fetch_object($rx);
		$valor=$rex->valor;
		$valor++;
	} else
		$valor=1;
  	$aud->regAud("Tablas",$usr->getId(), "Agrega elemento: $descripcion a la tabla: $codtab", $centrosel);
	$ssql="insert into tablas (codtab, descripcion, valor, activo) values ('$codtab', '$descripcion', $valor, $activo)";
} else {
  	$aud->regAud("Tablas",$usr->getId(), "Modifica elemento: $descripcion de la tabla: $codtab", $centrosel);
  	$ssql="update tablas set descripcion='$descripcion', activo=$activo where id=$id";
}
	
$conx->getConsulta($ssql);
?>
<html>
<body>
<form name="form1" id="form1" action="planb_tab_main.php" method="post">
<input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
<input name="tablasel" id="tablasel" type="hidden" value="<?= $tablasel?>" />
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
