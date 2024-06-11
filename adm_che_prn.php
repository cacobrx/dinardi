<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/datesupport.php");
require_once 'clases/centro.php';
require_once 'clases/support.php';
require_once 'clases/util.php';
require_once 'clases/adm_che.php';
require_once 'clases/conexion.php';
require_once 'impresion/adm_che_prn.php';
$conx=new conexion();
$utl=new util();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$limmax=$cfg->getLimmax();
$hoy=date("Y-m-d");
if($tipofechache==1)
    $campofecha="fechapago";
else
    $campofecha="fechaorigen";

$condicion="";
switch($filtroche) {
case 1:
    $condicion.="$campofecha>='$fechainiche' and $campofecha<='$fechafinche' and fechadeb is not null and ";
    break;
case 2:
    $condicion.="$campofecha>='$fechainiche' and $campofecha<='$fechafinche' and ";
    break;
default:
    $condicion.="fechadeb is null and ";
    break;
}
if($campoche!="")
    $condicion.="(instr(nrocheque,'$campoche')>0 or instr(upper(destinatario), '".strtoupper($campoche)."')>0 or instr(upper(referencia), '".strtoupper($campoche)."')>0) and ";
if($tipoche>0)
    $condicion.="tipo=$tipoche and ";
if($condicion!="") $condicion=" where ".substr($condicion,0,strlen($condicion)-5);
$stot="select sum(importe) as totalimporte from adm_che $condicion";
$ssql="select * from adm_che $condicion";

$rs=$conx->getConsulta($stot);
$rre=mysqli_fetch_object($rs);
$total=$rre->totalimporte;
//echo $ssql."<br>";
$che=new adm_che_2($ssql);
$a_id=$che->getId();
$a_fori=$che->getFechaorigen();
$a_fven=$che->getFechapago();
$a_ban=$che->getBancodes();
$a_nro=$che->getNrocheque();
$a_des=$che->getDestinatario();
$a_acr=$che->getAcreditado();
$a_imp=$che->getImporte();
$a_ref=$che->getReferencia();
$a_fed=$che->getFechadeb();
$totalimporte=array_sum($a_imp);

$colu=array(5,15,35,55,80,110,150,240,270);
$pdf=new PDF_che("L", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();
?>
