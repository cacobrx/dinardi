<?php
/*
 * Creado el 01/12/2015 10:20:27
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_lst
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_com.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'impresion/pdf_com.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
 
$ssql="select * from adm_com where centro=$centrosel and $campofechacom>='$fechainicom' and $campofechacom<='$fechafincom' and tipo=1";
if($proveedorcom>0)
    $ssql.=" and idprv=$proveedorcom";
$ssqt="select sum(totaltotal) as totalcom from adm_com where $campofechacom>='$fechainicom' and $campofechacom<='$fechafincom' and tipo=1";
if($proveedorcom>0)
    $ssqt.=" and idprv=$proveedorcom";
//echo $ssqt;
$rt=$conx->getConsulta($ssqt);
$rtt=  mysqli_fetch_object($rt);
$totalcom=$rtt->totalcom;
$ssql.=" order by fecha ";
$adm=new adm_com_2($ssql);
//echo $ssql."<br>";    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_let=$adm->getLetra();
$a_com=$adm->getTipocomabr();
$a_pto=$adm->getPtovta();
$a_num=$adm->getNumero();
$a_prv=$adm->getProveedor();
$a_neto21=$adm->getNeto21();
$a_neto10=$adm->getNeto10();
$a_neto27=$adm->getNeto27();
$a_iva21=$adm->getIva21();
$a_iva10=$adm->getIva10();
$a_iva27=$adm->getIva27();
$a_pri=$adm->getPeriva();
$a_rti=$adm->getRetiva();
$a_prb=$adm->getPerretiibb();
$a_exe=$adm->getExento();
$a_ngr=$adm->getNogravado();
$a_fev=$adm->getFechaimputacion();
$a_imi=$adm->getImpinternos();
$a_mov=$adm->getMovimiento();
$a_asi=$adm->getCantidadasientos();
$a_nasi=$adm->getAsientos();
$m_det=$adm->getMov_detallecon();
$m_ent=$adm->getMov_entrada();
$m_sal=$adm->getMov_salida();
$m_cta=$adm->getMov_cuentades();
$d_ent=$adm->getDet_entrada();
$d_sal=$adm->getDet_salida();
$d_cta=$adm->getDet_cuentades();
$a_comx=$adm->getComprobantetodo();
$telefonoemp=$cen->getTelefono();
$nombreemp=$cen->getNombre();

$colu=array(5,17,39,59,125,145,165,185);
$pdf = new PDF_Com('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();
?>