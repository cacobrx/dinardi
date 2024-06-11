<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
$a_ngr=$adm->getNogravado();
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
$a_nrocuit=$adm->getNrocuit();
$a_total=$adm->getTotaltotal();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ivaventas.xls");
header("Pragma: no-cache");
header("Expires: 0"); 
$tiva10=0;
$tiva21=0;
$tneto=0;
echo "<table border='1'>";
echo "<tr>";
echo "<th>Fecha</th>";
echo "<th>Comp.</th>";
echo "<th>R.Social</th>";
echo "<th>IVA</th>";
echo "<th>Doc</th>";
echo "<th>Numero</th>";
echo "<th>Neto Gravado</th>";
echo "<th>IVA</th>";
echo "<th>Exentos</th>";
echo "<th>Int/No Alc.</th>";
echo "<th>Retenciones</th>";
echo "<th>Percepciones</th>";
echo "<th>Total</th>";
echo "</tr>";
for($i=0;$i<count($a_id);$i++) {
    if($a_com[$i]=="F" or $a_com[$i]=="D" or $a_com[$i]=="G" or $a_com[$i]=="I") {
        $tneto+=$a_neto10[$i]+$a_neto21[$i];
        $tiva10+=$a_iva10[$i];
        $tiva21+=$a_iva21[$i];
        $signo="";
    } else {
        $tn=$a_neto10[$i]+$a_neto21[$i];
        $tneto-=$tn;
        $tiva10-=$a_iva10[$i];
        $tiva21-=$a_iva21[$i];
        $signo="-";
    }    
    echo "<tr>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";
    echo "<td>".$a_com[$i]."-".$a_let[$i]."-".substr("0000",0,4-strlen($a_pto[$i])).$a_pto[$i]."-".substr("00000000",0,8-strlen($a_nro[$i])).$a_nro[$i]."</td>";
    echo "<td>".substr(utf8_decode($a_cli[$i]),0,34)."</td>";
    echo "<td>".$a_civa[$i]."</td>";
    echo "<td>CUIT</td>";    
    echo "<td>".$a_nrocuit[$i]."</td>";
    echo "<td>".$signo.number_format($a_neto[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".$signo.number_format($a_iva[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td></td>";
    echo "<td>".$signo.number_format($a_ngr[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td></td>";
    echo "<td>".$signo.number_format($a_per[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".$signo.number_format($a_neto[$i]+$a_iva[$i]+$a_per[$i]+$a_ngr[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "</tr>";
}



echo "</table>";