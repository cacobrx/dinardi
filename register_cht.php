<?php

#----------------------------------------
# Autor: gus
# Fecha: 01/04/2015 14:28:21
# Archivo: register_cob.php
#----------------------------------------
session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$tipofechacht=$glo->getGETPOST("tipofechacht");
$filtrocht=$glo->getGETPOST("filtrocht");
$tipocht=$glo->getGETPOST("tipocht");
$fechainicht=$glo->getGETPOST("fechainicht");
$fechafincht=$glo->getGETPOST("fechafincht");
$camposelcht=$glo->getGETPOST("camposelcht");
$campocht=$glo->getGETPOST("campocht");
$criteriocht=$glo->getGETPOST("criteriocht");
$primerocht=$glo->getGETPOST("primerocht");
$chkfechacht=$glo->getGETPOST("chkfechacht");
$bancocht=$glo->getGETPOST("bancocht");
$limcht=$glo->getGETPOST("limcht");
if($limcht=="")
    $limcht=0;
if($chkfechacht=="") $chkfechacht=0;
$_SESSION["tipofechacht"]=$tipofechacht;
$_SESSION["filtrocht"]=$filtrocht;
$_SESSION["tipocht"]=$tipocht;
$_SESSION["fechainicht"]=$fechainicht;
$_SESSION["fechafincht"]=$fechafincht;
$_SESSION["camposelcht"]=$camposelcht;
$_SESSION["campocht"]=$campocht;
$_SESSION["limcht"]=$limcht;
$_SESSION["criteriocht"]=$criteriocht;
$_SESSION["primerocht"]=$primerocht;
$_SESSION["chkfechacht"]=$chkfechacht;
$_SESSION["bancocht"]=$bancocht;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_cht_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>