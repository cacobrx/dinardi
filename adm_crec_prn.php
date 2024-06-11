<?php
// (c) Xavier Nicolay
// Exemple de génération de devis/facture PDF
require_once 'user.php';
require_once 'clases/planb_config.php';
require_once 'clases/globalson.php';
require_once 'clases/adm_crec.php';
require_once 'clases/adm_rec2.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cli.php';
require_once 'impresion/recibo.php';
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$idrec=$glo->getGETPOST("idrec");
//echo "pasa1<br>";
$rec=new adm_crec1_1($idrec);
//echo "pasa2<br>";
//$ssql="select * from adm_rec2 where idrec=$idrec";
//$det=new adm_rec2_2($ssql);
//$d_id=$det->getId();
//$d_fpg=$det->getDetalle();
//$d_imp=$det->getImporte();
//$d_ppp=$det->getDetallepago();
$cli=new adm_cli_1($rec->getIdcli());
$totaltotal=$rec->getImporte();
$nombreempresa=$cen->getNombre();
$direccionempresa=$cen->getDireccion();
$ciudadempresa=$cen->getCiudad();
$cpostalempresa="6720";
$telefonoempresa=$cen->getTelefono();
$numero=$rec->getId();
$pdf= new PDF_CRecibo("P", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();
?>