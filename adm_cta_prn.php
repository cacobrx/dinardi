<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/adm_cta.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'impresion/cta.php';
$sup=new support();
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$ssql="select * from adm_cta where centro=$centrosel";
if($textocta!="") 
    $ssql.=" and (instr(upper(nombre),'".strtoupper($textocta)."')>0 or instr(codigo,'$textocta')>0)";
$ssql.=" order by codigo";
//echo $ssql."<br>";
$cta=new adm_cta_2($ssql);
$a_id=$cta->getId();
$a_nom=$cta->getNombre();
$a_tip=$cta->getTipodes();
$a_cod=$cta->getCodigo();
$a_del=$cta->getOkborrar();
$cantidadtotal=$cta->getMaxRegistros();

$colu=array(10,50,175);
$pdf=new pdf_cta("p", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();