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
$neto17=$glo->getGETPOST("neto17");
$iva21=$glo->getGETPOST("iva21");
$iva10=$glo->getGETPOST("iva10");
$iva27=$glo->getGETPOST("iva27");
$iva17=$glo->getGETPOST("iva17");
$detalle=$glo->getGETPOST("detalle");
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
$tipoganancia=$glo->getGETPOST("tipoganancia");
$clave=$glo->getGETPOST("clave");
$importepag=$glo->getGETPOST("importepag");
$prv=new adm_prv_1($idprv, $conn);
if($tipoganancia=="") $tipoganancia=0;
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
$conn=$conx->conectarBase();

$totaltotal=$neto21 + $neto10 + $neto27 + $neto17 + $iva21 + $iva10 + $iva27 + $iva17 + $impinternos + $periva + $retiva + $retiibb + $exento + $nogravado;

$aud->regAud("Compras Proveedores Varios",$usr->getId(),"Modifica Compras Proveedores Varios: Nro. $ptovta-$numero",$centrosel);
$ssql="update adm_com set fecha='$fecha', tipocom=$tipocom, letra='$letra', ptovta=$ptovta, numero=$numero, idprv=$idprv, ";
$ssql.="neto21=$neto21, neto10=$neto10, neto27=$neto27, neto17=$neto17, iva21=$iva21, iva10=$iva10, iva27=$iva27, iva17=$iva17, impinternos=$impinternos, tipoganancia=$tipoganancia, ";
$ssql.="nogravado=$nogravado, exento=$exento, periva=$periva, retiva=$retiva, perretiibb=$retiibb, fechaven='$fechaven', importepag=$importepag, ";
$ssql.="totaltotal=$totaltotal, fechaimputacion='$fechaimputacion', tipo=2 where id=$id";
//echo $ssql."<br>";
$conx->consultaBase($ssql,$conn);
$ssql="delete from adm_com_det where idcom=$id";
$conx->consultaBase($ssql,$conn);
//echo $ssql;
$cantidad=$glo->getGETPOST("cantidaddet");

for($i=0;$i<=$cantidad;$i++) {
    $item_descriptor1="item_descriptor1$i";
    $item_descriptor2="item_descriptor2$i";
    $item_descriptor3="item_descriptor3$i";
    $item_descriptor4="item_descriptor4$i";
    $item_detalle="item_detalle$i";
    $item_importe="item_importe$i";

    $$item_descriptor1=$glo->getGETPOST($item_descriptor1);
    $$item_descriptor2=$glo->getGETPOST($item_descriptor2);
    $$item_descriptor3=$glo->getGETPOST($item_descriptor3);
    $$item_descriptor4=$glo->getGETPOST($item_descriptor4);
    $$item_detalle=$glo->getGETPOST($item_detalle);
    $$item_importe=$glo->getGETPOST($item_importe);

    if($$item_descriptor1=="") $$item_descriptor1=0;
    if($$item_descriptor2=="") $$item_descriptor2=0;
    if($$item_descriptor3=="") $$item_descriptor3=0;
    if($$item_descriptor4=="") $$item_descriptor4=0;
//    echo "idremdet: $idremdet | ".$$idremdet."<br>";
    
    $ssql="insert into adm_com_det (idcom, descriptor1, descriptor2, descriptor3, descriptor4, detalle, importe) values (";
    $ssql.="$id, ".$$item_descriptor1.", '".$$item_descriptor2."', ".$$item_descriptor3.", ".$$item_descriptor4.", '".$$item_detalle."', ".$$item_importe.")";
    //echo $ssql."<br>";
    $conx->consultaBase($ssql,$conn);
   
    }
//echo $ssql."<br>";

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
    if($tipocom!=2) {
        $$entrada=$neto21 + $neto10 + $neto27 + $neto17 + $exento + $nogravado;
        $$salida="";
    } else {
        $$salida=$neto21 + $neto10 + $neto27 + $neto17 + $exento + $nogravado;
        $$entrada="";
    }
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
    if($tipocom!=2) {
        $$entrada=$iva21;
        $$salida="";
    } else {
        $$salida=$iva21;
        $$entrada="";
    }
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
    if($tipocom!=2) {
        $$entrada=$iva10;
        $$salida="";
    } else {
        $$entrada=$iva10;
        $$salida="";
    }
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
    if($tipocom!=2) {
        $$entrada=$iva27;
        $$salida="";
    } else {
        $$salida=$iva27;
        $$entrada="";
    }
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
    if($tipocom!=2) {
        $$entrada=$iva17;
        $$salida="";
    } else {
        $$salida=$iva17;
        $$entrada="";
    }
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
    if($tipocom!=2) {
        $$entrada=$retiva;
        $$salida="";
    } else {
        $$salida=$retiva;
        $$entrada="";
    }
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
    if($tipocom!=2) {
        $$entrada=$periva;
        $$salida="";
    } else {
        $$salida=$periva;
        $$entrada="";
    }
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
    if($tipocom!=2) {
        $$entrada=$retiibb;
        $$salida="";
    } else {
        $$salida=$retiibb;
        $$entrada="";
    }
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
    if($tipocom!=2) {
        $$entrada=$impinternos;
        $$salida="";
    } else {
        $$entrada=$impinternos;
        $$salida="";
    }
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
    if($tipocom!=2) {
        $$entrada="";
        $$salida=$totalproveedor;
    } else {
        $$salida="";
        $$entrada=$totalproveedor;
    }
}

$totalfactura=$neto10+$neto21+$neto27+$neto17+$iva21+$iva10+$iva27+$iva17+$nogravado+$exento+$periva+$retiva+$retiibb+$impinternos;

$asiento=0;
$ssql="select * from adm_mov1 where idcom=$id";
//echo $ssql."<br>";
if($conx->getCantidadRegA($ssql, $conn)==0) {
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
} else {
    $rc=$conx->consultaBase($ssql, $conn);
    $rcc=mysqli_fetch_object($rc);
    $idmov1=$rcc->id;
    $ssql="update adm_mov1 set fecha='$fecha', detalle='Compra Nro $numero proveedor ".$prv->getApellido()."') where id=".$rcc->id;
    $conx->consultaBase($ssql, $conn);
}


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
//        echo $ssql."<br>";
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
