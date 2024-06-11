<?php
/*
 * Creado el 21/01/2020 20:19:44
 * Autor: gus
 * Archivo: fix_faena.php
 * planbsistemas.com.ar
 */

require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_rem.php';
$dsup = new datesupport();
$conx = new conexion();
$sup = new support();
$glo = new globalson();
$conn=$conx->conectarBase();
$ssql="select * from adm_rem";
$rs=$conx->consultaBase($ssql, $conn);
$condicion="";
while($reg=mysqli_fetch_object($rs)) {
    $ssql="select * from adm_rem_det where idrem=".$reg->id." and idart>0";
    if($conx->getCantidadRegA($ssql, $conn)==0) {
        $condicion.="id=".$reg->id." or ";
    }
}
if($condicion!="") {
    $ssql="update adm_rem set faena=1 where ".substr($condicion,0,strlen($condicion)-4);
    echo $ssql."<br>";
    $conx->getConsulta($ssql);
}
?>
