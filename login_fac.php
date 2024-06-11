<?php
/*
 * creado el 19 jun. 2022 17:57:29
 * Usuario: gus
 * Archivo: login_fac
 */

session_start();
require_once("clases/globalson.php");
require_once("clases/conexion.php");
require_once("clases/auditoria.php");
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$hoy=date("Y-m-d");
$email=$glo->getGETPOST("email");
$clave=$glo->getGETPOST("clave");
$clavemd5=md5($clave);
$pasa=0;
$ssql="select * from usuarios where email='$email'";
if($conx->getCantidadReg($ssql)>0)
    $pasa=1;

if($pasa==1) {

    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $iduser=$reg->id;
    $_SESSION["iduser"]=$reg->id;
    $_SESSION["centrosel"]=$reg->centro;

    // pedidos
    $_SESSION["fechainiped"]=date("Y-m-01");
    $_SESSION["fechafinped"]=date("Y-m-d");

    // usuarios
    $_SESSION["limusu"]=0;
    $_SESSION["textousu"]="";

    // art
    $_SESSION["limart"]=0;
    $_SESSION["textoart"]="";
    $_SESSION["rubroart"]=0;
    $_SESSION["ordenart"]="codigodinardi";
    
    // exp
    $_SESSION["limexp"]=0;
    $_SESSION["fechainiexp"]= date("Y-m-01");
    $_SESSION["fechafinexp"]= date("Y-m-d");
    $_SESSION["detalleexp"]=0;
 

    // ban
    $_SESSION["limban"]=0;

    // art
    $_SESSION["limpro"]=0;
    $_SESSION["textopro"]="";

    //prv
    $_SESSION["limprv"]=0;
    $_SESSION["textoprv"]="";
    $_SESSION["tipoprv"]=1;
    $_SESSION["ordenprv"]=1;

    // prv precio
    $_SESSION["ordenprvp"]="codigodinardi";
    $_SESSION["soloprecioprvp"]=1;
    $_SESSION["rubroprvp"]=0;

    // cli precio
    $_SESSION["ordenclip"]="codigoproducto";
    $_SESSION["soloprecioclip"]=1;
    $_SESSION["rubroclip"]=0;
    $_SESSION["verpreciosclip"]=1;

    //OPG
    $_SESSION["limela"]=0;
    $_SESSION["fechainiela"]=date("Y-m-01");
    $_SESSION["fechafinela"]=date("Y-m-d");
    $_SESSION["proveedorela"]=0;
    $_SESSION["verdetalleela"]=0;
    
    $_SESSION["limenv"]=0;
    $_SESSION["fechainienv"]=date("Y-m-01");
    $_SESSION["fechafinenv"]=date("Y-m-d");
    $_SESSION["proveedorenv"]=0;
    $_SESSION["articuloenv"]=0;
    $_SESSION["tunelenv"]="";
    
    
    $_SESSION["limband"]=0;
    $_SESSION["fechainiband"]=date("Y-m-01");
    $_SESSION["fechafinband"]=date("Y-m-d");
    $_SESSION["proveedorband"]=0;
    
    
    $_SESSION["limopg"]=0;
    $_SESSION["fechainiopg"]=date("Y-m-01");
    $_SESSION["fechafinopg"]=date("Y-m-d");

    // cheques propios
    $_SESSION["limche"]=0;
    $_SESSION["fechainiche"]=date("Y-m-01");
    $_SESSION["fechafinche"]=date("Y-m-d", strtotime("$hoy + 30 days"));
    $_SESSION["tipofechache"]=1;
    $_SESSION["filtroche"]=0;
    $_SESSION["campoche"]="";
    $_SESSION["tipoche"]=0;

    
            // ciudad
    $_SESSION["limciu"]=0;
    $_SESSION["textociu"]="";


    // cheques terceros 
    $_SESSION["fechainicht"]=date("Y-m-01");
    $_SESSION["fechafincht"]=date("Y-m-d");
    $_SESSION["camposelcht"]="id";
    $_SESSION["campocht"]="";
    $_SESSION["filtrocht"]="";
    $_SESSION["limcht"]=0;
    $_SESSION["tipocht"]=0;
    $_SESSION["tipofechacht"]=0;
    $_SESSION["primerocht"]=1;
    $_SESSION["criteriocht"]=0;
    $_SESSION["chkfechacht"]=0;   
    $_SESSION["bancocht"]=0;


    // fis
    $_SESSION["fechainifis"]=date("Y-m-01");
    $_SESSION["fechafinfis"]=date("Y-m-d");
    $_SESSION["fechainiinf"]=date("Y-m-01");
    $_SESSION["fechafininf"]=date("Y-m-d");
    $_SESSION["clientefis"]="";
    $_SESSION["limfis"]=0;
    $_SESSION["numerofis"]="";
    $_SESSION["letrafis"]="";
    $_SESSION["ptoventafis"]=0;
    $_SESSION["tipocomfis"]="";
    $_SESSION["deudafis"]=0;
    $_SESSION["vendedorfis"]=0;
    $_SESSION["detallefis"]=0;
    $_SESSION["ordenfis"]=0;
    $_SESSION["totalpagfis"]=0;
    $_SESSION["lineasfis"]="";        

    // remitos
    $_SESSION["limrem"]=0;
    $_SESSION["fechainirem"]=date("Y-m-01");
    $_SESSION["fechafinrem"]=date("Y-m-d");
    $_SESSION["detallerem"]=0;
    $_SESSION["proveedorrem"]=0;
    $_SESSION["faenarem"]=0;
    $_SESSION["seleccionrem"]=0;

    // control de remitos
    $_SESSION["limcrm"]=0;
    $_SESSION["fechainicrm"]=date("Y-m-01");
    $_SESSION["fechafincrm"]=date("Y-m-d");
    $_SESSION["detallecrm"]=0;
    $_SESSION["remitocrm"]=0;
    $_SESSION["proveedorcrm"]=0;

    // pedidos
    $_SESSION["fechainicped"]=date("Y-m-01");
    $_SESSION["fechafincped"]=date("Y-m-d");
    $_SESSION["clientecped"]=0;
    $_SESSION["detallecped"]=0;
    $_SESSION["limcped"]=0;

    // remitos
    $_SESSION["fechainicrem"]=date("Y-m-01");
    $_SESSION["fechafincrem"]=date("Y-m-d");
    $_SESSION["clientecrem"]=0;
    $_SESSION["detallecrem"]=0;
    $_SESSION["limcrem"]=0;      

    // recibos
    $_SESSION["fechainicrec"]=date("Y-m-01");
    $_SESSION["fechafincrec"]=date("Y-m-d");
    $_SESSION["clientecrec"]=0;
    $_SESSION["detallecrec"]=0;
    $_SESSION["limcrec"]=0;    
    $_SESSION["numerocrec"]="";

    // tab
    $_SESSION["limtab"]=0;
    $_SESSION["tablasel"]=0;
    $_SESSION["textotab"]="";

    // rec
    $_SESSION["limrec"]=0;
    $_SESSION["fechainirec"]=date("Y-m-01");
    $_SESSION["fechafinrec"]=date("Y-m-d");
    $_SESSION["centrorec"]=0;
    $_SESSION["cajarec"]=0;


            // caja mov
    $_SESSION["limcajm"]=0;
    $_SESSION["fechainicajm"]=date("Y-m-d");
    $_SESSION["fechafincajm"]=date("Y-m-d");
    $_SESSION["cajacajm"]=0;
    $_SESSION["detallecajm"]=0;
    $_SESSION["detalledivcajm"]=0;
    $_SESSION["detallechtcajm"]=0;

    // opg
    $_SESSION["limopg"]=0;
    $_SESSION["fechainiopg"]=date("Y-m-01");
    $_SESSION["fechafinopg"]=date("Y-m-d");
    $_SESSION["proveedoropg"]=0;
    $_SESSION["cajaopg"]=0;
    $_SESSION["detalleopg"]=0;

    // prd
    $_SESSION["limprd"]=0;
    $_SESSION["textoprd"]="";
    $_SESSION["ordenprd"]="codigoproducto";
    $_SESSION["rubroprd"]=0;

    // ciudades
    $_SESSION["limciu"]=0;

    //clientes
    $_SESSION["campocli"]="N";
    $_SESSION["textocli"]="";
    $_SESSION["criteriocli"]=0;
    $_SESSION["ordencli"]=1;
    $_SESSION["activosel"]=1;
    $_SESSION["limcli"]=0;

    // auditoria
    $_SESSION["limaud"]=0;
    $_SESSION["fechainiaud"]=date("Y-m-01");
    $_SESSION["fechafinaud"]=date("Y-m-d");
    $_SESSION["usuarioaud"]=0;
    $_SESSION["centroaud"]=0;
    $_SESSION["textoaud"]="";

    // cta
    $_SESSION["limcta"]=0;
    $_SESSION["textocta"]="";

    // mov
    $_SESSION["textomov"]="";
    $_SESSION["fechainimov"]=date("Y-m-01");
    $_SESSION["fechafinmov"]=date("Y-m-d");
    $_SESSION["asientomov"]="";
    $_SESSION["limmov"]=0;
    $_SESSION["detallemov"]=0;

    // may
    $_SESSION["fechainimay"]=date("Y-m-01");
    $_SESSION["fechafinmay"]=date("Y-m-d");
    $_SESSION["cuentasmay"]="";
    $_SESSION["idctamay"]="";

    // ajustes
    $_SESSION["fechainiaju"]=date("Y-m-01");
    $_SESSION["fechafinaju"]=date("Y-m-d");
    $_SESSION["limaju"]=0;        

    // recibos
    $_SESSION["fechainicrec"]=date("Y-m-d", strtotime("$hoy - 1 month"));
    $_SESSION["fechafincrec"]=date("Y-m-d");
    $_SESSION["clientecrec"]=0;
    $_SESSION["textocrec"]="";
    $_SESSION["limcrec"]=0;

    // opg
    $_SESSION["fechainiopg"]=date("Y-m-01");
    $_SESSION["fechafinopg"]=date("Y-m-d");
    $_SESSION["limopg"]=0;
    $_SESSION["criterioopg"]=0;
    $_SESSION["filtroopg"]=0;
    $_SESSION["campoopg"]="";
    $_SESSION["tipocontabilidadopg"]=0;
    $_SESSION["campofechaopg"]="fecha";
    $_SESSION["tipoopg"]=0;

    // compras
    $_SESSION["fechainicom"]=date("Y-m-01");
    $_SESSION["fechafincom"]=date("Y-m-d");
    $_SESSION["limcom"]=0;
    $_SESSION["proveedorcom"]=0;
    $_SESSION["campofechacom"]="fecha";
    $_SESSION["movimientocom"]=0;
    $_SESSION["numerocom"]="";
    $_SESSION["sincomprasrem"]=0;
    $_SESSION["tipocomcom"]=0;
    $_SESSION["detallecom"]=0;

    // compras varias
    $_SESSION["fechainicva"]=date("Y-m-01");
    $_SESSION["fechafincva"]=date("Y-m-d");
    $_SESSION["limcva"]=0;
    $_SESSION["proveedorcva"]=0;
    $_SESSION["campofechacva"]="adm_com.fecha";
    $_SESSION["movimientocva"]=0;
    $_SESSION["descriptor1cva"]=0;
    $_SESSION["descriptor2cva"]=0;
    $_SESSION["descriptor3cva"]=0;
    $_SESSION["descriptor4cva"]=0;
    $_SESSION["ordencva"]="adm_com.fecha, adm_com.id";
    $_SESSION["numerocva"]="";
    $_SESSION["letracva"]="";


    //movimientos caja
    $_SESSION["limmcj"]=0;
    $_SESSION["fechainimcj"]=date("Y-m-01");
    $_SESSION["fechafinmcj"]=date("Y-m-d");
    $_SESSION["cajamcj"]=1;
    $_SESSION["textomcj"]="";
    $_SESSION["descriptor1mcj"]=0;
    $_SESSION["descriptor2mcj"]=0;
    $_SESSION["descriptor3mcj"]=0;
    $_SESSION["descriptor4mcj"]=0;
    $_SESSION["segmento1mcj"]=0;
    $_SESSION["segmento2mcj"]=0;
    $_SESSION["segmento3mcj"]=0;
    $_SESSION["segmento4mcj"]=0;
    $_SESSION["oficinamcj"]=0;
    $_SESSION["tipopagomcj"]=0;
    $_SESSION["paginarmcj"]=1;
    $_SESSION["tipomovmcj"]=0;
    $_SESSION["vistamcj"]=1;

    //clasif
    $_SESSION["limclf"]=0;
    $_SESSION["tipoclf"]="";
    $_SESSION["cajaclf"]=0;
    $_SESSION["depenclf"]=0;
    $_SESSION["ordenclf"]="texto";

    // eco
    $_SESSION["anoeco"]=date("Y");
    
    // gastos
    $_SESSION["fechainigas"]=date("Y-m-01");
    $_SESSION["fechafingas"]=date("Y-m-d");
    $_SESSION["idprvgas"]=0;
    $_SESSION["limgas"]=0;
    $_SESSION["descriptor1gas"]=0;
    $_SESSION["descriptor2gas"]=0;
    $_SESSION["descriptor3gas"]=0;
    $_SESSION["descriptor4gas"]=0;
    
    // per
    $_SESSION["limper"]=0;
    
    // otros ingresos
    $_SESSION["limoin"]=0;
    $_SESSION["fechainioin"]=date("Y-m-01");
    $_SESSION["fechafinoin"]=date("Y-m-d");
    
    // trnaferencias
    $_SESSION["limtr"]=0;
    $_SESSION["fechainitr"]=date("Y-m-01");
    $_SESSION["fechafintr"]=date("Y-m-d");
    $_SESSION["tipotr"]=0;
    
    // inf descriptores
    $_SESSION["fechainides"]=date("Y-m-01");
    $_SESSION["fechafindes"]=date("Y-m-d");
    $_SESSION["descriptor1des"]=0;
    $_SESSION["descriptor2des"]=0;
    $_SESSION["descriptor3des"]=0;
    $_SESSION["descriptor4des"]=0;
    
    $url="adm_fis_main.php";
    $error=0;
    $aud->regAud("Login Sistema", $reg->id, "Ingreso al sistema", $reg->centro);
} else {
    $error=1;
    $url="index.php";
    $iduser=0;
}
?>
<html>
<body>
<form id="form1" name="form1" action="<?= $url?>" method="post">
<input name="error" id="error" type="hidden" value="<?= $error?>">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
