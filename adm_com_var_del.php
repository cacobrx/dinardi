
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
require_once "clases/adm_com.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$id=$glo->getGETPOST("id");
$com=new adm_com_1($id);
$ssql="delete from adm_mov1 where clave='".$com->getClave()."'";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$ssql="delete from adm_mov2 where clave='".$com->getClave()."'";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$ssql="delete from adm_com where id=$id";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$aud->regAud("Compras",$usr->getId(),"Elimina Compras Varias: ".$com->getLetra()."-".$com->getPtovta()."-".$com->getNumero()." Prov: ".$com->getProveedor(),$centrosel);
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_com_var_main.php">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
