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
$apellido=$glo->getGETPOST("apellido");
$email=$glo->getGETPOST("email");
$nivel=$glo->getGETPOST("nivel");
$id=$glo->getGETPOST("id");
$servidorafip=$glo->getGETPOST("servidorafip");
if($servidorafip=="") $servidorafip=0;
$tarea=$glo->getGETPOST("tarea");
if($tarea=="A") {
  $aud->regAud("USUARIOS",$usr->getId(),"Ingresa nuevo usuario: $apellido $nombre",$centrosel);
  $ssql="insert into usuarios (apellido, nombre, email, nivel, servidorafip) values ('$apellido', '$nombre', '$email', $nivel, $servidorafip)";
} else {
  $aud->regAud("USUARIOS",$usr->getId(),"Modifica usuario: $apellido $nombre",$centrosel);
  $ssql="update usuarios set apellido='$apellido', nombre='$nombre', email='$email', nivel=$nivel, servidorafip=$servidorafip, fechamod='".date("Y-m-d H:i:s")."' where id=$id";
}
$conx->getConsulta($ssql);
//echo $ssql."<br>";
?>
<html>
<body>
<form name="form1" id="form1" action="planb_usr_main.php" method="post">
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
