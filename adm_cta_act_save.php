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
$nombre=$glo->getGETPOST("nombre");
$tipo=$glo->getGETPOST("tipo");
$id=$glo->getGETPOST("id");
$tarea=$glo->getGETPOST("tarea");
$codigo=$glo->getGETPOST("codigo");
if($tarea=="A") {
  $aud->regAud("ADM Cuentas",$usr->getId(),"Ingresa nueva cuenta: $codigo | $nombre | $tipo",$centrosel,$centrosel);
  $ssql="insert into adm_cta (nombre, tipo, centro, codigo) values ('$nombre', $tipo, ".$centrosel.", '$codigo')";
} else {
  $aud->regAud("ADM Cuentas",$usr->getId(),"Modifica cuenta: $codigo | $nombre | $tipo",$centrosel, $centrosel);
  $ssql="update adm_cta set nombre='$nombre', tipo=$tipo, codigo='$codigo' where id=$id";
}
$conx->getConsulta($ssql);
//echo $ssql."<br>";
?>
<html>
<body>
<form name="form1" id="form1" action="adm_cta_main.php" method="post">
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
