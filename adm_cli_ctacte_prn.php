<?php

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_cli.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/clientes.php';
require_once 'impresion/pdf_cctacte.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$clienteselcta=$glo->getGETPOST("clienteselcta");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$fechainicioctacte=$cfg->getFechainicioctacte();
$cli=new adm_cli_1($clienteselcta);
$cliente=$cli->getApellido()." ".$cli->getNombre();
$saldoini=$cli->getSaldoini ();

$inf=new ctacte_clientes($clienteselcta, $fechaini, $fechafin, $fechainicioctacte, 1,$cli->getSaldoini());

$i_fec=$inf->getFecha();
$i_det=$inf->getDetalle();
$i_imp=$inf->getImporte();
$i_sal=$inf->getSaldo();
$i_sig=$inf->getSigno();
$totaldebe=0;
$totalhaber=0;
for($i=0;$i<count($i_fec);$i++) {
    if($i_sig[$i]=="D")
        $totaldebe+=$i_imp[$i];
    else
        $totalhaber+=$i_imp[$i];
}
$saldofinal=-$totalhaber + $totaldebe;
$colu=array(5,30,145,165,185);
$nombreemp=$cen->getNombre();
$telefonoemp=$cen->getTelefono();
$pdf = new PDF_CCtacte( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>