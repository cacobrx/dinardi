<?php
/*
 * Creado el 02/11/2020 12:19:08
 * Autor: gus
 * Archivo: adm_opg_retenciones_sicore.php
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

//$ssql="select * from adm_opg1 where ($campofechaopg between '$fechainiopg' and '$fechafinopg') and adm_opg1.centro=$centrosel $condicionprv and retencioniibb>0";
$ssql="select * from adm_opg1 where ($campofechaopg between '$fechainiopg' and '$fechafinopg') and adm_opg1.centro=$centrosel $condicionprv and retencionganancia>0";
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
$a_net=$opg->getNetos();
$a_ser=$opg->getTiposer();

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
//    $cad.=$cuit.date("d/m/Y", strtotime($a_fec[$i])).date("Y", strtotime($a_fec[$i])).$sup->AddZeros($a_nro[$i], 8).$sup->AddZeros(number_format($a_ret[$i],2,".",""), 11)."A";
//    $cad.=$a_id[$i]." ";
    $cad.="06";
    if(date("j", strtotime($a_fec[$i]))<10)
        $cad.=" ".date("j/m/Y", strtotime($a_fec[$i]));
    else
        $cad.=date("j/m/Y", strtotime($a_fec[$i]));
    $cad.=$sup->AddZeros($a_nro[$i], 16);
    $cad.=$sup->AddZeros(number_format($a_imp[$i],2,",",""), 16);
    $cad.="02170";
    if($a_ser[$i]==1)
        $cad.="78";
    else
        $cad.="94";
    $cad.="1";
//    $cad.=date("d/m/Y", strtotime($a_fec[$i]));
    $cad.=$sup->AddZeros(number_format($a_net[$i],2,",",""), 14);
    if(date("j", strtotime($a_fec[$i]))<10)
        $cad.=" ".date("j/m/Y", strtotime($a_fec[$i]));
    else
        $cad.=date("j/m/Y", strtotime($a_fec[$i]));
    //$cad.=date("d/m/Y", strtotime($a_fec[$i]));
    $cad.="01";
    $cad.=$sup->AddZeros(number_format($a_rea[$i],2,",",""), 15);
    $cad.="0     0         ";
    $cad.="80";
    $cad.=$a_cuit[$i];
    $cad.=$sup->AddSpaces(" ", 9);
    $cad.=$sup->AddZeros("0", 15);
    $cad.=$sup->AddSpaces(" ", 29);
    $cad.=$sup->AddZeros("0", 27);
    $cad.="2020";
    $cad.=$sup->AddZeros($a_nro[$i], 6);
    
    $cad.="\r\n";
}


$destino="retencion_ganancia.txt";


header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=\"retencion_ganancia.txt\";" );
header("Content-Transfer-Encoding: binary");
print $cad;
