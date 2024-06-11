<?php
/*
 * Creado el 04/11/2018 18:39:54
 * Autor: gus
 * Archivo: adm_opg_act_save.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_cht.php';
require_once 'clases/adm_prv.php';
require_once 'clases/adm_che.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$id=$glo->getGETPOST("idop");
$tarea=$glo->getGETPOST("tarea");
$idprv=$glo->getGETPOST("idprv");
$fecha=$glo->getGETPOST("fecha");
$tipo=$glo->getGETPOST("tipo");
$tiposer=$glo->getGETPOST("tiposer");
$importe=$glo->getGETPOST("importe");
$retenciones=$glo->getGETPOST("retenciones");
$concepto=$glo->getGETPOST("concepto");
$caja=$glo->getGETPOST("caja");
$canti=$glo->getGETPOST("canti");
$cantd=$glo->getGETPOST("cantd");
$alicuotaret=$glo->getGETPOST("alicuotaret");
$importeefectivo=$glo->getGETPOST("importeefectivo");
$importeganancia=$glo->getGETPOST("importeganancia");
$transferencia=$glo->getGETPOST("transferencia");
$importeiibb=$glo->getGETPOST("importeiibb");
$cantidadcht=$glo->getGETPOST("cantidadcht");
$cantidadche=$glo->getGETPOST("cantidadche");
$otraforma=$glo->getGETPOST("otraforma");
$retencionganancia=$glo->getGETPOST("retencionganancia");
$o2_detalle= unserialize($glo->getGETPOST("o2_detalle"));
$o2_importe= unserialize($glo->getGETPOST("o2_importe"));
$o2_id= unserialize($glo->getGETPOST("o2_id"));
$o2_tipopag= unserialize($glo->getGETPOST("o2_tipopag"));
$o2_chequet= unserialize($glo->getGETPOST("o2_chequet"));
$o2_chequep= unserialize($glo->getGETPOST("o2_chequep"));
//$cantidadccc=$glo->getGETPOST("cantidadccc");
if($importe=="") $importe=0;
if($otraforma=="") $otraforma=0;
if($retenciones=="") $retenciones=0;
if($retencionganancia=="") $retencionganancia=0;
if($importeganancia=="") $importeganancia=0;
$prv=new adm_prv_1($idprv);
$conn=$conx->conectarBase();
$pasa=1;
if($tarea=="A") {
    
    $ssql="select * from adm_opg1 where idprv=$idprv and importe=$importe and fecha='$fecha' and concepto='$concepto'";
    if($conx->getCantidadRegA($ssql, $conn)>0) $pasa=0;
        
}
if($pasa==1) {
    if($tarea=="A") {
        $aud->regAudC("O.PAGO", $usr->getId(), "Se agrega ORDEN DE PAGO: $idprv | $fecha | $importe | $retenciones", $centrosel, $conn);
        $ssql="insert into adm_opg1 (centro, fecha, concepto, idprv, importe, tipo, caja, retencioniibb, alicuotaret, retencionganancia, tiposer) values (";
        $ssql.="$centrosel, '$fecha', '$concepto', $idprv, $importe, $tipo, $caja, $retenciones, $alicuotaret, $importeganancia, $tiposer)";
    } else {
        $aud->regAudC("O.PAGO", $usr->getId(), "Se agrega ORDEN DE PAGO: $idprv | $fecha | $importe | $retenciones", $centrosel,$conn);
        $ssql="update adm_opg1 set fecha='$fecha', concepto='$concepto', idprv='$idprv', importe=$importe, tipo=$tipo, caja=$caja, retencioniibb=$retenciones, alicuotaret=$alicuotaret, retencionganancia=$importeganancia, tiposer=$tiposer, fechamod='".date("Y-m-d H:i:s")."' where id=$id";
    }
    $conx->consultaBase($ssql, $conn);
    //echo $ssql."<br>";
    if($tarea=="A") $id=$conx->getLastId ("adm_opg1", $conn);
    $ssql="select * from adm_opg1 where id=$id";
    $rx=$conx->consultaBase($ssql, $conn);
    $rxx=mysqli_fetch_object($rx);
    if($rxx->retencioniibb>0 and $rxx->numeroret==0) {
        $num=0;
        $ssql="select * from adm_opg1 where numeroret>0 order by numeroret desc";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rt=$conx->consultaBase($ssql, $conn);
            $rtt=mysqli_fetch_object($rt);
            $num=$rtt->numeroret;
        }
        $num++;
        $ssql="update adm_opg1 set numeroret=$num where id=$id";
        $conx->consultaBase($ssql, $conn);
    }
    
    if($rxx->retencionganancia>0 and $rxx->numeroretg==0) {
        $num=0;
        $ssql="select * from adm_opg1 where numeroretg>0 order by numeroretg desc";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rt=$conx->consultaBase($ssql, $conn);
            $rtt=mysqli_fetch_object($rt);
            $num=$rtt->numeroretg;
        }
        $num++;
        $ssql="update adm_opg1 set numeroretg=$num where id=$id";
        $conx->consultaBase($ssql, $conn);
    }
    
    
    $ssql="delete from adm_opg2 where idop=$id";
    $conx->consultaBase($ssql, $conn);
    for($i=0;$i<$cantidadcht;$i++) {
        $chkcht="chkcht$i";
        $$chkcht=$glo->getGETPOST($chkcht);
        if($$chkcht>0) {
            $cht=new adm_cht_1($$chkcht, $conn);
            $detalle="Ch ".$cht->getBancodes()." ".$cht->getNrocheque()." (".$dsup->getFechaNormalCorta($cht->getFechapago()).")";
    //        echo $detalle."<br>";
            $ssql="insert into adm_opg2 (centro, idop, detalle, importe, idcht) values ";
            $ssql.="($centrosel, $id, '$detalle', ".$cht->getImporte().", ".$$chkcht.")";
            $conx->consultaBase($ssql, $conn);
            $ssql="update adm_cht set entregado='".$prv->getApellido()." ".$prv->getNombre()."', idopg=$id where id=".$$chkcht;
            $conx->consultaBase($ssql, $conn);

        }
    }

    for($i=0;$i<$cantidadche;$i++) {
        $chkche="chkche$i";
        $$chkche=$glo->getGETPOST($chkche);
        if($$chkche>0) {
            $che=new adm_che_1($$chkche, $conn);
            $detalle="Ch ".$che->getBancodes()." ".$che->getNrocheque()." (".$dsup->getFechaNormalCorta($che->getFechapago()).")";
    //        echo $detalle."<br>";
            $ssql="insert into adm_opg2 (centro, idop, detalle, importe, idche) values ";
            $ssql.="($centrosel, $id, '$detalle', ".$che->getImporte().", ".$$chkche.")";
            $conx->consultaBase($ssql, $conn);
            $ssql="update adm_che set entregado=1, idopg=$id where id=".$$chkche;
            $conx->consultaBase($ssql, $conn);

        }
    }
    
    // guardo los cheques que estaban antes
    $cantidadpago=count($o2_detalle);
    for($i=0;$i<count($o2_detalle);$i++) {
        if($o2_chequep[$i]>0 or $o2_chequet[$i]>0) {
            $ssql="insert into adm_opg2 (centro, idop, detalle, importe, idche, idcht) values (";
            $ssql.="$centrosel, $id, '".$o2_detalle[$i]."', ".$o2_importe[$i].", ".$o2_chequep[$i].", ".$o2_chequet[$i].")";
            $conx->consultaBase($ssql, $conn);
        }
    }
    


    if($importeefectivo>0) {
        $ssql="insert into adm_opg2 (centro, idop, detalle, importe, idcht) values ($centrosel, $id, 'Efectivo', $importeefectivo, 0)";
        $conx->consultaBase($ssql, $conn);
    }

    if($transferencia>0) {
        $ssql="insert into adm_opg2 (centro, idop, detalle, importe, idcht) values ($centrosel, $id, 'Transferencia', $transferencia, 0)";
        $conx->consultaBase($ssql, $conn);
    }

    if($importeganancia>0) {
        $ssql="insert into adm_opg2 (centro, idop, detalle, importe, idcht) values ($centrosel, $id, 'Retención Ganancias', $importeganancia, 0)";
        $conx->consultaBase($ssql, $conn);
    }

    if($importeiibb>0) {
        $ssql="insert into adm_opg2 (centro, idop, detalle, importe, idcht) values ($centrosel, $id, 'Retención IIBB', $importeiibb, 0)";
        $conx->consultaBase($ssql, $conn);
    }
    
    for($p=0;$p<$otraforma;$p++) {
        $formapago="formapago$p";
        $importefp="importefp$p";
        $$formapago=$glo->getGETPOST($formapago);
        $$importefp=$glo->getGETPOST($importefp);
        if($$importefp!="") {
            $ssql="insert into adm_opg2 (centro, idop, detalle, importe, idcht, tipopago) values ($centrosel, $id, '".$$formapago."', ".$$importefp.", 0, 9)";
            $conx->consultaBase($ssql, $conn);
        }
    }
//    print_r($o2_detalle);
//    for($i=0;$i<count($o2_detalle);$i++) {
//        if($o2_tipopag[$i]==9) {
//            $ssql="insert into adm_opg2 (centro, idop, detalle, importe, idcht, tipopago) values ($centrosel, $id, '".$o2_detalle[$i]."', ".$o2_importe[$i].", 0, 9)";
//            echo $ssql."<br>";
//            $conx->consultaBase($ssql, $conn);
//        }
//    }


    if($tarea=="M") {
        $ssql="update adm_com set importepag=0, idopg=0 where idopg=$id";
        $conx->consultaBase($ssql, $conn);
    }
    $ssql="delete from adm_opg3 where idop=$id";
    $conx->consultaBase($ssql, $conn);
    for($i=0;$i<$cantd; $i++) {
        $pagar="pagar$i";
        $idcom="idcom$i";
        $importetot="importetot$i";
        $$importetot=$glo->getGETPOST($importetot);
        $$pagar=$glo->getGETPOST($pagar);
        $$idcom=$glo->getGETPOST($idcom);
        if($$pagar==1) {
    //        $ssql="insert into adm_opg3 (centro, idop, idcom, importetotal, importecancelado) values ($centrosel, $id, ".$$idcom.", ".$$importetot.", ".$$pagar.")";
    //        $conx->consultaBase($ssql, $conn);
    //        echo $ssql."<br>";
            if($tipo==1)
                $ssql="update adm_com set importepag=totaltotal, idopg=$id where id=".$$idcom;
            else
                $ssql="update adm_gas set pagado=importe, idopg=$id where id=".$$idcom;

//            echo $ssql;
            $conx->consultaBase($ssql, $conn);
        }
    }
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_opg_main.php" method="post">
        </form>
        <script language="javascript">
           document.form1.submit();
        </script>
    </body>
</html>

