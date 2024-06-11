<?php
/*
 * Creado el 28/01/2020 12:53:25
 * Autor: gus
 * Archivo: adm_opg_var_act_save.php
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
require_once 'clases/adm_com.php';
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
if($importe=="") $importe=0;
if($retenciones=="") $retenciones=0;
if($importeganancia=="") $importeganancia=0;
$prv=new adm_prv_1($idprv);
$conn=$conx->conectarBase();
$pasa=1;
if($tarea=="A") {
    
    $ssql="select * from adm_opg1 where idprv=$idprv and importe=$importe and fecha='$fecha' and concepto='$concepto'";
    if($conx->getCantidadRegA($ssql, $conn)>0) $pasa=0;
        
}
//$pasa=1;
if($pasa==1) {
    if($tarea=="A") {
        $aud->regAudC("O.PAGO", $usr->getId(), "Se agrega ORDEN DE PAGO: $idprv | $fecha | $importe | $retenciones | $importeganancia", $centrosel, $conn);
        $ssql="insert into adm_opg1 (centro, fecha, concepto, idprv, importe, tipo, caja, retencioniibb, alicuotaret, retencionganancia) values (";
        $ssql.="$centrosel, '$fecha', '$concepto', $idprv, $importe, $tipo, $caja, $retenciones, $alicuotaret, $importeganancia)";
    } else {
        $aud->regAudC("O.PAGO", $usr->getId(), "Se agrega ORDEN DE PAGO: $idprv | $fecha | $importe | $retenciones | $importeganancia", $centrosel,$conn);
        $ssql="update adm_opg1 set fecha='$fecha', concepto='$concepto', idprv='$idprv', importe=$importe, tipo=$tipo, caja=$caja, retencioniibb=$retenciones, alicuotaret=$alicuotaret, retencionganancia=$importeganancia, fechamod='".date("Y-m-d H:i:s")."' where id=$id";
    }
    $conx->consultaBase($ssql, $conn);
//    echo $ssql."<br>";
    if($tarea=="A") $id=$conx->getLastId ("adm_opg1", $conn);
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
    
    $cantidadtotal=$glo->getGETPOST("cantidadtotal");
    
    for($i=0;$i<$cantidadtotal;$i++) {
        $chkpag="chkpag$i";
        $$chkpag=$glo->getGETPOST($chkpag);
        if($$chkpag>0) {
            
        }
    }

    if($tarea=="M") {
        $ssql="update adm_com set importepag=0 where idopg=$id";
        $conx->consultaBase($ssql, $conn);
    }
    $ssql="delete from adm_opg3 where idop=$id";
    $conx->consultaBase($ssql, $conn);
//    echo "cantidadtotal: $cantidadtotal<br>";
    for($i=0;$i<$cantidadtotal;$i++) {
        $chkpag="chkpag$i";
        $$chkpag=$glo->getGETPOST($chkpag);
//        echo "chkpag: $chkpag | ".$$chkpag."<br>";
        if($$chkpag>0) {
            $com=new adm_com_1($$chkpag, $conn);
            $imp=$com->getTotaltotal();
            $ssql="update adm_com set importepag=$imp, idopg=$id where id=".$$chkpag;
//            echo $ssql."<br>";
            $conx->consultaBase($ssql, $conn);
        }
    }
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_com_var_main.php" method="post">
        </form>
        <script language="javascript">
           document.form1.submit();
        </script>
    </body>
</html>

