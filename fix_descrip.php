<?php
/*
 * Creado el 09/01/2020 20:25:09
 * Autor: gus
 * Archivo: fix_descrip.php
 * planbsistemas.com.ar
 */

require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_clasif.php';
$conx = new conexion();
$sup = new support();
$glo = new globalson();
$tipo=$glo->getGETPOST("tipo");
$dependencia=$glo->getGETPOST("dependencia");
$tipodep=$glo->getGETPOST("tipodep");
$archivo=$glo->getGETPOST("archivo");
$run=$glo->getGETPOST("run");
if($tipo=="") {
    echo "Falta tipo<br>";
}
if($dependencia=="") {
    echo "Falta dependencia<br>";
}
if($tipodep=="") {
    echo "Falta tipodep<br>";
}
if($archivo=="") {
    echo "Falta archivo<br>";
}
if(!file_exists($archivo))
    echo "Archivo $archivo no existe<br>";

if($tipo!="" and $dependencia!="" and $tipodep!="" and $archivo!="" and file_exists($archivo)) {
    $conn=$conx->conectarBase();
    $ssql="delete from adm_clasif where tipo='$tipo' and dependencia='$dependencia' and tipodep='$tipodep'";
    echo $ssql."<br>";
    if($run==1) $conx->consultaBase ($ssql, $conn);
    $aaa=new adm_clasif_1($dependencia, $conn);
    $codigo=$aaa->getCodigodep();
    $i=0;
    $lines=file($archivo);
    $ssql="insert into adm_clasif (tipo, dependencia, tipodep, caja, codigodep, texto, activo) values ";
    foreach ($lines as $line_num => $line) {
        if(ltrim(rtrim($line))!="") {
            $i++;
            $codigodep=$codigo.$sup->AddZeros($i, 3);
            $ssql.=" ('$tipo', $dependencia, '$tipodep', 1, '$codigodep', '$line', 1) ,";
        }
    }
    
    $ssql=substr($ssql,0,strlen($ssql)-2);
    echo $ssql."<br>";
    if($run==1) $conx->consultaBase ($ssql, $conn);
}



?>
