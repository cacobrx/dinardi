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
$cad="";

for($i=0;$i<count($a_id);$i++) {
    
    $cuit=substr($a_cuit[$i],0,2)."-".substr($a_cuit[$i],2,8)."-".substr($a_cuit[$i],10,1);
    $cad.=$cuit.date("d/m/Y", strtotime($a_fec[$i])).$sup->AddZeros($a_pto[$i], 4).$sup->AddZeros($a_nro[$i], 8).$sup->AddZeros(number_format($a_imp[$i],2,".",""), 11)."A";
    
    $cad.="\r\n";
}

$archivo="AR-".$cfg->getFiscalcuit()."-".date("Ym", strtotime($fechainifis))."-retenciones.txt";

header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=\"$archivo\";" );
header("Content-Transfer-Encoding: binary");
print $cad;

?>