<?php
/*
 * creado el 14/01/2018 19:43:12
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_caj_prn
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_caj.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'impresion/adm_caj_prn.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$conn=$conx->conectarBase();

$ssql="select * from adm_caj order by nombre";
$adm=new adm_caj_2($ssql);
    
$a_id=$adm->getId();
$a_nom=$adm->getNombre();
$a_tip=$adm->getTipo();
$a_mon=$adm->getMonedapesos();
$nombreemp=$cfg->getFiscalfantasia();
$telefonoemp=$cfg->getFiscaltelefono();
$colu=array(10,30,150);
$pdf=new pdf_caja("p", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();