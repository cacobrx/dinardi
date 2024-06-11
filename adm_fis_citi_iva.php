<?php
/*
 * Creado el 29/09/2015 13:44:13
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_citi_iva
 */

require_once 'user.php';
//require_once 'clases/conexion.php';
//require_once 'clases/globalson.php';
//require_once 'clases/auditoria.php';
require_once 'clases/adm_com.php';
require_once 'clases/support.php';
require_once 'clases/adm_fis.php';
require_once 'clases/support.php';

$sup=new support();
//$aud = new registra_auditoria();
//$conx = new conexion();
//$glo = new globalson();
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

$ssql="select adm_fis.* from adm_fis, adm_cli $condicion and adm_fis.idcli=adm_cli.id";
//$ssql.=" and numero=2179";
$ssql.=" order by $ordenorden";

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
$a_cdc=$adm->getCodigodoc();
$a_netocf10=$adm->getNetocf10();
$a_netocf21=$adm->getNetocf21();
$a_netori10=$adm->getNetori10();
$a_netori21=$adm->getNetori21();
$a_ivari10=$adm->getIvari10();
$a_ivari21=$adm->getIvari21();
$a_ivacf10=$adm->getIvacf10();
$a_ivacf21=$adm->getIvacf21();
$d_id=$adm->getDet_id();
$d_det=$adm->getDet_descripcion();
$d_art=$adm->getDet_articulo();
$d_can=$adm->getDet_cantidad();
$d_iva=$adm->getDet_iva();
$d_pre=$adm->getDet_precio();
$d_imp=$adm->getDet_importe();
$a_ngr=$adm->getNogravado();

//print_r($a_ivacf10);
//print_r($a_ivari10);
//print_r($a_ivacf21);
//print_r($a_ivari21);

$a_email=$adm->getEmail();

$cad="";
$cadiva="";
for($i=0;$i<count($a_id);$i++) {
    
    $prv=$sup->SanearCaracteres($a_cli[$i]);
    //echo "2: ".$prv."<br>";
    $cad.=date("Ymd", strtotime($a_fec[$i]));
    
    switch ($a_let[$i]) {
        case "A":
            switch ($a_com[$i]) {
                case "F": // fc
                    $tipocomprobante=1;
                    break;
                case "G": // fc
                    $tipocomprobante=1;
                    break;
                case "C": // nc
                    $tipocomprobante=3;
                    break;
                case "H": // nc
                    $tipocomprobante=3;
                    break;
                case "D": // nd
                    $tipocomprobante=2;
                    break;
                case "I": // nd
                    $tipocomprobante=2;
                    break;
            }
            break;
        case "B":
            switch ($a_com[$i]) {
                case "F": // fc
                    $tipocomprobante=1;
                    break;
                case "G": // fc
                    $tipocomprobante=1;
                    break;
                case "C": // nc
                    $tipocomprobante=3;
                    break;
                case "H": // nc
                    $tipocomprobante=3;
                    break;
                case "D": // nd
                    $tipocomprobante=2;
                    break;
                case "I": // nd
                    $tipocomprobante=2;
                    break;
            }
            break;
        case "C":
            switch ($a_com[$i]) {
                case "F": // fc
                    $tipocomprobante=1;
                    break;
                case "G": // fc
                    $tipocomprobante=1;
                    break;
                case "C": // nc
                    $tipocomprobante=3;
                    break;
                case "H": // nc
                    $tipocomprobante=3;
                    break;
                case "D": // nd
                    $tipocomprobante=2;
                    break;
                case "I": // nd
                    $tipocomprobante=2;
                    break;
            }
            break;
        case "Z":
            $tipocomprobante=83;
            break;
                    
    }
    
    $tipocomprobante=$sup->AddZeros($tipocomprobante, 3);
    $neto21=($a_netocf21[$i]+$a_netori21[$i])*100;
    $iva21=($a_ivacf21[$i]+$a_ivari21[$i])*100;
    if($neto21>0) {
        $cadiva.=$tipocomprobante;
        $cadiva.=$sup->AddZeros($a_pto[$i], 5);
        $cadiva.=$sup->AddZeros($a_nro[$i], 20);
        //$cadiva.=$sup->AddZeros($a_cdc[$i], 2);
        //$cadiva.=$sup->AddZeros($a_cuit[$i], 20);
        $cadiva.=$sup->AddZeros($neto21, 15);
        $cadiva.=$sup->AddZeros(5, 4);
        $cadiva.=$sup->AddZeros($iva21, 15);
        $cadiva.="\r\n";
    }
    $neto10=($a_netocf10[$i]+$a_netori10[$i])*100;
    $iva10=($a_ivari10[$i]+$a_ivacf10[$i])*100;
    if($neto10>0) {
        $cadiva.=$tipocomprobante;
        $cadiva.=$sup->AddZeros($a_pto[$i], 5);
        $cadiva.=$sup->AddZeros($a_nro[$i], 20);
        //$cadiva.=$sup->AddZeros($a_cdc[$i], 2);
        //$cadiva.=$sup->AddZeros($a_cuit[$i], 20);
        $cadiva.=$sup->AddZeros($neto10, 15);
        $cadiva.=$sup->AddZeros(4, 4);
        $cadiva.=$sup->AddZeros($iva10, 15);
        $cadiva.="\r\n";
    }
    if($neto21==0 and $neto10==0) {
        $cadiva.=$tipocomprobante;
        $cadiva.=$sup->AddZeros($a_pto[$i], 5);
        $cadiva.=$sup->AddZeros($a_nro[$i], 20);
        //$cadiva.=$sup->AddZeros($a_cdc[$i], 2);
        //$cadiva.=$sup->AddZeros($a_cuit[$i], 20);
        $cadiva.=$sup->AddZeros(0, 15);
        $cadiva.=$sup->AddZeros(3, 4);
        $cadiva.=$sup->AddZeros(0, 15);
        $cadiva.="\r\n";
        
    }
}
header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=\"citi_ventas_alicuotas.txt\";" );
header("Content-Transfer-Encoding: binary");
print $cadiva;

