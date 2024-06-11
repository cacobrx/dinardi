<?
/*
 * Creado el 12/03/2013 21:16:19
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_cli_act_save.php
 */
    
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$usuario=$usr->getId();
$id=$glo->getGETPOST("id");
$apellido=strtoupper($glo->getGETPOST("apellido"));
$nombre=strtoupper($glo->getGETPOST("nombre"));
$telefono=$glo->getGETPOST("telefono");
$celular=strtoupper($glo->getGETPOST("celular"));
$ciudad=$glo->getGETPOST("ciudad");
$cuit=$glo->getGETPOST("cuit");
$observaciones=$glo->getGETPOST("observaciones");
$tarea=$glo->getGETPOST("tarea");
$email=$glo->getGETPOST("email");
$condicioniva=$glo->getGETPOST("condicioniva");
$direccion=$glo->getGETPOST("direccion");
$saldoini=$glo->getGETPOST("saldoini");
$percepcioniibb=$glo->getGETPOST("percepcioniibb");
$diasvencimientofac=$glo->getGETPOST("diasvencimientofac");
$fechainicioctacte=$glo->getGETPOST("fechainicioctacte");
if($diasvencimientofac=="") $diasvencimientofac=0;
if($saldoini=="") $saldoini=0;
if($percepcioniibb=="") $percepcioniibb=0;
if($tarea=="A") {
    $aud->regAud("CLIENTES",$usr->getId(),"Ingresa Nuevo Cliente: $apellido",$centrosel);
    $ssql="insert into adm_cli (centro, apellido, nombre, celular, email, telefono, ciudad, cuit, observaciones, direccion, condicioniva, saldoini, percepcioniibb, diasvencimientofac, fechainicioctacte) values ($centrosel, '$apellido', '$nombre', '$celular', '$email', '$telefono', '$ciudad', '$cuit', '$observaciones', '$direccion', $condicioniva, $saldoini, $percepcioniibb, $diasvencimientofac, '$fechainicioctacte')";
} else {
    $aud->regAud("CLIENTES",$usr->getId(),"Modifica Cliente: $apellido",$centrosel);
    $ssql="update adm_cli set apellido='$apellido', nombre='$nombre', celular='$celular', telefono='$telefono', ciudad=$ciudad, cuit='$cuit', observaciones='$observaciones', email='$email', direccion='$direccion', condicioniva=$condicioniva, saldoini=$saldoini, percepcioniibb=$percepcioniibb, diasvencimientofac=$diasvencimientofac, fechainicioctacte='$fechainicioctacte', fechamod='".date("Y-m-d H:i:s")."' where id=$id";
}
$conx->getConsulta($ssql);
//echo $ssql;
?>
<html>
<body>
<form name="form1" id="form1" action="adm_cli_main.php" method="post">
<input name="limcli" id="limcli" type="hidden" value="<?= $limcli?>" />
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
