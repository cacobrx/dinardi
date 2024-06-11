<?php
/*
 * Creado el 05/10/2019 17:14:53
 * Autor: gus
 * Archivo: fix_elimina_crmdet.php
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
$ssql="select * from adm_crem_det";
$rs=$conx->consultaBase($ssql, $conn);
$condicion="";
while($reg=mysqli_fetch_object($rs)) {
    $ssql="select * from adm_crem where id=".$reg->idrem;
    echo $ssql."<br>";
    echo $conx->getCantidadRegA($ssql, $conn)."<br>";
    if($conx->getCantidadRegA($ssql, $conn)==0)
        $condicion.="id=".$reg->id." or ";
}

if($condicion!="") {
    $ssql="delete from adm_crem_det where ".substr($condicion,0,strlen($condicion)-4);
    echo $ssql."<br>";
    if($run==1) $conx->consultaBase ($ssql, $conn);
}
?>
