<?php
/*
 * Creado el 15/10/2015 17:38:03
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: register_ade
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();


$personalade=$glo->getGETPOST("personalade");
$fechainiade=$glo->getGETPOST("fechainiade");
$fechafinade=$glo->getGETPOST("fechafinade");
$limade=$glo->getGETPOST("limade");

if($limade=="")
    $limade=0;

$_SESSION["personalade"]=$personalade;
$_SESSION["fechainiade"]=$fechainiade;
$_SESSION["fechafinade"]=$fechafinade;
$_SESSION["limade"]=$limade;

//print_r($_SESSION);
?>
<html>
<body>
<form name="form1" id="form1" action="adm_adelantos_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>

