<?php
/*
 * Creado el 03/02/2020 18:53:45
 * Autor: gus
 * Archivo: fix_cant_rem.php
 * planbsistemas.com.ar
 */

require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
$dsup = new datesupport();
$conx = new conexion();
$sup = new support();
$glo = new globalson();
$run=$glo->getGETPOST("run");
$conn=$conx->conectarBase();
$ssql="select * from adm_crm_det order by id";
$rs=$conx->consultaBase($ssql, $conn);
while($reg=mysqli_fetch_object($rs)) {
    if($reg->idremdet>0) {
        $ssql="update adm_rem_det set cantidadcrm=".$reg->cantidad." where id=".$reg->idremdet;
        echo $ssql."<br>";
        if($run==1) $conx->consultaBase ($ssql, $conn);
    }
}
?>
