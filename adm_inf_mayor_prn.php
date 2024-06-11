<?php
/*
 * creado el 23/11/2017 15:38:14
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_inf_mayor
 */

//print_r($_POST);
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_contable.php';
require_once 'clases/pdf_imprime.php';
require_once 'clases/adm_emp.php';
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$emp=new adm_emp_1($empresamain);
$empresanom=$emp->getFantasia();

$adm=new libromayor($centrosel,$empresamain,$fechainimay, $fechafinmay, $idctamay);
$a_cta=$adm->getIdcta();
$a_nom=$adm->getNombre();
$a_cod=$adm->getCodigo();
$a_deb=$adm->getEntrada();
$a_cre=$adm->getSalida();
$a_sal=$adm->getSaldo();
$m_fec=$adm->getDet_fecha();
$m_des=$adm->getDet_descripcion();
$m_asi=$adm->getDet_asiento();
$m_ent=$adm->getDet_entrada();
$m_sal=$adm->getDet_salida();
$m_sdo=$adm->getDet_saldo();

$colu=array(5,30,50,110,150,180);
$pdf=new PDF_inf_mayor("p", "mm", "A4");
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();
