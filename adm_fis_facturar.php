<?php
/*
 * creado el 28 mar. 2022 21:18:39
 * Usuario: gus
 * Archivo: adm_fis_facturar
 */


require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_fis.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_cli.php';
require_once 'afip.php';
require_once 'clases/debug.php';

$aud = new registra_auditoria();
$cfg=new planb_config_1($centrosel);
$conx = new conexion();
$glo = new globalson();
$dbg=new debug();
$id=$glo->getGETPOST("id");
$fis=new adm_fis_1($id);
$cli=new adm_cli_1($fis->getIdcli());
$s_percepcioniibb=$fis->getPercepcioniibb();
$s_porcentajeiibb=$fis->getPorcentajeiibb();
$s_tipodes=$fis->getTipodes();
$s_letra=$fis->getLetra();
$s_docreferencia=$fis->getDocreferencia();
$s_condicioniva=$fis->getCondicioniva();
$s_ptovta=$fis->getPtovta();
$s_codigocomp=$fis->getCodigocomp();
$s_nogravado=$fis->getNogravado();


#==============================================================================
define ("WSDLWSAA", "wsaa.wsdl");
define ("WSDLWSW", "wsfe.wsdl");
#define ("URLWSAA", "https://wsaahomo.afip.gov.ar/ws/services/LoginCms");
#define ("URLWSW", "https://wswhomo.afip.gov.ar/wsfev1/service.asmx");
# Cambiar para produccion
define ("URLWSAA", "https://wsaa.afip.gov.ar/ws/services/LoginCms");
define ("URLWSW", "https://servicios1.afip.gov.ar/wsfev1/service.asmx");
#==============================================================================

date_default_timezone_set('America/Buenos_Aires');
$wsfe=new WsFE();
$cuit=$cfg->getFiscalcuit();
$nro = 0;
$PtoVta = $s_ptovta;
$TipoComp=$s_codigocomp;
$FechaComp = $fis->getFecha();
$certificado = "cert$cuit.crt";
$clave = "clav$cuit.key";
$wsfe->CUIT=$cuit;
$urlwsaa = URLWSAA;
$wsfe->setURL(URLWSW);

$neto21=$fis->getNetocf21()+$fis->getNetori21();
$neto10=$fis->getNetocf10()+$fis->getNetori10();
$iva21=$fis->getIvacf21()+$fis->getIvari21();
$iva10=$fis->getIvacf10()+$fis->getIvari10();
$totaltotal=$neto21+$neto10+$iva21+$iva10+$s_percepcioniibb+$s_nogravado;
$ImpTotalConc=$s_nogravado;
$archivo="log/fiscal.log";
//echo "neto21: $neto21<br>neto10: $neto10<br>iva21: $iva21<br>iva10: $iva10<br>total: $totaltotal<br>";
$fechafactura=date("Ymd", strtotime($FechaComp));
$fechapago=date("Ymd", strtotime($fis->getFechapago()));
if($TipoComp==2 or $TipoComp==1 or $TipoComp==3) $fechapago="";
//echo "fechafactura: $fechafactura<br>";
$error="";
$numero="";
$numerocae="";
$fechacae="";
if ($wsfe->Login($certificado, $clave, $urlwsaa)) {
//    echo "paso1<br>";
    if (!$wsfe->RecuperaLastCMP($PtoVta, $TipoComp)) {
        $error=$wsfe->ErrorDesc." (2)";
    } else {
        $wsfe->Reset();
        //echo $fis->getNrocuit()."<br>";
        $cuitcli=$cli->getCuit();
        if(strlen($cuitcli)==11)
            $tipodoc=80;
        else {
            if($cuitcli==0)
                $tipodoc=99;
            else
                $tipodoc=96;
        }
//        echo "tipodoc: $tipodoc<br>";
        $lencuit=strlen($cuitcli);
        $cad="$tipodoc, $cuitcli ($lencuit), $totaltotal, $ImpTotalConc, $neto21, $neto10, $iva21, $iva10, $s_percepcioniibb, $s_porcentajeiibb";
//        echo $cad."<br>";
//        echo "cuitcli: $cuitcli<br>";
//        echo "Total: $totaltotal<br>Netos: $neto21 | $neto10<br>Ivas: $iva21 | $iva10<br>";
//        echo "ultimo numero: ".$wsfe->RespUltNro."<br>";
//        echo "fechafactura: $fechafactura<br>";
//        echo "fechapago: $fechapago<br>";
        $dbg->WriteLog($cad, $archivo);
        $wsfe->AgregaFactura(1, $tipodoc, $cuitcli, $wsfe->RespUltNro + 1, $wsfe->RespUltNro + 1, $fechafactura, $totaltotal, $ImpTotalConc, $neto21+$neto10, 0.0, "", "", $fechapago, "PES", 1);
        if($s_docreferencia>0 and ($TipoComp==2 or $TipoComp==3 or $TipoComp==7 or $TipoComp==8 or $TipoComp==12 or $TipoComp==13 or $TipoComp==52 or $TipoComp==53)) {
            $wsfe->AgregaCompAsoc($TipoComp, $PtoVta, $s_docreferencia);
            $dbg->WriteLog("Documento Asociado: ".$s_docreferencia, $archivo);
        }
        if($iva21>0) {
            $wsfe->AgregaIVA(5, $neto21, $iva21);
            $dbg->WriteLog("IVA 21%: $neto21 $iva21", $archivo);
        }
        if($iva10>0) {
            //echo "4, $neto10, $iva10<br>";
            $wsfe->AgregaIVA (4, $neto10, $iva10);
            $dbg->WriteLog("IVA 10.5%: $neto10 $iva10", $archivo);
        }
        
        if($s_condicioniva==3 or $s_condicioniva==4) {
            if($s_percepcioniibb>0) {
                $wsfe->AgregaTributo(2, "Perc IIBB", $neto21+$neto10, $s_porcentajeiibb, $s_percepcioniibb);
                $dbg->WriteLog("Percepcion: $s_porcentajeiibb $s_percepcioniibb", $archivo);
            }
                
        }
        
        //$wsfe->AgregaIVA(3, $$importe, 0);
        //$wsfe->AgregaTributo(2, "Perc IIBB", $$importe, $iibb, 35);
        if ($wsfe->Autorizar($PtoVta, $TipoComp)) {
//            echo "paso4<br>";
            //echo "Si ve este mensaje instalo correctamente FEAFIP. CAE y Vencimiento :" . $wsfe->RespCAE . " " . $wsfe->RespVencimiento." numero: ".$wsfe->RespUltNro."<br>";
            $numerocae=$wsfe->RespCAE;
            $fechacae=$wsfe->RespVencimiento;
            $numero=$wsfe->RespUltNro+1;
            $error="Se agrega comprobante ".$s_tipodes."-".$s_letra."-".$s_ptovta."-".$numero." CAE: ".$numerocae." (4)";
            $ssql="update adm_fis set numero=$numero, numerocae=$numerocae, fechacae='$fechacae' where id=$id";
            $conx->getConsulta($ssql);
        } else {
//            echo "paso6<br>";
            $error=$wsfe->ErrorCode." ".$wsfe->ErrorDesc." (6)";
        }

    }

} else {
//    echo "paso7<br>";
    $error=$wsfe->ErrorDesc." (7)";
}
$ssql="update adm_fis set error='$error' where id=$id";
$conx->getConsulta($ssql);
//echo "Error: $error";
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_fis_main.php" method="post">
        </form>
        <script language="javascript">
            alert("<?= $error?>");
            document.form1.submit();
        </script>
    </body>
</html>

