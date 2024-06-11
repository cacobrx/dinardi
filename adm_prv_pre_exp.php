<?php
/*
 * Creado el 21/01/2019 08:54:13
 * Autor: gus
 * Archivo: adm_prv_pre_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_prv.php';
require_once 'impresion/pdf_prv_pre.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$botoncap="Modificar";
$adm=new adm_prv_1($id);
$carteltarea="Precios del Proveedor "." ".strtoupper($adm->getApellido());
$pre_idart=$adm->getPre_idart();
$pre_articulo=$adm->getPre_articulo();
$pre_importe=$adm->getPre_importe();
$pre_preciominimo=$adm->getPre_preciominimo();
$pre_preciomaximo=$adm->getPre_preciomaximo();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Precios del Proveedor.xls");
header("Pragma: no-cache");
header("Expires: 0");


echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Producto</th> ";
echo "<th>Precio</th> ";
echo "<th>Precio Min</th> ";
echo "<th>Precio Max</th> ";
echo "</tr> ";  
for($i=0;$i<count($pre_idart);$i++) {
        echo "<tr>";
        echo "<td>".$pre_idart[$i]."</td>";
        echo "<td>".$pre_articulo[$i]."</td>";
        echo "<td>".number_format($pre_importe[$i],2,$cfg->getPuntodecimal(),"")."</td>";        
        echo "<td>".number_format($pre_preciominimo[$i],2,$cfg->getPuntodecimal(),"")."</td>";  
        echo "<td>".number_format($pre_preciomaximo[$i],2,$cfg->getPuntodecimal(),"")."</td>";
        echo "</tr>";    
}
print $carteltarea;