<?php
/*
 * creado el 4 mar. 2022 08:18:30
 * Usuario: gus
 * Archivo: fix_cht
 */

require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
$glo = new globalson();
$conx = new conexion();
$sup = new support();
$dsup = new datesupport();
$conn=$conx->conectarBase();
$ssql="select * from adm_opg2 where instr(detalle,'Ch ')>0";
$rs=$conx->consultaBase($ssql, $conn);
while($reg=mysqli_fetch_object($rs)) {
    $dat=explode(' ',$reg->detalle);
    $nc=$dat[count($dat)-2];
//    echo $reg->detalle." | $nc<br>";
    $ssql="select * from adm_cht where nrocheque=$nc and entregado=''";
    if($conx->getCantidadRegA($ssql, $conn)>0) {
        $rc=$conx->consultaBase($ssql, $conn);
        $rcc=mysqli_fetch_object($rc);
        echo $reg->detalle." | $nc | ".$rcc->id." | ".$reg->idop."<br>";
    }
}
?>
