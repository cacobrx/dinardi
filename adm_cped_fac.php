<?php
/*
 * Creado el 15/10/2015 17:19:00
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_cped_fac
 */

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
require_once 'clases/adm_cped.php';
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$cfg=new planb_config_1($centrosel);
$idcped=$glo->getGETPOST("idcped");
$cped=new adm_cped_1($idcped);
$cli=new adm_cli_1($cped->getIdcli());
$totaltotal=$cped->getTotaltotal();

$wsfe=new WsFE();
$cuit=$wsfe->NormalizaCUIT($cfg->getFiscalcuit());
$nro = 0;
$PtoVta = $cfg->getFiscalpuntoventa();
if($cped->getTipodoc()==0)
    $TipoComp=11;
else
    $TipoComp=13;
$FechaComp = date("Ymd");
$certificado = "cert".$cfg->getFiscalcuit().".crt";
$clave = "clav".$cfg->getFiscalcuit().".key";
// prueba *******************
//$cuit = 20939802593;
//$clave="clave.key";
//$certificado="certificado.crt";
//***************************
$wsfe->CUIT=$cuit;
$urlwsaa = URLWSAA;
$wsfe->setURL(URLWSW);
//echo "paso1<br>";
if ($wsfe->Login($certificado, $clave, $urlwsaa)) {
    if (!$wsfe->RecuperaLastCMP($PtoVta, $TipoComp)) {
        $error=$wsfe->ErrorDesc." (2)";
        $ssql="update adm_cped set error='$error' where id=$idcped";
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
            $wsfe->AgregaFactura(1, 96, $cuitcli, $wsfe->RespUltNro + 1, $wsfe->RespUltNro + 1, date("Ymd"), $totaltotal, 0.0, $totaltotal, 0.0, "", "", "", "PES", 1);            
            //$wsfe->AgregaFactura($Concepto, $DocTipo, $DocNro, $CbteDesde, $CbteHasta, $CbteFch, $ImpTotal, $ImpTotalConc, $ImpNeto, $ImpOpEx, $FchServDesde, $FchServHasta, $FchVtoPago, $MonId, $MonCotiz)
            if($cped->getDocreferencia()>0)
                $wsfe->AgregaCompAsoc($TipoComp, $PtoVta, $cped->getDocreferencia ());
            if ($wsfe->Autorizar($PtoVta, $TipoComp)) {
                //echo "Si ve este mensaje instalo correctamente FEAFIP. CAE y Vencimiento :" . $wsfe->RespCAE . " " . $wsfe->RespVencimiento." numero: ".$wsfe->RespUltNro."<br>";
                $numerocae=$wsfe->RespCAE;
                $fechacae=$wsfe->RespVencimiento;
                $numero=$wsfe->RespUltNro+1;
                $ssql="update adm_cped set fechafactura='".date("Y-m-d")."', numero=$numero, numerocae=$numerocae, fechacae='$fechacae', ptovta=$PtoVta where id=$idcped";
                //echo $ssql."<br>";
                $error="Se agrega comprobante ".$cped->getTipocomdes()."-C-".$PtoVta."-".$numero." CAE: ".$numerocae;
                $conx->getConsulta($ssql);
            } else {
                $error=$wsfe->ErrorDesc." (6)";
                $ssql="update adm_cped set error='$error' where id=$idcped";
                //echo "Error: $error<br>";
                $conx->getConsulta($ssql);
            }

        }

} else {
    //echo "paso7<br>";
    $error=$wsfe->ErrorDesc." (7)";
    $ssql="update adm_cped set error='$error' where id=$idcped";
    //echo "Error: $error<br>";
    $conx->getConsulta($ssql);
}

$aud->regAud("Fiscal", $usr->getId(), $error, $centrosel,$cped->getIdcli());
    
//echo $error;    

?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_cped_main.php" method="post">
        </form>
        <script languaje="javascript">
            alert("<?= $error?>");
            document.form1.submit()
        </script>
    </body>
</html>
