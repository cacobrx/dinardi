<?php
/*
 * Creado el 17/12/2018 11:22:07
 * Autor: gus
 * Archivo: adm_rem_det.php
 * planbsistemas.com.ar
 */

class adm_rem_det_2 {
    var $id=array();
    var $idrem=array();
    var $descripcion=array();
    var $animales=array();
    var $kilos=array();
    var $idart=array();
    var $cantidad=array();
    var $unidad=array();
    var $unidaddes=array();
//    var $idenv=array();
//    var $idela=array();
    var $precio=array();
    var $preciosiva=array();
    var $importe=array();
    var $total=array();
    var $totalremito=array();
    var $articulo=array();
    var $alicuota=array();
    var $iva=array();
    var $neto=array();
    var $crm_cantidad=array();
    var $crm_peso=array();
    var $crm_temperatura=array();
    var $crm_observaciones=array();
    var $crm_idart=array();
    var $crm_articulo=array();
    var $crm_unidad=array();
    var $crm_unidaddes=array();
    var $crm_idenv=array();
    var $crm_idela=array();
    var $frm_peso=array();
    var $frm_temperatura=array();
    var $frm_observaciones=array();
    var $frm_idart=array();
    var $frm_articulo=array();
    var $frm_unidad=array();
    var $frm_unidaddes=array();
    var $frm_idela=array();
    var $frm_idenv=array();
    var $neto0=array();
    var $neto10=array();
    var $neto21=array();
    var $iva0=array();
    var $iva10=array();
    var $iva21=array();
    
    var $netor0=array();
    var $netor10=array();
    var $netor21=array();
    var $ivar0=array();
    var $ivar10=array();
    var $ivar21=array();
    var $netor=array();
    var $ivar=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_art.php';
        require_once 'clases/adm_crm_det.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql,$conn);
            $xneto0=0;
            $xneto10=0;
            $xneto21=0;
            $xiva0=0;
            $xiva10=0;
            $xiva21=0;
            $xnetor0=0;
            $xnetor10=0;
            $xnetor21=0;
            $xivar0=0;
            $xivar10=0;
            $xivar21=0;
            //echo "gus1: $ssql\n";        
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->idrem,$reg->idrem);
                array_push($this->descripcion,$reg->descripcion);
                array_push($this->animales,$reg->animales);
                array_push($this->kilos,$reg->kilos);
                array_push($this->idart,$reg->idart);
                array_push($this->cantidad,$reg->cantidad);
                array_push($this->unidad,$reg->unidad);
//                array_push($this->idela,$reg->idela);
//                array_push($this->idenv,$reg->idenv);
                array_push($this->precio,$reg->precio);
                array_push($this->alicuota,$reg->alicuota);
                array_push($this->preciosiva, $reg->precio/(1+$reg->alicuota/100));
//                array_push($this->total,$reg->precio*$reg->cantidad);
                $tot=$reg->precio*$reg->cantidad;
                $imp=$reg->precio*$reg->cantidad;
                //echo "imp: $imp | Precio: ".$reg->precio."| Cantidad: ".$reg->cantidad."\n";
                $art=new adm_art_1($reg->idart,$conn);       
                array_push($this->articulo,$art->getDescripcion());
                array_push($this->importe,$reg->cantidad*$reg->precio);
                array_push($this->unidaddes,$conx->getTextoValor($reg->unidad, "UNI", $conn));
                $ssql="select adm_crm_det.* from adm_crm_det, adm_crm where adm_crm_det.idart=".$reg->idart." and adm_crm.idrem=".$reg->idrem." and adm_crm_det.idcrm=adm_crm.id and adm_crm_det.idremdet=".$reg->id;
//                $ssql="select adm_crm_det.* from adm_crm_det inner join adm_crm on adm_crm_det.idcrm=adm_crm.id where adm_crm.idrem=".$reg->idrem;                
//                echo "rem_det_2: $ssql\n";
                if($conx->getCantidadRegA($ssql, $conn)>0) {
                    $rc=$conx->consultaBase($ssql, $conn);
                    $rcc=mysqli_fetch_object($rc);
                    array_push($this->crm_cantidad,$rcc->cantidad);
                    array_push($this->crm_peso,$rcc->peso);
                    array_push($this->crm_temperatura,$rcc->temperatura);
//                    array_push($this->total,$reg->precio*$rcc->cantidad);
                    array_push($this->crm_observaciones,$rcc->observaciones);
                    array_push($this->crm_idart,$rcc->idart);
                    $cart=new adm_art_1($rcc->idart, $conn);
                    array_push($this->crm_articulo,$cart->getDescripcion());
                    array_push($this->crm_unidad,$rcc->unidad);
                    array_push($this->crm_unidaddes,$conx->getTextoValor($rcc->unidad, "UNI", $conn));
                    array_push($this->crm_idela,$rcc->idela);
                    array_push($this->crm_idenv,$rcc->idenv);
                    $tot=$reg->precio*$rcc->cantidad;
                    //echo "tot: $tot | Precio: ".$reg->precio."| Cantidad: ".$rcc->cantidad."\n";
                } else {
                    array_push($this->crm_cantidad,"");
                    array_push($this->crm_peso,"");
                    array_push($this->crm_temperatura,"");
//                    array_push($this->total,$reg->precio*$reg->cantidad);
                    array_push($this->crm_observaciones,"");
                    array_push($this->crm_idart,0);
                    array_push($this->crm_articulo,"");
                    array_push($this->crm_unidad,"");
                    array_push($this->crm_unidaddes,"");
                    array_push($this->crm_idela,0);
                    array_push($this->crm_idenv,0);
                }
                //$tot=$imp;
                array_push($this->total,$tot);
                $neto=$tot / (1 + $reg->alicuota/100);
//                echo "neto: $neto\n";
                $iva=$tot-$neto;
                //echo "iva: $iva\n";
                array_push($this->neto, $neto);
                array_push($this->iva,$iva);
                
                array_push($this->totalremito,$imp);
                $netor=$imp / (1 + $reg->alicuota/100);
//                echo "netor: $netor\n";
                $ivar=$imp-$netor;
//                echo "iva: $ivar\n";
                array_push($this->netor, $netor);
                array_push($this->ivar,$ivar);
                
                $ssql="select adm_crm_det.* from adm_crm_det, adm_crm where adm_crm_det.idcrm=adm_crm.id and adm_crm.idrem=".$reg->idrem;
//                echo "rem_det: $ssql\n";
                $crm=new adm_crm_det_2($ssql, $conn);
                $this->frm_articulo=$crm->getArticulo();
                $this->frm_idart=$crm->getIdart();
                $this->frm_observaciones=$crm->getObservaciones();
                $this->frm_idela=$crm->getIdela();
                $this->frm_idenv=$crm->getIdenv();
                $this->frm_peso=$crm->getPeso();
                $this->frm_temperatura=$crm->getTemperatura();
                $this->frm_unidad=$crm->getUnidad();
                $this->frm_unidaddes=$crm->getUnidaddes();
                
                //echo $reg->idart." ".$reg->alicuota."\n";
                $xneto10=0;
                $xneto21=0;
                $xneto0=0;
                $xiva10=0;
                $xiva21=0;
                $xiva0=0;
                $xnetor10=0;
                $xnetor21=0;
                $xnetor0=0;
                $xivar10=0;
                $xivar21=0;
                $xivar0=0;
                
                switch ($reg->alicuota) {
                    case 0:
                        $xneto0=$neto;
                        $xiva0=$iva;
                        $xnetor0=$netor;
                        $xivar0=$ivar;
                        break;
                    case 10.5:
                        $xneto10=$neto;
                        $xiva10=$iva;
                        $xnetor10=$netor;
                        $xivar10=$ivar;
                        break;
                    case 21:
                        $xneto21=$neto;
                        $xiva21=$iva;
                        $xnetor21=$netor;
                        $xivar21=$ivar;
                        break;
                }
//                echo "netor10: $xnetor10\n";
//                echo "neto10: $xneto10\n";
                array_push($this->neto0,$xneto0);
                array_push($this->neto10,$xneto10);
                array_push($this->neto21,$xneto21);
                array_push($this->iva0,$xiva0);
                array_push($this->iva10,$xiva10);
                array_push($this->iva21,$xiva21);
                
                array_push($this->netor0,$xnetor0);
                array_push($this->netor10,$xnetor10);
                array_push($this->netor21,$xnetor21);
                array_push($this->ivar0,$xivar0);
                array_push($this->ivar10,$xivar10);
                array_push($this->ivar21,$xivar21);
                
//                array_push($this->total,$xneto0+$xneto10+$xneto21+$xiva10+$xiva21);
            }    
        }
    }

    function getId() { return $this->id; }
    function getIdrem() { return $this->idrem; }
    function getAnimales() { return $this->animales; }
    function getKilos() { return $this->kilos; }
//    function getIdela() { return $this->idela; }
//    function getIdenv() { return $this->idenv; }
    function getCantidad() { return $this->cantidad; }
    function getUnidad() { return $this->unidad; }
    function getUnidaddes() { return $this->unidaddes; }
    function getIdart() { return $this->idart; }
    function getArticulo() { return $this->articulo; }
    function getDescripcion() { return $this->descripcion; }
    function getPrecio() { return $this->precio; }
    function getPreciosiva() { return $this->preciosiva; }
    function getImporte() { return $this->importe; }
    function getTotal() { return $this->total; }
    function getAlicuota() { return $this->alicuota; }
    function getCrm_cantidad() { return $this->crm_cantidad; }
    function getCrm_peso() { return $this->crm_peso; }
    function getCrm_temperatura() { return $this->crm_temperatura; }
    function getCrm_observaciones() { return $this->crm_observaciones; }
    function getCrm_idart() { return $this->crm_idart; }
    function getCrm_articulo() { return $this->crm_articulo; }
    function getCrm_unidad() { return $this->crm_unidad; }
    function getCrm_unidaddes() { return $this->crm_unidaddes; }
    function getCrm_idenv() { return $this->crm_idenv; }
    function getCrm_idela() { return $this->crm_idela; }
    
    function getFrm_articulo() { return $this->frm_articulo; }
    function getFrm_idart() { return $this->frm_idart; }
    function getFrm_observaciones() { return $this->frm_observaciones; }
    function getFrm_peso() { return $this->frm_peso; }
    function getFrm_temperatura() { return $this->frm_temperatura; }
    function getFrm_unidad() { return $this->frm_unidad; }
    function getFrm_unidaddes() { return $this->frm_unidaddes; }
    function getFrm_cantidad() { return $this->frm_peso; }
    function getFrm_idela() { return $this->frm_idela; }
    function getFrm_idenv() { return $this->frm_idenv; }
    
    function getIva() { return $this->iva; }
    function getNeto() { return $this->neto; }
    function getNeto0() { return $this->neto0; }
    function getNeto10() { return $this->neto10; }
    function getNeto21() { return $this->neto21; }
    function getIva0() { return $this->iva0; }
    function getIva10() { return $this->iva10; }
    function getIva21() { return $this->iva21; }
  
    function getIvar() { return $this->ivar; }
    function getNetor() { return $this->netor; }
    function getNetor0() { return $this->netor0; }
    function getNetor10() { return $this->netor10; }
    function getNetor21() { return $this->netor21; }
    function getIvar0() { return $this->ivar0; }
    function getIvar10() { return $this->ivar10; }
    function getIvar21() { return $this->ivar21; }
    
    function getTotalremito() { return $this->totalremito; }
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}
