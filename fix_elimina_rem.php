<?php
/*
 * Creado el 18/10/2019 14:05:19
 * Autor: gus
 * Archivo: fix_elimina_rem.php
 * planbsistemas.com.ar
 */

require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
$conx = new conexion();
$sup = new support();
$glo = new globalson();
$conn=$conx->conectarBase();
$run=$glo->getGETPOST("run");
$condicion="";
$ssql="select * from adm_rem where fecha<'2019-09-30'";
$rs=$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";
while($reg=mysqli_fetch_object($rs)) {
    $condicion.="idcrm=".$reg->id." or ";
}
if($condicion!="") {
    $ssql="delete from adm_rem_det where ".substr($condicion,0,strlen($condicion)-4);
    echo $ssql."<br>";
    if($run==1) $conx->consultaBase ($ssql, $conn);
    $ssql="delete from adm_rem where fecha<'2019-09-30'";
    echo $ssql."<br>";
    if($run==1) $conx->consultaBase ($ssql, $conn);
}
