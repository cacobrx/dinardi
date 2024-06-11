<?php
/*
 * Creado el 07/10/2019 12:48:06
 * Autor: gus
 * Archivo: inf_compras.php
 * planbsistemas.com.ar
 */

class inf_compras {
    var $articulos=array();
    var $cantidad=array();
    var $importe=array();
    var $iva=array();
    var $neto=array();
    var $idart=array();
    
    function __construct($fechaini, $fechafin, $orden, $idprv, $idart, $solofaena, $sinfaena) {
        require_once 'clases/conexion.php';
        require_once 'clases/support.php';
        require_once 'clases/adm_prv_pre.php';
        $conx=new conexion();
        $sup=new support();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_art";
        if($idart>0) $ssql.=" where id=$idart";
        $ssql.=" order by descripcion";
//        echo $ssql."<br>";
        $rs=$conx->consultaBase($ssql, $conn);
        $cad=array();
        while($reg=mysqli_fetch_object($rs)) {
//            $ssql="select sum(adm_crm_det.cantidad) as totcantidad, sum(adm_rem_det.cantidad*adm_rem_det.precio) as totimporte ";
//            $ssql.="from adm_rem_det, adm_rem ";
//            $ssql.="where adm_rem.fecha>='$fechaini' and adm_rem.fecha<='$fechafin' and adm_rem_det.idart=".$reg->id." and adm_rem.id=adm_rem_det.idrem";
//            if($idprv>0) $ssql.=" and adm_rem.idprv=$idprv ";
            
            
            $ssql="select adm_crm_det.*, adm_rem.idprv, adm_crm.idrem from adm_crm_det, adm_crm, adm_rem where adm_crm.fecha>='$fechaini' and adm_crm.fecha<='$fechafin' and adm_crm_det.idart=".$reg->id." and adm_crm.id=adm_crm_det.idcrm and adm_crm.idrem=adm_rem.id";
//            $ssql="select adm_crm_det.*, adm_crm.idprv, adm_crm.idrem from adm_crm_det, adm_crm where adm_crm.fecha>='$fechaini' and adm_crm.fecha<='$fechafin' and adm_crm_det.idart=".$reg->id." and adm_crm.id=adm_crm_det.idcrm";
            if($idprv>0) $ssql.=" and adm_rem.idprv=$idprv";
            if($solofaena==1) $ssql.=" and adm_rem.faena=1";
            if($sinfaena==1) $ssql.=" and adm_rem.faena=0";
            
            //echo $ssql."\n";
//            echo "cc: ".$conx->getCantidadRegA($ssql, $conn)."\n";
            $rd=$conx->consultaBase($ssql, $conn);
            $can=0;
            $imp=0;
            $neto=0;
            $iva=0;
            $control=array();
            while($rdd=mysqli_fetch_object($rd)) {
                $can+=$rdd->cantidad;
//                echo $ssql."\n";
                $ssql="select * from adm_fae_det where idcrm=".$rdd->idcrm." and idart=".$rdd->idart;
//                echo $ssql."\n";
                $pre=new adm_prv_pre_1($rdd->idprv, $rdd->idart, $conn);
                if($conx->getCantidadRegA($ssql, $conn)==0) {
//                    echo $pre->getPreciofinal()."<br>";
                    $coon="";
                    for($x=0;$x<count($control);$x++) {
                        $coon.="id!=".$control[$x]." and ";
                    }
                    if($coon!="") $coon=" and ".substr($coon,0,strlen($coon)-4);
                    
                    $ssql="select * from adm_rem_det where idrem=".$rdd->idrem." and idart=".$rdd->idart." and cantidadcrm=".$rdd->cantidad.$coon;
                    $ssql="select * from adm_rem_det where idrem=".$rdd->idrem." and idart=".$rdd->idart.$coon;
//                    echo $ssql."\n";
                    if($conx->getCantidadRegA($ssql, $conn)>0) {
                        $rt=$conx->consultaBase($ssql, $conn);
                        $rtt=mysqli_fetch_object($rt);
                        $imp+=$rdd->cantidad*$rtt->precio;
                        $ximp=$rdd->cantidad*$rtt->precio;
                        array_push($control, $rtt->id);
                        
//                        echo "cantidad: ".$rdd->cantidad." | precio: ".$rtt->precio."\n";
                    } else {
//                        echo "idart: ".$rdd->idart."\n";
                        $imp+=$rdd->cantidad*$pre->getPreciofinal();
                        $ximp=$rdd->cantidad*$pre->getPreciofinal();
                    }
                } else {
                    $rf=$conx->consultaBase($ssql, $conn);
                    $rff=mysqli_fetch_object($rf);
                    $imp+=$rdd->cantidad * $rff->precio;
                    $ximp=$rdd->cantidad * $rff->precio;
                }
                
                $alicuota=$pre->getAlicuota();
                $xneto=$ximp/(1+$alicuota/100);
                $xiva=$ximp-$xneto;
                $neto+=$xneto;
                $iva+=$xiva;
            }
////            echo $ssql."\n";
//            $rx=$conx->consultaBase($ssql, $conn);
//            $rxx=mysqli_fetch_object($rx);
//            if($rxx->totcantidad=="") $can=0; else $can=$rxx->totcantidad;
//            if($rxx->totimporte=="") $imp=0; else $imp=$rxx->totimporte;
            $cadx=$reg->descripcion."|$can|$imp|$neto|$iva|".$reg->id;
            switch ($orden) {
                case 1: // x cliente
                    $or=$reg->descripcion;
                    break;
                case 2: // x cantidad
                    $or=$sup->AddZeros($can,10);
                    break;
                case 3: // x importe
                    $or=$sup->AddZeros(number_format($imp*100,0,".",""),16);
                    break;
                    
            }
//            echo "cadx: $cadx\n";
            array_push($cad,$or."|".$cadx);
        }
        sort($cad);
        if($orden>1)
            $cadd= array_reverse($cad);
        else
            $cadd=$cad;
//        print_r($cad);
        for($i=0;$i<count($cadd);$i++) {
            $xcad=explode("|",$cadd[$i]);
            if($xcad[2]>0) {
                array_push($this->articulos,$xcad[1]);
                array_push($this->cantidad,$xcad[2]);
                array_push($this->importe,$xcad[3]);
                array_push($this->neto,$xcad[4]);
                array_push($this->iva,$xcad[5]);
                array_push($this->idart,$xcad[6]);
            }
        }
    }
    
    function getArticulo() {
        return $this->articulos;
    }
    
    function getCantidad() {
        return $this->cantidad;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getNeto() { return $this->neto; }
    function getIva() { return $this->iva; }
    function getIdart() { return $this->idart; }
}


class inf_compras_prv {
    var $articulos=array();
    var $cantidad=array();
    var $importe=array();
    var $iva=array();
    var $neto=array();
    
    function __construct($fechaini, $fechafin, $orden, $idprv, $idart, $solofaena, $sinfaena) {
        require_once 'clases/conexion.php';
        require_once 'clases/support.php';
        require_once 'clases/adm_prv_pre.php';
        require_once 'clases/adm_prv.php';
        require_once 'clases/adm_rem.php';
        $conx=new conexion();
        $sup=new support();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_prv";
        if($idprv>0) $ssql.=" where id=$idprv";
        $ssql.=" order by apellido, nombre";
//        echo $ssql."<br>";
        $rs=$conx->consultaBase($ssql, $conn);
        $cad=array();
        while($reg=mysqli_fetch_object($rs)) {
//            $ssql="select sum(adm_crm_det.cantidad) as totcantidad, sum(adm_rem_det.cantidad*adm_rem_det.precio) as totimporte ";
//            $ssql.="from adm_rem_det, adm_rem ";
//            $ssql.="where adm_rem.fecha>='$fechaini' and adm_rem.fecha<='$fechafin' and adm_rem_det.idart=".$reg->id." and adm_rem.id=adm_rem_det.idrem";
//            if($idprv>0) $ssql.=" and adm_rem.idprv=$idprv ";
            
            
            $ssql="select adm_crm_det.*, adm_rem.idprv, adm_crm.idrem from adm_crm_det, adm_crm, adm_rem where adm_crm.fecha>='$fechaini' and adm_crm.fecha<='$fechafin' and adm_rem.idprv=".$reg->id." and adm_crm.id=adm_crm_det.idcrm and adm_crm.idrem=adm_rem.id";
            if($idart>0) $ssql.=" and adm_crm_det.idart=$idart";
            if($solofaena==1) $ssql.=" and adm_rem.faena=1";
            if($sinfaena==1) $ssql.=" and adm_rem.faena=0";
//            echo $ssql."\n";
            $rd=$conx->consultaBase($ssql, $conn);
            $can=0;
            $imp=0;
            $neto=0;
            $iva=0;
            $control=array();
            while($rdd=mysqli_fetch_object($rd)) {
                $can+=$rdd->cantidad;
                $ssql="select * from adm_fae_det where idcrm=".$rdd->idcrm." and idart=".$rdd->idart;
//                echo $ssql."\n";
                $pre=new adm_prv_pre_1($rdd->idprv, $rdd->idart, $conn);
                if($conx->getCantidadRegA($ssql, $conn)==0) {
                    $coon="";
                    for($x=0;$x<count($control);$x++) {
                        $coon.="id!=".$control[$x]." and ";
                    }
                    if($coon!="") $coon=" and ".substr($coon,0,strlen($coon)-4);
                    $ssql="select * from adm_rem_det where idrem=".$rdd->idrem." and idart=".$rdd->idart.$coon;
//                    echo $ssql."<br>";
                    if($conx->getCantidadRegA($ssql, $conn)>0) {
                        $rt=$conx->consultaBase($ssql, $conn);
                        $rtt=mysqli_fetch_object($rt);
                        $imp+=$rdd->cantidad*$rtt->precio;
                        $ximp=$rdd->cantidad*$rtt->precio;
                        array_push($control, $rtt->id);
//                        echo "id: ".$rdd->id."<br>";
                    } else {
                        $imp+=$rdd->cantidad*$pre->getPreciofinal();
                        $ximp=$rdd->cantidad*$pre->getPreciofinal();
                    }
                } else {
                    $rf=$conx->consultaBase($ssql, $conn);
                    $rff=mysqli_fetch_object($rf);
                    $imp+=$rdd->cantidad * $rff->precio;
                    $ximp=$rdd->cantidad * $rff->precio;
                }
                
                $alicuota=$pre->getAlicuota();
                $xneto=$ximp/(1+$alicuota/100);
                $xiva=$ximp-$xneto;
                $neto+=$xneto;
                $iva+=$xiva;
            }
            
            // faenas
//            $ssql="select adm_rem_det.*, adm_rem.idprv, adm_rem_det.idrem from adm_rem_det, adm_rem where adm_rem.fecha>='$fechaini' and adm_rem.fecha<='$fechafin' and adm_rem.idprv=".$reg->id." and adm_rem.id=adm_rem_det.idrem";
//            if($idart>0) $ssql.=" and adm_rem_det.idart=$idart";
//
//            $rd=$conx->consultaBase($ssql, $conn);
//            while($rdd=mysqli_fetch_object($rd)) {
//                $rem=new adm_rem_1($rdd->idrem, $conn);
//                echo $rdd->idrem."|".$rem->getFaena()."\n";
//                if($rem->getFaena()==1) {
//
//                    $ssql="select * from adm_rem_det where idrem=".$rdd->idrem;
//                    echo $ssql."<br>";
//                    if($conx->getCantidadRegA($ssql, $conn)>0) {
//                        $rr=$conx->consultaBase($ssql, $conn);
//                        $rrr=mysqli_fetch_object($rr);
//                        $can+=$rdd->cantidad;
//                        $imp+=$rdd->cantidad*$rrr->precio;
//                        $ximp=$rdd->cantidad*$rrr->precio;
////                        echo $rdd->idrem."|ximp: ".$ximp."\n";
//                        $pre=new adm_prv_pre_1($rdd->idprv, $rdd->idart, $conn);
//                        $alicuota=$pre->getAlicuota();
//                        $xneto=$ximp/(1+$alicuota/100);
//                        $xiva=$ximp-$xneto;
//                        $neto+=$xneto;
//                        $iva+=$xiva;
//                    }
//                }
//            }



            
////            echo $ssql."\n";
//            $rx=$conx->consultaBase($ssql, $conn);
//            $rxx=mysqli_fetch_object($rx);
//            if($rxx->totcantidad=="") $can=0; else $can=$rxx->totcantidad;
//            if($rxx->totimporte=="") $imp=0; else $imp=$rxx->totimporte;
            $prv=new adm_prv_1($reg->id, $conn);
            $cadx=$prv->getApellido()." ".$prv->getNombre()."|$can|$imp|$neto|$iva";
            switch ($orden) {
                case 1: // x cliente
                    $or=$prv->getApellido()." ".$prv->getNombre();
                    break;
                case 2: // x cantidad
                    $or=$sup->AddZeros(number_format($can*100,0,".",""),10);
                    break;
                case 3: // x importe
                    $or=$sup->AddZeros(number_format($imp*100,0,".",""),16);
                    break;
                    
            }
//            echo "cadx: $cadx\n";
            array_push($cad,$or."|".$cadx);
        }
        sort($cad);
        if($orden>1)
            $cadd= array_reverse($cad);
        else
            $cadd=$cad;
//        print_r($cad);
        for($i=0;$i<count($cadd);$i++) {
            $xcad=explode("|",$cadd[$i]);
            if($xcad[2]>0) {
                array_push($this->articulos,$xcad[1]);
                array_push($this->cantidad,$xcad[2]);
                array_push($this->importe,$xcad[3]);
                array_push($this->neto,$xcad[4]);
                array_push($this->iva,$xcad[5]);
            }
        }
    }
    
    function getArticulo() {
        return $this->articulos;
    }
    
    function getCantidad() {
        return $this->cantidad;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getNeto() { return $this->neto; }
    function getIva() { return $this->iva; }
}