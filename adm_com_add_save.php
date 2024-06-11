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
$clave=$glo->getGETPOST("clave");
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
$fechaimputacion=$glo->getGETPOST("fechaimputacion");
$clave=$glo->getGETPOST("clave");

//nc
$fechanc=$glo->getGETPOST("fechanc");
$numeronc=$glo->getGETPOST("numeronc");
$ptovtanc=$glo->getGETPOST("ptovtanc");
$letranc=$glo->getGETPOST("letranc");
$exentonc=$glo->getGETPOST("exentonc");
$perivanc=$glo->getGETPOST("perivanc");
$retivanc=$glo->getGETPOST("retivanc");
$retiibbnc=$glo->getGETPOST("retiibbnc");
$netonc10=$glo->getGETPOST("netonc10");
$netonc21=$glo->getGETPOST("netonc21");
$ivanc10=$glo->getGETPOST("ivanc10");
$ivanc21=$glo->getGETPOST("ivanc21");
$impinternosnc=$glo->getGETPOST("impinternosnc");
$nogravadonc=$glo->getGETPOST("nogravadonc");
$cainronc=$glo->getGETPOST("cainronc");

$tipoganancia=$glo->getGETPOST("tipoganancia");
if($tipoganancia=="") $tipoganancia=0;
$prv=new adm_prv_1($idprv, $conn);
if($ptovta=="")
    $ptovta=0;
if($numero=="")
    $numero=0;
if($neto21=="")  $neto21=0;
if($neto10=="") $neto10=0;
if($neto27=="") $neto27=0;
if($iva21=="") $iva21=0;
if($iva10=="") $iva10=0;
if($iva27=="") $iva27=0;
if($impinternos=="") $impinternos=0;
if($periva=="") $periva=0;
if($retiva=="") $retiva=0;
if($retiibb=="") $retiibb=0;
if($exento=="") $exento=0;
if($nogravado=="") $nogravado=0;
if($exentonc=="") $exentonc=0;
if($retiibbnc=="") $retiibbnc=0;
if($perivanc=="") $perivanc=0;
if($retivanc=="") $retivanc=0;
if($numeronc=="") $numeronc=0;
if($ptovtanc=="") $ptovtanc=0;
if($nogravadonc=="") $nogravadonc=0;
if($impinternosnc=="") $impinternosnc=0;
if($netonc21=="") $netonc21=0;
if($netonc10=="") $netonc10=0;
if($ivanc21=="") $ivanc21=0;
if($ivanc10=="") $ivanc10=0;

$totaltotal=$neto21 + $neto10 + $neto27 + $iva21 + $iva10 + $iva27 + $impinternos + $periva + $retiva + $retiibb + $exento + $nogravado;
$totalnc=$netonc21 + $netonc10 + $ivanc21 + $ivanc10 + $impinternosnc + $perivanc + $retivanc + $retiibbnc + $exentonc + $nogravadonc;
$ssql="select * from adm_com where clave='$clave'";
if($conx->getCantidadReg($ssql)==0) {
    $aud->regAud("Compras",$usr->getId(),"Ingresa Compras: Nro. $numero",$centrosel);
    $ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, ";
    $ssql.="impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario, tipoganancia) values ($centrosel, '$fecha', $tipocom, '$letra', $ptovta, $numero, ";
    $ssql.="$idprv, '$cainro', $neto21, $neto10, $neto27, $iva21, $iva10, $iva27, $impinternos, $nogravado, $exento, $periva, $retiva, $retiibb, '$fechaven', $totaltotal, '$clave', '$fechaimputacion', 1, ".$usr->getId().", $tipoganancia)";
    //echo $ssql."<br>";
    $idmov1=0;
    $conx->getConsulta($ssql);
    $id=$conx->getLastId("adm_com", $conn);

    $condicioncancela="";
    for($i=0;$i<$cantidadrem;$i++) {
        $cancela="cancela$i";
        $$cancela=$glo->getGETPOST($cancela);
        if($$cancela!="") $condicioncancela.="id=".$$cancela." or ";
    }

    if($condicioncancela!="") {
        $ssql="update adm_rem set idcom=$id where ".substr($condicioncancela,0,strlen($condicioncancela)-4);
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

    $totalfactura=$neto10+$neto21+$neto27+$iva21+$iva10+$iva27+$nogravado+$exento+$periva+$retiva+$retiibb+$impinternos;

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
    //        echo $ssql."<br>";
    }
    $condicionrem="";
    for($i=0;$i<$cantidadrem;$i++) {
        $r_id="r_id$i";
        $cancela="cancela$i";
        $$r_id=$glo->getGETPOST($r_id);
        $$cancela=$glo->getGETPOST($cancela);
    //    echo "cancela: ".$$cancela."<br>";
        if($$cancela>0) {
            $condicionrem.="id=".$$r_id." or ";
        }
    }
    if($condicionrem!="") {
        $ssql="update adm_rem set idcom=$id where ".substr($condicionrem, 0, strlen($condicionrem)-4);
        $conx->consultaBase($ssql, $conn);
    }
    //echo $ssql."<br>";
    if($numeronc!="") {
        $clave=$sup->generateKey();
        $ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, iva21, iva10, ";
        $ssql.="impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (";
        $ssql.="$centrosel, '$fechanc', 2, '$letranc', $ptovtanc, $numeronc, ";
        $ssql.="$idprv, '$cainronc', $netonc21, $netonc10, $ivanc21, $ivanc10, $impinternosnc, $nogravadonc, $exentonc, $perivanc, $retivanc, $retiibbnc, '$fechaven', $totalnc, '$clave', '$fechaimputacion', 1, ".$usr->getId().")";
        $conx->consultaBase($ssql, $conn);
        $cantnc=-1;
        $totalproveedornc=0;
        $ii=-1;
        if($netonc21>0 or $netonc10>0 or $netonc27>0 or $exentonc>0 or $nogravadonc>0) {
            $cantnc++;
            $ii++;
            $cuentanc="cuentanc$ii";
            $entradanc="entradanc$ii";
            $salidanc="salidanc$ii";
            $detalleconnc="detalleconnc$ii";
            $$detalleconnc="";
            $$cuentanc=$prv->getCuenta();
            $$salidanc=$netonc21 + $netonc10 + $exentonc + $nogravadonc;
            $$entradanc="";
            $totalproveedornc+=$netonc21+$netonc10+$exentonc+$nogravadonc;
        }
        if($ivanc21>0) {
            $cantnc++;
            $ii++;
            $cuentanc="cuentanc$ii";
            $entradanc="entradanc$ii";
            $salidanc="salidanc$ii";
            $detalleconnc="detalleconnc$ii";
            $$detalleconnc="";
            $$cuentanc=$cta->getIva21();
            $$salidanc=$ivanc21;
            $$entradanc="";
            $totalproveedornc+=$ivanc21;          
        }
        if($ivanc10>0) {
            $cantnc++;
            $ii++;
            $cuentanc="cuentanc$ii";
            $entradanc="entradanc$ii";
            $salidanc="salidanc$ii";
            $detalleconnc="detalleconnc$ii";
            $$detalleconnc="";
            $$cuentanc=$cta->getIva10();
            $$salidanc=$ivanc10;
            $$entradanc="";
            $totalproveedornc+=$ivanc10;          
        }
        if($retivanc>0) {
            $cantnc++;
            $ii++;
            $cuentanc="cuentanc$ii";
            $entradanc="entradanc$ii";
            $salidanc="salidanc$ii";
            $detalleconnc="detalleconnc$ii";
            $$detalleconnc="";
            $$cuentanc=$cta->getRetiva();
            $$salidanc=$retivanc;
            $$entradanc="";
            $totalproveedornc+=$retivanc;          
        }
        if($perivanc>0) {
            $cantnc++;
            $ii++;
            $cuentanc="cuentanc$ii";
            $entradanc="entradanc$ii";
            $salidanc="salidanc$ii";
            $detalleconnc="detalleconnc$ii";
            $$detalleconnc="";
            $$cuentanc=$cta->getPeriva();
            $$salidanc=$perivanc;
            $$entradanc="";
            $totalproveedornc+=$perivanc;          
        }
        if($retiibbnc>0) {
            $cantnc++;
            $ii++;
            $cuentanc="cuentanc$ii";
            $entradanc="entradanc$ii";
            $salidanc="salidanc$ii";
            $detalleconnc="detalleconnc$ii";
            $$detalleconnc="";
            $$cuentanc=$cta->getretiibb();
            $$salidanc=$retiibbnc;
            $$entradanc="";
            $totalproveedornc+=$retiibbnc;          
        }
        if($impinternosnc>0) {
            $cantnc++;
            $ii++;
            $cuentanc="cuentanc$ii";
            $entradanc="entradanc$ii";
            $salidanc="salidanc$ii";
            $detalleconnc="detalleconnc$ii";
            $$detalleconnc="";
            $$cuentanc=$cta->getImpinternos();
            $$salidanc=$impinternosnc;
            $$entradanc="";
            $totalproveedornc+=$impinternosnc;          
        }
        if($totalproveedor>0) {
            $cantnc++;
            $ii++;
            $cuentanc="cuentanc$ii";
            $entradanc="entradanc$ii";
            $salidanc="salidanc$ii";
            $detalleconnc="detalleconnc$ii";
            $$detalleconnc="";
            $$cuentanc=$cta->getAcreedor();
            $$salidanc="";
            $$entradanc=$totalproveedornc;
        }

        $totalfacturanc=$netonc10+$netonc21+$ivanc21+$ivanc10+$nogravadonc+$exentonc+$perivanc+$retivanc+$retiibbnc+$impinternosnc;

        $asiento=0;
        $ssql="select * from adm_mov1 order by asiento desc limit 1";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $ra=$conx->consultaBase($ssql, $conn);
            $raa= mysqli_fetch_object($ra);
            $asiento=$raa->asiento;
        }
        $asiento++;
        $ssql="insert into adm_mov1 (fecha, detalle, clave, centro, asiento) values ('$fechanc', 'NC Compra Nro $numeronc proveedor ".$prv->getApellido()."', '$clave', $centrosel, $asiento)";
        $conx->consultaBase($ssql, $conn);


        $idmov1=$conx->getLastId('adm_mov1', $conn);
        //echo $ssql."<br>";
        $ssql="delete from adm_mov2 where idmov=$idmov1";
        $conx->consultaBase($ssql, $conn);
        for($i=0;$i<=$cantnc;$i++) {
            $cuentanc="cuentanc$i";
            $entradanc="entradanc$i";
            $salidanc="salidanc$i";
            $detalleconnc="detalleconnc$i";
    //        $$cuenta=$glo->getGETPOST($cuenta);
            //echo "cuenta: ".$$cuenta."<br>";
    //        $$detallecon=$glo->getGETPOST($detallecon);
    //        $$entrada=$glo->getGETPOST($entrada);
    //        $$salida=$glo->getGETPOST($salida);
    //        echo "entradanc: $entradanc ".$$entradanc."<br>";
    //        echo "salidanc: $salidanc ".$$salidanc."<br>";
            if($$entradanc>0) {
                $tipo=1;
                $importe=$$entradanc;
            } else {
                $tipo=2;
                $importe=$$salidanc;
            }
            $ssql="insert into adm_mov2 (idmov, importe, tipo, idcta, detalle, centro, clave) values ($idmov1, $importe, $tipo, ".$$cuentanc.", '".$$detalleconnc."', $centrosel, '$clave')";
            $conx->consultaBase($ssql, $conn);
    //        echo $ssql."<br>";
        }


    //    echo $ssql;
    }
}
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
