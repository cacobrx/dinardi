<?php
/*
 * Creado el 15/03/2016 17:17:55
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: register_opg
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainiopg=$glo->getGETPOST("fechainiopg");
$fechafinopg=$glo->getGETPOST("fechafinopg");
$criterioopg=$glo->getGETPOST("criterioopg");
$tipocontabilidadopg=$glo->getGETPOST("tipocontabilidadopg");
$filtroopg=$glo->getGETPOST("filtroopg");
$campoopg=$glo->getGETPOST("campoopg");
$tipoopg=$glo->getGETPOST("tipoopg");
//$campofechaopg=$glo->getGETPOST("campofechaopg");
$limopg=$glo->getGETPOST("limopg");
if($limopg=="")
    $limopg=0;
$_SESSION["fechainiopg"]=$fechainiopg;
$_SESSION["fechafinopg"]=$fechafinopg;
$_SESSION["tipoopg"]=$tipoopg;
$_SESSION["criterioopg"]=$criterioopg;
$_SESSION["tipocontabilidadopg"]=$tipocontabilidadopg;
$_SESSION["campoopg"]=$campoopg;
$_SESSION["filtroopg"]=$filtroopg;
//$_SESSION["campofechaopg"]=$campofechaopg;
$_SESSION["limopg"]=$limopg;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_opg_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
