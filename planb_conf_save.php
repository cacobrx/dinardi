<?
//print_r($_POST);
require_once 'user.php';
require_once("clases/conexion.php");
require_once("clases/globalson.php");
require_once 'clases/datesupport.php';
require_once 'clases/auditoria.php';
require_once 'clases/support.php';
$sup=new support();
$aud=new registra_auditoria();
$dsup=new datesupport();
$glo=new globalson();
$conx=new conexion();
$color1=$glo->getGETPOST("color1");
$colordescriptor1=$glo->getGETPOST("colordescriptor1");
$colordescriptor2=$glo->getGETPOST("colordescriptor2");
$colordescriptor3=$glo->getGETPOST("colordescriptor3");
$colordescriptor4=$glo->getGETPOST("colordescriptor4");
$colorbarra=$glo->getGETPOST("colorbarra");
$limmax=$glo->getGETPOST("limmax");
$piepagina=$glo->getGETPOST("piepagina");
$titulo=$glo->getGETPOST("titulo");
$cabecera=$glo->getGETPOST("cabecera");
$alturamarco=$glo->getGETPOST("alturamarco");
$cuentaentradaop=$glo->getGETPOST("cuentaentradaop");
$cuentasalidaop=$glo->getGETPOST("cuentasalidaop");
$diasvencimientocht=$glo->getGETPOST("diasvencimientocht");
$diasfinalcht=$glo->getGETPOST("diasfinalcht");
$minimoretenciones=$glo->getGETPOST("minimoretenciones");
if($minimoretenciones=="") $minimoretenciones=0;
$minimoretencionesser=$glo->getGETPOST("minimoretencionesser");
$fechainicioctacte=$glo->getGETPOST("fechainicioctacte");
if($minimoretencionesser=="") $minimoretencionesser=0;
if($diasfinalcht=="") $diasfinalcht=0;
if($diasvencimientocht=="") $diasvencimientocht=0;

if($cuentaentradaop=="") $cuentaentradaop=0;
if($cuentasalidaop=="") $cuentasalidaop=0;
if($limmax=="")
    $limmax=0;
if($alturamarco=="")
    $alturamarco=0;
$ssql="update planb_config set titulo='$titulo', cabecera='$cabecera', color1='$color1', colordescriptor1='$colordescriptor1', colordescriptor2='$colordescriptor2', colordescriptor3='$colordescriptor3', colordescriptor4='$colordescriptor4', colorbarra='$colorbarra', limmax=$limmax, piepagina='$piepagina', alturamarco=$alturamarco, cuentaentradaop=$cuentaentradaop, cuentasalidaop=$cuentasalidaop, ";
$ssql.="diasvencimientocht=$diasvencimientocht, diasfinalcht=$diasfinalcht, minimoretenciones=$minimoretenciones, minimoretencionesser=$minimoretencionesser, fechainicioctacte='$fechainicioctacte' ";
$ssql.="where id=$centrosel";
$conx->getConsulta($ssql);
$aud->regAud("Configuracion", $usr->getId(), "Ajusta configuracion centro: $centrosel", $centrosel); 
//echo $ssql;
?>
<html>
<body>
<form name="form1" id="form1" action="planb_conf.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
