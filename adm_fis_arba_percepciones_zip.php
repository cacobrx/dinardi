<?php
/*
 * Creado el 10/01/2020 09:56:58
 * Autor: gus
 * Archivo: adm_fis_arba_percepciones_zip.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();

$archivo="AR-".$cfg->getFiscalcuit()."-".date("Ym", strtotime($fechainifis))."0-7-Percepciones-Lote1.txt";

//echo "existe: ".file_exists($archivo);

$zip=new ZipArchive();
$md5= md5_file($archivo);
$zipfile=$archivo."_".$md5;
if($zip->open($zipfile, ZIPARCHIVE::CREATE)===true) {
    $zip->addFile($archivo);
    $zip->close();
    $cartel="El archivo comprimido fue creado correctamente.";
} else
    $cartel="Error al crear el archivo comprimido.";


?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_fis_main.php" method="post">
            
        </form>
        <script language="javascript">
            alert('<?= $cartel?>');
            document.form1.submit();
        </script>
    </body>
</html>
