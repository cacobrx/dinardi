<?
require("user.php");
require_once("clases/conexion.php");
require_once("clases/globalson.php");
require_once("clases/auditoria.php");
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$ciudad=$glo->getGETPOST("ciudad");
$provincia=$glo->getGETPOST("provincia");
$cpostal=$glo->getGETPOST("cpostal");
$id=$glo->getGETPOST("id");
$tarea=$glo->getGETPOST("tarea");
$abreviado=$glo->getGETPOST("abreviado");
if($provincia=="") $provincia=0;
if($tarea=="A") {
  $aud->regAud("Ciudades",$usr->getId(),"Ingresa nueva ciudad: $ciudad",$centrosel);
  $ssql="insert into ciudades (centro, ciudad, provincia, cpostal, abreviado) values (1, '$ciudad', $provincia, '$cpostal', '$abreviado')";
} else {
  $aud->regAud("Ciudades",$usr->getId(),"Modifica ciudad: $ciudad",$centrosel);
  $ssql="update ciudades set ciudad='$ciudad', provincia=$provincia, cpostal='$cpostal', abreviado='$abreviado' where id=$id";
}
$conx->getConsulta($ssql);
//echo $ssql."<br>";
?>
<html>
<body>
<form name="form1" id="form1" action="planb_ciu_main.php" method="post">
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
