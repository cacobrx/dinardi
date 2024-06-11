<?php
/*
 * Creado el 07/10/2019 20:41:10
 * Autor: gus
 * Archivo: fix_preciojusto.php
 * planbsistemas.com.ar
 */

require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_cli_pre.php';
$conx = new conexion();
$sup = new support();
$glo = new globalson();
$conn=$conx->conectarBase();
$run=$glo->getGETPOST("run");
$ssql="select adm_crem_det.*, adm_crem.idcli from adm_crem_det, adm_crem where adm_crem_det.idrem=adm_crem.id";
$rs=$conx->consultaBase($ssql, $conn);
while($reg=mysqli_fetch_object($rs)) {
    $pre=new adm_cli_pre_1($reg->idcli, $reg->idpro, $conn);
    $preciofin=$pre->getPreciofinal();
    $ssql="update adm_crem_det set precio=$preciofin where id=".$reg->id;
    echo $ssql."<br>";
    if($run==1) $conx->consultaBase ($ssql, $conn);
}
?>
