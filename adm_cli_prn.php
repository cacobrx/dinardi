<?
/*
 * Creado el 12/03/2013 21:16:19
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_cli_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_cli.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'impresion/adm_cli_prn.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
switch ($ordencli) {
    case 0:
        $orden="adm_cli.id";
        break;
    case 1:
        $orden="adm_cli.apellido, adm_cli.nombre";
        break;
}
$ssql="select * from adm_cli";
$condicion="";
$ntex=strlen($textocli);
if($textocli!="") $condicion.="(instr(upper(adm_cli.apellido),upper('$textocli'))>0 or adm_cli.id='$textocli' or instr(adm_cli.cuit,'$textocli')>0) and ";
if($condicion!="") {
    $condicion=" where ".substr($condicion,0,strlen($condicion)-5);
}


$ssql.=$condicion;

$ssql.=" order by id ";
//echo $ssql."<br>";

//$ssql="select * from adm_cli where centro=$centrosel order by apellido, nombre limit $lim,".$cfg->getLimmax();
$adm=new adm_cli_2($ssql);
    
$a_id=$adm->getId();
$a_ape=$adm->getApellido();
$a_nom=$adm->getNombre();
$a_tel=$adm->getTelefono();
$a_cel=$adm->getCelular();
$a_doc=$adm->getCuit();
$a_ciu=$adm->getCiudaddes();
$a_dir=$adm->getDireccion();
$a_iva=$adm->getCondicionivaabr();

$colu=array(5,20,86,135,170,185);
$pdf=new pdf_cli("p", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
?>