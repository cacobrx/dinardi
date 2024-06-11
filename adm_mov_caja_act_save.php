<?
/*
 * Creado el 19/05/2014 13:04:13
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_mov_caja_act_save.php
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$centro=$glo->getGETPOST("centro");
$fecha=$glo->getGETPOST("fecha");
$detalle=$glo->getGETPOST("detalle");
$importe=$glo->getGETPOST("importe");
$tipocaja=$glo->getGETPOST("tipocaja");
$descriptor1=$glo->getGETPOST("descriptor1");
$descriptor2=$glo->getGETPOST("descriptor2");
$descriptor3=$glo->getGETPOST("descriptor3");
$descriptor4=$glo->getGETPOST("descriptor4");
$segmento1=$glo->getGETPOST("segmento1");
$segmento2=$glo->getGETPOST("segmento2");
$segmento3=$glo->getGETPOST("segmento3");
$segmento4=$glo->getGETPOST("segmento4");
$oficina=$glo->getGETPOST("oficina");
$tipomov=$glo->getGETPOST("tipomov");
$cajadestino=$glo->getGETPOST("cajadestino");
$tipopago=$glo->getGETPOST("tipopago");
$idrec=$glo->getGETPOST("idrec");
$idopg=$glo->getGETPOST("idopg");
$indice=$glo->getGETPOST("indice");
if($idrec=="")
    $idrec=0;
if($idopg=="")
    $idopg=0;
if($tipopago=="")
    $tipopago=0;
//$idmov=$glo->getGETPOST("idmov");
//$tipomov=$glo->getGETPOST("tipomov");
if($descriptor1=="")
    $descriptor1=0;
if($descriptor2=="")
    $descriptor2=0;
if($descriptor3=="")
    $descriptor3=0;
if($descriptor4=="")
    $descriptor4=0;
if($segmento1=="")
    $segmento1=0;
if($segmento2=="")
    $segmento2=0;
if($segmento3=="")
    $segmento3=0;
if($segmento4=="")
    $segmento4=0;
if($oficina=="")
    $oficina=0;
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $aud->regAud("Movimientos de Caja",$usr->getId(),"Ingresa Movimientos de Caja: $fecha | $detalle | $tipocaja | $importe",$centrosel);
    $ssql="insert into adm_mov_caja (centro, fecha, detalle, tipomov, importe, tipocaja, descriptor1, descriptor2, descriptor3, descriptor4, segmento1, segmento2, segmento3, segmento4, oficina, tipopago, indice, idrec, idopg) values ($centrosel, '$fecha', '$detalle', $tipomov, $importe, $tipocaja, $descriptor1, $descriptor2, $descriptor3, $descriptor4, $segmento1, $segmento2, $segmento3, $segmento4, $oficina, $tipopago, '$indice', $idrec, $idopg)";
} else {
    $aud->regAud("Movimientos de Caja",$usr->getId(),"Modifica Movimientos de Caja: $fecha | $detalle | $tipocaja | $importe",$centrosel);
    $ssql="update adm_mov_caja set fecha='".$fecha."', tipomov=$tipomov, detalle='$detalle', importe=$importe, tipocaja=$tipocaja, descriptor1=$descriptor1, descriptor2=$descriptor2, descriptor3=$descriptor3, descriptor4=$descriptor4, segmento1=$segmento1, segmento2=$segmento2, segmento3=$segmento3, segmento4=$segmento4, oficina=$oficina, tipopago=$tipopago, indice='$indice', idrec=$idrec, idopg=$idopg where id=$id";
}
$conx->getConsulta($ssql);

if($cajadestino>0) {
    if($tipomov==0)
        $tipomovdes=1;
    else
        $tipomovdes=0;
    $aud->regAud("Movimientos de Caja",$usr->getId(),"Ingresa Movimientos de Caja: $fecha | $detalle | $cajadestino | $importe",$centrosel);
    $ssql="insert into adm_mov_caja (centro, fecha, detalle, tipomov, importe, tipocaja, descriptor1, descriptor2, descriptor3, descriptor4, segmento1, segmento2, segmento3, segmento4, oficina, tipopago) values ($centrosel, '$fecha', '$detalle', $tipomovdes, $importe, $cajadestino, $descriptor1, $descriptor2, $descriptor3, $descriptor4, $segmento1, $segmento2, $segmento3, $segmento4, $oficina, $tipopago)";
    //echo $ssql."<br>";
    $conx->getConsulta($ssql);
}
//echo "$ssql\n";
?>
<html>
<body>
<form name="form1" id="form1" action="adm_mov_caja_main.php" method="post">
<input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
