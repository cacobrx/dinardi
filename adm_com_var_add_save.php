<?php
/*
 * Creado el 07/08/2019 14:04:36
 * Autor: gus
 * Archivo: adm_com_add_save.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_prv.php';
require_once 'clases/support.php';
require_once 'clases/adm_com_cta.php';
$sup=new support();
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$cta=new adm_com_cta_cen($centrosel);
$conn=$conx->conectarBase();
$cantidadrem=$glo->getGETPOST("cantidadrem");
$fecha=$glo->getGETPOST("fecha");
$ptovta=$glo->getGETPOST("ptovta");
$letra=strtoupper($glo->getGETPOST("letra"));
$numero=$glo->getGETPOST("numero");
$idprv=$glo->getGETPOST("idprv");
$cainro=$glo->getGETPOST("cainro");
$neto21=$glo->getGETPOST("neto21");
$neto10=$glo->getGETPOST("neto10");
$neto27=$glo->getGETPOST("neto27");
$neto17=$glo->getGETPOST("neto17");
$iva21=$glo->getGETPOST("iva21");
$iva10=$glo->getGETPOST("iva10");
$iva27=$glo->getGETPOST("iva27");
$iva17=$glo->getGETPOST("iva17");
$impinternos=$glo->getGETPOST("impinternos");
$nogravado=$glo->getGETPOST("nogravado");
$exento=$glo->getGETPOST("exento");
$periva=$glo->getGETPOST("periva");
$retiva=$glo->getGETPOST("retiva");
$retiibb=$glo->getGETPOST("retiibb");
$fechaven=$glo->getGETPOST("fechaven");
$cantc=$glo->getGETPOST("cantc");
$tipocom=$glo->getGETPOST("tipocom");
$tipo=$glo->getGETPOST("tipo");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$fechaimputacion=$glo->getGETPOST("fechaimputacion");
$clave=$glo->getGETPOST("clave");
 
$prv=new adm_prv_1($idprv, $conn);
if($ptovta=="")
    $ptovta=0;
if($numero=="")
    $numero=0;
if($neto21=="")
    $neto21=0;
if($neto10=="")
    $neto10=0;
if($neto27=="")
    $neto27=0;
if($neto17=="")
    $neto17=0;
if($iva21=="")
    $iva21=0;
if($iva10=="")
    $iva10=0;
if($iva27=="")
    $iva27=0;
if($iva17=="")
    $iva17=0;
if($impinternos=="")
    $impinternos=0;
if($periva=="")
    $periva=0;
if($retiva=="")
    $retiva=0;
if($retiibb=="")
    $retiibb=0;
if($exento=="")
    $exento=0;
if($nogravado=="")
    $nogravado=0;



$totaltotal=$neto21 + $neto10 + $neto27 + $neto17 + $iva21 + $iva10 + $iva27 + $iva17 + $impinternos + $periva + $retiva + $retiibb + $exento + $nogravado;
$clave=$sup->generateKey();
$aud->regAud("Compras Proveedores Varios",$usr->getId(),"Ingresa Compras Proveedores Varios: Nro. $numero",$centrosel);
$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, neto17, iva21, iva10, iva27, iva17, ";
$ssql.="impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values ($centrosel, '$fecha', $tipocom, '$letra', $ptovta, $numero, ";
$ssql.="$idprv, '$cainro', $neto21, $neto10, $neto27, $neto17, $iva21, $iva10, $iva27, $iva17, $impinternos, $nogravado, $exento, $periva, $retiva, $retiibb, '$fechaven', $totaltotal, '$clave', '$fechaimputacion', 2, ".$usr->getId().")";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$id=$conx->getLastId("adm_com");

// contable
$cantc=-1;
$ii=-1;
$totalproveedor=0;
if($neto21>0 or $neto10>0 or $neto27>0 or $neto17>0 or $exento>0 or $nogravado>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$prv->getCuenta();
    $$entrada=$neto21 + $neto10 + $neto27 + $neto17 + $exento + $nogravado;
    $$salida="";
    $totalproveedor+=$neto21+$neto10+$neto27+$neto17+$exento+$nogravado;
}
if($iva21>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$cta->getIva21();
    $$entrada=$iva21;
    $$salida="";
    $totalproveedor+=$iva21;          
}
if($iva10>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$cta->getIva10();
    $$entrada=$iva10;
    $$salida="";
    $totalproveedor+=$iva10;          
}
if($iva27>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$cta->getIva27();
    $$entrada=$iva27;
    $$salida="";
    $totalproveedor+=$iva27;          
}
if($iva17>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$cta->getIva17();
    $$entrada=$iva17;
    $$salida="";
    $totalproveedor+=$iva17;          
}
if($retiva>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$cta->getRetiva();
    $$entrada=$retiva;
    $$salida="";
    $totalproveedor+=$retiva;          
}
if($periva>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$cta->getPeriva();
    $$entrada=$periva;
    $$salida="";
    $totalproveedor+=$periva;          
}
if($retiibb>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$cta->getretiibb();
    $$entrada=$retiibb;
    $$salida="";
    $totalproveedor+=$retiibb;          
}
if($impinternos>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$cta->getImpinternos();
    $$entrada=$impinternos;
    $$salida="";
    $totalproveedor+=$impinternos;          
}
if($totalproveedor>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$cta->getAcreedor();
    $$entrada="";
    $$salida=$totalproveedor;
}

$totalfactura=$neto10+$neto21+$neto27+$iva21+$iva10+$iva27+$nogravado+$exento+$periva+$retiva+$retiibb+$impinternos+$neto17+$iva17;

$asiento=0;
$ssql="select * from adm_mov1 order by asiento desc limit 1";
if($conx->getCantidadRegA($ssql, $conn)>0) {
    $ra=$conx->consultaBase($ssql, $conn);
    $raa= mysqli_fetch_object($ra);
    $asiento=$raa->asiento;
}
$asiento++;
$ssql="insert into adm_mov1 (fecha, detalle, clave, centro, asiento, idcom) values ('$fecha', 'Compra Nro $numero proveedor ".$prv->getApellido()."', '$clave', $centrosel, $asiento, $id)";
$conx->consultaBase($ssql, $conn);


$idmov1=$conx->getLastId('adm_mov1', $conn);
//echo $ssql."<br>";
$ssql="delete from adm_mov2 where idmov=$idmov1";
$conx->consultaBase($ssql, $conn);
for($i=0;$i<=$cantc;$i++) {
    $cuenta="cuenta$i";
    $entrada="entrada$i";
    $salida="salida$i";
    $detallecon="detallecon$i";
//        $$cuenta=$glo->getGETPOST($cuenta);
    //echo "cuenta: ".$$cuenta."<br>";
//        $$detallecon=$glo->getGETPOST($detallecon);
//        $$entrada=$glo->getGETPOST($entrada);
//        $$salida=$glo->getGETPOST($salida);
//        echo "salida: $salida ".$$salida."<br>";
    if($$entrada>0) {
        $tipo=1;
        $importe=$$entrada;
    } else {
        $tipo=2;
        $importe=$$salida;
    }
    $ssql="insert into adm_mov2 (idmov, importe, tipo, idcta, detalle, centro, clave) values ($idmov1, $importe, $tipo, ".$$cuenta.", '".$$detallecon."', $centrosel, '$clave')";
    $conx->consultaBase($ssql, $conn);
//
}

$cantidaddet=$glo->getGETPOST("cantidaddet");
//echo "cantidaddet: $cantidaddet<br>";
//print_r($cantidad);
for($i=0;$i<=$cantidaddet;$i++) {
    $item_detalle="item_detalle$i";
    $item_descriptor1="item_descriptor1$i";
    $item_descriptor2="item_descriptor2$i";
    $item_descriptor3="item_descriptor3$i";
    $item_descriptor4="item_descriptor4$i";
    $item_importe="item_importe$i";
    $$item_descriptor1=$glo->getGETPOST($item_descriptor1);
    $$item_descriptor2=$glo->getGETPOST($item_descriptor2);
    $$item_descriptor3=$glo->getGETPOST($item_descriptor3);
    $$item_descriptor4=$glo->getGETPOST($item_descriptor4);
    $$item_importe=$glo->getGETPOST($item_importe);
    $$item_detalle=$glo->getGETPOST($item_detalle);
    if($$item_descriptor2=="") $$item_descriptor2=0;
    if($$item_descriptor3=="") $$item_descriptor3=0;
    if($$item_descriptor4=="") $$item_descriptor4=0;
    if($$item_importe=="") $$item_importe=0;
    if($$item_importe>0) {
        $ssql="insert into adm_com_det (idcom, descriptor1, descriptor2, descriptor3, descriptor4, detalle, importe) values (";
        $ssql.="$id, ".$$item_descriptor1.", '".$$item_descriptor2."', ".$$item_descriptor3.", ".$$item_descriptor4.", '".$$item_detalle."', ".$$item_importe.")";
//        echo $ssql."<br>";
            $conx->consultaBase($ssql, $conn);
    }
}


?>
<html>
<body>
<form name="form1" id="form1" action="adm_com_var_main.php" method="post">
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
