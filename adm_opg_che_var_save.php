<?php
/*
 * Creado el 22/01/2020 17:57:03
 * Autor: gus
 * Archivo: adm_opg_che_var_save.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
//print_r($_POST);
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_prv.php';
$dsup=new datesupport();
$sup=new support();
$glo=new globalson();
$conx=new conexion();
$fecha=$glo->getGETPOST("fecha");
$idprv=$glo->getGETPOST("idprv");
$canti=$glo->getGETPOST("canti");
$cantc=$glo->getGETPOST("cantc");
$cantf=$glo->getGETPOST("cantf");
$tarea=$glo->getGETPOST("tarea");
$idop=$glo->getGETPOST("idop");
$concepto=$glo->getGETPOST("concepto");
$importe=$glo->getGETPOST("importe");
$primero=$glo->getGETPOST("primero");
$cantf=$glo->getGETPOST("cantf");
$tipocontabilidad=$glo->getGETPOST("tipocontabilidad");
$che_fechaorigen=$glo->getGETPOST("che_fechaorigen");
$che_fechaven=$glo->getGETPOST("che_fechaven");
$che_importe=$glo->getGETPOST("che_importe");
$che_nrocheque=$glo->getGETPOST("che_nrocheque");
$che_banco=$glo->getGETPOST("che_banco");


$idop=$glo->getGETPOST("idop");
$tarea=$glo->getGETPOST("tarea");
$idprv=$glo->getGETPOST("idprv");
$fecha=$glo->getGETPOST("fecha");
$tipo=$glo->getGETPOST("tipo");
$importe=$glo->getGETPOST("importe");
$retenciones=$glo->getGETPOST("retenciones");
$concepto=$glo->getGETPOST("concepto");
$alicuotaret=$glo->getGETPOST("alicuotaret");
$transferencia=$glo->getGETPOST("transferencia");
$importeganancia=$glo->getGETPOST("importeganancia");
$totalpagosche=$glo->getGETPOST("totalpagosche");
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$caja=$glo->getGETPOST("caja");
$cantd=$glo->getGETPOST("cantd");
$prv=new adm_prv_1($idprv);
$destinatario=$prv->getApellido()." ".$prv->getNombre();
if($transferencia=="") $transferencia=0;
if($importeganancia=="") $importeganancia=0;
if($retenciones=="") $retenciones=0;
for($i=0;$i<$cantd;$i++) {
    $pagar="pagar$i";
    $$pagar=$glo->getGETPOST($pagar);
}


$totalpagosche=$glo->getGETPOST("totalpagosche");
$totalpagoscht=$glo->getGETPOST("totalpagoscht");
$cantidadcht=$glo->getGETPOST("cantidadcht");
$cantidadche=$glo->getGETPOST("cantidadche");

$ssql="select * from adm_che where idbanco=$che_banco and nrocheque='$che_nrocheque' and fechaorigen='$che_fechaorigen' and fechapago='$che_fechaven' and importe=$che_importe";
//echo $ssql."<br>";
//echo "rr: ".$conx->getCantidadReg($ssql)."<br>";
if($conx->getCantidadReg($ssql)==0) {

    $ssql="insert into adm_che (centro, idbanco, nrocheque, fechaorigen, fechapago, importe, acreditado, idemp, destinatario) values ";
    $ssql.="($centrosel, $che_banco, '$che_nrocheque', '$che_fechaorigen', '$che_fechaven', $che_importe, 0, 0, '$destinatario')";

    //echo $ssql."<br>";
    $conx->getConsulta($ssql);
}


?>

<html>
    <body>
        <form name="form1" id="form1" action="adm_opg_var_act.php" method="post">
           <input name="primero" id="primero" type="hidden" value="<?= $primero?>" />

           <input name="fecha" id="fecha" type="hidden" value="<?= $fecha?>" />
           <input name="idprv" id="idprv" type="hidden" value="<?= $idprv?>" />
           <input name="canti" id="canti" type="hidden" value="<?= $canti?>" />
           <input name="cantc" id="cantc" type="hidden" value="<?= $cantc?>" />
           <input name="cantf" id="cantf" type="hidden" value="<?= $cantf?>" />
           <input name="tarea" id="tarea" type="hidden" value="<?= $tarea?>" />
           <input name="idop" id="idop" type="hidden" value="<?= $idop?>" />
           <input name="tipocontabilidad" id="tipocontabilidad" type="hidden" value="<?= $tipocontabilidad?>" />
           
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
                $idcom="idcom$i";
                $pagar="pagar$i";
                $$idcom=$glo->getGETPOST($idcom);
                $$pagar=$glo->getGETPOST($pagar);
           ?>
           <input name="idcom<?= $i?>" id="idcom<?= $i?>" type="hidden" value="<?= $$idcom?>" />
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
           
            <input name="totalpagosche" id="totalpagosche" type="hidden" value="<?= $totalpagosche?>" />
            <input name="totalpagoscht" id="totalpagoscht" type="hidden" value="<?= $totalpagoscht?>" />
            <input name="cantidadcht" id="cantidadcht" type="hidden" value="<?= $cantidadcht?>" />
            <input name="cantidadche" id="cantidadche" type="hidden" value="<?= $cantidadche?>" />
            <input name="cantidadtotal" id="cantidadtotal" type="hidden" value="<?= $cantidadtotal?>" />
            <? for($i=0;$i<$cantidadtotal;$i++) { 
                $chkpag="chkpag$i";
                $$chkpag=$glo->getGETPOST($chkpag);
                if($$chkpag>0) { ?>
                <input name="chkpag<?= $i?>" id="chkpag<?= $i?>" type="hidden" value="<?= $$chkpag?>" />
            <? } }
            for($i=0;$i<$cantidadcht;$i++) { 
                $chkcht="chkcht$i";
                $$chkcht=$glo->getGETPOST($chkcht);
                if($$chkcht>0) { ?>
                <input name="chkcht<?= $i?>" id="chkcht<?= $i?>" type="hidden" value="<?= $$chkcht?>" />
            <? } }
            for($i=0;$i<$cantidadche;$i++) { 
                $chkche="chkche$i";
                $$chkche=$glo->getGETPOST($chkche);
                if($$chkche>0) { ?>
                <input name="chkche<?= $i?>" id="chkche<?= $i?>" type="hidden" value="<?= $$chkche?>" />
            <? } }?>
           
        </form>
        <script language="javascript">
            document.form1.submit()
        </script>
    </body>
</html>

