<?php
/*
 * creado el 01/07/2016 15:43:08
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_alu_pag_imp_save
 */

require 'edd_user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/edd_num.php';
require_once 'clases/datesupport.php';
require_once 'clases/edd_alumnos.php';
require_once 'clases/edd_cur.php';
require_once("clases/edd_auditoria.php");
require_once 'clases/debug.php';
require_once 'clases/educativa.php';
$dbg=new debug();
$aud=new registra_auditoria();

$dsup=new datesupport();
$conx=new conexion();
$glo=new globalson();
$idalu=$glo->getGETPOST("idalu");
$idcur=$glo->getGETPOST("idcur");
$importe=$glo->getGETPOST("importe");
$importetotal=$glo->getGETPOST("importetotal");
$importepag=$glo->getGETPOST("importepag");
$fechapago=$glo->getGETPOST("fechapago");
$cuota=$glo->getGETPOST("cuota");
$fechaven=$glo->getGETPOST("fechaven");
$importe=$glo->getGETPOST("importe");
$prontopago=$glo->getGETPOST("prontopago");
$chkpp=$glo->getGETPOST("chkpp");
$alu=new edd_alumnos_1($idalu);
$cur=new edd_cur_1($idcur);
$cuotaini=$cuota;
$diapp=date("d",strtotime($fechapago));
$anomespp=date("Ym",strtotime($fechapago));
$anomesvn=date("Ym",strtotime($fechaven));
$archivo="log/p".date("Ymd").".log";
$conn=$conx->conectarBase();
$ssql="select sum(importe) as totalpag from edd_alu_pag where idalu=$idalu and idcur=$idcur and cuota=$cuota";
$rs=$conx->consultaBase($ssql, $conn);
$reg=mysqli_fetch_object($rs);
$pagadoant=$reg->totalpag;
$cuotaini=$cuota;
$cuerpo="Se realiza el pago:<br><br>";
$cuerpo.="IP: ".$_SERVER["REMOTE_ADDR"]."<br>";
$cuerpo.="Fecha y Hora: ".date("Y-m-d H:i:s")."<br>";
$cuerpo.="Centro: ".$cen->getNombre()."<br>";
$cuerpo.="Usuario: ".$usr->getApellido()." ".$usr->getNombre()."<br><br>";
$cuerpo.="Alumno: ".$alu->getLegajo()." ".$alu->getApellido()." ".$alu->getNombre()."<br>";
$cuerpo.="Curso: ".$cur->getNombrecurso()."<br><br>";
while($importepag>0) {
    //echo "importepag: $importepag<br>";
    $rec=new edd_num_act($centrosel, $conn);
    $recibo=$rec->getNumrecibo();
    if($idcur>0)
        $ssql="select * from edd_alu_cuo where cuota=$cuota and idalu=$idalu and idcur=$idcur";
    else
	$ssql="select * from edd_alu_cuo where cuota=$cuota and idalu=$idalu";
    if($conx->getCantidadRegA($ssql,$conn)==0) {
	$cuota=99;
	$ssql="select * from edd_alu_cuo where cuota=$cuota and idalu=$idalu and idcur=$idcur";
    }
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $anomesvn=date("Ym", strtotime($reg->fechaven));
    //echo "anomesvn: $anomesvn<br>";
    //echo "diapp: $diapp anomesvn: $anomesvn anomespp: $anomespp<br>";
    if(($diapp<=10 and $anomesvn>=$anomespp) or $chkpp==1 ) {
        // prontopago
        //echo "paso1<br>";
	if($cuota>0 and $cuota!=99) {
            $totalcuota=$reg->prontopago-$pagadoant;
            $tipopagoset=2;
            //echo "paso2<br>";
        } else {
            $totalcuota=$reg->importe-$pagadoant;
            $tipopagoset=1;
            //echo "paso3<br>";
        }
    } else {
        //echo "paso4<br>";
	if($cuota==1) {
            $totalcuota=$reg->prontopago-$pagadoant;
            $tipopagoset=2;
            //echo "paso5<br>";
        } else {
            //echo "paso6<br>";
            if($anomesvn>$anomespp) {
                //echo "paso7<br>";
                if($cuota==0 or $cuota==99) {
                    //echo "paso8<br>";
                    $totalcuota=$reg->importe-$pagadoant;
                    $tipopagoset=1;
                } else {
                    //echo "paso9<br>";
                    $totalcuota=$reg->prontopago-$pagadoant;
                    $tipopagoset=2;
                }
            } else {
                //echo "paso10<br>";
                $totalcuota=$reg->importe-$pagadoant;
                $tipopagoset=1;
            }
        }
    }
    //echo "tipopagoset: $tipopagoset<br>";
    //echo "totalcuota: $totalcuota<br>";
    //echo "importepag: $importepag<br>";
    if($importepag>=$totalcuota)
        $importeregistrar=$totalcuota;
    else
	$importeregistrar=$importepag;
    if($totalcuota>$importepag)
        $tipopagoset=0;
    //echo "importeregistrar: $importeregistrar<br>";
    if($importeregistrar>0) {
        $facturacion=$alu->getFacturacion();
        if($facturacion=="") $facturacion=0;
        $ssql="select * from edd_alu_pag where centro=$centrosel and idalu=$idalu and idcur=$idcur and importe=$importeregistrar and fechapago='$fechapago' and cuota=$cuota";
        if($conx->getCantidadRegA($ssql, $conn)==0) { 
            $ssql="insert into edd_alu_pag (centro, idalu, idcur, importe, fechapago, recibo, cuota, facturacion) values ($centrosel, $idalu, $idcur, $importeregistrar, '$fechapago', $recibo, $cuota, $facturacion)";
//            $dbg->WriteLog($ssql,$archivo);
            //echo $ssql."<br>";
            $conx->consultaBase($ssql, $conn);

            $ssql="update edd_alu_cuo set paraimprimir=1, pagado=$tipopagoset where idalu=$idalu and idcur=$idcur and cuota=$cuota";
            //echo $ssql."<br>";
            $conx->consultaBase($ssql, $conn);
            $aud->regAudC("Alumnos Pagos",$usr->getId(), "Pago del alumno ".$alu->getApellido()." ".$alu->getNombre()." cuota: $cuota - Importe: $importeregistrar - curso: ".$cur->getPlanestudio().$cur->getNumero(), $centrosel, $conn);
        }
    }
    //echo "importeregistrar: $importeregistrar<br>";
    $importepag-=$importeregistrar;
    //$dbg->WriteLog("Total Cuota: $totalcuota | Importepag: $importepag | importeregistrar: $importeregistrar","imp.log");
    $pagadoant=0;
    $cuerpo.="Cuota: $cuota<br>";
    $cuerpo.="Importe: $importeregistrar<br>";
    $cuota++;
    //$recibo++;
}
$cuota=$cuotaini;
$asunto="PAGO: ".$cen->getNombre()." - Alumno: ".$alu->getLegajo()." (".$alu->getId().") - Curso: ".$cur->getNombrecurso();

$cuerpo.="<br><br>Enviado desde eddis.edu.ar";
$header="From: ".$cen->getNombre()." <".$cen->getEmail().">\nContent-Type: text/html"; 
//mail("eddiscontrol@gmail.com", $asunto, $cuerpo, $header);
//echo $cuerpo;
// verificar que cuota cancelo completamente

// educativa
$edu=new existe_alumno($idalu);
if($edu->getRet()==0) {
    $edu=new agregar_alumno($idalu, $idcur);
    if($edu->getRet()==1)
        $mensaje="El alumno fue agregado a la plataforma Educativa";
    else
        $mensaje="El alumno ya se encuentra en la plataforma Educativa";
} else {
    $edu=new agregar_aula($idalu, $idcur);
    if($edu->getRet()==1)
        $mensaje="El alumno fue agregado a la plataforma Educativa";
    else
        $mensaje="El alumno ya se encuentra en la plataforma Educativa";
}
    
$aud->regAud("Educativa", $usr->getId(), "(Pago) ".$mensaje." | Alumno: ".$alu->getLegajo()." ".$alu->getApellido()." ".$alu->getNombre()." | Curso: ".$cur->getNombrecurso(), $centrosel, $idalu);


/*
$conn=$conx->conectarBase();
$ssql="select * from edd_alu_cuo where idalu=$idalu and idcur=$idcur and centro=$centrosel order by cuota";
$rs=$conx->consultaBase($ssql, $conn);
while($reg=mysqli_fetch_object($rs)) {
    $ssql="select * from edd_alu_pag where idalu=$idalu and idcur=$idcur and cuota=".$reg->cuota;
    $rp=$conx->consultaBase($ssql, $conn);
    $totalpagado=0;
    while($rep=mysqli_fetch_object($rp)) {
        $totalpagado+=$rep->importe;
	$fechapago=$rep->fechapago;
    }
    $tipopago=0;
    if($reg->cuota==99) {
        if($totalpagado==$reg->importe)
            $tipopago=1;	
    } else {
	if($totalpagado==$reg->importe)
            $tipopago=1;
	if($totalpagado==$reg->prontopago)
            $tipopago=2;
    }
    $ssql="update edd_alu_cuo set pagado=$tipopago where idalu=$idalu and idcur=$idcur and cuota=".$reg->cuota;
    //else
    //$ssql="update edd_alu_cuo set pagado=$tipopago where idalu=$idalu and cuota=".$reg->cuota;
    echo $ssql."<br>";
    $conx->consultaBase($ssql, $conn);

}
$conx->cerrarBase($conn);
*/

//$aud->regAud("Alumnos Pagos",$usr->getId(), "Agrega pago alumno: leg ".$alu->getLegajo()." ".$alu->getApellido()." ".$alu->getNombre(), $centrosel);

?>
<html>
<body>
    <form name="form1" id="form1" action="adm_alu_pag_prn_rec.php" method="post">
<input name="alumnosel" id="alumnosel" type="hidden" value="<?= $idalu?>" />
<input name="recibo" id="recibo" type="hidden" value="<?= $recibo?>" />
<input name="fechapago" id="fechapago" type="hidden" value="<?= $fechapago?>" />
<input name="idcur" id="idcur" type="hidden" value="<?= $idcur?>" />
<input name="importe" id="importe" type="hidden" value="<?= $importepag?>" />
<input name="cuota" id="cuota" type="hidden" value="<?= $cuota?>" />
<input name="fechaven" id="fechaven" type="hidden" value="<?= $fechaven?>" />
</form>
<script language="javascript">
document.form1.submit();
</script>
</body>
</html>
