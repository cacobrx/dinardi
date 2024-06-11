<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($_POST);
//echo "<br>";
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cli.php';
require_once 'clases/adm_rec1.php';
require_once 'clases/util.php';
require_once 'clases/adm_cht.php';
$utl=new util();
$dsup=new datesupport();
$sup=new support();
$glo=new globalson();
$conx=new conexion();
$fecha=$glo->getGETPOST("fecha");
$idcli=$glo->getGETPOST("idcli");
$canti=$glo->getGETPOST("canti");
$cantc=$glo->getGETPOST("cantc");
$cantf=$glo->getGETPOST("cantf");
$tarea=$glo->getGETPOST("tarea");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$caja=$glo->getGETPOST("caja");
if($caja=="") $caja=0;
$lim=$glo->getGETPOST("lim");
$idrec=$glo->getGETPOST("idrec");
$rec1=new adm_rec1_1($idrec);
$concepto=$glo->getGETPOST("concepto");
$importe=$glo->getGETPOST("importe");
$primero=$glo->getGETPOST("primero");
$tipocontabilidad=$glo->getGETPOST("tipocontabilidad");
$cantf=$glo->getGETPOST("cantf");
$cli=new adm_cli_1($idcli);
$clave=$sup->generateKey();

// validacion de importes
$errorcontable=0;
$errordetalle=0;
$errorpagocontable=0;
$totalpagar=0;
if($cantf==0)
    $totalpagar=$importe;
else {
    for($i=0;$i<$cantf;$i++) {
        $pagar="pagar$i";
        $conceptoc="concepto$i";
        $$conceptoc=$glo->getGETPOST($concepto);
        $$pagar=$glo->getGETPOST($pagar);
        $totalpagar+=$$pagar;
        //echo "totalpagar: $totalpagar<br>";
    }
}
$totaldetalle=0;
for($i=0;$i<$canti;$i++) {
    $importedet="importedet$i";
    $$importedet=$glo->getGETPOST($importedet);
    $totaldetalle+=$$importedet;
    //echo "totaldetalle: $totaldetalle<br>";
}
//echo "totalpagar: $totalpagar<br>";
//echo "----<br>$totaldetalle<br>$totalpagar<br>";
$dif=$totalpagar - $totaldetalle;
//echo "dif: $dif<br>";

if($dif>.01)
    $errordetalle=1;
$errordetalle=0;
//echo $errordetalle."<br>";

if($errordetalle==0) {
    if($tarea=="A")
        $ssql="insert into adm_rec1 (fecha, idcli, concepto, clave, centro, importe, tipocontabilidad, caja) values ('$fecha', $idcli, '$concepto', '$clave', $centrosel, $importe, $tipocontabilidad, $caja)";
    else
        $ssql="update adm_rec1 set fecha='$fecha', idcli=$idcli, concepto='$concepto', importe=$importe, tipocontabilidad=$tipocontabilidad, caja=$caja where id=$idrec";
    $conx->getConsulta($ssql);
    //echo $ssql."<br>";
    if($tarea=="A") {
//        $ssql="select * from adm_rec1 where clave='$clave'";
//        echo $ssql."<br>";
//        $rs=$conx->getConsulta($ssql);
//        $reg=mysqli_fetch_object($rs);
        $idrec=$conx->getLastId("adm_rec1");
    } else {
        $ssql="delete from adm_rec2 where idrec=$idrec";
        //echo $ssql."<br>";
        $conx->getConsulta($ssql);
        //$idrec1=$idrec;
    }

    //echo "clave: $clave<br>";
    for($i=0;$i<$canti;$i++) {
        $detallemov="detalle$i";
        $importedet="importedet$i";
        $chequeter="chequeter$i";
        $detallepago="detallepago$i";
        $$detallepago=$glo->getGETPOST($detallepago);
        $$detallemov=$glo->getGETPOST($detallemov);
        $$importedet=$glo->getGETPOST($importedet);
        $$chequeter=$glo->getGETPOST($chequeter);
        //echo $$chequeter."<br>";
        //$vvv=explode("|",$$chequeter);
        if($$importedet>0) {
            $ssql="insert into adm_rec2 (centro, idrec, detalle, importe, detallepago) values ($centrosel, $idrec, '".$$detallemov."', ".$$importedet.", ".$$detallepago.")";
            //echo $ssql."<br>";
            $conx->getConsulta($ssql);
        }
    }

    // anota los cheques de 3ros entregados
//    for($i=0;$i<$canti;$i++) {
//        $chequeter="chequeter$i";
//        $vvv=explode('|',$$chequeter);
//        if($vvv[1]>0) {
//            if($vvv[0]=="p")
//                $ssql="update adm_che set destinatario='".$cli->getApellido()." ".$cli->getNombre()."' where id=".$vvv[1];
//            else
//                $ssql="update adm_cht set entregado='".$cli->getApellido()." ".$cli->getNombre()."' where id=".$vvv[1];
//            $conx->getConsulta($ssql);
//        }
//    }

    // anota pago en factura de compra
    for($i=0;$i<$cantf;$i++) {
        $idcped="idcped$i";
        $pagar="pagar$i";
        $$idcped=$glo->getGETPOST($idcped);
        $$pagar=$glo->getGETPOST($pagar);
        if($$pagar>0) {
            if($tarea=="A") {
                //$ssql="update adm_rec1 set importepago=importepag + ".$$pagar." where id=".$$idcped;
                //echo $ssql."<br>";
                //$conx->getConsulta($ssql);
                $ssql="insert into adm_rec_pag (centro, idcped, idrec, idcli, fecha, importe) values ($centrosel, ".$$idcped.", $idrec, $idcli, '$fecha', ".$$pagar.")";
                //echo $ssql."<br>";
                $conx->getConsulta($ssql);
                if($tipocontabilidad==1)
                    $ssql="update adm_vta set importepag=importepag + ".$$pagar." where id=".$$idcped;
                else
                    $ssql="update adm_cped set importepago=importepago + ".$$pagar." where id=".$$idcped;
                $conx->getConsulta($ssql);
                //echo $ssql."<br>";
            } else {
                $ssql="select * from adm_rec_pag where centro=$centrosel and idcped=".$$idcped." and idrec=$idrec";
                //echo $ssql."<br>";
                $rc=$conx->getConsulta($ssql);
                $rec=mysqli_fetch_object($rc);
                $ssql="update adm_cped set importepago=importepago - ".$rec->importe." + ".$$pagar." where id=".$$idcped;
                //echo "2.".$ssql."<br>";
                $conx->getConsulta($ssql);
                $ssql="update adm_rec_pag set importe=".$$pagar." where id=".$rec->id;
                //echo $ssql."<br>";
                $conx->getConsulta($ssql);
            }
        }
    }


        
    $detalle=$concepto." - Cliente: ".$cli->getApellido();
    if($tarea=="M") {
        $ssql="delete from adm_mov1 where id=".$rec1->getIdmov();
        $conx->getConsulta($ssql);
        $ssql="delete from adm_mov2 where idmov1=".$rec1->getIdmov();
        $conx->getConsulta($ssql);
            
    }
    $ssql="insert into adm_mov1 (fecha, detalle, clave, gastodiferido, idemp, centro, tipocontabilidad) values ('$fecha', '$detalle', '$clave', 0, $idrec, $centrosel, $tipocontabilidad)";
    $conx->getConsulta($ssql);
    //echo $ssql."<br>";
//    $ssql="select * from adm_mov1 where clave='$clave'";
//    //echo $ssql."<br>";
//    $rs=$conx->getConsulta($ssql);
//    $reg=mysqli_fetch_object($rs);
    $idmov1=$conx->getLastId("adm_mov1");
    $idmov3=0;

    //echo "cantc: $cantc<br>";
    for($i=0;$i<$cantc;$i++) {
        $cuenta="cuenta$i";
        $entrada="entrada$i";
        $salida="salida$i";
        $detallecon="detallecon$i";
        $$cuenta=$glo->getGETPOST($cuenta);
        $$entrada=$glo->getGETPOST($entrada);
        $$salida=$glo->getGETPOST($salida);
        $$detallecon=$glo->getGETPOST($detallecon);
        //echo "cuenta: ".$$cuenta."<br>";
        if($$entrada>0 or $$salida>0) {
            if($$entrada>0 and ($$salida=="" or $$salida==0)) {
                $tipo=0;
                $importecon=$$entrada;
            } else {
                $tipo=1;
                $importecon=$$salida;
            }
            $ssql="insert into adm_mov2 (centro, idemp, idmov1, detalle, tipo, importe, idcta) values ($centrosel, $idrec, $idmov1, '".$$detallecon."', $tipo, ".$importecon.", ".$$cuenta.")";
            //echo $ssql."<br>";
            $conx->getConsulta($ssql);
        }
    }

    // guardo nro de asiento en la orden de pago
    $ssql="update adm_rec1 set idmov=$idmov1 where id=$idrec";
    $conx->getConsulta($ssql);
    
    // guardo cheques terceros desde tmp
    $ssql="select * from tmp_cht where idcli=$idcli and usuario=".$usr->getId();
    $cht=new adm_cht_2($ssql);
    $cht_id=$cht->getId();
    $cht_nro=$cht->getNrocheque();
    $cht_ban=$cht->getIdbanco();
    $cht_importe=$cht->getImporte();
    $cht_fechaven=$cht->getFechapago();
    $cht_fechaorigen=$cht->getFechaorigen();
    $cht_nombre=$cht->getNombre();
    $cht_cliente=$cht->getCliente();
    $cht_tipo=$cht->getTipo();
    for($i=0;$i<count($cht_id);$i++) {
        $ssql="insert into adm_cht (centro, fecha, fechaorigen, fechapago, idbanco, nrocheque, nombre, importe, idcli, cliente, tipo) values ";
        $ssql.="($centrosel, '$fecha','".$cht_fechaorigen[$i]."', '".$cht_fechaven[$i]."', ".$cht_ban[$i].", '".$cht_nro[$i]."', '".$cht_nombre[$i]."', ".$cht_importe[$i].", $idcli, '".$cht_cliente[$i]."', ".$cht_tipo[$i].")";
        $conx->getConsulta($ssql);
        //echo $ssql;
    }
    
    // elimino tmp
    $ssql="delete from tmp_cht where idcli=$idcli and usuario=".$usr->getId();
    $conx->getConsulta($ssql);
    
    
    $url="adm_crec_main.php";
} else
    $url="adm_crec_act.php";
?>
<html>
    <body>
        <form name="form1" id="form1" action="<?= $url?>" method="post">
           <input name="fechaini" id="fechaini" type="hidden" value="<?= $fechaini?>" />
           <input name="fechafin" id="fechaini" type="hidden" value="<?= $fechafin?>" />
           <input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
           <input name="errordetalle" id="errordetalle" type="hidden" value="<?= $errordetalle?>" />
           <input name="errorcontable" id="errorcontable" type="hidden" value="<?= $errorcontable?>" />
           <input name="errorpagocontable" id="errorpagocontable" type="hidden" value="<?= $errorpagocontable?>" />
           <input name="primero" id="primero" type="hidden" value="<?= $primero?>" />
           <input name="fecha" id="fecha" type="hidden" value="<?= $fecha?>" />
           <input name="idcli" id="idcli" type="hidden" value="<?= $idcli?>" />
           <input name="canti" id="canti" type="hidden" value="<?= $canti?>" />
           <input name="cantc" id="cantc" type="hidden" value="<?= $cantc?>" />
           <input name="cantf" id="cantf" type="hidden" value="<?= $cantf?>" />
           <input name="tarea" id="tarea" type="hidden" value="<?= $tarea?>" />
           <input name="idrec" id="idrec" type="hidden" value="<?= $idrec?>" />
           <input name="concepto" id="concepto" type="hidden" value="<?= $concepto?>" />
           <input name="importe" id="importe" type="hidden" value="<?= $importe?>" />
           <? for($i=0;$i<$canti;$i++) { 
                $detallemov="detalle$i";
                $importedet="importedet$i";
                $chequeter="chequeter$i";
                $$detallemov=$glo->getGETPOST($detallemov);
                $$importedet=$glo->getGETPOST($importedet);
                $$chequeter=$glo->getGETPOST($chequeter);
                ?>
           <input name="detallemov<?= $i?>" id="detallemov<?= $i?>" type="hidden" value="<?= $$detallemov?>" />
           <input name="importedet<?= $i?>" id="importedet<?= $i?>" type="hidden" value="<?= $$importedet?>" />
           <input name="chequeter<?= $i?>" id="chequeter<?= $i?>" type="hidden" value="<?= $$chequeter?>" />
           <? } 
            for($i=0;$i<$cantf;$i++) {
                $idcped="idcped$i";
                $pagar="pagar$i";
                $$idcped=$glo->getGETPOST($idcped);
                $$pagar=$glo->getGETPOST($pagar);
           ?>
           <input name="idcped<?= $i?>" id="idcped<?= $i?>" type="hidden" value="<?= $$idcped?>" />
           <input name="pagar<?= $i?>" id="pagar<?= $i?>" type="hidden" value="<?= $$pagar?>" />

           <? } 
            for($i=0;$i<$cantc;$i++) {
                $cuenta="cuenta$i";
                $entrada="entrada$i";
                $salida="salida$i";
                $detallecon="detallecon$i";
                $$cuenta=$glo->getGETPOST($cuenta);
                $$entrada=$glo->getGETPOST($entrada);
                $$salida=$glo->getGETPOST($salida);
                $$detallecon=$glo->getGETPOST($detallecon);
                
           ?>
           <input name="cuenta<?= $i?>" id="cuenta<?= $i?>" type="hidden" value="<?= $$cuenta?>" />
           <input name="entrada<?= $i?>" id="entrada<?= $i?>" type="hidden" value="<?= $$entrada?>" />
           <input name="salida<?= $i?>" id="salida<?= $i?>" type="hidden" value="<?= $$salida?>" />
           <input name="detallecon<?= $i?>" id="detallecon<?= $i?>" type="hidden" value="<?= $$detallecon?>" />
           <? } ?>
        </form>
        <script language="javascript">
//            document.form1.submit()
        </script>
    </body>
</html>
