<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_vta_act_save.php
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'clases/adm_cped.php';
require_once 'clases/adm_cped_det.php';
require_once 'clases/adm_crem_det.php';
require_once 'clases/adm_crem.php';
$sup=new support();
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$usuario=$usr->getId();
$id=$glo->getGETPOST("id");
$numero=$glo->getGETPOST("numero");
$ptovta=$glo->getGETPOST("ptovta");
$fecharem=$glo->getGETPOST("fecharem");
if($numero=="") $numero=0;
if($ptovta=="") $ptovta=0;
//echo "id del pedido: $id<br>";
$ped=new adm_cped_1($id);

//    echo "idx: $idx<br>";
$aud->regAud("Remito",$usr->getId(),"Ingresa Remito desde Orden de Pedido $id - fecha ".$ped->getFecha()." - Cliente ".$ped->getCliente(),$centrosel);
$ssql="insert into adm_crem (fecha, idcli, fechaentrega, observaciones, idped, ptovta, numero, patente) values ";
$ssql.="('$fecharem', ".$ped->getIdcli().", '".$ped->getFechaentrega()."', '".$ped->getObservaciones()."', $id, $ptovta, $numero,'".$ped->getPatente()."')";
$conx->getConsulta($ssql);
//echo $ssql."<br>";

$det_cantidad=$ped->getDet_cantidad();
$det_idart=$ped->getDet_idpro();
$det_precio=$ped->getDet_precio();
$det_recipiente=$ped->getDet_recipiente();

$idrem=$conx->getLastId("adm_crem");
for($i=0;$i<count($det_cantidad);$i++) {
        $ssql="insert into adm_crem_det (idrem, idpro, cantidad, precio, recipiente) values ";
        $ssql.="($idrem, ".$det_idart[$i].", ".$det_cantidad[$i].", ".$det_precio[$i].", ".$det_recipiente[$i].")";
//        echo $ssql."<br>"; 
        $conx->getConsulta($ssql);            
        }    
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_cped_main.php" method="post">
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
