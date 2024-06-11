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
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primero=$glo->getGETPOST("primero");

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

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=mayor.xls");
header("Pragma: no-cache");
header("Expires: 0"); 

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Fecha</th> ";
echo "<th>Asientos</th> ";
echo "<th>Descripcion</th> ";
echo "<th>Entrada</th> ";
echo "<th>Salida</th> ";
echo "<th>Saldo</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_cta);$i++) {

    echo "<tr>";
    echo "<td>"."cuenta:"."</td>";
    echo "<td>".$a_nom[$i]."</td>";
    echo "<td>".number_format($a_deb[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format($a_cre[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format($a_sal[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "</tr>";

    for($m=0;$m<count($m_fec[$i]);$m++) {
        echo "<tr>";
        echo "<td>".$dsup->getFechaNormalCorta($m_fec[$i][$m])."</td>";
        echo "<td>".$m_asi[$i][$m]."</td>";
        echo "<td>".$m_des[$i][$m]."</td>";
        echo "<td>".number_format($m_ent[$i][$m],2,$cfg->getPuntodecimal(),"")."</td>";
        echo "<td>".number_format($m_sal[$i][$m],2,$cfg->getPuntodecimal(),"")."</td>";
        echo "<td>".number_format($m_sdo[$i][$m],2,$cfg->getPuntodecimal(),"")."</td>";    
        echo "</tr>";

    }
}