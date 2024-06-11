<?php
/*
 * creado el 19/10/2016 16:21:14
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_mov_caj_exc_t
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_mov_caja.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/adm_mov_caja_ini.php';

$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);

$glo=new globalson();
$formatoexc=$glo->getGETPOST("formatoexc");
//echo "formatoexc: $formatoexc";
$puntodec=".";
if($formatoexc==1)
    $puntodec=",";
$condicion="";
//echo "Nivel: ".$usr->getNivel()."<br>";
//if($cajamcj>0)
//    $condicion=" and tipocaja=$cajamcj";
if($textomcj!="")
    $condicion.=" and (instr(upper(detalle), '".strtoupper($textomcj)."')>0 or instr(upper(indice), '".strtoupper($textomcj)."')>0)";
if($usr->getNivel()>0)
    $condicion.=" and tipocaja!=3";
if($descriptor1mcj>0)
    $condicion=" and descriptor1=$descriptor1mcj";
if($descriptor2mcj>0)
    $condicion=" and descriptor2=$descriptor2mcj";
if($descriptor3mcj>0)
    $condicion=" and descriptor3=$descriptor3mcj";
if($descriptor4mcj>0)
    $condicion=" and descriptor4=$descriptor4mcj";
if($segmento1mcj>0)
    $condicion=" and segmento1=$segmento1mcj";
if($segmento2mcj>0)
    $condicion=" and segmento2=$segmento2mcj";
if($segmento3mcj>0)
    $condicion=" and segmento3=$segmento3mcj";
if($segmento4mcj>0)
    $condicion=" and segmento4=$segmento4mcj";
if($oficinamcj>0)
    $condicion=" and oficina=$oficinamcj";
if($tipopagomcj>0)
    $condicion.=" and tipopago=$tipopagomcj";
if($tipomovmcj>0) {
    if($tipomovmcj==1)
        $condicion.=" and tipomov=0";
    else
        $condicion.=" and tipomov=1";
}

$ssql="select * from adm_mov_caja where centro=$centrosel and eliminado=0 $condicion and fecha>='$fechainimcj' and fecha<='$fechafinmcj' order by fecha, id";
$adm=new adm_mov_caja_2($ssql);
//echo $ssql."<br>";    
$a_id=$adm->getId();
$a_fec=$adm->getfecha();
$a_det=$adm->getdetalle();
$a_imp=$adm->getimporte();
$a_tip=$adm->gettipocaja();
$a_tmv=$adm->getDescriptor1();
$a_des1=$adm->getDescriptor1des();
$a_des2=$adm->getDescriptor2des();
$a_des3=$adm->getDescriptor3des();
$a_des4=$adm->getDescriptor4des();
$a_seg1=$adm->getSegmento1des();
$a_seg2=$adm->getSegmento2des();
$a_seg3=$adm->getSegmento3des();
$a_seg4=$adm->getSegmento4des();
$a_ofi=$adm->getOficinades();
$a_mov=$adm->getTipomovdes();
$a_pgo=$adm->getTipopagodes();
$sal=new Saldoinicial($fechainimcj, $cajamcj);
$saldoini=$sal->getSaldoini();
//print_r($a_imp);
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=movcaja.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Caja</th>";
echo "<th>Fecha</th> ";
echo "<th>Detalle</th> ";
echo "<th>Descriptor - Segmento - Oficina</th> ";
echo "<th>Importe</th>";
echo "<th>Descriptor1</th>";
echo "<th>Descriptor2</th>";
echo "<th>Descriptor3</th>";
echo "<th>Descriptor4</th>";
echo "<th>Segmento1</th>";
echo "<th>Segmento2</th>";
echo "<th>Segmento3</th>";
echo "<th>Segmento4</th>";
echo "<th>Oficina</th>";
echo "<th>Movimiento</th>";
echo "<th>Mediopago</th>";
echo "<th>Mes</th>";
echo "<th>Dia</th>";
echo "</tr> ";  

$saldo=$saldoini;
for ($i=0;$i<count($a_id);$i++) {
    if($a_tmv[$i]==1)
        $saldo+=$a_imp[$i];
    else
        $saldo-=$a_imp[$i];
    $cad=utf8_decode($a_des2[$i])."/".utf8_decode($a_des3[$i])."/".utf8_decode($a_des4[$i])." - ".utf8_decode($a_seg1[$i])."/".utf8_decode($a_seg2[$i])."/".utf8_decode($a_seg3[$i])."/".utf8_decode($a_seg4[$i])." - ".utf8_decode($a_ofi[$i]);
    echo "<tr>";
    echo "<td>".$a_id[$i]."</td>";
    echo "<td>".$a_tip[$i]."</td>";
    echo "<td>".date("d/m/Y", strtotime($a_fec[$i]))."</td>";
    echo "<td>".$a_det[$i]."</td>";
    echo "<td>".$cad."</td>";
    if($a_tmv[$i]==1) {
        echo "<td>".number_format($a_imp[$i],2,$puntodec,"")."</td>";
    } else { 
        echo "<td>".number_format($a_imp[$i],2,$puntodec,"")."</td>";
    }
    echo "<td>".utf8_decode($a_des1[$i])."</td>";
    echo "<td>".utf8_decode($a_des2[$i])."</td>";
    echo "<td>".utf8_decode($a_des3[$i])."</td>";
    echo "<td>".utf8_decode($a_des4[$i])."</td>";
    echo "<td>".utf8_decode($a_seg1[$i])."</td>";
    echo "<td>".utf8_decode($a_seg2[$i])."</td>";
    echo "<td>".utf8_decode($a_seg3[$i])."</td>";
    echo "<td>".utf8_decode($a_seg4[$i])."</td>";
    echo "<td>".utf8_decode($a_ofi[$i])."</td>";
    echo "<td>".utf8_decode($a_mov[$i])."</td>";
    echo "<td>".utf8_decode($a_pgo[$i])."</td>";
    echo "<td>".date("n",strtotime($a_fec[$i]))."</td>";
    echo "<td>".date("d",strtotime($a_fec[$i]))."</td>";
    echo "</tr>";
}
//print "Movimiento de Caja --> ".$conx->getTextoValor($cajamcj, "CAJA");
?>
