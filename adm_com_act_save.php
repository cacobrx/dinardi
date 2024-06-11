<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_act_save.php
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
$id=$glo->getGETPOST("id");
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
$iva21=$glo->getGETPOST("iva21");
$iva10=$glo->getGETPOST("iva10");
$iva27=$glo->getGETPOST("iva27");
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
$importepag=$glo->getGETPOST("importepag");
$fechaimputacion=$glo->getGETPOST("fechaimputacion");
$clave=$glo->getGETPOST("clave");
$prv=new adm_prv_1($idprv, $conn);
if($importepag=="") $importepag=0;
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
if($iva21=="")
    $iva21=0;
if($iva10=="")
    $iva10=0;
if($iva27=="")
    $iva27=0;
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

$totaltotal=$neto21 + $neto10 + $neto27 + $iva21 + $iva10 + $iva27 + $impinternos + $periva + $retiva + $retiibb + $exento + $nogravado;

$aud->regAud("Compras",$usr->getId(),"Modifica Compras: Nro. $ptovta-$numero",$centrosel);
$ssql="update adm_com set fecha='$fecha', tipocom=$tipocom, letra='$letra', ptovta=$ptovta, numero=$numero, idprv=$idprv, ";
$ssql.="neto21=$neto21, neto10=$neto10, neto27=$neto27, iva21=$iva21, iva10=$iva10, iva27=$iva27, impinternos=$impinternos, ";
$ssql.="nogravado=$nogravado, exento=$exento, periva=$periva, retiva=$retiva, perretiibb=$retiibb, fechaven='$fechaven', ";
$ssql.="totaltotal=$totaltotal, fechaimputacion='$fechaimputacion', tipo=1, importepag='$importepag' where id=$id";
//echo $ssql."<br>";
$idmov1=0;
$conx->getConsulta($ssql);

$condicioncancela="";
for($i=0;$i<$cantidadrem;$i++) {
    $cancela="cancela$i";
    $$cancela=$glo->getGETPOST($cancela);
    if($$cancela!="") $condicioncancela.="id=".$$cancela." or ";
}
$ssql="update adm_rem set idcom=0 where idcom=$id";
//echo $ssql."<br>";
$conx->getConsulta($ssql);

if($condicioncancela!="") {
    $ssql="update adm_rem set idcom=$id where ".substr($condicioncancela,0,strlen($condicioncancela)-4);
//    echo $ssql."<br>";
    $conx->consultaBase($ssql, $conn);
}

// contable
$cantc=-1;
$ii=-1;
$totalproveedor=0;
if($neto21>0 or $neto10>0 or $neto27>0 or $exento>0 or $nogravado>0) {
    $cantc++;
    $ii++;
    $cuenta="cuenta$ii";
    $entrada="entrada$ii";
    $salida="salida$ii";
    $detallecon="detallecon$ii";
    $$detallecon="";
    $$cuenta=$prv->getCuenta();
    $$entrada=$neto21 + $neto10 + $neto27 + $exento + $nogravado;
    $$salida="";
    $totalproveedor+=$neto21+$neto10+$neto27+$exento+$nogravado;
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
    $$cuenta=$cta->getRetiva();
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
    $$cuenta=$cta->getRetiibb();
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

$totalfactura=$neto10+$neto21+$neto27+$iva21+$iva10+$iva27+$nogravado+$exento+$periva+$retiva+$retiibb+$impinternos;
$conn=$conx->conectarBase();
$ssql="select * from adm_mov1 where clave='$clave'";
if($conx->getCantidadRegA($ssql,$conn)>0) {
    $rm=$conx->consultaBase($ssql, $conn);
    $rmm= mysqli_fetch_object($rm);
    $idmov1=$rmm->id;
    $asiento=$rmm->asiento;
} else {

    $asiento=0;
    $ssql="select * from adm_mov1 order by asiento desc limit 1";
    if($conx->getCantidadRegA($ssql, $conn)>0) {
        $ra=$conx->consultaBase($ssql, $conn);
        $raa= mysqli_fetch_object($ra);
        $asiento=$raa->asiento;
    }
    $asiento++;
    $ssql="insert into adm_mov1 (fecha, detalle, clave, centro, asiento) values ('$fecha', 'Compra Nro $numero proveedor ".$prv->getApellido()."', '$clave', $centrosel, $asiento)";
    $conx->consultaBase($ssql, $conn);
    $idmov1=$conx->getLastId("adm_mov1", $conn);
}


$ssql="delete from adm_mov2 where idmov=$idmov1";
$conx->consultaBase($ssql, $conn);
for($i=0;$i<=$cantc;$i++) {
    $cuenta="cuenta$i";
    $entrada="entrada$i";
    $salida="salida$i";
    $detallecon="detallecon$i";
    if($$entrada>0) {
        $tipo=1;
        $importe=$$entrada;
    } else {
        $tipo=2;
        $importe=$$salida;
    }
    $ssql="insert into adm_mov2 (idmov, importe, tipo, idcta, detalle, centro, clave) values ($idmov1, $importe, $tipo, ".$$cuenta.", '".$$detallecon."', $centrosel, '$clave')";
    $conx->consultaBase($ssql, $conn);
}

//echo $ssql."<br>";
?>
<html>
<body>
<form name="form1" id="form1" action="adm_com_main.php" method="post">
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
