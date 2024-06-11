<?php
/*
 * Creado el 10/01/2020 08:52:14
 * Autor: gus
 * Archivo: adm_fis_arba_percepciones.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_fis.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_fis_det.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$conx=new conexion();
$xlimmax=$cfg->getLimmax ();
$condicion="adm_fis.fecha>='$fechainifis' and adm_fis.fecha<='$fechafinfis' and ";
if($clientefis>0)
    $condicion.="adm_fis.idcli=$clientefis and ";
if($numerofis>0)
    $condicion.="adm_fis.numero=$numerofis and ";
if($ptoventafis>0)
    $condicion.="adm_fis.ptovta=$ptoventafis and ";
if($letrafis!="")
    $condicion.="adm_fis.letra='$letrafis' and ";
if($tipocomfis!="")
    $condicion.="adm_fis.tipo='$tipocomfis' and ";
//if($clientefis!="") 
//    $condicion.="instr(upper(cliente), '".strtoupper($clientefis)."')>0 and ";
if($clientefis!="") {
    $partes=explode(" ", $clientefis);
    $datonombre="%";
    for($i=0;$i<count($partes);$i++) {
        $ntex=strlen($partes[$i]);
        $datonombre.=$partes[$i]."%";
    }
    $condicion.="concat_ws(' ', adm_cli.apellido, adm_cli.nombre) like '".strtoupper($datonombre)."' and ";
}

if($condicion!="")
    $condicion=" where ".substr($condicion,0,strlen($condicion)-5);


//echo $ssqt;
switch ($ordenfis) {
    case 0:
        $ordenorden="adm_fis.tipo, adm_fis.letra, adm_fis.ptovta, adm_fis.numero, adm_fis.fecha, adm_fis.id";
        break;
    case 1:
        $ordenorden="adm_fis.id";
        break;
}
$ssql="select sum(adm_fis_det.cantidad * adm_fis_det.precio) as totalfac from adm_fis_det, adm_fis, adm_cli $condicion and (adm_fis.tipo='F' or adm_fis.tipo='D') and adm_fis.id = adm_fis_det.idfis and adm_fis.idcli=adm_cli.id";
$rf=$conx->getConsulta($ssql);
$rff=mysqli_fetch_object($rf);
//echo $ssql;
$ssql="select sum(adm_fis_det.cantidad * adm_fis_det.precio) as totalcre from adm_fis_det, adm_fis, adm_cli $condicion and adm_fis.tipo='C' and adm_fis.id = adm_fis_det.idfis and adm_fis.idcli=adm_cli.id";
$rc=$conx->getConsulta($ssql);
$rcc=mysqli_fetch_object($rc);

$totaltotal=$rff->totalfac-$rcc->totalcre;
$ssql="select adm_fis.* from adm_fis, adm_cli $condicion and adm_fis.idcli=adm_cli.id order by $ordenorden";

//$ssql.=" limit $limfis,$xlimmax";
$adm=new adm_fis_2($ssql);
$a_id=$adm->getId();
$a_cuit=$adm->getNrocuit();
$a_fec=$adm->getFecha();
$a_pto=$adm->getPtovta();
$a_nro=$adm->getNumero();
$a_imp=$adm->getPercepcioniibb();
$a_com=$adm->getTipodes2();
$a_let=$adm->getLetra();
$a_netori10=$adm->getNetori10();
$a_netori21=$adm->getNetori21();
$a_netocf10=$adm->getNetocf10();
$a_netocf21=$adm->getNetocf21();
$cad="";

for($i=0;$i<count($a_id);$i++) {
    if($a_imp[$i]>0) {
        $cuit=substr($a_cuit[$i],0,2)."-".substr($a_cuit[$i],2,8)."-".substr($a_cuit[$i],10,1);
        $neto=$a_netori10[$i]+$a_netori21[$i]+$a_netocf10[$i]+$a_netocf21[$i];
        $neto=$sup->AddZeros(number_format($neto,2,",",""), 12);
        $perc=$sup->AddZeros(number_format($a_imp[$i],2,",",""), 11);
        if($a_com[$i]=="C") {
            $neto="-".substr($neto,1,strlen($neto));
            $perc="-".substr($perc,1,strlen($perc));
        }
        $cad.=$cuit.date("d/m/Y", strtotime($a_fec[$i])).$a_com[$i].$a_let[$i].$sup->AddZeros($a_pto[$i], 4).$sup->AddZeros($a_nro[$i], 8).$neto.$perc."A";

        $cad.="\r\n";
    }
}

$archivo="AR-".$cfg->getFiscalcuit()."-".date("Ym", strtotime($fechainifis))."0-7-Percepciones-Lote1.txt";

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
