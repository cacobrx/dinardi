<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_vta_main.php
 */

require_once 'user.php';
//require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_fis.php';
require_once 'clases/datesupport.php';
//require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
//$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
//$glo=new globalson();
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
$a_cdc=$adm->getCodigodoc();
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
$a_cui=$adm->getNrocuit();
$a_ngr=$adm->getNogravado();

$a_email=$adm->getEmail();

//print_r($a_tot);

$cad="";
$cadiva="";

for($i=0;$i<count($a_id);$i++) {
    
    $cliente=$sup->SanearCaracteres($a_cli[$i]);
    //echo "2: ".$prv."<br>";
    $cad.=date("Ymd", strtotime($a_fec[$i]));
    $codigoop="A";
//    echo $a_com[$i]."<br>".$a_let[$i]."<br>";;
    switch ($a_let[$i]) {
        case "A":
            $codigoop="0";
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
            $codigoop="N";
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
            $codigoop="A";
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
    $cad.=$tipocomprobante;
    $cad.=$sup->AddZeros($a_pto[$i], 5);
    $cad.=$sup->AddZeros($a_nro[$i], 20);
    $cad.=$sup->AddZeros($a_nro[$i], 20);
    $cad.=$sup->AddZeros($a_cdc[$i], 2);
    $cad.=$sup->AddZeros($a_cui[$i], 20);    
    $cad.=$sup->AddSpaces($cliente, 30);
    
    $totaltotal=abs($a_tot[$i])*100;
    $nogravado=abs($a_ngr[$i])*100;
    $exento=abs(0);
    $percepcioniva=0;
    $percepcioniibb=abs($a_per[$i])*100;
    $impuestosinternos=0;
//    echo $a_ivari10[$i]."|".$a_ivari21[$i]."|".$a_ivacf10[$i]."|".$a_ivacf21[$i]."<br>";
    //echo "percepcioniva: $percepcioniva | percepcioniibb: $percepcioniibb | impuestos internos: $impuestosinternos<br>";
    $creditofiscal=$a_ivari10[$i]+$a_ivari21[$i]+$a_ivacf10[$i]+$a_ivacf21[$i];
    $creditofiscal=$creditofiscal*100;
    $xtotaltotal=$sup->AddZeros((int)$totaltotal, 15); // total #9
    $cad.=$xtotaltotal;
    $cad.=$sup->AddZeros($nogravado, "15"); // importe total de concentos que no integran el precio neto gravado #10
    $cad.=$sup->AddZeros(0, "15"); // percepcion no categorizadas #11
    $cad.=$sup->AddZeros(0, "15"); // exentas #12
    $cad.=$sup->AddZeros(0, "15"); // impuestos nacionales #13 --> preguntar
    if($a_tot[$i]<0) $xtotaltotal="-".substr($xtotaltotal,1,strlen($xtotaltotal));
    $xpercepcioniibb=$sup->AddZeros($percepcioniibb, 15); // percepcioniibb #14
    if($a_per[$i]<0) $xpercepcioniibb="-".substr($xpercepcioniibb,1,strlen($xpercepcioniibb));
    $cad.=$xpercepcioniibb;
    $cad.=$sup->AddZeros("", 15); // per imp. municipales #15
    $cad.=$sup->AddZeros("", 15); // impuestos internos #16
    
    $caniva=0;
    if($a_ivari10[$i]>0)
        $caniva++;
    if($a_ivari21[$i]>0)
        $caniva++;
    if($a_ivacf10[$i]>0)
        $caniva++;
    if($a_ivacf21[$i]>0)
        $caniva++;
    if($caniva==0) $caniva=1;
    $cad.="PES"; // #17
    //$cad.=$sup->AddZeros(1, 10); // 18
    $cad.="0001000000"; // #18
    $cad.=$caniva; // #19
    if($nogravado>0) $codigoop="N";
    $cad.=$codigoop; // #20
    
//    $cad.="10"; // #19
    $cad.=$sup->AddZeros("", 15); //  otros tributos #21
    if($tipocomprobante==83)
        $cad.="00000000";
    else
        $cad.=date("Ymd", strtotime($a_fec[$i])); // #22
    $cad.="\r\n";
}
header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=\"citi_ventas.txt\";" );
header("Content-Transfer-Encoding: binary");
print $cad;

?>
