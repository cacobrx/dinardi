<?
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once("clases/auditoria.php");
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$uu=new usuarios_1($id);
$clave=$glo->getGETPOST("clave");
$url=$glo->getGETPOST("url");
$enviamail=$glo->getGETPOST("enviamail");
$clavemd5=md5($clave);
$ssql="update usuarios set clave='$clavemd5' where id=$id";
$conx->getConsulta($ssql);
$aud->regAud("Usuarios",$usr->getId(),"Modifica clave usuario: ".$uu->getApellido()." ".$uu->getNombre(),$usr->getCentro());
if($enviamail==1) {
    $asunto=$cen->getNombre()." - Modificacion de Clave";
    $cuerpo="Se ha modificado la clave del sitio <a href='impulso.planbsistemas.com.ar'>impulso.planbsistemas.com.ar</a><br><br>";
    $cuerpo.="Usuario: ".$uu->getEmail()."<br>";
    $cuerpo.="Clave: $clave<br><br>";
    $cuerpo.=$cen->getNombre();
    mail($uu->getEmail(),$asunto,$cuerpo,"From: ".$cen->getNombre()." <".$cen->getEmail().">\nContent-Type: text/html");
}
?>
<html>
<body>
<form name="form1" id="form1" action="<?= $url?>" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
