<?php
/*
 * Creado el 28/08/2019 09:24:13
 * Autor: gus
 * Archivo: adm_crec_act_save.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_cht.php';
require_once 'clases/adm_crec.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();

$tarea=$glo->getGETPOST("tarea");
$fecha=$glo->getGETPOST("fecha");
$idcli=$glo->getGETPOST("idcli");
$canti=$glo->getGETPOST("canti");
$cantf=$glo->getGETPOST("cantf");
$concepto=$glo->getGETPOST("concepto");
$idrec=$glo->getGETPOST("idrec");
$clave=$sup->generateKey();
$importe=$glo->getGETPOST("importe");
$caja=$glo->getGETPOST("caja");
$numero=$glo->getGETPOST("numero");
if($numero=="") $numero=0;
$conn=$conx->conectarBase();
$eee=0;
if($tarea=="A") {
    $ssql="select * from adm_crec1 where fecha='$fecha' and idcli=$idcli and concepto='$concepto' and numero=$numero";
    $eee=$conx->getCantidadRegA($ssql, $conn);
}
if($eee==0) { 
    if($tarea=="A") {
        $ssql="insert into adm_crec1 (fecha, idcli, concepto, clave, caja, numero) values ('$fecha', $idcli, '$concepto', '$clave', $caja, $numero)";
    } else {
        $ssql="update adm_crec1 set fecha='$fecha', idcli=$idcli, concepto='$concepto', caja=$caja, numero=$numero where id=$idrec";
    }
    $conx->consultaBase($ssql, $conn);
//    echo $ssql."<br>";
    if($tarea=="A")
        $id=$conx->getLastId("adm_crec1", $conn);
    else {
        $id=$idrec;
    }
    $ssql="delete from adm_crec2 where idcrec=$id";
    $conx->consultaBase($ssql, $conn);

    for($i=0;$i<$cantf;$i++) {
        $idcped="idcped$i";
        $importetot="importetot$i";
        $pagar="pagar$i";
        $$idcped=$glo->getGETPOST($idcped);
        $$importetot=$glo->getGETPOST($importetot);
        $$pagar=$glo->getGETPOST($pagar);
        if($$pagar>0) {
            $ssql="insert into adm_crec2 (idcrec, idfis, importe, importepago, clave) values ($id, ".$$idcped.", ".$$importetot.", ".$$pagar.", '$clave')";
            $conx->consultaBase($ssql, $conn);
            $ssql="update adm_fis set importepago=importepago + ".$$pagar." where id=".$$idcped;
            $conx->consultaBase($ssql, $conn);
    //        echo $ssql."<br>";
        }
    }
    // borro los cheques para la modificación
    if($tarea=="M") {
        $condicionche="";
        for($i=0;$i<$canti;$i++) {
            $chequepro="chequepro$i";
            $$chequepro=$glo->getGETPOST("chequepro");
            if($$chequepro>0)
                $condicionche.="id=".$$chequepro." or ";
        }
        
        if($chequepro!="") {
            $ssql="delete from adm_cht where ".substr($condicionche,0,strlen($condicionche)-4);
            $conx->consultaBase($ssql, $conn);
        }
    }
    
    
    
    $ssql="delete from adm_crec3 where idcrec=$id";
    $conx->consultaBase($ssql, $conn);
    for($i=0;$i<$canti;$i++) {
        $detallepago="detallepago$i";
        $detalle="detalle$i";
        $chequepro="chequepro$i";
        $importedet="importedet$i";
        $ch_banco="ch_banco$i";
        $ch_nrocheque="ch_nrocheque$i";
        $$ch_nrocheque=$glo->getGETPOST($ch_nrocheque);
        $$ch_banco=$glo->getGETPOST($ch_banco);
        $$detallepago=$glo->getGETPOST($detallepago);
        $$detalle=$glo->getGETPOST($detalle);
        $$chequepro=$glo->getGETPOST($chequepro);
        $$importedet=$glo->getGETPOST($importedet);
        if($$chequepro=="") $$chequepro=0;
        if($$importedet>0) {
            $ssql="insert into adm_crec3 (idcrec, detallepago, detalle, importe, tmpcht) values ($id, ".$$detallepago.", '".$$detalle."', ".$$importedet.", ".$$chequepro.")";
            $conx->consultaBase($ssql, $conn);
    //        echo $ssql."<br>";
            if($chequepro>0) {
                $ssql="insert into adm_cht (idbanco, nrocheque, fechaorigen, fechapago, importe, nombre, cliente, idcli, fecha) values (";
                $ssq.=$$ch_banco.", ".$$ch_nrocheque.", ";

            }
        }
    }

    // ingresa cheque propio
    $condiciondelcht="";
    for($i=0;$i<$canti;$i++) {
        $chequepro="chequepro$i";
        $$chequepro=$glo->getGETPOST($chequepro);
        if($$chequepro) {
            $cht=new tmp_cht_1($$chequepro, $conn);
            if($cht->getIdbanco()>0) {
                $ssql="insert into adm_cht (idbanco, nrocheque, fechaorigen, fechapago, importe, nombre, cliente, idcli, fecha) values (";
                $ssql.=$cht->getIdbanco().", ".$cht->getNrocheque().", '".$cht->getFechaorigen()."', '".$cht->getFechapago()."', ".$cht->getImporte();
                $ssql.=", '".$cht->getNombre()."', '".$cht->getCliente()."', ".$cht->getIdcli().", '".date("Y-m-d")."')";
                $conx->consultaBase($ssql, $conn);
//                echo $ssql."<br>";
                $idcht=$conx->getLastId("adm_cht",$conn);
                $ssql="update adm_crec3 set idcht=$idcht where tmpcht=".$$chequepro;
                $conx->consultaBase($ssql, $conn);
                $condiciondelcht.="id=".$$chequepro." or ";
            }
        }
    }
    if($condiciondelcht!="") {
        $ssql="delete from tmp_cht where ".substr($condiciondelcht,0,strlen($condiciondelcht)-4);
        $conx->consultaBase($ssql, $conn);
    }
    
    // agrego el cheque que ya estaba ingresado
    
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_crec_main.php" method="post">
            
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>
