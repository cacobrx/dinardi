<?php
/*
 * Creado el 29/07/2015 11:49:55
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_fis_exc
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
if($clientefis!="") 
    $condicion.="instr(upper(cliente), '".strtoupper($clientefis)."')>0 and ";
if($condicion!="")
    $condicion=" where centro=$centrosel and ".substr($condicion,0,strlen($condicion)-5);


//echo $ssqt;
switch ($ordenfis) {
    case 0:
        $ordenorden="adm_fis.tipo, adm_fis.letra, adm_fis.ptovta, adm_fis.numero, adm_fis.fecha, adm_fis.id";
        break;
    case 1:
        $ordenorden="adm_fis.id";
        break;
}
$ssql="select adm_fis.* from adm_fis $condicion order by $ordenorden";

$totaltotal=0;
$rt=$conx->getConsulta($ssql);
while($rtt=mysqli_fetch_object($rt)) {
    //echo $rtt->netocf21."\n";
    if($rtt->tipo=="C") {
        $totaltotal-=$rtt->total;
    } else {
        $totaltotal+=$rtt->total;
    }
}


$adm=new adm_fis_2($ssql);
//echo $ssql;    
$a_id=$adm->getId();
$a_cli=$adm->getCliente();
$a_fec=$adm->getFecha();
$a_civa=$adm->getCondicionivades();
$a_tot=$adm->getTotaltotal();
$a_pag=$adm->getImportepago();
$a_com=$adm->getTipo();
$a_let=$adm->getLetra();
$a_pto=$adm->getPtovta();
$a_nro=$adm->getNumero();
//$a_prn=$adm->getImprimir();
$a_ttt=$adm->getTipopagodes();
$a_cae=$adm->getNumerocae();
$a_fee=$adm->getFechacae();
$a_cui=$adm->getNrocuit();
$a_netri21=$adm->getNetori21();
$a_netri10=$adm->getNetori10();
$a_netcf21=$adm->getNetocf21();
$a_netcf10=$adm->getNetocf10();
$a_ivari10=$adm->getIvari10();
$a_ivari21=$adm->getIvari21();
$a_ivacf10=$adm->getIvacf10();
$a_ivacf21=$adm->getIvacf21();
$cantidadtotal=$adm->getMaxRegistros();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=comprobantes_fiscales.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Tipo</th> ";
echo "<th>Letra</th> ";
echo "<th>PtoVta</th> ";
echo "<th>Numero</th> ";
echo "<th>Fecha</th> ";
echo "<th>Cliente</th> ";
echo "<th>CUIT/DNI</th> ";
echo "<th>CI</th> ";
echo "<th>Neto RI 21%</th> ";
echo "<th>Iva RI 21%</th> ";
echo "<th>Neto RI 10.5%</th> ";
echo "<th>Iva RI 10.5%</th> ";
echo "<th>Neto CF 21%</th> ";
echo "<th>Iva CF 21%</th> ";
echo "<th>Neto CF 10.5%</th> ";
echo "<th>Iva CF 10.5%</th> ";
echo "<th>Total</th> ";
echo "</tr> ";  



for ($i=0;$i<count($a_com);$i++) {
    if($a_com[$i]=="C") {
        $a_netri10[$i]=$a_netri10[$i]*-1;
        $a_netri21[$i]=$a_netri21[$i]*-1;
        $a_netcf10[$i]=$a_netcf10[$i]*-1;
        $a_netcf21[$i]=$a_netcf21[$i]*-1;
        $a_ivari10[$i]=$a_ivari10[$i]*-1;
        $a_ivari21[$i]=$a_ivari21[$i]*-1;
        $a_ivacf10[$i]=$a_ivacf10[$i]*-1;
        $a_ivacf21[$i]=$a_ivacf21[$i]*-1;
    }
        
    echo "<tr>";
    echo "<td>".$a_com[$i]."</td>";
    echo "<td>".$a_let[$i]."</td>";
    echo "<td>".$a_pto[$i]."</td>";
    echo "<td>".$a_nro[$i]."</td>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";
    echo "<td>".$a_cli[$i]."</td>";
    echo "<td>".$a_cui[$i]."</td>";
    echo "<td>".$a_civa[$i]."</td>";
    echo "<td>".number_format($a_netri21[$i],2,',','')."</td>";
    echo "<td>".number_format($a_ivari21[$i],2,',','')."</td>";
    echo "<td>".number_format($a_netri10[$i],2,',','')."</td>";
    echo "<td>".number_format($a_ivari10[$i],2,',','')."</td>";
    echo "<td>".number_format($a_netcf21[$i],2,',','')."</td>";
    echo "<td>".number_format($a_ivacf21[$i],2,',','')."</td>";
    echo "<td>".number_format($a_netcf10[$i],2,',','')."</td>";
    echo "<td>".number_format($a_ivacf10[$i],2,',','')."</td>";
    echo "<td>".number_format($a_netcf10[$i]+$a_netcf21[$i]+$a_netri10[$i]+$a_netri21[$i]+$a_ivacf10[$i]+$a_ivacf21[$i]+$a_ivari10[$i]+$a_ivari21[$i],2,',','')."</td>";
    echo "</tr>";
}
?>
