<?php
/*
 * Creado el 22/01/2020 12:01:12
 * Autor: gus
 * Archivo: adm_opg_var_act.php
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
require_once 'clases/adm_com.php';
require_once 'clases/adm_cht.php';
require_once 'clases/adm_che.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$conn=$conx->conectarBase();
$fecha=$glo->getGETPOST("fecha");
if($fecha=="") $fecha=date("Y-m-d");


// verifico si todos los comprobantes son del mismo proveedor
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$condicion="";
for($i=0;$i<$cantidadtotal;$i++) {
    $chkpag="chkpag$i";
    $$chkpag=$glo->getGETPOST($chkpag);
    if($$chkpag>0)
        $condicion.="id=".$$chkpag." or ";
    
}
$textoerror=array("Ok", "Debe seleccionar los comprobantes de un mismo proveedor", "No hay comprobantes seleccionados");

$error=0;
if($condicion!="") {
    $ssql="select idprv from adm_com where ".substr($condicion,0,strlen($condicion)-4);
    $rs=$conx->consultaBase($ssql, $conn);
    $a_idprv=array();
    while($reg=mysqli_fetch_object($rs)) {
        array_push($a_idprv,$reg->idprv);
    }
    
    $idprv=$a_idprv[0];
    for($i=1;$i<count($a_idprv);$i++) {
        if($idprv!=$a_idprv[$i]) {
            $error=1;
            break;
        }
    }
    
} else 
    $error=2;

if($error>0) { 
    ?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_com_var_main.php" method="post">
        </form>
        <script language="javascript">
            alert('<?= $textoerror[$error]?>');
            document.form1.submit();
        </script>
    </body>
</html>
<? } else { 
    $cantidadcht=$glo->getGETPOST("cantidadcht");
    $cantidadche=$glo->getGETPOST("cantidadche");
    $xcht_importe=array();
    $xche_importe=array();
    $xcht_id=array();
    $xche_id=array();
    $condicioncht="";
    $condicionche="";
    $xcht_importe=array();
    for($i=0;$i<$cantidadcht;$i++) {
        $chkcht="chkcht$i";
        $$chkcht=$glo->getGETPOST($chkcht);
        if($$chkcht>0) {
            $condicioncht.="id=".$$chkcht." or ";
        }
    }
    for($i=0;$i<$cantidadche;$i++) {
        $chkche="chkche$i";
        $$chkche=$glo->getGETPOST($chkche);
        if($$chkche>0) {
            $condicionche.="id=".$$chkche." or ";
        }
    }
    if($condicioncht!="") {
        $ssql="select * from adm_cht where ".substr($condicioncht,0,strlen($condicioncht)-4);
        $cht=new adm_cht_2($ssql);
        $xcht_id=$cht->getId();
        $xcht_fecha=$cht->getFechapago();
        $xcht_nro=$cht->getNrocheque();
        $xcht_importe=$cht->getImporte();
        $xcht_banco=$cht->getBancodes();

    }
//    echo "con: $condicioncht<br>";
    if($condicionche!="") {
        $ssql="select * from adm_che where ".substr($condicionche,0,strlen($condicionche)-4);
        $che=new adm_che_2($ssql);
        $xche_id=$che->getId();
        $xche_fecha=$che->getFechapago();
        $xche_nro=$che->getNrocheque();
        $xche_importe=$che->getImporte();
        $xche_banco=$che->getBancodes();

    }
    
    
    
    $reten=$glo->getGETPOST("reten");
    
    $botoncap="Agregar O/Pago";
    $totalpagos=$glo->getGETPOST("totalpagos");
    $carteltarea="AGREGA ORDEN DE PAGO";
    $ssql="select * from adm_com where ".substr($condicion,0,strlen($condicion)-4);
    $adm=new adm_com_2($ssql);
    $c_fec=$adm->getFecha();
    $c_prv=$adm->getProveedor();
    $c_tipo=$adm->getTipocom();
    $c_imp=$adm->getTotaltotal();
    $c_num=$adm->getNumero();
    $c_pto=$adm->getPtovta();
    $c_id=$adm->getId();
    $c_gan=$adm->getTipoganancia();
    $c_net=$adm->getNeto();
    $c_let=$adm->getLetra();
    $retenciones=$glo->getGETPOST("retenciones");
    $transferencia=$glo->getGETPOST("transferencia");
    $importeganancia=$glo->getGETPOST("importeganancia");
    if($importeganancia=="") $importeganancia=0;
    $importe=array_sum($c_imp);
    $c_com=$adm->getComprobantetodo();
    $concepto="Pago ";
    for($i=0;$i<count($c_num);$i++) {
        $concepto.="FC ".$c_num[$i]."/ ";
    }
    if($concepto!="") $concepto=substr($concepto,0,strlen($concepto)-2);
    $prv=new adm_prv_1($idprv);
    $ssql="select sum(neto21) as tneto21, sum(neto10) as tneto10, sum(nogravado) as tnogravado from adm_com where tipocom!=2 and (".substr($condicion,0,strlen($condicion)-4).")";
//            echo $ssql."\n";
    $rx=$conx->getConsulta($ssql);
    $rxx=mysqli_fetch_object($rx);
    $suma1=$rxx->tneto21+$rxx->tneto10+$rxx->tnogravado;
    $ssql="select sum(neto21) as tneto21, sum(neto10) as tneto10, sum(nogravado) as tnogravado from adm_com where tipocom=2 and (".substr($condicion,0,strlen($condicion)-4).")";
//            echo $ssql."\n";
    $rx=$conx->getConsulta($ssql);
    $rxx=mysqli_fetch_object($rx);
    $suma2=$rxx->tneto21+$rxx->tneto10+$rxx->tnogravado;
    //echo "neto21: ".$rxx->tneto21." | neto10: ".$rxx->tneto10." | Ret: ".$prv->getRetencioniibb()."\n";
    $alicuotaret=$prv->getRetencioniibb();
    $totalneto=$suma1-$suma2;
//    echo "totalneto: $totalneto\n";
    $retenciones=number_format(($suma1-$suma2)*$prv->getRetencioniibb()/100,2,".","");
//            echo $alicuotaret." ".$retenciones;
    
    $fechaini=date("Y-m-01", strtotime($fecha));
    $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
    $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
    
    $retanterior=0;
    
//    $ssql="select sum(importeretecion) as retanterior from adm_opg1 where fecha>='$fechaini' and fecha<='$fechafin'";
//    $ro=$conx->consultaBase($ssql, $conn);
//    $roo=mysqli_fetch_object($ro);
//    $retanterior=$roo->retanterior;
//    
//    $importeganancia=0;
    
    
    $fechaini=date("Y-m-01", strtotime($fecha));
    $fechafin=$fecha;
    $condicion="";
    $ssql="select * from adm_opg1 where idprv=$idprv and fecha>='$fechaini' and fecha<='$fechafin'";
    $rs=$conx->consultaBase($ssql, $conn);
    $retencionanterior=0;
    while($reg=mysqli_fetch_object($rs)) {
        $condicion.="idopg=".$reg->id." or ";
        $retencionanterior+=$reg->retencionganancia;
    }
    
    if($condicion!="") {
        $ssql="select sum(neto21) as tnet21, sum(neto10) as tnet10 from adm_com where tipocom!=2 and (".substr($condicion,0,strlen($condicion)-4).")";
//        echo $ssql."\n";
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $tneto=$reg->tnet21+$reg->tnet10;

        $ssql="select sum(neto21) as tnet21, sum(neto10) as tnet10 from adm_com where tipocom=2 and (".substr($condicion,0,strlen($condicion)-4).")";
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $tnetoc=$reg->tnet21+$reg->tnet10;

        $tneto-=$tnetoc;
        

//        echo "neto anterior: $tneto\n";
//        echo "neto actual: ".array_sum($c_net)."\n";
        $totalneto=$tneto+array_sum($c_net);
//        echo "neto total: $totalneto\n";
//        echo "gan: ".$c_gan[0]."\n";
        if($c_gan[0]==0)
            $importe1=$totalneto-$cfg->getMinimoretenciones ();
        else
            $importe1=$totalneto-$cfg->getMinimoretencionesser ();
//        echo "Importe1: $importe1\n";
        $importeganancia=0;
        if($importe1>0) {
            $importeganancia=$importe1*2/100;
            $importeganancia-=$retencionanterior;
        }
    }

    
    $importeganancia=number_format($importeganancia,2,".","");
    if($totalpagos=="") $totalpagos=0;
    if($transferencia=="") $transferencia=0;
    if($prv->getExpganancia()>0) $importeganancia=0;
    $efectivo=$importe-$totalpagos-$retenciones-$importeganancia-$transferencia-array_sum($xche_importe)-array_sum($xcht_importe);
//    echo "importe: $importe<br>";
//    echo "totalpagos: $totalpagos<br>";
//    echo "retenciones: $retenciones<br>";
//    echo "transferecia: $transferencia<br>";
            
    ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?= $cfg->getTitulo()?></title>
        <style type="text/css">
        <!--
        #barblue {
                position:absolute;
                left:0px;
                top:0px;
                width:100%;
                height:51px;
                z-index:1;
                background-color:<?= $cfg->getColor1()?>;
                /*visibility: hidden;*/
        }
        #barcentral {
                position:absolute;
                left:50%;
                top:<?= $cfg->getAlturamarco()?>px;
                width:960px;
                height:75px;
                z-index:1;
                margin-left: -480px;
                /*visibility: hidden;*/
        }

        -->
        </style>
        <link href="css.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="planb.js?1.0.17"></script>
        <script src="js/jquery-1.3.2.js" type="text/javascript"></script>
        <script src="js/vanadium.js" type="text/javascript"></script>
        <script language="javascript">

        var VanadiumRules = {
                errordetalle: ['required', 'only_on_submit'],
        }
        
        function AjustaLinea(tipo) {
            valor=document.form1.canti.value;
            if(tipo==0)
                valor++;
            if(tipo==1)
                valor--;
            if(valor==0)
                valor=1
            document.form1.canti.value=valor;
        }

        function AjustaLineaC(tipo) {
            valor=document.form1.cantc.value;
            if(tipo==0)
                valor++;
            if(tipo==1)
                valor--;
            if(valor==0)
                valor=1
            document.form1.cantc.value=valor;
        }
        
        function pagacompleto2(cant) {
            totpag=0;
            if(document.getElementById("tipo").value==1)
              totconcepto='Pago FC ';
            else
              totconcepto='Pago ';
//            alert(cant);
            for(f=0;f<cant;f++) {
                pagar="pagar"+f;
                importe="importe" + f;
                concepto="concepto"+f;
                importetot="importetot" + f;
                tipocom="tipocom" + f;
                //alert(f + " " + document.getElementById(pagar).value);
                if(document.getElementById(pagar).checked==true) {
                  if(document.getElementById(tipocom).value==2)
                    totpag-=parseFloat(document.getElementById(importetot).value);
                  else
                    totpag+=parseFloat(document.getElementById(importetot).value);
                  //alert(totpag);
                  //alert(document.getElementById(importetot).value);
                  totconcepto+=document.form1[concepto].value + " / ";
                  //alert(concepto);
                }
            }
            totpag=Math.round(totpag * 100) / 100;
            document.form1.importe.value=totpag;
            //document.form1.detalle0.value="Efectivo";
            document.form1.importeefectivo.value=totpag;
            document.form1.concepto.value=totconcepto;
            //document.form1.entrada0.value=totpag;
            //document.form1.salida1.value=totpag;
        }
        
        function calculasaldoefectivo() {
            chequest=document.getElementById("totalpagoscht").value;
            chequesp=document.getElementById("totalpagosche").value;
            transferencia=document.getElementById("transferencia").value;
            importeiibb=document.getElementById("importeiibb").value;
            importeganancia=document.getElementById("importeganancia").value;
            efectivo=parseFloat(document.getElementById("importe").value)-parseFloat(chequest)-parseFloat(chequesp)-parseFloat(transferencia)-parseFloat(importeiibb)-parseFloat(importeganancia);
            document.getElementById("importeefectivo").value=efectivo;
        }

        </script>
        <? include("estilos.php");?>
    </head>
    <body>
        <div class="style1" id="barblue">
          <blockquote>
            <p class="titulo1"><?= $cfg->getCabecera()?></p>
          </blockquote>
        </div>
        <div id="barcentral">
            <form name="form1" id="form1" action="adm_opg_var_act_save.php" method="post">
                <tr>
                    <? include("adm_menu.php") ?>
                    <input name="tarea" type="hidden" id="tarea" value="A" />
                    <input name="idprv" type="hidden" id="idprv" value="<?= $idprv?>" />
                    <input name="primero" type="hidden" id="primero" value="1" />
                    <input name="reten" id="reten" type="hidden" />
                    <!--<input name="canti" type="hidden" id="canti" value="<?= $canti?>" />-->
                    <input name="cantd" type="hidden" value="<?= count($c_id)?>" id="cantd" />
                    <input name="alicuotaret" id="alicuotaret" type="hidden" value="<?= $alicuotaret?>" />
                    <input name="cantidadcht" id="cantidadcht" type="hidden" value="<?= $cantidadcht?>" />
                    <input name="cantidadche" id="cantidadche" type="hidden" value="<?= $cantidadche?>" />
                    <input name="c_com" id="c_com" type="hidden" value='<?= serialize($c_com)?>' />
                    <!--<input name="c_tip" id="c_tip" type="hidden" value='<?= serialize($c_tip)?>' />-->
                    <!--<input name="c_ppp" id="c_ppp" type="hidden" value='<?= serialize($c_ppp)?>' />-->
                    <input name="c_imp" id="c_imp" type="hidden" value='<?= serialize($c_imp)?>' />
                    <!--<input name="c_let" id="c_let" type="hidden" value='<?= serialize($c_let)?>' />-->
                    <!--<input name="c_ptv" id="c_ptv" type="hidden" value='<?= serialize($c_ptv)?>' />-->
                    <!--<input name="c_nro" id="c_nro" type="hidden" value='<?= serialize($c_nro)?>' />-->
                    <input name="c_id" id="c_id" type="hidden" value='<?= serialize($c_id)?>' />
                    <input name="c_fec" id="c_fec" type="hidden" value='<?= serialize($c_fec)?>' />
                    <!--<input name="c_net" id="c_net" type="hidden" value='<?= serialize($c_net)?>' />-->
                    <input name="totalpagosche" id="totalpagosche" type="hidden" value="<?= array_sum($xche_importe)?>" />
                    <input name="totalpagoscht" id="totalpagoscht" type="hidden" value="<?= array_sum($xcht_importe)?>" />
                    <input name="cantidadtotal" id="cantidadtotal" type="hidden" value="<?= $cantidadtotal?>" />
                    <input name="url" id="url" type="hidden" value="adm_opg_var_act.php" />
                    <? for($i=0;$i<$cantidadtotal;$i++) { 
                        $chkpag="chkpag$i";
                        $$chkpag=$glo->getGETPOST($chkpag);
                        if($$chkpag>0) {
                        ?>
                        <input name="chkpag<?= $i?>" id="chkpag<?= $i?>" type="hidden" value="<?= $$chkpag?>" />
                    <? } }
                    
                    for($i=0;$i<$cantidadcht;$i++) { 
                        $chkcht="chkcht$i";
                        $$chkcht=$glo->getGETPOST($chkcht);
                        if($$chkcht>0) {
                        ?>
                        <input name="chkcht<?= $i?>" id="chkcht<?= $i?>" type="hidden" value="<?= $$chkcht?>" />
                    <? } }
                    for($i=0;$i<$cantidadche;$i++) { 
                        $chkche="chkche$i";
                        $$chkche=$glo->getGETPOST($chkche);
                        if($$chkche>0) {
                        ?>
                        <input name="chkche<?= $i?>" id="chkche<?= $i?>" type="hidden" value="<?= $$chkche?>" />
                    <? } }?>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="2" class="letra6">
                            <? require_once 'displayusuario.php';?>

                            <tr>
                                <td>
                                    <div class="panel960 letra6">
                                        <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                            <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>
                                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr>
                                                    <td colspan="2"><a href="javascript: document.form1.target='_self'; document.form1.action='adm_com_var_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" width="35%">Fecha&nbsp;</td>
                                                    <td width="65%"><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Proveedor&nbsp;</td>
                                                    <td class="letra6bold"><?= $c_prv[0]?></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Concepto&nbsp;</td>
                                                    <td>
                                                        <textarea name="concepto" id="concepto" rows="2" cols="50" class="letra6"><?= $concepto?></textarea>
                                                        <!--<input name="concepto" type="text" class="letra6" id="concepto" size="50" maxlength="100" value="<?= $concepto?>" />-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Tipo&nbsp;</td>
                                                    <td>
                                                        <select name="tipo" id="tipo" onchange="javascript: document.form1.target='_self'; document.form1.action='adm_opg_var_act.php'; document.form1.submit()">
                                                            <?
                                                            $array=array("Compras","Gastos");
                                                            $avalor=array(1,2);
                                                            $sup->cargaComboArrayValor($array, $avalor, $tipo);
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Caja&nbsp;</td>
                                                    <td>
                                                        <select name="caja" id="caja">
                                                            <?
                                                            $ssql="select id as id, nombre as campo from adm_caj order by nombre";
                                                            $sup->cargaCombo3($ssql,$caja);
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Total Importe&nbsp;</td>
                                                    <td><input name="importe" type="text" class="letra6" id="importe" size="10" maxlength="10" readonly="readonly" style="background-color:#CCCCCC; border:none; text-align:center" value="<?= array_sum($c_imp)?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Retenciones&nbsp;</td>
                                                    <td><input name="retenciones" type="text" class="letra6" id="retenciones" size="10" maxlength="10" readonly="readonly" style="background-color:#CCCCCC; border:none; text-align:center" value="<?= $retenciones?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Retenciones Ganancia&nbsp;</td>
                                                    <td><input name="retencionesganancia" type="text" class="letra6" id="retencionesganancia" size="10" maxlength="10" readonly="readonly" style="background-color:#CCCCCC; border:none; text-align:center" value="<?= $importeganancia?>" /></td>
                                                </tr>

                                                <? if($idprv>0) { ?>
<!--                                                <tr>
                                                    <td align="center" colspan="2">
                                                        <a href="javascript: document.form1.target='_self'; document.form1.reten.value=1; document.form1.action='adm_opg_var_act.php'; document.form1.submit()">Calcular y Agregar Rentención IIBB en Detalle de Pago</a>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="panel910 letra6">
                                                            <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                                <h3 class="ui-widget-header ui-corner-all">Comprobantes a Aplicar</h3>

                                                                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="letra6">
                                                                    <tr>
                                                                        <td align="center">Fecha</td>
                                                                        <td align="left">Número</td>
                                                                        <td align="right">Importe</td>
                                                                    </tr>
                                                                    <? 
                                                                    for($i=0;$i<count($c_id);$i++) { 
                                                                        $pagar="pagar$i";
                                                                        $importetot=$c_imp[$i];
                                                                        $conce=$c_com[$i];
                                                                    ?>
                                                                    <tr class="letra6bold">
                                                                        <td align="center"><?= $dsup->getFechaNormalCorta($c_fec[$i])?>
                                                                            <input name="importetot<?= $i?>" id="importetot<?= $i?>" type="hidden" value="<?= $importetot?>" />
                                                                            <!--<input name="importepag<?= $i?>" id="importepag<?= $i?>" type="hidden" value="<?= $importepag?>" />-->
                                                                            <input name="concepto<?= $i?>" id="concepto<?= $i?>" type="hidden" value="<?= $conce?>" />
                                                                            <input name="idcom<?= $i?>" type="hidden" id="idcom<?= $i?>" value="<?= $c_id[$i]?>" />
                                                                            <!--<input name="neto<?= $i?>" type="hidden" id="neto<?= $i?>" value="<?= $c_net[$i]?>" />-->
                                                                            <!--<input name="tipocom<?= $i?>" id="tipocom<?= $i?>" type="hidden" value="<?= $c_tip[$i]?>"-->
                                                                        </td>
                                                                        <td align="left">
                                                                            <?= $c_com[$i]?>
                                                                        </td>
                                                                        <td align="right"><?= number_format($c_imp[$i],2)?></td>
                                                                    </tr>
                                                                    <? } ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="panel910 letra6">
                                                            <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                                <h3 class="ui-widget-header ui-corner-all">Detalle de Pagos</h3>

                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                                    <tr>
                                                                        <td>
                                                                            
                                                                        Detalle de Pagos</td>
                                                                        <td width="10%" align="right">Importe</td>
                                                                        <td width="10%" align="right">
                                                                            <a href="javascript: document.form1.taget='_self'; document.form1.action='adm_cht_var_buscar.php'; document.form1.submit()"><i class="fas fa-search-dollar fa-2x" title="Seleccionar Cheques de Terceros" alt="Seleccionar Cheques de Terceros"></i></a> 
                                                                            <a href="javascript: document.form1.taget='_self'; document.form1.action='adm_che_var_buscar.php'; document.form1.submit()"><i class="fas fa-search-dollar fa-2x" style="color: blue" title="Seleccionar Cheques Propios" alt="Seleccionar Propios"></i></a> 
                                                                        </td>
                                                                    </tr>
                                                                    <?
                                                                    if(count($xcht_importe)>0)
                                                                        $totalpagos+=array_sum($xcht_importe);
                                                                    for($i=0;$i<count($xcht_id);$i++) { ?>
                                                                    <tr class="letra6bold" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td class="letra6bold">
                                                                            <input name="xcht_id<?= $i?>" type="hidden" value="<?= $xcht_id[$i]?>" />
                                                                            <?= "T: ".$xcht_banco[$i]." ".$xcht_nro[$i]." ".date("d/m/Y", strtotime($xcht_fecha[$i]))." [".$xcht_id[$i]."]"?>
                                                                        </td>
                                                                        <td align="right">
                                                                            <?= number_format($xcht_importe[$i],2)?>
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                        
                                                                    <? } 
                                                                    if(count($xche_importe)>0)
                                                                        $totalpagos+=array_sum($xche_importe);
                                                                    for($i=0;$i<count($xche_id);$i++) { ?>
                                                                    <tr class="letra6bold" onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td class="letra6bold">
                                                                            <input name="xche_id<?= $i?>" type="hidden" value="<?= $xche_id[$i]?>" />
                                                                            <?= "P: ".$xche_banco[$i]." ".$xche_nro[$i]." ".date("d/m/Y", strtotime($xche_fecha[$i]))." [".$xche_id[$i]."]"?>
                                                                        </td>
                                                                        <td align="right">
                                                                            <?= number_format($xche_importe[$i],2)?>
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                        
                                                                    <? } ?>

                                                                    
                                                                    <tr class="letra6bold">
                                                                        <td>EFECTIVO</td>
                                                                        <td align="right">
                                                                            <input name="importeefectivo" id="importeefectivo" value="<?= $efectivo?>" size="10" maxlength="10" onkeypress="return validar_punto_menos(event)" style="text-align: center" onblur="javascript: calculasaldoefectivo()" />
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr class="letra6bold">
                                                                        <td>TRANSFERENCIA</td>
                                                                        <td align="right">
                                                                            <input name="transferencia" id="transferencia" value="<?= $transferencia?>" size="10" maxlength="10" onkeypress="return validar_punto_menos(event)" style="text-align: center" onblur="javascript: calculasaldoefectivo()" />
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr class="letra6bold">
                                                                        <td>RETENCIÓN GANANCIAS</td>
                                                                        <td align="right">
                                                                            <input name="importeganancia" id="importeganancia" value="<?= $importeganancia?>" size="10" maxlength="10" onkeypress="return validar_punto_menos(event)" style="text-align: center" onblur="javascript: calculasaldoefectivo()" />
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr class="letra6bold">
                                                                        <td>RETENCIÓN IIBB</td>
                                                                        <td align="right">
                                                                            <input name="importeiibb" id="importeiibb" value="<?= $retenciones?>" size="10" maxlength="10" onkeypress="return validar_punto_menos(event)" style="text-align: center" onblur="javascript: calculasaldoefectivo()" />
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="panel910 letra6">
                                                            <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                                <h3 class="ui-widget-header ui-corner-all">Ingreso de Cheques Propios</h3>
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                                    <tr class="letra6Bold">
                                                                        <td width="9%">Fecha Origen</td>
                                                                        <td width="12%">Fecha Vencimiento</td>
                                                                        <td width="20%">Banco</td>
                                                                        <td width="17%">Nro. Cheque</td>
                                                                        <td width="20%">Importe</td>
                                                                        <td width="22%">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input name="che_fechaorigen" type="date" class="letra6" id="che_fechaorigen" value="<?= date("Y-m-d")?>" /></td>
                                                                        <td><input name="che_fechaven" type="date" class="letra6" id="che_fechaven" size="10" maxlength="10"  /></td>
                                                                        <td>
                                                                            <select name="che_banco" class="letra6" id="che_banco">
                                                                            <? $sup->cargaCombo3("select valor as id, descripcion as campo from tablas where codtab='BAN' order by descripcion", 0, "Sel") ?>
                                                                            </select>
                                                                        </td>
                                                                        <td><input name="che_nrocheque" id="che_nrocheque" type="text" class="letra3" size="10" maxlength="10"  /></td>
                                                                        <td><input name="che_importe" id="che_importe" type="text" class="letra3" size="10" maxlength="10"  style="text-align: center" onkeypress="return validar_punto(event)" /></td>
                                                                        <td><input type="submit" name="cmdIngCheque" id="cmdIngCheque" value="Ingresar Cheque" onclick="javascript: document.form1.action='adm_opg_che_var_save.php'; document.form1.submit()" /></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center">
                                                        <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: document.form1.action='adm_opg_var_act_save.php'; document.form1.submit()" />
                                                    </td>
                                                </tr>
                                                
                                                
                                                <? } ?>

                                                
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </form>
        </div>
    </body>
</html>

    
<? } ?>

