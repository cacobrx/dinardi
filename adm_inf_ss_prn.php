<?
//print_r($_POST);
require "user.php";
require_once "clases/globalson.php";
require_once "clases/planb_config.php";
require_once 'clases/adm_contable.php';
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'impresion/contabilidad.php';
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$empresanom=$cfg->getFiscalfantasia();
if($fechaini=="")
    $fechaini=date("Y-m-01");
if($fechafin=="")
    $fechafin=date("Y-m-d");
$primero=$glo->getGETPOST("primero");
$adm=new sumasysaldos($centrosel, $fechaini, $fechafin);
$a_cta=$adm->getCodigo();
$a_nom=$adm->getNombre();
$a_deb=$adm->getDebitos();
$a_cre=$adm->getCreditos();
$a_let=$adm->getLetra();
$a_esp=$adm->getCantespacios();
$a_sal=$adm->getSaldo();

$colu=array(10,120,150,180);
$pdf=new PDF_inf_ss("p", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();