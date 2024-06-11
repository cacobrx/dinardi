<?php
/*
 * Creado el 28/10/2018 18:28:32
 * Autor: gus
 * Archivo: adm_opg_act2.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_com.php';
require_once 'clases/adm_cht.php';
require_once 'clases/adm_che.php';
require_once 'clases/adm_prv.php';
require_once 'clases/adm_gas.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_opg1.php';
$dsup = new datesupport();
$sup = new support();
$conx=new conexion();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$idop=$glo->getGETPOST("idop");
$tarea=$glo->getGETPOST("tarea");
$idprv=$glo->getGETPOST("idprv");
$fecha=$glo->getGETPOST("fecha");
$tipo=$glo->getGETPOST("tipo");
$importe=$glo->getGETPOST("importe");
$retenciones=$glo->getGETPOST("retenciones");
$transferencia=$glo->getGETPOST("transferencia");
$importeganancia=$glo->getGETPOST("importeganancia");
$concepto=$glo->getGETPOST("concepto");
$caja=$glo->getGETPOST("caja");
$canti=$glo->getGETPOST("canti");
$reten=$glo->getGETPOST("reten");
$primero=$glo->getGETPOST("primero");
$otraforma=$glo->getGETPOST("otraforma");
$cantidadcht=$glo->getGETPOST("cantidadcht");
$tiposer=$glo->getGETPOST("tiposer");
if($otraforma=="") $otraforma=0;
if($transferencia=="") $transferencia=0;
//echo "otraforma: $otraforma<br>";
$totfp=0;
for($p=0;$p<$otraforma;$p++) {
    $importefp="importefp$p";
    $$importefp=$glo->getGETPOST($importefp);
//    echo "importefp: $importefp: ".$$importefp."<br>";
    if($$importefp!="") $totfp+=$$importefp;
}

$totalpagos=0;
$condicioncht="";
$xcht_id=array();
$xcht_importe=array();
for($i=0;$i<$cantidadcht;$i++) {
    $chkcht="chkcht$i";
    $$chkcht=$glo->getGETPOST($chkcht);
    if($$chkcht>0) {
        $condicioncht.="id=".$$chkcht." or ";
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

// che
$cantidadche=$glo->getGETPOST("cantidadche");
$totalpagos=0;
$condicionche="";
$xche_id=array();
$xche_importe=array();
for($i=0;$i<$cantidadche;$i++) {
    $chkche="chkche$i";
    $$chkche=$glo->getGETPOST($chkche);
    if($$chkche>0) {
        $condicionche.="id=".$$chkche." or ";
    }
}
if($condicionche!="") {
    $ssql="select * from adm_che where ".substr($condicionche,0,strlen($condicionche)-4);
    $che=new adm_che_2($ssql);
    $xche_id=$che->getId();
    $xche_fecha=$che->getFechapago();
    $xche_nro=$che->getNrocheque();
    $xche_importe=$che->getImporte();
    $xche_banco=$che->getBancodes();
    
}

if($canti=="")
    $canti=1;
if($canti<1)
    $canti=1;
$importecheque=0;
$o2_id=array();
$o2_detalle=array();
$o2_importe=array();
$o2_tipopag=array();
$o2_chequet=array();
$o2_chequep=array();
if($tarea=="A") {
    $carteltarea="AGREGAR ORDEN DE PAGO";
    $botoncap="Agregar";
    if($canti=="") $canti=1;
    if($fecha=="") $fecha=date("Y-m-d");
    if($idprv=="") $idprv=0;
    if($tipo=="") $tipo=1;
    if($caja=="") $caja=1;
    if($tiposer=="") $tiposer=1;
    if($idprv>0) {
        $prv=new adm_prv_1($idprv);
//        echo "tipo: $tipo\n";
        if($tipo==1) {
            $ssql="select * from adm_com where idprv=$idprv and centro=$centrosel and totaltotal > importepag order by fecha";
//            echo $ssql."<br>";
            $com=new adm_com_2($ssql);
            $c_id=$com->getId();
            $c_com=$com->getTipocomdes();
            $c_tip=$com->getTipocom();
            $c_let=$com->getLetra();
            $c_fec=$com->getFecha();
            $c_ptv=$com->getPtovta();
            $c_nro=$com->getNumero();
            $c_imp=$com->getTotaltotal();
            $c_pag=$com->getImportepag();
            $c_net=$com->getNeto();
//            print_r($c_imp);
            //$canti=count($c_id);
        } else {
            $ssql="Select * from adm_gas where idprv=$idprv and centro=$centrosel and importe>pagado order by fecha";
            $gas=new adm_gas_2($ssql);
            $c_id=$gas->getId();
            $c_imp=$gas->getImporte();
            $c_fec=$gas->getFecha();
            $c_pag=$gas->getPagado();
            $c_com=$gas->getComprobantedes();
        }
    } else
        $c_id=array();
} else {
    $carteltarea="MODIFICAR ORDEN DE PAGO #$idop";
    $botoncap="Modificar";
    if($primero!=1) {
        $adm=new adm_opg1_1($idop);
        $fecha=$adm->getFecha();
        $idprv=$adm->getIdprv();
        $concepto=$adm->getConcepto();
        $tipo=$adm->getTipo();
        $tiposer=$adm->getTiposer();
        $caja=$adm->getCaja();
        $importe=$adm->getImporte();
        $transferencia=$adm->getTranferencia();
        $retenciones=$adm->getRetencioniibb();
        $importeganancia=$adm->getRetencionganancia();
        $conn=$conx->conectarBase();
        $alicuotaret=$adm->getAlicuotaret();
        $o2_detalle=$adm->getE_detalle();
        $o2_importe=$adm->getE_importe();
        $o2_id=$adm->getE_id();
        $o2_tipopag=$adm->getE_tipopago();
        $o2_chequet=$adm->getE_chequet();
        $o2_chequep=$adm->getE_chequep();
//        print_r($o2_tipopag);
        $otraforma=0;
        for($t=0;$t<count($o2_importe);$t++) {
            if(substr($o2_detalle[$t],0,2)=="Ch")
                $importecheque+=$o2_importe[$t];
            if($o2_tipopag[$t]==9) {
                $otraforma++;
                $formapago="formapago$otraforma";
                $importefp="importefp$otraforma";
                $$formapago=$o2_detalle[$t];
                $$importefp=$o2_importe[$t];
                $totfp+=$o2_importe[$t];
                
            }
        }
        //echo "otraforma: $otraforma<br>";
        $c_id=array();
        $c_com=array();
        $c_tip=array();
        $c_let=array();
        $c_fec=array();
        $c_ptv=array();
        $c_nro=array();
        $c_imp=array();
        $c_pag=array();
        $c_net=array();
        $c_ppp=array();

        if($tipo==1) {
            $ssql="select * from adm_com where idprv=$idprv and idopg=$idop";
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($c_id,$reg->id);
                switch ($reg->tipocom) {
                    case 1:
                        array_push($c_com,"Factura");
                        $signo=1;
                        break;
                    case 2:
                        array_push($c_com,"Nota Crédito");
                        $signo=-1;
                        break;
                    case 3:
                        array_push($c_com,"Nota Débito");
                        $signo=1;
                        break;
                }
                array_push($c_tip,$reg->tipocom);
                array_push($c_let,$reg->letra);
                array_push($c_fec,$reg->fecha);
                array_push($c_ptv,$reg->ptovta);
                array_push($c_nro,$reg->numero);
                array_push($c_imp,$reg->totaltotal*$signo);
                array_push($c_pag,$reg->importepag);
                array_push($c_net,$reg->neto21+$reg->neto10);
                array_push($c_ppp,1);
            }
            $ssql="select * from adm_com where idprv=$idprv and idopg=0 and totaltotal>importepag";
//            echo $ssql;
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($c_id,$reg->id);
                switch ($reg->tipocom) {
                    case 1:
                        array_push($c_com,"Factura");
                        break;
                    case 2:
                        array_push($c_com,"Nota Crédito");
                        break;
                    case 3:
                        array_push($c_com,"Nota Débito");
                        break;
                }
                array_push($c_tip,$reg->tipocom);
                array_push($c_let,$reg->letra);
                array_push($c_fec,$reg->fecha);
                array_push($c_ptv,$reg->ptovta);
                array_push($c_nro,$reg->numero);
                array_push($c_imp,$reg->totaltotal);
                array_push($c_pag,$reg->importepag);
                array_push($c_net,$reg->neto21+$reg->neto10);
                array_push($c_ppp,0);
            }
        }
    } else {
        $fecha=$glo->getGETPOST("fecha");
        $idprv=$glo->getGETPOST("idprv");
        $importe=$glo->getGETPOST("importe");
        $retenciones=$glo->getGETPOST("retenciones");
        $concepto=$glo->getGETPOST("concepto");
        $tiposer=$glo->getGETPOST("tiposer");
        $tipo=$glo->getGETPOST("tipo");
        //$alicuotaret=$glo->getGETPOST("alicuotaret");
        $caja=$glo->getGETPOST("caja");
        $c_id=unserialize($glo->getGETPOST("c_id"));
        $c_ppp=unserialize($glo->getGETPOST("c_ppp"));
        $c_imp=unserialize($glo->getGETPOST("c_imp"));
        $c_pag=unserialize($glo->getGETPOST("c_pag"));
        $c_com=unserialize($glo->getGETPOST("c_com"));
        $c_tip=unserialize($glo->getGETPOST("c_tip"));
        $c_let=unserialize($glo->getGETPOST("c_let"));
        $c_ptv=unserialize($glo->getGETPOST("c_ptv"));
        $c_nro=unserialize($glo->getGETPOST("c_nro"));
        $c_fec=unserialize($glo->getGETPOST("c_fec"));
        $c_net=unserialize($glo->getGETPOST("c_net"));
        $o2_detalle= unserialize($glo->getGETPOST("o2_detalle"));
        $o2_id= unserialize($glo->getGETPOST("o2_id"));
        $o2_importe= unserialize($glo->getGETPOST("o2_importe"));
        for($t=0;$t<count($o2_importe);$t++) {
            if(substr($o2_detalle[$t],0,2)=="Ch")
                $importecheque+=$o2_importe[$t];
        }
        
//        print_r($c_ppp);
        
    }
}

//print_r($c_com);
$alicuotaret=$glo->getGETPOST("alicuotaret");
if($alicuotaret=="") $alicuotaret=0;
if($idprv>0) {
    $prv=new adm_prv_1($idprv);
    $expganancia=$prv->getExpganancia();
    $conn=$conx->conectarBase();
    if($reten==1) {
        $ccc="";
        for($i=0;$i<count($c_id);$i++) {
            $pagar="pagar$i";
            $idcom="idcom$i";
            $$pagar=$glo->getGETPOST($pagar);
            $$idcom=$glo->getGETPOST($idcom);
            if($$pagar>0) $ccc.="id=".$$idcom." or ";
        }
        if($ccc!="") {
            if($c_let[0]!="M") {
                $ssql="select sum(neto21) as tneto21, sum(neto10) as tneto10, sum(nogravado) as tnogravado from adm_com where tipocom!=2 and (".substr($ccc,0,strlen($ccc)-4).")";
//                    echo $ssql."\n";
                $rx=$conx->consultaBase($ssql, $conn);
                $rxx=mysqli_fetch_object($rx);
                $suma1=$rxx->tneto21+$rxx->tneto10+$rxx->tnogravado;
                $ssql="select sum(neto21) as tneto21, sum(neto10) as tneto10, sum(nogravado) as tnogravado from adm_com where tipocom=2 and (".substr($ccc,0,strlen($ccc)-4).")";
//                    echo $ssql."\n";
                $rx=$conx->consultaBase($ssql, $conn);
                $rxx=mysqli_fetch_object($rx);
                $suma2=$rxx->tneto21+$rxx->tneto10+$rxx->tnogravado;
    //            echo "neto21: ".$rxx->tneto21." | neto10: ".$rxx->tneto10." | Ret: ".$prv->getRetencioniibb()."\n";
                $alicuotaret=$prv->getRetencioniibb();
    //            echo $suma1 - $suma2."<br>";
                $retenciones=number_format(($suma1-$suma2)*$prv->getRetencioniibb()/100,2,".","");

                $importeganancia=0;

                // ganancia anterior
                $fechaini=date("Y-m-01", strtotime($fecha));
                $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
                $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));

                $ssql="select adm_com.* from adm_com, adm_opg1 where adm_com.idprv=$idprv and adm_opg1.fecha>='$fechaini' and adm_opg1.fecha<='$fechafin' and adm_opg1.id=adm_com.idopg and adm_com.letra!='M'";
//                echo $ssql."\n";
                $rr=$conx->consultaBase($ssql, $conn);
                $totr=0;
                $totn=0;
                while($rrr=mysqli_fetch_object($rr)) {
                    $neto=$rrr->neto21+$rrr->neto17+$rrr->neto10+$rrr->neto27;
                    if($rrr->tipocom!=2) {
                        //$totr+=$rrr->importeretenido;
                        $totn+=$neto;
                    } else {
                        //$totr-=$rrr->importeretenido;
                        $totn-=$neto;
                    }
                }
    //            echo "neto: $totn\n";

                $ssql="select sum(retencionganancia) as totganancia from adm_opg1 where idprv=$idprv and fecha>='$fechaini' and fecha<='$fechafin' and instr(concepto,'M-')=0";
//                echo $ssql."\n";
                $rg=$conx->consultaBase($ssql, $conn);
                $rgg=mysqli_fetch_object($rg);
                $totr=$rgg->totganancia;

    //            echo "totr: $totr\n";

                $ssql="select * from adm_com where (".substr($ccc,0,strlen($ccc)-4).")";
//                echo $ssql."\n";
                $rx=$conx->consultaBase($ssql, $conn);
                $totn2=0;
                while($rxx=mysqli_fetch_object($rx)) {
                    $neto=$rxx->neto10+$rxx->neto21+$rxx->neto27+$rxx->neto17;
                    if($rxx->tipocom!=2)
                        $totn2+=$neto;
                    else
                        $totn2-=$neto;
                }
//                echo "totn2: $totn2\n";
                $totalneto=$totn+$totn2;
//                echo "totalneto: $totalneto\n";
                $minimoret=$cfg->getMinimoretenciones();
                if($tiposer==2) $minimoret=$cfg->getMinimoretencionesser ();
                if($totalneto>$minimoret) {
//                    echo "totalneto: $totalneto | ".$cfg->getMinimoretenciones()."<br>";
                    $minimo=$totalneto-$minimoret;
//                    echo "totr: $totr | minimo: $minimo\n";
                    $importeganancia=($minimo*2/100)-$totr;
//                    $importeganancia=$minimo-$totr;
//                    echo "importeganancia: $importeganancia\n";
                }
                $importeganancia=number_format($importeganancia,2,".","");
                if($expganancia>0)
                    $importeganancia=0;
    //                echo $alicuotaret." ".$retenciones;
            } else {
                $ssql="select * from adm_com where (".substr($ccc,0,strlen($ccc)-4).")";
//                echo $ssql."\n";
                $rx=$conx->consultaBase($ssql, $conn);
                $totneto=0;
                $totiva=0;
                while($reg= mysqli_fetch_object($rx)) {
                    $net=$reg->neto21+$reg->neto10;
                    $iva=$reg->iva21+$reg->iva10;
                    if($reg->tipocom==2) {
                        $totneto-=$net;
                        $totiva-=$iva;
                    } else {
                        $totneto+=$net;
                        $totiva+=$iva;
                    }
                }
//                echo "neto: $totneto<br>iva: $totiva<br>";
                
                $importeganancia=number_format($totneto*6/100,2,".","");
                $retenciones=number_format($totneto*$prv->getRetencioniibb()/100,2,".","");

            }
        }
    }
}
if($transferencia=="") $transferencia=0;
if($importe=="") $importe=0;
if($totalpagos=="") $totalpagos=0;
if($retenciones=="") $retenciones=0;
if($importeganancia=="") $importeganancia=0;
if($totfp=="") $totfp=0;
if($importecheque=="") $importecheque=0;



//if($primero=="")
//  $canti=0;

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
                importepag="importepag" + f;
//                alert(document.getElementById(importetot).value);
//                alert(document.getElementById(importepag).value);
                apagar=parseFloat(document.getElementById(importetot).value)-parseFloat(document.getElementById(importepag).value);
//                alert(apagar);
                //alert(f + " " + document.getElementById(pagar).value);
                if(document.getElementById(pagar).checked==true) {
                  //alert(document.getElementById(tipocom).value);
                  totpag+=parseFloat(apagar);
                  //alert(totpag);
                  //alert(document.getElementById(importetot).value);
                  totconcepto+=document.form1[concepto].value + " / ";
                  //alert(concepto);
                }
            }
            totefectivo=totpag;
            totefectivo-=parseFloat(document.getElementById("importecheque").value);
            totpag=Math.round(totpag * 100) / 100;
            totefectivo=Math.round(totefectivo * 100) / 100;
            //alert(totpag);
            document.form1.importe.value=totpag;
            //document.form1.detalle0.value="Efectivo";
            document.form1.importeefectivo.value=totefectivo;
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
            otraforma=document.getElementById("otraforma").value
            importecheque=document.getElementById("importecheque").value;
            if(chequest=="") chequest=0;
            if(chequesp=="") chequesp=0;
            if(transferencia=="") transferencia=0;
            if(importe=="") importe=0;
            if(totalpagos=="") totalpagos=0;
            if(retenciones=="") retenciones=0;
            if(importeganancia=="") importeganancia=0;
            if(totfp=="") totfp=0;
            if(importecheque=="") importecheque=0;
            
            
            if(importeiibb=="") importeiibb=0;
            if(importeganancia=="") importeganancia=0;
            totfp=0;
            for(p=0;p<otraforma;p++) {
                importefp="importefp" + p;
//                alert(document.getElementById(importefp).value);
                if(document.getElementById(importefp).value!="")
                    totfp+=parseFloat(document.getElementById(importefp).value);
            }
            efectivo=parseFloat(document.getElementById("importe").value)-parseFloat(chequest)-parseFloat(chequesp)-parseFloat(transferencia)-parseFloat(importeiibb)-parseFloat(importeganancia)-parseFloat(totfp);
//            alert(efectivo + "|" + importecheque + "|" + totfp);
            efectivo-=parseFloat(importecheque);
//            alert(efectivo);
            efectivo=Math.round(efectivo*100)/100;
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
            <form name="form1" id="form1" action="adm_opg_act_save.php" method="post">
                <tr>
                    <? include("adm_menu.php") ?>
                    <input name="totalpagos" id="totalpagos" type="hidden" />
                    <input name="totfp" id="totfp" type="hidden" />
                    <input name="id" id="id" type="hidden" />
                    <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
                    <input name="idop" type="hidden" id="idop" value="<?= $idop?>" />
                    <input name="primero" type="hidden" id="primero" value="1" />
                    <input name="reten" id="reten" type="hidden" />
                    <input name="canti" type="hidden" id="canti" value="<?= $canti?>" />
                    <input name="cantd" type="hidden" value="<?= count($c_id)?>" id="cantd" />
                    <input name="alicuotaret" id="alicuotaret" type="hidden" value="<?= $alicuotaret?>" />
                    <input name="cantidadcht" id="cantidadcht" type="hidden" value="<?= $cantidadcht?>" />
                    <input name="cantidadche" id="cantidadche" type="hidden" value="<?= $cantidadche?>" />
                    <input name="c_com" id="c_com" type="hidden" value='<?= serialize($c_com)?>' />
                    <input name="c_tip" id="c_tip" type="hidden" value='<?= serialize($c_tip)?>' />
                    <input name="c_ppp" id="c_ppp" type="hidden" value='<?= serialize($c_ppp)?>' />
                    <input name="c_imp" id="c_imp" type="hidden" value='<?= serialize($c_imp)?>' />
                    <input name="c_let" id="c_let" type="hidden" value='<?= serialize($c_let)?>' />
                    <input name="c_ptv" id="c_ptv" type="hidden" value='<?= serialize($c_ptv)?>' />
                    <input name="c_nro" id="c_nro" type="hidden" value='<?= serialize($c_nro)?>' />
                    <input name="c_id" id="c_id" type="hidden" value='<?= serialize($c_id)?>' />
                    <input name="c_fec" id="c_fec" type="hidden" value='<?= serialize($c_fec)?>' />
                    <input name="c_net" id="c_net" type="hidden" value='<?= serialize($c_net)?>' />
                    <input name="totalpagosche" id="totalpagosche" type="hidden" value="<?= array_sum($xche_importe)?>" />
                    <input name="totalpagoscht" id="totalpagoscht" type="hidden" value="<?= array_sum($xcht_importe)?>" />
                    <input name="otraforma" id="otraforma" type="hidden" value="<?= $otraforma?>" />
                    <input name="importecheque" id="importecheque" type="hidden" value="<?= $importecheque?>" />
                    <input name="o2_detalle" id="o2_detalle" type="hidden" value='<?= serialize($o2_detalle)?>' />
                    <input name="o2_id" id="o2_id" type="hidden" value='<?= serialize($o2_id)?>' />
                    <input name="o2_importe" id="o2_importe" type="hidden" value='<?= serialize($o2_importe)?>' />
                    <input name="o2_tipopag" id="o2_tipopag" type="hidden" value='<?= serialize($o2_tipopag)?>' />
                    <input name="o2_chequet" id="o2_chequet" type="hidden" value='<?= serialize($o2_chequet)?>' />
                    <input name="o2_chequep" id="o2_chequep" type="hidden" value='<?= serialize($o2_chequep)?>' />
                    <!--<input name="cantidadccc" id="cantidadccc" type="hiden" value="<?= count($o2_chequet)?>" />-->
                    
                    <? for($i=0;$i<$cantidadcht;$i++) { 
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
                                                    <td colspan="2"><a href="javascript: document.form1.target='_self'; document.form1.action='adm_opg_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" width="35%">Fecha&nbsp;</td>
                                                    <td width="65%"><input name="fecha" type="date" class="letra6" id="fecha" value="<?= $fecha?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Proveedor&nbsp;</td>
                                                    <td>
                                                        <select name="idprv" class="letra6" id="idprv" onchange="javascript: document.form1.action='adm_opg_act.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv order by apellido";
                                                        $sup->cargaCombo3($ssql, $idprv, "Sel");
                                                        ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Concepto&nbsp;</td>
                                                    <td>
                                                        <textarea name="concepto" id="concepto" rows="2" cols="50" class="letra6"><?= $concepto?></textarea>
                                                        <!--<input name="concepto" type="text" class="letra6" id="concepto" size="50" maxlength="100" value="<?= $concepto?>" />-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Tipo&nbsp;<input name="tipo" id="tipo" value="1" type="hidden" /></td>
                                                    <td>
                                                        <select name="tiposer" id="tiposer">
                                                            <?
                                                            $array=array("Bienes","Servicios");
                                                            $avalor=array(1,2);
                                                            $sup->cargaComboArrayValor($array, $avalor, $tiposer);
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
                                                    <td><input name="importe" type="text" class="letra6" id="importe" size="10" maxlength="10" readonly="readonly" style="background-color:#CCCCCC; border:none; text-align:center" value="<?= $importe?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Retenciones&nbsp;</td>
                                                    <td><input name="retenciones" type="text" class="letra6" id="retenciones" size="10" maxlength="10" readonly="readonly" style="background-color:#CCCCCC; border:none; text-align:center" value="<?= $retenciones?>" /></td>
                                                </tr>

                                                <? if($idprv>0) { ?>
                                                <tr>
                                                    <td align="center" colspan="2">
                                                        <a href="javascript: document.form1.target='_self'; document.form1.reten.value=1; document.form1.action='adm_opg_act.php'; document.form1.submit()">Calcular y Agregar Rentención IIBB en Detalle de Pago</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="panel910 letra6">
                                                            <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                                <h3 class="ui-widget-header ui-corner-all">Comprobantes a Aplicar</h3>

                                                                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="letra6">
                                                                    <tr class="letra6bold">
                                                                        <td align="center">Fecha</td>
                                                                        <td align="left">Número</td>
                                                                        <td align="right">Importe</td>
                                                                        <td align="center">Pagado</td>
                                                                        <td align="center">Pagar</td>
                                                                        <td align="center">&nbsp;</td>
                                                                    </tr>
                                                                    <? 
                                                                    for($i=0;$i<count($c_id);$i++) { 
                                                                        $pagar="pagar$i";
                                                                        $$pagar=$glo->getGETPOST($pagar);
                                                                        if($tarea=="M" and $primero!=1)
                                                                            $$pagar=$c_ppp[$i];
                                                                        $importetot=$c_imp[$i];
                                                                        $importepag=$c_pag[$i];
                                                                        if($tipo==1)
                                                                            $conce=$c_com[$i]." ".$c_let[$i]."-".$c_ptv[$i]."-".$c_nro[$i];
                                                                        else
                                                                            $conce=$c_com[$i]." ".$c_id[$i];
                                                                    ?>
                                                                    <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                                        <td align="center"><?= $dsup->getFechaNormalCorta($c_fec[$i])?>
                                                                            <input name="importetot<?= $i?>" id="importetot<?= $i?>" type="hidden" value="<?= $importetot?>" />
                                                                            <input name="importepag<?= $i?>" id="importepag<?= $i?>" type="hidden" value="<?= $importepag?>" />
                                                                            <input name="concepto<?= $i?>" id="concepto<?= $i?>" type="hidden" value="<?= $conce?>" />
                                                                            <input name="idcom<?= $i?>" type="hidden" id="idcom<?= $i?>" value="<?= $c_id[$i]?>" />
                                                                            <input name="neto<?= $i?>" type="hidden" id="neto<?= $i?>" value="<?= $c_net[$i]?>" />
                                                                            <? if($tipo==1) { ?>
                                                                            <input name="tipocom<?= $i?>" id="tipocom<?= $i?>" type="hidden" value="<?= $c_tip[$i]?>"
                                                                            <? } else { ?>
                                                                            <input name="tipocom<?= $i?>" id="tipocom<?= $i?>" type="hidden" value="1"
                                                                            <? } ?>
                                                                        </td>
                                                                        <td align="left">
                                                                            <? if($tipo==1)
                                                                                echo $c_com[$i]." ".$c_let[$i]."-".$c_ptv[$i]."-".$c_nro[$i];
                                                                            else
                                                                                echo $c_com[$i]." ".$c_id[$i];
                                                                            ?>
                                                                        </td>
                                                                        <td align="right"><?= number_format($c_imp[$i],2)?></td>
                                                                        <td align="center"><?= number_format($c_pag[$i],2)?></td>
                                                                        <td align="center"><?= number_format($c_imp[$i]-$c_pag[$i],2)?></td>
                                                                        <td align="center"><input name="pagar<?= $i?>" type="checkbox" id="pagar<?= $i?>" value="1" <? if($$pagar==1) echo "checked='checked'"?> onclick="javascript: pagacompleto2(<?= count($c_id)?>)" /></td>
                                                                        <!--<td align="center"><a href="javascript: pagacompleto(<?= $i?>, <?= count($c_id)?>)"><img src="images/pesos.png" alt="Paga completo" width="14" height="16" border="0" /></a></td>-->
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
                                                                            <a href="javascript: document.form1.taget='_self'; document.form1.otraforma.value++; document.form1.action='adm_opg_act.php'; document.form1.submit()"><i class="fas fa-comment-dollar fa-2x" title="Agregar otra forma de pago" alt="Agregar otra forma de pago"></i></a> 
                                                                            <a href="javascript: document.form1.taget='_self'; document.form1.action='adm_cht_buscar.php'; document.form1.submit()"><i class="fas fa-search-dollar fa-2x" title="Seleccionar Cheques de Terceros" alt="Seleccionar Cheques de Terceros"></i></a> 
                                                                            <a href="javascript: document.form1.taget='_self'; document.form1.action='adm_che_buscar.php'; document.form1.submit()"><i class="fas fa-search-dollar fa-2x" style="color: blue" title="Seleccionar Cheques Propios" alt="Seleccionar Propios"></i></a> 
                                                                        </td>
                                                                    </tr>
                                                                    <?
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
                                                                        
                                                                    <? }
//                                                                    $importecheque=array_sum($o2_importe);
                                                                    for($t=0;$t<count($o2_id);$t++) { 
                                                                        if(substr($o2_detalle[$t],0,2)=="Ch") { ?>
                                                                    <tr class="letra6bold">
                                                                        <td>
                                                                            <?= $o2_detalle[$t]?></td>
                                                                        <td align="right"><?= number_format($o2_importe[$t],2)?></td>
                                                                        <td><a href="javascript: bajareg(<?= $o2_id[$t]?>,'Elimina Cheque?','adm_opg_che_del.php')"><i class="fas fa-minus-circle fa-lg" style="color: #BB0000" title="Eliminar Forma de Pago"></i></a></td>
                                                                    </tr>
                                                                    <? } }?>

                                                                    
                                                                    <tr class="letra6bold">
                                                                        <td>EFECTIVO</td>
                                                                        <td align="right">
                                                                            <? "1: $importe<br>2: $totalpagos<br>3: $retenciones<br>4: $transferencia<br>5: $importeganancia<br>6: $totfp<br>7: $importecheque<br>";?>
                                                                            <input name="importeefectivo" id="importeefectivo" value="<?= $importe-$totalpagos-$retenciones-$transferencia-$importeganancia-$totfp-$importecheque?>" size="10" maxlength="10" onkeypress="return validar_punto_menos(event)" style="text-align: center" onblur="javascript: calculasaldoefectivo()" />
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
                                                                    <? 
                                                                    for($p=0;$p<$otraforma;$p++) { 
                                                                        if($tarea=="A" or ($tarea=="M" and $primero==1)) {
                                                                        $formapago="formapago$p";
                                                                        $importefp="importefp$p";
                                                                        $$formapago=$glo->getGETPOST($formapago);
                                                                        $$importefp=$glo->getGETPOST($importefp);
                                                                        }
                                                                        ?>
                                                                    <tr>
                                                                        <td><input name="formapago<?= $p?>" id="formapago<?= $i?>" value="<?= $$formapago?>" type="text" size="20" maxlength="50" /></td>
                                                                        <td align="right">
                                                                            <input name="importefp<?= $p?>" id="importefp<?= $p?>" value="<?= $$importefp?>" size="10" maxlength="10" onkeypress="return validar_punto_menos(event)" style="text-align: center" onblur="javascript: calculasaldoefectivo()" />
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                    <? } ?>
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
                                                                        <td><input type="submit" name="cmdIngCheque" id="cmdIngCheque" value="Ingresar Cheque" onclick="javascript: document.form1.action='adm_opg_che_act_save.php'; document.form1.submit()" /></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center">
                                                        <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: document.form1.action='adm_opg_act_save.php'; document.form1.submit()" />
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
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </form>
        </div>
    </body>
</html>

