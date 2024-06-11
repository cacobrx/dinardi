<?php
/*
 * Creado el 30/10/2020 12:09:43
 * Autor: gus
 * Archivo: adm_opg_retg_prn_m.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_opg1.php';
require_once 'impresion/retencionganancia.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$idop=$glo->getGETPOST("idop");
$nret=1;
$ssql="select * from adm_opg1 order by numeroretg desc";
if($conx->getCantidadReg($ssql)>0) {
    $rr=$conx->getConsulta($ssql);
    $rrr=mysqli_fetch_object($rr);
    $nret=$rrr->numeroretg;
    $nret++;
}
$ssql="update adm_opg1 set numeroretg=$nret where id=$idop and numeroretg=0";
$conx->getConsulta($ssql);

$adm=new adm_opg1_1($idop);
$importeganancia=$adm->getRetencionganancia();

$fechaini=date("Y-m-01", strtotime($adm->getFecha()));
$fechafin=$adm->getFecha();
$conn=$conx->conectarBase();
$condicion="";
$ssql="select * from adm_opg1 where idprv=".$adm->getIdprv()." and fecha>='$fechaini' and fecha<='$fechafin'";
$rs=$conx->consultaBase($ssql, $conn);
$retencionanterior=0;
while($reg=mysqli_fetch_object($rs)) {
    $condicion.="idopg=".$reg->id." or ";
    if($reg->id<$idop)
        $retencionanterior+=$reg->retencionganancia;
}

if($condicion!="") {
    $ssql="select sum(neto21) as tnet21, sum(neto10) as tnet10 from adm_com where tipocom!=2 and (".substr($condicion,0,strlen($condicion)-4).")";
//        echo $ssql."\n";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $tneto=$reg->tnet21+$reg->tnet10;

    $ssql="select sum(neto21) as tnet21, sum(neto10) as tnet10 from adm_com where tipocom=2 and (".substr($condicion,0,strlen($condicion)-4).")";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $tnetoc=$reg->tnet21+$reg->tnet10;

    $tneto-=$tnetoc;
    
    $ssql="select * from adm_com where (".substr($condicion,0,strlen($condicion)-4).") limit 1";
//        echo $ssql."\n";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $tipoganancia=$reg->tipoganancia;

//        echo "neto anterior: $tneto\n";
//        echo "neto actual: ".array_sum($c_net)."\n";
    $totalneto=$tneto;
//        echo "neto total: $totalneto\n";
//        echo "gan: ".$c_gan[0]."\n";
    
    
//    if($tipoganancia==0)
//        $importe1=$totalneto-$cfg->getMinimoretenciones ();
//    else
//        $importe1=$totalneto-$cfg->getMinimoretencionesser ();
////        echo "Importe1: $importe1\n";
//    $importeganancia=0;
//    if($importe1>0) {
//        $importeganancia1=$importe1*2/100;
//        $importeganancia=$importeganancia1-$retencionanterior;
//    }
}



$pdf = new retencionganancia_m('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();
