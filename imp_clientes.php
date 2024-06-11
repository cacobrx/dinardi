<?php
/*
 * Creado el 14/05/2019 15:11:39
 * Autor: gus
 * Archivo: imp_clientes.php
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
$lines=file("clientes.csv");
if($run==1) {
    $ssql="truncate adm_cli";
    $conx->consultaBase($ssql, $conn);
    $ssql="truncate ciudades";
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
    $ssql="select * from ciudades where ciudad='$localidad'";
    echo $ssql."<br>";
    if($conx->getCantidadRegA($ssql, $conn)==0) {
        $ssql="insert into ciudades (centro, ciudad) values (1, '$localidad')";
        $conx->consultaBase($ssql, $conn);
        $idciu=$conx->getLastId("ciudades", $conn);
    } else {
        $rc=$conx->consultaBase($ssql, $conn);
        $rcc=mysqli_fetch_object($rc);
        $idciu=$rcc->id;
    }
    
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
    
    
    $ssql="insert into adm_cli (apellido, direccion, ciudad, telefono, condicioniva, cuil) values ('$razonsocial', '$domicilio', $idciu, '$telefono', $niva, '$cuit')";
    echo $ssql."<br>";
    if($run==1) $conx->consultaBase ($ssql, $conn);
}

?>
