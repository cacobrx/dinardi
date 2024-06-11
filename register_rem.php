<?php
/*
 * Creado el 15/01/2019 10:38:01
 * Autor: gus
 * Archivo: register_rem.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
require_once 'clases/support.php';
$glo=new globalson();
$sup=new support();
$fechainirem=$glo->getGETPOST("fechainirem");
$fechafinrem=$glo->getGETPOST("fechafinrem");
$detallerem=$glo->getGETPOST("detallerem");
$proveedorrem=$glo->getGETPOST("proveedorrem");
$faenarem=$glo->getGETPOST("faenarem");
$sincomprasrem=$glo->getGETPOST("sincomprasrem");
$seleccionrem=$glo->getGETPOST("seleccionrem");
$limrem=$glo->getGETPOST("limrem");
$certificadorem=$glo->getGETPOST("certificadorem");
$cer1rem=$glo->getGETPOST("cer1rem");
$letrarem=$glo->getGETPOST("letrarem");
$cer2rem=$glo->getGETPOST("cer2rem");
$paisrem=$glo->getGETPOST("paisrem");
if($letrarem=="" and $cer1rem!="" and $cer2rem!="") $letrarem=" ";
if($cer1rem!="" or $cer2rem!="") 
    $cer1rem=$sup->AddZeros($cer1rem,4);
else
    $cer1rem="";
if($cer2rem!="" or $cer1rem!="") 
    $cer2rem=$sup->AddZeros($cer2rem,8);
else
    $cer2rem="";
if($limrem=="") $limrem=0;
$_SESSION["fechainirem"]=$fechainirem;
$_SESSION["fechafinrem"]=$fechafinrem;
$_SESSION["detallerem"]=$detallerem;
$_SESSION["proveedorrem"]=$proveedorrem;
$_SESSION["limrem"]=$limrem;
$_SESSION["faenarem"]=$faenarem;
$_SESSION["sincomprasrem"]=$sincomprasrem;
$_SESSION["seleccionrem"]=$seleccionrem;
$_SESSION["cer1rem"]=$cer1rem;
$_SESSION["letrarem"]=$letrarem;
$_SESSION["cer2rem"]=$cer2rem;
$_SESSION["certificadorem"]=$cer1rem."".$letrarem."".$cer2rem;
$_SESSION["paisrem"]=$paisrem;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_rem_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
