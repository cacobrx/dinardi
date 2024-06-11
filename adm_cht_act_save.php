<?
//print_r($_POST);
require("user.php");
require_once("clases/conexion.php");
require_once("clases/globalson.php");
require_once("clases/auditoria.php");
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$fechaorigen=$glo->getGETPOST("fechaorigen");
$fechapago=$glo->getGETPOST("fechapago");
$idbanco=$glo->getGETPOST("idbanco");
$nrocheque=$glo->getGETPOST("nrocheque");
$idche=$glo->getGETPOST("idche");
$tarea=$glo->getGETPOST("tarea");
$nombre=$glo->getGETPOST("nombre");
$idcli=$glo->getGETPOST("idcli");
$importe=$glo->getGETPOST("importe");
$acreditado=$glo->getGETPOST("acreditado");
$entregado=$glo->getGETPOST("entregado");
$fechaacr=$glo->getGETPOST("fechaacr");
$tipo=$glo->getGETPOST("tipo");
if($tarea=="A") {
  $aud->regAud("ADM Cheques Terceros",$usr->getId(),"Ingresa nuevo cheque: $idcli ($importe)",$centrosel);
  $ssql="insert into adm_cht (centro, fechaorigen, fechapago, idbanco, nrocheque, nombre, importe, idcli, entregado, fechaacr) values ($centrosel,'$fechaorigen', '$fechapago', $idbanco, '$nrocheque', '$nombre', $importe, '$idcli', '$entregado', '$fechaacr')";
} else {
    $ahora=date("Y-m-d H:i:m");
  $aud->regAud("ADM Cheques Terceros",$usr->getId(),"Modifica cheque: $idcli ($importe)",$centrosel);
  $ssql="update adm_cht set fechaorigen='$fechaorigen', fechapago='$fechapago', idbanco=$idbanco, nombre='$nombre', nrocheque='$nrocheque', importe=$importe, idcli='$idcli', entregado='$entregado', fechamod='$ahora', fechaacr='$fechaacr' where id=$idche";
}
$conx->getConsulta($ssql);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_cht_main.php" method="post">
</form>
<script languaje="javascript">
  //document.form1.submit()
</script>
</body>
</html>
