<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_com.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
 
$ssql="select adm_com.* from adm_com, adm_prv where adm_com.centro=$centrosel and $campofechacva>='$fechainicva' and $campofechacva<='$fechafincva' and adm_com.tipo=2 and adm_com.idprv=adm_prv.id";
if($proveedorcva>0)
    $ssql.=" and idprv=$proveedorcva";
$ssql.=" order by $ordencva";
//$ssql="Select * from adm_com where id=2663";
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
$a_neto17=$adm->getNeto17();
$a_iva21=$adm->getIva21();
$a_iva10=$adm->getIva10();
$a_iva27=$adm->getIva27();
$a_iva17=$adm->getIva17();
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
$a_detalle=$adm->getDet_detalle();
$a_des1=$adm->getDet_descriptor1des();
$a_des2=$adm->getDet_descriptor2des();
$a_des3=$adm->getDet_descriptor3des();
$a_des4=$adm->getDet_descriptor4des();
$a_importe=$adm->getDet_importe();
//print_r($a_importe);

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=comprasproveedoresvarios.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>#</th> ";
echo "<th>Fecha</th> ";
echo "<th>As</th> ";
echo "<th>Numero</th> ";
echo "<th>Proveedor</th>";
echo "<th>Neto</th> ";
echo "<th>Impuestos</th> ";
echo "<th>Perc.Ret</th> ";
echo "<th>Total</th> ";
echo "<th>F.Imput</th> ";
echo "<th>Detalle</th> ";
echo "<th>Des1</th> ";
echo "<th>Des2</th> ";
echo "<th>Des3</th> ";
echo "<th>Des4</th> ";
echo "<th>Importe</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_fec);$i++) {    
    echo "<tr>";
    echo "<td>".$a_id[$i]."</td>";  
    echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";
    echo "<td>".$a_nasi[$i]."</td>";    
    echo "<td>".$a_comx[$i]."</td>";
    echo "<td>".substr($a_prv[$i],0,30)."</td>";
    echo "<td>".number_format(($a_neto21[$i]+$a_neto10[$i]+$a_neto27[$i]+$a_neto17[$i]+$a_exe[$i]+$a_ngr[$i]),2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format(($a_iva21[$i] + $a_iva10[$i] + $a_iva27[$i] + $a_iva17[$i] + $a_imi[$i]),2,$cfg->getPuntodecimal(),"")."</td>";    
    echo "<td>".number_format(($a_pri[$i] + $a_rti[$i] + $a_prb[$i]),2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format(($a_neto21[$i] + $a_neto10[$i] + $a_neto17[$i] + $a_neto27[$i] + $a_iva21[$i] + $a_iva17[$i] + $a_iva10[$i] + $a_iva27[$i] + $a_imi[$i] + $a_pri[$i] + $a_rti[$i] + $a_prb[$i] + $a_exe[$i] + $a_ngr[$i]),2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fev[$i])."</td>";
    echo "</tr>";
    for($d=0;$d<count($a_detalle[$i]);$d++) {
        echo "<tr>";
        echo "<td colspan='10'></td>";
        echo "<td>".$a_detalle[$i][$d]."</td>";
        echo "<td>".$a_des1[$i][$d]."</td>";
        echo "<td>".$a_des2[$i][$d]."</td>";
        echo "<td>".$a_des3[$i][$d]."</td>";
        echo "<td>".$a_des4[$i][$d]."</td>";
        echo "<td>".number_format($a_importe[$i][$d],2,$cfg->getPuntodecimal(),"")."</td>";
        echo "</tr>";
    }
}

