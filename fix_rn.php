<?php
/*
 * Creado el 23/05/2019 20:10:19
 * Autor: gus
 * Archivo: fix_rn.php
 * planbsistemas.com.ar
 */

require_once 'clases/conexion.php';
$conx = new conexion();
$ssql="select * from adm_prd";
$conn=$conx->conectarBase();
$rs=$conx->consultaBase($ssql, $conn);
while($reg=mysqli_fetch_object($rs)) {
    $ddd= str_replace("\r\n", "", $reg->descripcion);
    echo $ddd;
    $ssql="update adm_prd set descripcion='$ddd' where id=".$reg->id;
    $conx->consultaBase($ssql, $conn);
}
$ssql="select * from adm_art";
$conn=$conx->conectarBase();
$rs=$conx->consultaBase($ssql, $conn);
while($reg=mysqli_fetch_object($rs)) {
    $ddd= str_replace("\r\n", "", $reg->descripcion);
    echo $ddd;
    $ssql="update adm_art set descripcion='$ddd' where id=".$reg->id;
    $conx->consultaBase($ssql, $conn);
}
?>
