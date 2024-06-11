<?php
/*
 * Creado el 17/07/2020 20:56:39
 * Autor: gus
 * Archivo: adm_compras_exp.php
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
$formatoexc=$glo->getGETPOST("formatoexc");

$ssql="select * from adm_com where centro=$centrosel and $campofechacom>='$fechainicom' and $campofechacom<='$fechafincom' and letra='A' or letra='B'";
$puntodec=$cfg->getPuntodecimal();
if($proveedorcom>0)
    $ssql.=" and idprv=$proveedorcom";
$ssqt="select sum(totaltotal) as totalcom from adm_com where $campofechacom>='$fechainicom' and $campofechacom<='$fechafincom'";
if($proveedorcom>0)
    $ssqt.=" and idprv=$proveedorcom";
//echo $ssqt;
$rt=$conx->getConsulta($ssqt);
$rtt=  mysqli_fetch_object($rt);
$totalcom=$rtt->totalcom;
$ssql.=" order by fecha";
//$ssql="Select * from adm_com where id=2663";
$adm=new adm_com_2($ssql);
//echo $ssql."<br>";    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_let=$adm->getLetra();
$a_com=$adm->getTipocomabr();
$a_pto=$adm->getPtovta();
$a_num=$adm->getNumero();
$a_prv=$adm->getProveedor();
$a_neto21=$adm->getNeto21();
$a_neto10=$adm->getNeto10();
$a_neto27=$adm->getNeto27();
$a_iva21=$adm->getIva21();
$a_iva10=$adm->getIva10();
$a_iva27=$adm->getIva27();
$a_pri=$adm->getPeriva();
$a_rti=$adm->getRetiva();
$a_prb=$adm->getPerretiibb();
$a_exe=$adm->getExento();
$a_ngr=$adm->getNogravado();
$a_fev=$adm->getFechaimputacion();
$a_imi=$adm->getImpinternos();
$a_mov=$adm->getMovimiento();
$a_asi=$adm->getCantidadasientos();
$a_nasi=$adm->getAsientos();
$m_det=$adm->getMov_detallecon();
$m_ent=$adm->getMov_entrada();
$m_sal=$adm->getMov_salida();
$m_cta=$adm->getMov_cuentades();
$d_ent=$adm->getDet_entrada();
$d_sal=$adm->getDet_salida();
$d_cta=$adm->getDet_cuentades();



header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=compras.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Fecha</th> ";
echo "<th>As</th> ";
echo "<th>Cm</th> ";
echo "<th>Numero</th> ";
echo "<th>Proveedor</th>";
echo "<th>Neto 21</th> ";
echo "<th>Neto 10</th> ";
echo "<th>Neto 27</th> ";
echo "<th>Exento</th> ";
echo "<th>No Gravado</th> ";
echo "<th>Iva 21</th> ";
echo "<th>Iva 10</th> ";
echo "<th>Iva 27</th> ";
echo "<th>Impuestos</th> ";
echo "<th>Perc.Ret</th> ";
echo "<th>Total</th> ";
echo "<th>F.Imput</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_fec);$i++) {    
    $cadenaasi="";
    for($a=0;$a<count($a_nasi[$i]);$a++) {
        $cadenaasi.=$a_nasi[$i][$a]." ";
    }
    echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";
    echo "<td>".$cadenaasi."</td>";
    echo "<td>".$a_com[$i]."</td>";
    echo "<td>".$a_let[$i]."-".substr("0000",0,4-strlen($a_pto[$i])).$a_pto[$i]."-".substr("00000000",0,8-strlen($a_num[$i])).$a_num[$i]."</td>";
    echo "<td>".substr($a_prv[$i],0,30)."</td>";
    echo "<td>".number_format($a_neto21[$i],2,",","")."</td>";
    echo "<td>".number_format($a_neto10[$i],2,",","")."</td>";
    echo "<td>".number_format($a_neto27[$i],2,",","")."</td>";
    echo "<td>".number_format($a_exe[$i],2,",","")."</td>";
    echo "<td>".number_format($a_ngr[$i],2,",","")."</td>";
    echo "<td>".number_format($a_iva21[$i],2,",","")."</td>";    
    echo "<td>".number_format($a_iva10[$i],2,",","")."</td>";    
    echo "<td>".number_format($a_iva27[$i],2,",","")."</td>";    
    echo "<td>".number_format($a_imi[$i],2,",","")."</td>";    
    echo "<td>".number_format($a_pri[$i] + $a_rti[$i] + $a_prb[$i],2,",","")."</td>";
    echo "<td>".number_format($a_neto21[$i] + $a_neto10[$i] + $a_neto27[$i] + $a_iva21[$i] + $a_iva10[$i] + $a_iva27[$i] + $a_imi[$i] + $a_pri[$i] + $a_rti[$i] + $a_prb[$i] + $a_exe[$i] + $a_ngr[$i],2,$puntodec,"")."</td>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fev[$i])."</td>";
    echo "</tr>";
}