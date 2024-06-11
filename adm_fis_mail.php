<?php
/*
 * Creado el 08/11/2015 14:30:48
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_fis_mail
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_fis.php';
require_once 'clases/adm_cli.php';
require_once 'clases/support.php';
$sup=new support();
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$id=$glo->getGETPOST("id");
$cuerpofis=$glo->getGETPOST("cuerpofis");
$fis=new adm_fis_1($id);
$cli=new adm_cli_1($fis->getIdcli());
$email=$cli->getEmail();
$asunto= utf8_decode($cen->getNombre())." - Comprobante ".$fis->getLetra()."-".$sup->AddZeros($fis->getPtovta(),4)."-".$sup->AddZeros($fis->getNumero(),8);
$cuerpo=$cuerpofis."<br><br>";
//$cuerpo="El comprobante ha sido generado<br>";
$cuerpo.="<a href='http://190.184.224.9/planb/adm_fis_prn_mail.php?id=$id'>Clic para descargar la Factura</a><br><br>";
//$cuerpo.="Este es un mail automatico, cualquier duda dirijase a Administracion";
//$header="From: ".$cen->getNombre()."<info@eddis.edu.ar\nContent-Type: text/html";
$header="From: PlanB Sistemas - Gustavo Bragagnolo <gustavo.bragagnolo@gmail.com>\nContent-Type: text/html; charset=UTF-8";
//$header="From: Maderera Forestal Tigre <gustavo.bragagnolo@gmail.com>\nContent-Type: text/html; charset=UTF-8";
mail($email,$asunto,$cuerpo,$header);
//mail("planb.sistemasweb@gmail.com",$asunto,$cuerpo,$header2);

//echo $email."<br>";
//echo $asunto."<br>";
//echo $header."<br>";
//echo $cuerpo."<br>";
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_fis_main.php" method="post">
        </form>
        <script language="javascript">
            alert("El comprobante fue enviado a <?= $email?>");
            document.form1.submit();
        </script>
    </body>
</html>