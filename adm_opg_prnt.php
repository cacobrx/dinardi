<?php
// (c) Xavier Nicolay
// Exemple de génération de devis/facture PDF
require_once 'user.php';
require_once 'clases/planb_config.php';
require_once 'clases/globalson.php';
require_once 'clases/adm_opg1.php';
require_once 'clases/adm_opg2.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_prv.php';
require_once 'impresion/opago.php';
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$idop=$glo->getGETPOST("idop");
$opg=new adm_opg1_1($idop);
//$ssql="select * from adm_opg1 where idprv=$idprv";
$a_id=$opg->getId();
$a_fec=$opg->getFecha();
$a_pro=$opg->getProveedor();
$a_imp=$opg->getImporte();
$idprv=$opg->getIdprv();
$centrosel=$opg->getCentro();
$tipocontabilidad=$opg->getTipo();
$op2_detalle=$opg->getE_detalle();
$op2_importe=$opg->getE_importe();
$nombreempresa=$cfg->getFiscalnombre();
$direccionempresa=$cfg->getFiscaldireccion();
$ciudadempresa=$cfg->getFiscalciudad();
$cpostalempresa=$cfg->getFiscalmail();
$telefonoempresa=$cfg->getFiscaltelefono();
$inicioactividad=$cfg->getFiscalfechainicio();
$numero=$opg->getId();
$pdf= new PDF_opg1("P", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();


$pdf->Output();
?>