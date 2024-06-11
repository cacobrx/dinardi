<?php
/*
 * Creado el 05/10/2020 12:53:51
 * Autor: gus
 * Archivo: fix_gastos.php
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
$ssql="select * from adm_com where letra='X'";
$rs=$conx->consultaBase($ssql, $conn);
while($reg=mysqli_fetch_object($rs)) {
    $fecha=$reg->fecha;
    $idprv=$reg->idprv;
    $ssql="select * from adm_com_det where idcom=".$reg->id;
    $rd=$conx->consultaBase($ssql, $conn);
    $rdd=mysqli_fetch_object($rd);
    $detalle=$rdd->detalle;
    $descriptor1=$rdd->descriptor1;
    $descriptor2=$rdd->descriptor2;
    $descriptor3=$rdd->descriptor3;
    $descriptor4=$rdd->descriptor4;
    $fechaven=$reg->fecha;
    $importe=$reg->totaltotal;
    $ssql="insert into adm_gas (fecha, idprv, detalle, importe, descriptor1, descriptor2, descriptor3, descriptor4, fechaven, fechapago) values (";
    $ssql.="'$fecha', $idprv, '$detalle', $importe, $descriptor1, $descriptor2, $descriptor3, $descriptor4, '$fechaven', '$fecha')";
    $conx->consultaBase($ssql, $conn);
    echo $ssql."<br>";
    
}
        
