<?php
/*
 * creado el 06/06/2017 11:28:35
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_fis_fac
 */

#==============================================================================
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


require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/planb_config.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'afip.php';
require_once 'clases/adm_cli.php';
require_once 'clases/adm_fis.php';
require_once 'clases/support.php';
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$idfis=$glo->getGETPOST("id");
$fis=new adm_fis_1($idfis);
$cli=new adm_cli_1($fis->getIdcli());
$totaltotal=$fis->getTotaltotal();
$tipo=$fis->getTipo();
$ttt=$fis->getTotaltotal();
$neto21=$fis->getNetocf21()+$fis->getNetori21();
$neto10=$fis->getNetocf10()+$fis->getNetori10();
$percepcioniibb=$fis->getPercepcioniibb();
//echo $fis->getTotal()."<br>";
//echo $fis->getNetocf21()."<br>";


$wsfe=new WsFE();
//$cuit=$wsfe->NormalizaCUIT($cfg->getFiscalcuit());
$cuit=$cfg->getFiscalcuit();
$nro = 0;
$PtoVta = $cfg->getFiscalpuntoventa();
$TipoComp=$fis->getCodigocomp();
$FechaComp = date("Ymd");
$certificado = "cert".$cfg->getFiscalcuit().".crt";
$clave = "clav".$cfg->getFiscalcuit().".key";

$wsfe->CUIT=$cuit;
$urlwsaa = URLWSAA;
$wsfe->setURL(URLWSW);
//echo "paso1<br>";
$ttdoc=96;
if(strlen($cli->getCuit())>8)
    $ttdoc=80;

if ($wsfe->Login($certificado, $clave, $urlwsaa)) {
    if (!$wsfe->RecuperaLastCMP($PtoVta, $TipoComp)) {
        $error=$wsfe->ErrorDesc." (2)";
        $ssql="update adm_fis set error='$error' where id=$idfis";
            $conx->getConsulta($ssql);
        } else {
            $wsfe->Reset();
//            echo "numero: ".$wsfe->RespUltNro."<br>";
//            echo "Doc: ".$cli->getCuit()."<br>";
//            echo "Importe: ".$totaltotal."<br>";
//            echo "Neto21: $neto21<br>Iva21: $iva21<br>Neto10: $neto10<br>iva10: $iva10<br>";
//            echo "IVA: ".$cli->getCondicioniva()."<br>";
//            echo "(1, 80, ".$cli->getCuit().", ".$wsfe->RespUltNro." + 1, ".$wsfe->RespUltNro." + 1, ".date("Ymd").", ".$totaltotal.", 0.0, ".$neto21." + ".$neto10.", 0.0, , , , PES, 1)<br>";
            $cuitcli=$wsfe->NormalizaCUIT($cli->getCuit());
            //$wsfe->AgregaFactura(1, $ttdoc, $cuitcli, $wsfe->RespUltNro + 1, $wsfe->RespUltNro + 1, date("Ymd"), $totaltotal, 0.0, $totaltotal, 0.0, "", "", "", "PES", 1);            
            //$wsfe->AgregaFactura($Concepto, $DocTipo, $DocNro, $CbteDesde, $CbteHasta, $CbteFch, $ImpTotal, $ImpTotalConc, $ImpNeto, $ImpOpEx, $FchServDesde, $FchServHasta, $FchVtoPago, $MonId, $MonCotiz)
            
            $wsfe->AgregaFactura(1, 80, $cuitcli, $wsfe->RespUltNro + 1, $wsfe->RespUltNro + 1, date("Ymd"), $totaltotal, $ImpTotalConc, $neto21+$neto10, 0.0, "", "", "", "PES", 1);
            //$wsfe->AgregaFactura($Concepto, $DocTipo, $DocNro, $CbteDesde, $CbteHasta, $CbteFch, $ImpTotal, $ImpTotalConc, $ImpNeto, $ImpOpEx, $FchServDesde, $FchServHasta, $FchVtoPago, $MonId, $MonCotiz)
            if($vta->getDocreferencia()>0)
                $wsfe->AgregaCompAsoc($TipoComp, $PtoVta, $vta->getDocreferencia ());
            if($iva21>0) {
                //echo "5, $neto21, $iva21<br>";
                $wsfe->AgregaIVA(5, $neto21, $iva21);
            }
            if($iva10>0) {
                //echo "4, $neto10, $iva10<br>";
                $wsfe->AgregaIVA (4, $neto10, $iva10);
            }
            //$wsfe->AgregaIVA(3, $$importe, 0);
            if($cli->getCondicioniva()==3 or $cli->getCondicioniva()==4) {
                if($percepcioniibb>0)
                    $wsfe->AgregaTributo(2, "Perc IIBB", $neto21+$neto10, $iibb, $percepcioniibb);
            }
            
            
            if($fis->getDocreferencia()>0)
                $wsfe->AgregaCompAsoc($TipoComp, $PtoVta, $fis->getDocreferencia());
            if ($wsfe->Autorizar($PtoVta, $TipoComp)) {
                //echo "Si ve este mensaje instalo correctamente FEAFIP. CAE y Vencimiento :" . $wsfe->RespCAE . " " . $wsfe->RespVencimiento." numero: ".$wsfe->RespUltNro."<br>";
                $numerocae=$wsfe->RespCAE;
                $fechacae=$wsfe->RespVencimiento;
                $numero=$wsfe->RespUltNro+1;
                $ssql="update adm_fis set fecha='".date("Y-m-d")."', numero=$numero, numerocae=$numerocae, fechacae='$fechacae', ptovta=$PtoVta where id=$idfis";
                //echo $ssql."<br>";
                $error="Se agrega comprobante ".$fis->getTipodes()."-C-".$PtoVta."-".$numero." CAE: ".$numerocae;
                $conx->getConsulta($ssql);
            } else {
                $error=$wsfe->ErrorDesc." (6)";
                $ssql="update adm_fis set error='$error' where id=$idfis";
                //echo "Error: $error<br>";
                $conx->getConsulta($ssql);
            }

        }

} else {
    //echo "paso7<br>";
    $error=$wsfe->ErrorDesc." (7)";
    $ssql="update adm_fis set error='$error' where id=$idfis";
    //echo "Error: $error<br>";
    $conx->getConsulta($ssql);
}
$aud->regAud("Fiscal", $usr->getId(), $error, $centrosel,$fis->getIdcli());
    
//echo $error;    

?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_fis_main.php" method="post">
        </form>
        <script languaje="javascript">
            alert("<?= $error?>");
            document.form1.submit()
        </script>
    </body>
</html>
