<?php
/*
 * Creado el 23/05/2019 17:29:04
 * Autor: gus
 * Archivo: imp_art.php
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
$lines=file("productos.csv");
if($run==1) {
    $ssql="truncate adm_art";
    $conx->consultaBase($ssql, $conn);
}
foreach ($lines as $line_num => $line) {
    $datos=explode(";", $line);
    $id=$datos[0];
    $descripcion=$datos[1];
    $rubro=0;
    switch ($id) { 
        case ($id>=1 and $id<=99):
            $rubro=1;
            break;
        case ($id>=100 and $id<=149):
            $rubro=2;
            break;
        case ($id>=150 and $id<=160):
            $rubro=3;
            break;
        case ($id>=200 and $id<=249):
            $rubro=7;
            break;
        case ($id>=250 and $id<=256):
            $rubro=8;
            break;
        case ($id>=301 and $id<=399):
            $rubro=4;
            break;
        case ($id>=400 and $id<=499):
            $rubro=6;
            break;
        case ($id>=500 and $id<=599):
            $rubro=5;
            break;
        case ($id>=600 and $id<=699):
            $rubro=10;
            break;
        case ($id>=700 and $id<=799):
            $rubro=11;
            break;
        case ($id>=800 and $id<=899):
            $rubro=9;
            break;
        case ($id>=900 and $id<=999):
            $rubro=10;
            break;
    }
    
    $ssql="insert into adm_art (descripcion, rubro, codigodinardi) values ('$descripcion', $rubro, '$id')";
    echo $ssql."<br>";
    if($run==1) $conx->consultaBase ($ssql, $conn);
}

?>
