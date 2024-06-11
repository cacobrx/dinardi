<?php
/*
 * Creado el 05/10/2019 16:34:01
 * Autor: gus
 * Archivo: fix_idremdet.php
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
$ssql="select adm_crm_det.*, adm_crm.idrem from adm_crm_det, adm_crm where adm_crm.id=adm_crm_det.idcrm";
$rs=$conx->consultaBase($ssql, $conn);
while($reg= mysqli_fetch_object($rs)) {
    $ssql="select id from adm_rem_det where idrem=".$reg->idrem." and idart=".$reg->idart;
    if($conx->getCantidadRegA($ssql, $conn)) {
        $rx=$conx->consultaBase($ssql, $conn);
        $rxx=mysqli_fetch_object($rx);
        $ssql="update adm_crm_det set idremdet=".$rxx->id." where id=".$reg->id;
        echo $ssql."<br>";
        if($run==1) $conx->consultaBase ($ssql, $conn);
    }
}
?>
