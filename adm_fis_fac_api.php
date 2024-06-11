<?php
/*
 * creado el 9 oct. 2023 15:50:32
 * Usuario: gus
 * Archivo: adm_fis_fac_api
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_fis.php';
require_once 'clases/adm_cli.php';
$aud = new registra_auditoria();
$glo = new globalson();
$conx = new conexion();
$sup = new support();
$dsup = new datesupport();
$cfg = new planb_config_1($centrosel);
$id=$glo->getGETPOST("id");
$fis=new adm_fis_1($id);
$cli=new adm_cli_1($fis->getIdcli());


//$url = 'https://190.184.224.217/afip/autoriza_comprobante.php';
$url = 'https://afip.planbsistemas.com.ar/autoriza_comprobante.php';

//create a new cURL resource
$ch = curl_init($url);

//setup request to send json via POST
$data = array(
    'sistema'       => "dinardi",
    'fecha'         => $fis->getFecha(),
    'cuit'          => $cfg->getFiscalcuit(),
    'ptovta'        => $fis->getPtovta(),
    'tipodoc'       => $fis->getCodigodoc(),
    'nrodoc'        => $fis->getNrocuit(),
    'tipocomp'      => $fis->getCodigocomp(),
    'docreferencia' => $fis->getDocreferencia(),
    'tipodes'       => $fis->getTipodes(),
    'letra'         => $fis->getLetra(),
    'importetotal'  => number_format($fis->getTotal(),2,".",""),
    'importeneto'   => number_format($fis->getTotal() / 1.21,2,".",""),
    'importeiva'    => number_format($fis->getTotal()-$fis->getTotal()/1.21,2,".","")
    
);

//print_r($data);

$payload = json_encode(array("fis" => $data));

//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

//set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

//return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute the POST request
$result = curl_exec($ch);

//close cURL resource
curl_close($ch);
//print_r($result);
$datos= json_decode($result);
//print_r($datos);
$coderror=$datos->coderror;
$error=$datos->error;
$numero=$datos->numero;
$numerocae=$datos->numerocae;
$fechacae=$datos->fechacae;
if($coderror==0)
    $ssql="update adm_fis set error='$error', numero=$numero, numerocae='$numerocae', fechacae='$fechacae' where id=$id";
else 
    $ssql="update adm_fis set error='$error' where id=$id";
//echo "<br>ssql: $ssql<br>";
$conx->getConsulta($ssql);
$aud->regAud("FACTURACION", $usr->getId(), $error, 1);

//$error=$result;
//echo "Result: $result<br>";
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_fis_main.php" method="post">

        </form>
        <script languaje="javascript">
            alert('<?= $error?>');
            document.form1.submit()
        </script>
    </body>
</html>
