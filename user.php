<?
session_start();
$idusr=$_SESSION["iduser"];
if($idusr=="")
  header("location: index.php");
require_once("clases/usuarios.php");
require_once 'clases/centro.php';
$hoy=date("Y-m-d");
$usr=new usuarios_1($idusr);
$idusr=$usr->getId();
$usr_safip=$usr->getServidorafip();
$centrosel=$_SESSION["centrosel"];

// art
$limart=$_SESSION["limart"];
$textoart=$_SESSION["textoart"];
$rubroart=$_SESSION["rubroart"];
$ordenart=$_SESSION["ordenart"];

// rem_exp
$limexp=$_SESSION["limexp"];
$fechainiexp=$_SESSION["fechainiexp"];
$fechafinexp=$_SESSION["fechafinexp"];
$detalleexp=$_SESSION["detalleexp"];

// art
$limban=$_SESSION["limban"];

//elaboracion
$limela=$_SESSION["limela"];
$fechainiela=$_SESSION["fechainiela"];
$fechafinela=$_SESSION["fechafinela"];
$proveedorela=$_SESSION["proveedorela"];
$verdetalleela=$_SESSION["verdetalleela"];

//bandejas
$limband=$_SESSION["limband"];
$fechainiband=$_SESSION["fechainiband"];
$fechafinband=$_SESSION["fechafinband"];
$proveedorband=$_SESSION["proveedorenv"];


//envasado
$limenv=$_SESSION["limenv"];
$fechainienv=$_SESSION["fechainienv"];
$fechafinenv=$_SESSION["fechafinenv"];
$proveedorenv=$_SESSION["proveedorenv"];
$articuloenv=$_SESSION["articuloenv"];
$tunelenv=$_SESSION["tunelenv"];


// caja mov
$limcajm=$_SESSION["limcajm"];
$fechainicajm=$_SESSION["fechainicajm"];
$fechafincajm=$_SESSION["fechafincajm"];
$cajacajm=$_SESSION["cajacajm"];
$detallecajm=$_SESSION["detallecajm"];
$detalledivcajm=$_SESSION["detalledivcajm"];
$detallechtcajm=$_SESSION["detallechtcajm"];

//// pro
//$limart=$_SESSION["limpro"];
//$textoart=$_SESSION["textopro"];

// REMITOS
$limrem=$_SESSION["limrem"];
$fechainirem=$_SESSION["fechainirem"];
$fechafinrem=$_SESSION["fechafinrem"];
$detallerem=$_SESSION["detallerem"];
$proveedorrem=$_SESSION["proveedorrem"];
$faenarem=$_SESSION["faenarem"];
$seleccionrem=$_SESSION["seleccionrem"];
$certificadorem=$_SESSION["certificadorem"];
$paisrem=$_SESSION["paisrem"];
$articulosselrem=$_SESSION["articulosselrem"];

// control de REMITOS
$limcrm=$_SESSION["limcrm"];
$fechainicrm=$_SESSION["fechainicrm"];
$fechafincrm=$_SESSION["fechafincrm"];
$detallecrm=$_SESSION["detallecrm"];
$remitocrm=$_SESSION["remitocrm"];
$proveedorcrm=$_SESSION["proveedorcrm"];
        
////crem
$fechainicrem=$_SESSION["fechainicrem"];
$fechafincrem=$_SESSION["fechafincrem"];
$clientecrem=$_SESSION["clientecrem"];
$detallecrem=$_SESSION["detallecrem"];
$limcrem=$_SESSION["limcrem"];

////crec
$fechainicrec=$_SESSION["fechainicrec"];
$fechafincrec=$_SESSION["fechafincrec"];
$clientecrec=$_SESSION["clientecrec"];
$detallecrec=$_SESSION["detallecrec"];
$limcrec=$_SESSION["limcrec"];
$numerocrec=$_SESSION["numerocrec"];



//prv
$limprv=$_SESSION["limprv"];
$textoprv=$_SESSION["textoprv"];
$tipoprv=$_SESSION["tipoprv"];
$ordenprv=$_SESSION["ordenprv"];

// prv precios
$ordenprvp=$_SESSION["ordenprvp"];
$soloprecioprvp=$_SESSION["soloprecioprvp"];
$rubroprvp=$_SESSION["rubroprvp"];

// cli precios
$ordenclip=$_SESSION["ordenclip"];
$soloprecioclip=$_SESSION["soloprecioclip"];
$rubroclip=$_SESSION["rubroclip"];
$verpreciosclip=$_SESSION["verpreciosclip"];

//OPG
$limopg=$_SESSION["limopg"];
$fechainiopg=$_SESSION["fechainiopg"];
$fechafinopg=$_SESSION["fechafinopg"];

////cped
$fechainicped=$_SESSION["fechainicped"];
$fechafincped=$_SESSION["fechafincped"];
$clientecped=$_SESSION["clientecped"];
$detallecped=$_SESSION["detallecped"];
$limcped=$_SESSION["limcped"];


// cht
$fechainicht=$_SESSION["fechainicht"];
$fechafincht=$_SESSION["fechafincht"];
$campocht=$_SESSION["campocht"];
$camposelcht=$_SESSION["camposelcht"];
$limcht=$_SESSION["limcht"];
$tipocht=$_SESSION["tipocht"];
$filtrocht=$_SESSION["filtrocht"];
$tipofechacht=$_SESSION["tipofechacht"];
$criteriocht=$_SESSION["criteriocht"];
$primerocht=$_SESSION["primerocht"];
$chkfechacht=$_SESSION["chkfechacht"];
$bancocht=$_SESSION["bancocht"];


// cheques propios
$limche=$_SESSION["limche"];
$fechainiche=$_SESSION["fechainiche"];
$fechafinche=$_SESSION["fechafinche"];
$tipofechache=$_SESSION["tipofechache"];
$filtroche=$_SESSION["filtroche"];
$campoche=$_SESSION["campoche"];
$tipoche=$_SESSION["tipoche"];

// usuarios
$limusu=$_SESSION["limusu"];
$textousu=$_SESSION["textousu"];

// tablas
$limtab=$_SESSION["limtab"];
$tablasel=$_SESSION["tablasel"];
$textotab=$_SESSION["textotab"];

// fis
$fechainifis=$_SESSION["fechainifis"];
$fechafinfis=$_SESSION["fechafinfis"];
$fechainiinf=$_SESSION["fechainiinf"];
$fechafininf=$_SESSION["fechafininf"];
$clientefis=$_SESSION["clientefis"];
$limfis=$_SESSION["limfis"];
$numerofis=$_SESSION["numerofis"];
$ptoventafis=$_SESSION["ptoventafis"];
$letrafis=$_SESSION["letrafis"];
$tipocomfis=$_SESSION["tipocomfis"];
$deudafis=$_SESSION["deudafis"];
$vendedorfis=$_SESSION["vendedorfis"];
$detallefis=$_SESSION["detallefis"];
$ordenfis=$_SESSION["ordenfis"];
$totalpagfis=$_SESSION["totalpagfis"];
$lineasfis=$_SESSION["lineasfis"];

// rec
$limrec=$_SESSION["limrec"];
$fechainirec=$_SESSION["fechainirec"];
$fechafinrec=$_SESSION["fechafinrec"];
$centrorec=$_SESSION["centrorec"];
$cajarec=$_SESSION["cajarec"];

// opg
$limopg=$_SESSION["limopg"];
$detalleopg=$_SESSION["detalleopg"];
$fechainiopg=$_SESSION["fechainiopg"];
$fechafinopg=$_SESSION["fechafinopg"];
$proveedoropg=$_SESSION["proveedoropg"];
$cajaopg=$_SESSION["cajaopg"];

// clientes
$criteriocli=$_SESSION["criteriocli"];
$textocli=$_SESSION["textocli"];
$ordencli=$_SESSION["ordencli"];
$campocli=$_SESSION["campocli"];
$activosel=$_SESSION["activosel"];
$limcli=$_SESSION["limcli"];

// prd
$limprd=$_SESSION["limprd"];
$textoprd=$_SESSION["textoprd"];
$ordenprd=$_SESSION["ordenprd"];
$rubroprd=$_SESSION["rubroprd"];

// ciu
$limciu=$_SESSION["limciu"];
$textociu=$_SESSION["textociu"];

// auditoria
$limaud=$_SESSION["limaud"];
$fechainiaud=$_SESSION["fechainiaud"];
$fechafinaud=$_SESSION["fechafinaud"];
$usuarioaud=$_SESSION["usuarioaud"];
$centroaud=$_SESSION["centroaud"];
$textoaud=$_SESSION["textoaud"];

// cta
// cta
$limcta=$_SESSION["limcta"];
$textocta=$_SESSION["textocta"];

// mov
$textomov=$_SESSION["textomov"];
$fechainimov=$_SESSION["fechainimov"];
$fechafinmov=$_SESSION["fechafinmov"];
$asientomov=$_SESSION["asientomov"];
$textomov=$_SESSION["textomov"];
$limmov=$_SESSION["limmov"];
$detallemov=$_SESSION["detallemov"];

// may
$fechainimay=$_SESSION["fechainimay"];
$fechafinmay=$_SESSION["fechafinmay"];
$cuentasmay=$_SESSION["cuentasmay"];
$idctamay=$_SESSION["idctamay"];

// ajuste
$limaju=$_SESSION["limaju"];
$fechainiaju=$_SESSION["fechainiaju"];
$fechafinaju=$_SESSION["fechafinaju"];

// recibos
$fechainicrec=$_SESSION["fechainicrec"];
$fechafincrec=$_SESSION["fechafincrec"];
$textocrec=$_SESSION["textocrec"];
$clientecrec=$_SESSION["clientecrec"];
$limcrec=$_SESSION["limcrec"];

// opg
$fechainiopg=$_SESSION["fechainiopg"];
$fechafinopg=$_SESSION["fechafinopg"];
$criterioopg=$_SESSION["criterioopg"];
$filtroopg=$_SESSION["filtroopg"];
$campoopg=$_SESSION["campoopg"];
$limopg=$_SESSION["limopg"];
$tipocontabilidadopg=$_SESSION["tipocontabilidadopg"];
$campofechaopg=$_SESSION["campofechaopg"];
$tipoopg=$_SESSION["tipoopg"];

// compras
$fechainicom=$_SESSION["fechainicom"];
$fechafincom=$_SESSION["fechafincom"];
$limcom=$_SESSION["limcom"];
$proveedorcom=$_SESSION["proveedorcom"];
$campofechacom=$_SESSION["campofechacom"];
$movimientocom=$_SESSION["movimientocom"];
$numerocom=$_SESSION["numerocom"];
$sincomprasrem=$_SESSION["sincomprasrem"];
$tipocomcom=$_SESSION["tipocomcom"];
$detallecom=$_SESSION["detallecom"];

// compras
$fechainicva=$_SESSION["fechainicva"];
$fechafincva=$_SESSION["fechafincva"];
$limcva=$_SESSION["limcva"];
$proveedorcva=$_SESSION["proveedorcva"];
$campofechacva=$_SESSION["campofechacva"];
$movimientocva=$_SESSION["movimientocva"];
$descriptor1cva=$_SESSION["descriptor1cva"];
$descriptor2cva=$_SESSION["descriptor2cva"];
$descriptor3cva=$_SESSION["descriptor3cva"];
$descriptor4cva=$_SESSION["descriptor4cva"];
$ordencva=$_SESSION["ordencva"];
$numerocva=$_SESSION["numerocva"];
$letracva=$_SESSION["letracva"];

//moviemientos de caja

$limmcj=$_SESSION["limmcj"];
$fechainimcj=$_SESSION["fechainimcj"];
$fechafinmcj=$_SESSION["fechafinmcj"];
$cajamcj=$_SESSION["cajamcj"];
$textomcj=$_SESSION["textomcj"];
$descriptor1mcj=$_SESSION["descriptor1mcj"];
$descriptor2mcj=$_SESSION["descriptor2mcj"];
$descriptor3mcj=$_SESSION["descriptor3mcj"];
$descriptor4mcj=$_SESSION["descriptor4mcj"];
$segmento1mcj=$_SESSION["segmento1mcj"];
$segmento2mcj=$_SESSION["segmento2mcj"];
$segmento3mcj=$_SESSION["segmento3mcj"];
$segmento4mcj=$_SESSION["segmento4mcj"];
$oficinamcj=$_SESSION["oficinamcj"];
$tipopagomcj=$_SESSION["tipopagomcj"];
$paginarmcj=$_SESSION["paginarmcj"];
$tipomovmcj=$_SESSION["tipomovmcj"];
$vistamcj=$_SESSION["vistamcj"];

//adm_clasif
$limclf=$_SESSION["limclf"];
$cajaclf=$_SESSION["cajaclf"];
$tipoclf=$_SESSION["tipoclf"];
$depenclf=$_SESSION["depenclf"];
$ordenclf=$_SESSION["ordenclf"];

// gastos
$limgas=$_SESSION["limgas"];
$fechainigas=$_SESSION["fechainigas"];
$fechafingas=$_SESSION["fechafingas"];
$idprvgas=$_SESSION["idprvgas"];
$descriptor1gas=$_SESSION["descriptor1gas"];
$descriptor2gas=$_SESSION["descriptor2gas"];
$descriptor3gas=$_SESSION["descriptor3gas"];
$descriptor4gas=$_SESSION["descriptor4gas"];


// inf descriptores
$fechainides=$_SESSION["fechainides"];
$fechafindes=$_SESSION["fechafindes"];
$descriptor1des=$_SESSION["descriptor1des"];
$descriptor2des=$_SESSION["descriptor2des"];
$descriptor3des=$_SESSION["descriptor3des"];
$descriptor4des=$_SESSION["descriptor4des"];
$textodes=$_SESSION["textodes"];

// per
$limper=$_SESSION["limper"];

// eco
$anoeco=$_SESSION["anoeco"];

// otros ingresos
$limoin=$_SESSION["limoin"];
$fechainioin=$_SESSION["fechainioin"];
$fechafinoin=$_SESSION["fechafinoin"];

// transferencias
$limoin=$_SESSION["limtr"];
$fechainitr=$_SESSION["fechainitr"];
$fechafintr=$_SESSION["fechafintr"];
$tipotr=$_SESSION["tipotr"];

// inf
$fechainiinf=$_SESSION["fechainiinf"];
$fechafininf=$_SESSION["fechafininf"];
$paisinf=$_SESSION["paisinf"];
$articulosselinf=$_SESSION["articulosselinf"];

// empleados
$limemp=$_SESSION["limemp"];
$detalleemp=$_SESSION["detalleemp"];


//adelantos
$limade=$_SESSION["limade"];
$fechainiade=$_SESSION["fechainiade"];
$fechafinade=$_SESSION["fechafinade"];
$personalade=$_SESSION["personalade"];

//extras
$fechainiext=$_SESSION["fechainiext"];
$fechafinext=$_SESSION["fechafinext"];
$empleadoext=$_SESSION["empleadoext"];
$limext=$_SESSION["limext"];

//asistecias
$anomesasi=$_SESSION["anomesasi"];
$idempasi=$_SESSION["idempasi"];

//$fechainiasi=$_SESSION["fechainiasi"];
//$fechafinasi=$_SESSION["fechafinasi"];
//$limasi=$_SESSION["limasi"];
//$idperasi=$_SESSION["idperasi"];

//departamento
$limdep=$_SESSION["limdep"];

//Ingresos
$limhor=$_SESSION["limhor"];
$fechainihor=$_SESSION["fechainihor"];
$fechafinhor=$_SESSION["fechafinhor"];
$iddephor=$_SESSION["iddephor"];
$idemphor=$_SESSION["idemphor"];


$cen=new centro_1($centrosel);
?>
