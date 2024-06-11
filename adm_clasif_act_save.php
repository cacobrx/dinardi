<?php
/*
 * creado el 31/07/2016 18:12:59
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_clasif_act_save
 */
//print_r($_POST);
require("user.php");
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once("clases/auditoria.php");
$aud=new registra_auditoria();

$conx=new conexion();
$glo=new globalson();
$texto=$glo->getGETPOST("texto");
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
//$tipoclf=$glo->getGETPOST("tipoclf");
$tipoant=$glo->getGETPOST("tipoant");
$carteldes=$glo->getGETPOST("carteldes");
$dependencia=$glo->getGETPOST("dependencia");
$codigodep=$glo->getGETPOST("codigodep");
$activo=$glo->getGETPOST("activo");
if($dependencia=="")
    $dependencia=0;
if($tipoant=="")
    $tipoant=0;
if($codigodep=="")
$codigodep=0;
if($activo=="")
    $activo=0;

if($tarea=="A") {
    $aud->regAud("Clasificacion",$usr->getId(), "Agrega $carteldes: $texto", $centrosel);
    $ssql="insert into adm_clasif (tipo, texto, dependencia, tipodep, codigodep, activo) values ('$tipoclf', '$texto', $dependencia, '$tipoant', '$codigodep', $activo)";
} else {
    $aud->regAud("Clasificacion",$usr->getId(), "Modifica $carteldes: $texto", $centrosel);
    $ssql="update adm_clasif set texto='$texto', tipodep='$tipoant', dependencia=$dependencia, codigodep='$codigodep', activo=$activo where id=$id";
}
//echo $ssql."<br>";
$conx->getConsulta($ssql);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_clasif_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>