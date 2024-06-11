<?php
/*
 * Creado el 07/01/2020 17:07:48
 * Autor: gus
 * Archivo: test_clf.php
 * planbsistemas.com.ar
 */

require_once 'clases/globalson.php';
require_once 'clases/support.php';
$sup = new support();
$glo = new globalson();
$tt=$glo->getGETPOST("tt");
$vv=$glo->getGETPOST("vv");
$cod=$sup->getNuevocodigo($tt, $vv);
echo $cod;
?>
