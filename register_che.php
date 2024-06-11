<?php
/*
 * Creado el 27/09/2018 21:09:19
 * Autor: gus
 * Archivo: register_che.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$tipofechache=$glo->getGETPOST("tipofechache");
$filtroche=$glo->getGETPOST("filtroche");
$tipoche=$glo->getGETPOST("tipoche");
$fechainiche=$glo->getGETPOST("fechainiche");
$fechafinche=$glo->getGETPOST("fechafinche");
$campoche=$glo->getGETPOST("campoche");
$limche=$glo->getGETPOST("limche");
if($limche=="")
    $limche=0;
$_SESSION["tipofechache"]=$tipofechache;
$_SESSION["filtroche"]=$filtroche;
$_SESSION["tipoche"]=$tipoche;
$_SESSION["fechainiche"]=$fechainiche;
$_SESSION["fechafinche"]=$fechafinche;
$_SESSION["campoche"]=$campoche;
$_SESSION["limche"]=$limche;
//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_che_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>