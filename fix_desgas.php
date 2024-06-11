<?php
/*
 * creado el 29 jun. 2022 17:51:58
 * Usuario: gus
 * Archivo: fix_desgas
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
$glo = new globalson();
$conx = new conexion();
$sup = new support();
$dsup = new datesupport();
$conn=$conx->conectarBase();
$ssql="select * from adm_gas";
$rs=$conx->consultaBase($ssql, $conn);
$ssql="insert into adm_com_det (idgas, detalle, descriptor1, descriptor2, descriptor3, descriptor4, importe) values ";
while($reg=mysqli_fetch_object($rs)) {
    $ssql.="(".$reg->id.", '".$reg->detalle."', ".$reg->descriptor1.", ".$reg->descriptor2.", ".$reg->descriptor3.", ".$reg->descriptor4.", ".$reg->importe."), ";
}
if($ssql!="") $ssql=substr($ssql,0,strlen($ssql)-2);
echo $ssql."<br>";
$conx->consultaBase($ssql, $conn);
?>
