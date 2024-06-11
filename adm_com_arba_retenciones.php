<?php
/*
 * Creado el 10/01/2020 08:26:19
 * Autor: gus
 * Archivo: adm_fis_arba.php
 * planbsistemas.com.ar
 */


require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_com.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
 
$ssql="select * from adm_com where centro=$centrosel and $campofechacom>='$fechainicom' and $campofechacom<='$fechafincom' and perretiibb>0";
if($proveedorcom>0)
    $ssql.=" and idprv=$proveedorcom";
$ssqt="select sum(totaltotal) as totalcom from adm_com where $campofechacom>='$fechainicom' and $campofechacom<='$fechafincom' and perretiibb>0";
if($proveedorcom>0)
    $ssqt.=" and idprv=$proveedorcom";
//echo $ssqt;
$rt=$conx->getConsulta($ssqt);
$rtt=  mysqli_fetch_object($rt);
$totalcom=$rtt->totalcom;
$ssql.=" order by fecha";
//echo $ssql."<br>";
//$ssql="Select * from adm_com where id=2663";
$adm=new adm_com_2($ssql);
$a_id=$adm->getId();
$a_cuit=$adm->getIvaprov();
$a_fec=$adm->getFecha();
$a_pto=$adm->getPtovta();
$a_nro=$adm->getNumero();
$a_imp=$adm->getPerretiibb();
$cad="";

for($i=0;$i<count($a_id);$i++) {
    
    $cuit=substr($a_cuit[$i],0,2)."-".substr($a_cuit[$i],2,8)."-".substr($a_cuit[$i],10,1);
    $cad.=$cuit.date("d/m/Y", strtotime($a_fec[$i])).$sup->AddZeros($a_pto[$i], 4).$sup->AddZeros($a_nro[$i], 8).$sup->AddZeros(number_format($a_imp[$i],2,".",""), 11)."A";
    
    $cad.="\r\n";
}

$archivo="AR-".$cfg->getFiscalcuit()."-".date("Ym", strtotime($fechainicom))."6-Retenciones-Lote1.txt";

$destino="$archivo";

$target=fopen($archivo, "w");
fwrite($target, $cad);
fclose($target);


$zip=new ZipArchive();
$md5= md5_file($archivo);
$zipfile=$archivo."_".$md5.".zip";
if($zip->open($zipfile, ZIPARCHIVE::CREATE)===true) {
    $zip->addFile($archivo);
    $zip->close();
    $cartel="El archivo comprimido fue creado correctamente.";
} else
    $cartel="Error al crear el archivo comprimido.";

header("Content-disposition: attachment; filename=$zipfile");
header("Content-type: application/zip");
readfile($zipfile);


?>
