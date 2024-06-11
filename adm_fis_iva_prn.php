<?php
/*
 * creado el 03/01/2018 14:42:08
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_fis_iva_prn
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
require_once 'impresion/pdf_fis_iva.php';
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

$adm=new adm_fis_2($ssql);
//echo $ssql;    
$a_id=$adm->getId();
$a_cli=$adm->getCliente();
$a_fec=$adm->getFecha();
$a_civa=$adm->getCondicionivades();
$a_tot=$adm->getTotal();
$a_per=$adm->getPercepcioniibb();
$a_pag=$adm->getImportepago();
$a_com=$adm->getTipo();
$a_comd=$adm->getTipodes();
$a_let=$adm->getLetra();
$a_pto=$adm->getPtovta();
$a_nro=$adm->getNumero();
$a_ttt=$adm->getTipopagodes();
$a_cae=$adm->getNumerocae();
$a_fee=$adm->getFechacae();
$a_neto=$adm->getNeto();
$a_neto10=$adm->getNeto10();
$a_neto21=$adm->getNeto21();
$a_iva10=$adm->getIva10();
$a_iva21=$adm->getIva21();
$a_iva=$adm->getIva();
$a_ngr=$adm->getNogravado();
$a_nrocuit=$adm->getNrocuit();
$a_total=$adm->getTotaltotal();



$cartel="IVA VENTAS desde ".date("d/m/Y", strtotime($fechainifis))." hasta ".date("d/m/Y", strtotime($fechafinfis));

$tneto=0;
$tiva=0;
$colu=array(7,20,55,120,130,140, 165, 190, 205, 222,240, 260, 280);
$pdf=new PDF_fis_iva("L", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();

