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
require_once "clases/adm_fis.php";
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$fis=new adm_fis_1($id);
$ssql="delete from adm_fis where id=$id";
$conx->getConsulta($ssql);
$ssql="delete from adm_fis_det where idfis=$id";
$conx->getConsulta($ssql);
$ssql="update adm_crem set idfis=0 where idfis=$id";
$conx->getConsulta($ssql);
$aud->regAud("Comprobantes",$usr->getId(),"Elimina Comprobante: $id | ".$fis->getTipo()." | ".$fis->getLetra()." | ".$fis->getPtovta()." | ".$fis->getNumero(),$centrosel, $fis->getIdcli());
?>
<html>
<body>
<form  name="form1" id="form1" method="post" action="adm_fis_main.php">
    
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
    
