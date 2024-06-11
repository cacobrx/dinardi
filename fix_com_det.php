<?php
/*
 * Creado el 22/07/2020 10:27:42
 * Autor: gus
 * Archivo: fix_com_det.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$conn=$conx->conectarBase();
$run=$glo->getGETPOST("run");
$ssql="select * from adm_com where descriptor1>0";
$rs=$conx->consultaBase($ssql, $conn);
while($reg= mysqli_fetch_object($rs)) {
    $ssql="insert into adm_com_det (idcom, descriptor1, descriptor2, descriptor3, descriptor4, importe, detalle) values (";
    $ssql.=$reg->id.", ".$reg->descriptor1.", ".$reg->descriptor2.", ".$reg->descriptor3.", ".$reg->descriptor4.", ".$reg->totaltotal.", '".$reg->detalle."')";
    echo $ssql."<br>";
    if($run==1) $conx->consultaBase ($ssql, $conn);
}
?>
