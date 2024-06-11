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
$fechadeb=$glo->getGETPOST("fechadeb");
$nrocheque=$glo->getGETPOST("nrocheque");
$id=$glo->getGETPOST("id");
$tarea=$glo->getGETPOST("tarea");
$referencia=$glo->getGETPOST("referencia");
$destinatario=$glo->getGETPOST("destinatario");
$importe=$glo->getGETPOST("importe");
$acreditado=$glo->getGETPOST("acreditado");
$entregado=$glo->getGETPOST("entregado");
if($acreditado=="") $acreditado=0;
if($entregado=="") $entregado=0;
if($tarea=="A") {
    $aud->regAud("ADM Cheques",$usr->getId(),"Ingresa nuevo cheque: $destinatario ($importe)",$centrosel);
    $ssql="insert into adm_che (centro, fechaorigen, fechapago, idbanco, nrocheque, destinatario, acreditado, importe, referencia, entregado, fechadeb) values ($centrosel, '$fechaorigen', '$fechapago', $idbanco, '$nrocheque', '$destinatario', $acreditado, $importe, '$referencia', $entregado, '$fechadeb')";
} else {
    $ahora=date("Y-m-d H:i:s");
    $aud->regAud("ADM Cheques",$usr->getId(),"Modifica cheque: $destinatario ($importe)",$centrosel);
    $ssql="update adm_che set fechaorigen='$fechaorigen', fechapago='$fechapago', idbanco=$idbanco, destinatario='$destinatario', nrocheque='$nrocheque', importe=$importe, acreditado=$acreditado, referencia='$referencia', entregado=$entregado, fechamod='$ahora', fechadeb='$fechadeb' where id=$id";
}
$conx->getConsulta($ssql);
//echo $ssql."<br>";
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_che_main.php" method="post">
    </form>
    <script languaje="javascript">
        document.form1.submit()
    </script>
</body>
</html>
