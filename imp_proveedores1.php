<?php
/*
 * Creado el 14/05/2019 16:34:35
 * Autor: gus
 * Archivo: imp_proveedores1.php
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
$borrar=$glo->getGETPOST("borrar");
$conn=$conx->conectarBase();
$lines=file("proveedores.csv");
if($run==1 and $borrar==1) {
    $ssql="truncate adm_prv";
    $conx->consultaBase($ssql, $conn);
}
foreach ($lines as $line_num => $line) {
    $datos=explode(";", $line);
    $id=$datos[0];
    $razonsocial=$datos[1];
    $domicilio=$datos[2];
    $localidad=$datos[3];
    $telefono=$datos[5];
    $condicioniva=$datos[6];
    $cuit=$datos[7];
    //echo "cuit: $cuit<br>";
    $cuit= str_replace("-", "", $cuit);
    $cuit=ltrim(rtrim($cuit));
    //echo "cuitr: $cuit<br>";
    
    // verificar si existe la ciudad
    
    $niva=$condicioniva;
    switch ($condicioniva) {
        case 1:
            $niva=3;
            break;
        case 2:
            break;
        case 3:
            break;
    }
//    echo "iva: $niva<br>";
    if($niva=="") $niva=1;
    
    
    $ssql="insert into adm_prv (apellido, direccion, ciudad, telefono, condiva, cuit, tipo, codigodinardi) values ('$razonsocial', '$domicilio', '$localidad', '$telefono', $niva, '$cuit', 1, $id)";
    echo $ssql."<br>";
    if($run==1) $conx->consultaBase ($ssql, $conn);
}

$lines=file("proveedores_varios.csv");
foreach ($lines as $line_num => $line) {
    $datos=explode(";", $line);
    $id=$datos[0];
    $razonsocial=$datos[1];
    $domicilio=$datos[2];
    $localidad=$datos[3];
    $telefono=$datos[5];
    $condicioniva=$datos[6];
    $cuit=$datos[7];
    //echo "cuit: $cuit<br>";
    $cuit= str_replace("-", "", $cuit);
    $cuit=ltrim(rtrim($cuit));
    //echo "cuitr: $cuit<br>";
    $ssql="select * from adm_prv where codigodinardi=$id";
    if($conx->getCantidadRegA($ssql, $conn)==0) {

        // verificar si existe la ciudad

        $niva=$condicioniva;
        switch ($condicioniva) {
            case 1:
                $niva=3;
                break;
            case 2:
                break;
            case 3:
                break;
        }
    //    echo "iva: $niva<br>";
        if($niva=="") $niva=1;


        $ssql="insert into adm_prv (apellido, direccion, ciudad, telefono, condiva, cuit, tipo, codigodinardi) values ('$razonsocial', '$domicilio', '$localidad', '$telefono', $niva, '$cuit', 2, $id)";
        echo $ssql."<br>";
        if($run==1) $conx->consultaBase ($ssql, $conn);
    }
}


?>
