<?php
/*
 * Creado el 08/05/2020 19:00:02
 * Autor: gus
 * Archivo: adm_opg_arba_retenciones.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_opg1.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();


$condicionprv="";
if($campoopg!="") {
    $conn=$conx->conectarBase();
    $ntex=strlen($campoopg);
    if($criterioopg==1)
        $ssql="select * from adm_prv where left(upper(apellido), $ntex)='".strtoupper($campoopg)."'";
    else
        $ssql="select * from adm_prv where instr(upper(apellido),'".strtoupper($campoopg)."')>0";
    $rs=$conx->consultaBase($ssql, $conn);
    while($reg=mysqli_fetch_object($rs)) {
        $condicionprv.="idprv=".$reg->id." or ";
    }


    if($condicionprv!="")
        $condicionprv="and (".substr($condicionprv,0,strlen($condicionprv)-4).")";
    
}
    if($tipoopg>0)
        $condicionprv.="and tipo=$tipoopg";

$ssql="select * from adm_opg1 where ($campofechaopg between '$fechainiopg' and '$fechafinopg') and adm_opg1.centro=$centrosel $condicionprv and retencioniibb>0";
$ssql.=" order by $campofechaopg";

$opg=new adm_opg1_2($ssql);
$a_id=$opg->getId();
$a_fec=$opg->getFecha();
$a_pro=$opg->getProveedor();
$a_imp=$opg->getTotalimporte();
$a_con=$opg->getConcepto();
$a_ret=$opg->getRetencioniibb();
$a_tip=$opg->getTipodes();
$a_rea=$opg->getRetencionganancia();
$a_cuit=$opg->getCuit();
$a_nro=$opg->getNumeroret();

//echo $ssql."<br>";
//$ssql="Select * from adm_com where id=2663";
//$adm=new adm_com_2($ssql);
//$a_id=$adm->getId();
//$a_cuit=$adm->getIvaprov();
//$a_fec=$adm->getFecha();
//$a_pto=$adm->getPtovta();
//$a_nro=$adm->getNumero();
//$a_imp=$adm->getPerretiibb();
$cad="";

for($i=0;$i<count($a_id);$i++) {
    
    $cuit=substr($a_cuit[$i],0,2)."-".substr($a_cuit[$i],2,8)."-".substr($a_cuit[$i],10,1);
    $cad.=$cuit.date("d/m/Y", strtotime($a_fec[$i])).date("Y", strtotime($a_fec[$i])).$sup->AddZeros($a_nro[$i], 8).$sup->AddZeros(number_format($a_ret[$i],2,".",""), 11)."A";
    
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
