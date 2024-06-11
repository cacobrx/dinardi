<?php
/*
 * Creado el 25/03/2020 18:19:49
 * Autor: gus
 * Archivo: adm_com_iva_compras.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_com.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'impresion/iva_compras.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$ssql="select * from adm_com where centro=$centrosel and $campofechacom>='$fechainicom' and $campofechacom<='$fechafincom' and letra!='X'";
if($proveedorcom>0)
    $ssql.=" and idprv=$proveedorcom";
$ssqt="select sum(totaltotal) as totalcom from adm_com where $campofechacom>='$fechainicom' and $campofechacom<='$fechafincom' and letra!='X'";
if($proveedorcom>0)
    $ssqt.=" and idprv=$proveedorcom";
//echo $ssqt;
$rt=$conx->getConsulta($ssqt);
$rtt=  mysqli_fetch_object($rt);
$totalcom=$rtt->totalcom;
$ssql.=" order by $campofechacom";
//$ssql="Select * from adm_com where id=2663";
$adm=new adm_com_2($ssql);
//echo $ssql."<br>";    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_let=$adm->getLetra();
$a_com=$adm->getTipocomabr();
$a_pto=$adm->getPtovta();
$a_cuit=$adm->getIvaprov();
$a_civa=$adm->getTipoivades();
$a_num=$adm->getNumero();
$a_prv=$adm->getProveedor();
$a_neto21=$adm->getNeto21();
$a_neto10=$adm->getNeto10();
$a_neto27=$adm->getNeto27();
$a_neto17=$adm->getNeto17();
$a_iva21=$adm->getIva21();
$a_iva10=$adm->getIva10();
$a_iva27=$adm->getIva27();
$a_iva17=$adm->getIva17();
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
$a_comx=$adm->getComprobantetodo();

//print_r($a_pri);
//print_r($a_rti);
//print_r($a_prb);
//print_r($a_iva);
$cartel="IVA COMPRAS desde ".date("d/m/Y", strtotime($fechainicom))." hasta ".date("d/m/Y", strtotime($fechafincom));

$tneto=0;
$tiva=0;

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ivacompras.xls");
header("Pragma: no-cache");
header("Expires: 0"); 


echo "<table border='1'>";
echo "<tr>";
echo "<th>Fecha</th>";
echo "<th>Comp.</th>";
echo "<th>R.Social</th>";
echo "<th>Cuit</th>";
echo "<th>C.I.</th>";
echo "<th>IVA</th>";
echo "<th>Neto Gravado</th>";
echo "<th>Exentos</th>";
echo "<th>Int/No Alc.</th>";
echo "<th>Retenciones</th>";
echo "<th>Percepciones</th>";
echo "<th>Total</th>";
echo "</tr>";
for($i=0;$i<count($a_id);$i++) {
    if($a_com[$i]=="FC" or $a_com[$i]=="ND") {
        $tneto+=$a_neto10[$i]+$a_neto21[$i]+$a_neto27[$i]+$a_neto17[$i];
        $tiva+=$a_iva10[$i]+$a_iva21[$i]+$a_iva27[$i]+$a_iva17[$i];
        $signo="";
    } else {
        $tr=$a_rti[$i]+$a_pri[$i]+$a_prb[$i];
        $tn=$a_neto10[$i]+$a_neto21[$i]+$a_neto27[$i]+$a_neto17[$i];
        $ti=$a_iva10[$i]+$a_iva21[$i]+$a_iva27[$i]+$a_iva17[$i];
        $tneto-=$tn;
        $tiva-=$ti;
        $signo="-";

    }    
    echo "<tr>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";
    echo "<td>".$a_com[$i]."-".$a_let[$i]."-".substr("0000",0,4-strlen($a_pto[$i])).$a_pto[$i]."-".substr("00000000",0,8-strlen($a_num[$i])).$a_num[$i]."</td>";
    echo "<td>".substr(utf8_decode($a_prv[$i]),0,34)."</td>";
    echo "<td>".$a_cuit[$i]."</td>";
    echo "<td>".$a_civa[$i]."</td>";    
    echo "<td>".$signo.number_format($a_neto10[$i]+$a_neto21[$i]+$a_neto27[$i]+$a_neto17[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".$signo.number_format($a_iva10[$i]+$a_iva21[$i]+$a_iva27[$i]+$a_iva17[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".$signo.number_format($a_exe[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".$signo.number_format($a_ngr[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".$signo.number_format($a_rti[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".$signo.number_format($a_pri[$i]+$a_prb[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".$signo.number_format($a_neto10[$i]+$a_neto21[$i]+$a_iva21[$i]+$a_neto27[$i]+$a_iva10[$i]+$a_iva27[$i]+$a_exe[$i]+$a_ngr[$i]+$a_rti[$i]+$a_prb[$i]+$a_pri[$i]+$a_iva17[$i]+$a_neto17[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "</tr>";
}


echo "</table>";