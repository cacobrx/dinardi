<?php
/*
 * Creado el 17/12/2018 11:03:26
 * Autor: gus
 * Archivo: adm_crm_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_crm.php';
require_once 'impresion/pdf_crm.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
//$limmax=5;
$ssql="select adm_crm.* from adm_crm, adm_rem where adm_crm.fecha>='$fechainicrm' and adm_crm.fecha<='$fechafincrm' and adm_crm.idrem=adm_rem.id and adm_rem.faena=1";
if($remitocrm>0) $ssql.=" and adm_crm.idrem=$remitocrm";
if($proveedorcrm>0) $ssql.=" and adm_rem.idprv=$proveedorcrm";
$ssql.=" order by fecha, id";
//echo $ssql;
$adm=new adm_crm_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getRemito();
$a_hor1=$adm->getHorainicio();
$a_hor2=$adm->getHorafin();
$a_fec=$adm->getFecha();
$a_est=$adm->getEstado();
$a_ope=$adm->getResponsable();
$d_id=$adm->getDet_id();
$d_art=$adm->getDet_articulo();
$d_tem=$adm->getDet_temperatura();
$d_can=$adm->getDet_cantidad();
$d_pes=$adm->getDet_peso();
$d_obs=$adm->getDet_observaciones();
$f_tot=$adm->getFae_total();
$a_trem=$adm->getTotalremito();

$colu=array(5,15,35,124,145,165,180, 230, 250, 270);
$colu2=array(10,70,90,115);
$pdf=new PDF_crm("L", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>