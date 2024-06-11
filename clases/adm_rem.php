<?php
/*
 * Creado el 17/12/2018 11:06:33
 * Autor: gus
 * Archivo: adm_rem.php
 * planbsistemas.com.ar
 */

class adm_rem_1 {
    var $id=0;
    var $fecha='';
    var $idprv=0;
    var $proveedor="";
    var $observaciones="";
    var $direccion="";
    var $total=0;
    var $neto=0;
    var $iva=0;
    var $idcom=0;
    var $patente="";
    var $ptovta=0;
    var $numero=0;
    var $certificado=0;
    var $det_id=array();
    var $det_idrem=array();
    var $det_descripcion=array();
    var $det_animales=array();
    var $det_kilos=array();
    var $det_idart=array();
    var $det_cantidad=array();
    var $det_unidad=array();
    var $det_unidaddes=array();
    var $det_idela=array();
    var $det_idenv=array();
    var $det_precio=array();
    var $det_importe=array();
    var $det_total=array();
    var $det_articulo=array();
    var $det_alicuota=array();
    var $crm_cantidad=array();
    var $crm_peso=array();
    var $crm_temperatura=array();
    var $crm_unidad=array();
    var $crm_unidades=array();
    var $crm_articulo=array();
    var $crm_idart=array();
    var $crm_observaciones=array();
    var $crm_idela=array();
    var $crm_idenv=array();
    var $faena=0;
    var $faenac=0;
    var $seleccion=0;
    var $controlado=0;
    var $paises="";
    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_prv.php';
        require_once 'clases/adm_rem_det.php';
        require_once 'clases/adm_crm.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_rem where id=$id";
        $nn=0;
        $ii=0;
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql,$conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->fecha=$reg->fecha;
            $this->idprv=$reg->idprv;
            $this->observaciones=$reg->observaciones;
            $this->idcom=$reg->idcom;
            $this->faenac=$reg->faena;
            $this->patente=$reg->patente;
            $this->ptovta=$reg->ptovta;
            $this->numero=$reg->numero;
            $this->controlado=$reg->controlado;
            $this->certificado=$reg->certificado;
            $prv=new adm_prv_1($reg->idprv,$conn);
            $this->direccion=$prv->getDireccion();
            $this->proveedor=$prv->getApellido();
            $this->paises=$prv->getPaisesnom();
            $ssql="select * from adm_rem_det where idrem=".$reg->id;
            $det=new adm_rem_det_2($ssql, $conn);
            $this->det_id=$det->getId();
            $this->det_idrem=$det->getIdrem();
            $this->det_animales=$det->getAnimales();
            $this->det_kilos=$det->getKilos();
            $this->det_idart=$det->getIdart();
            $this->det_cantidad=$det->getCantidad();
            $this->det_descripcion=$det->getDescripcion();
            $this->det_unidad=$det->getUnidad();
            $this->det_idela=$det->getCrm_idela();
            $this->det_idenv=$det->getCrm_idenv();
            $this->det_unidaddes=$det->getUnidaddes();
            $this->det_precio=$det->getPrecio();
            $this->det_importe=$det->getImporte();
            $this->det_total=$det->getTotal();
            $this->det_alicuota=$det->getAlicuota();
            $this->det_articulo=$det->getArticulo();
            $this->total=array_sum($det->getTotal());
            $this->seleccion=$reg->seleccion;
            
            $xart=$det->getIdart();
            if(count($xart)>0) {
                if($xart[0]==0) {
                    $this->faena=1; 
                    $this->crm_cantidad=$det->getFrm_cantidad();
                    $this->crm_peso=$det->getFrm_peso();
                    $this->crm_temperatura=$det->getFrm_temperatura();
                    $this->crm_articulo=$det->getFrm_articulo();
                    $this->crm_unidades=$det->getFrm_unidaddes();
                    $this->crm_observaciones=$det->getFrm_observaciones();
                    $this->crm_idart=$det->getFrm_idart();
                    $this->crm_idela=$det->getFrm_idela();
                    $this->crm_idenv=$det->getFrm_idenv();
                } else {
                    $this->faena=0;
                    $this->crm_cantidad=$det->getCrm_cantidad();
                    $this->crm_peso=$det->getCrm_peso();
                    $this->crm_temperatura=$det->getCrm_temperatura();
                    $this->crm_articulo=$det->getCrm_articulo();
                    $this->crm_unidades=$det->getCrm_unidaddes();
                    $this->crm_observaciones=$det->getCrm_observaciones();
                    $this->crm_idart=$det->getCrm_idart();
                    $this->crm_idela=$det->getCrm_idela();
                    $this->crm_idenv=$det->getCrm_idenv();
                }
            } else {
                $this->faena=0;
                $this->crm_cantidad=$det->getCrm_cantidad();
                $this->crm_peso=$det->getCrm_peso();
                $this->crm_temperatura=$det->getCrm_temperatura();
                $this->crm_articulo=$det->getCrm_articulo();
                $this->crm_unidades=$det->getCrm_unidaddes();
                $this->crm_observaciones=$det->getCrm_observaciones();
                $this->crm_idart=$det->getCrm_idart();
                $this->crm_idela=$det->getCrm_idela();
                $this->crm_idenv=$det->getCrm_idenv();
            }
        }
        
    }

    function getId() {
        return $this->id;
    }
  
    function getIdprv() {
        return $this->idprv;
    }
  
    function getFecha() {
        return $this->fecha;
    }
    
    function getProveedor() {
        return $this->proveedor;
    }
    
    function getDireccion() {
        return $this->direccion;
    }    
  
    function getTotal() {
        return $this->total;
    }
    
    function getIdcom() { return $this->idcom; }
    
    function getFaena() { return $this->faena; }
    
    function getObservaciones() { return $this->observaciones; }
    
    function getDet_id() { return $this->det_id; }
    function getDet_idrem() { return $this->det_idrem; }
    function getDet_descripcion() { return $this->det_descripcion; }
    function getDet_animales() { return $this->det_animales; }
    function getDet_kilos() { return $this->det_kilos; }
    function getDet_idart() { return $this->det_idart; }
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_unidad() { return $this->det_unidad; }
    function getDet_unidaddes() { return $this->det_unidaddes; }
    function getDet_precio() { return $this->det_precio; }
    function getDet_importe() { return $this->det_importe; }
    function getDet_idela() { return $this->det_idela; }
    function getDet_idenv() { return $this->det_idenv; }
    function getDet_total() { return $this->det_total; }
    function getDet_articulo() { return $this->det_articulo; }
    function getDet_alicuota() { return $this->det_alicuota; }
    function getCrm_cantidad() { return $this->crm_cantidad; }
    function getCrm_peso() { return $this->crm_peso; }
    function getCrm_temperatura() { return $this->crm_temperatura; }
    function getCrm_articulo() { return $this->crm_articulo; }
    function getCrm_unidad() { return $this->crm_unidad; }
    function getCrm_unidaddes() { return $this->crm_unidades; }
    function getCrm_observaciones() { return $this->crm_observaciones; }
    function getCrm_idart() { return $this->crm_idart; }
    function getCrm_idenv() { return $this->crm_idenv; }
    function getCrm_idela() { return $this->crm_idela; }
    
    function getFaenac() { return $this->faenac; }
    function getPatente() { return $this->patente; }
    function getPtovta() { return $this->ptovta; }
    function getNumero() { return $this->numero; }
    function getSeleccion() { return $this->seleccion; }
    function getControlado() { return $this->controlado; }
    function getPaises() { return $this->paises; }
    function getCertificado() { return $this->certificado; }
    
}

class adm_rem_2 {
    var $id=array();
    var $fecha=array();
    var $idprv=array();
    var $proveedor=array();
    var $direccion=array();
    var $paises=array();
    var $observaciones=array();
    var $total=array();
    var $idcom=array();
    var $patente=array();
    var $ptovta=array();
    var $numero=array();
    var $certificado=array();
    var $det_id=array();
    var $det_idrem=array();
    var $det_descripcion=array();
    var $det_animales=array();
    var $det_kilos=array();
    var $det_idart=array();
    var $det_cantidad=array();
    var $det_unidad=array();
    var $det_unidaddes=array();
    var $det_precio=array();
    var $det_preciosiva=array();
    var $det_importe=array();
    var $det_total=array();
    var $det_alicuota=array();
    var $det_articulo=array();
    var $crm_cantidad=array();
    var $crm_temperatura=array();
    var $crm_observaciones=array();
    var $crm_idart=array();
    var $crm_articulo=array();
    var $crm_unidad=array();
    var $crm_unidaddes=array();
    var $crm_idela=array();
    var $crm_idenv=array();
    var $faena=array();
    var $faenac=array();
    var $importeiva=array();
    var $importeneto=array();
    var $neto0=array();
    var $neto10=array();
    var $neto21=array();
    var $iva0=array();
    var $iva10=array();
    var $iva21=array();
    
    var $totalremito=array();
    var $importeivar=array();
    var $importenetor=array();
    var $netor0=array();
    var $netor10=array();
    var $netor21=array();
    var $ivar0=array();
    var $ivar10=array();
    var $ivar21=array();
    
    var $seleccion=array();
    
    var $controlado=array();
    
//    var $idela=array();
//    var $idenv=array();
    var $fechaela=array();
    var $fechaenv=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_prv.php';
        require_once 'clases/adm_rem_det.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql,$conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->fecha,$reg->fecha);
                array_push($this->idprv,$reg->idprv);
                array_push($this->observaciones,$reg->observaciones);
                array_push($this->idcom, $reg->idcom);
                array_push($this->faenac,$reg->faena);
                array_push($this->patente,$reg->patente);
                array_push($this->ptovta,$reg->ptovta);
                array_push($this->numero,$reg->numero);
                array_push($this->controlado,$reg->controlado);
                array_push($this->certificado,$reg->certificado);
                $prv=new adm_prv_1($reg->idprv,$conn);
                array_push($this->proveedor,$prv->getApellido());
                array_push($this->direccion, $prv->getDireccion());
                array_push($this->paises, $prv->getPaisesnom());
                $ssql="select * from adm_rem_det where idrem=".$reg->id;
                $det=new adm_rem_det_2($ssql, $conn);
                array_push($this->det_id,$det->getId());
                array_push($this->det_idrem,$det->getIdrem());
                array_push($this->det_animales,$det->getAnimales());
                array_push($this->det_kilos,$det->getKilos());
                array_push($this->det_idart,$det->getIdart());
                array_push($this->det_cantidad,$det->getCantidad());
                array_push($this->det_descripcion,$det->getDescripcion());
                array_push($this->det_unidad,$det->getUnidad());
                array_push($this->det_unidaddes,$det->getUnidaddes());
                array_push($this->det_precio,$det->getPrecio());
                array_push($this->det_preciosiva,$det->getPreciosiva());
                array_push($this->det_importe,$det->getImporte());
                array_push($this->det_total,$det->getTotal());
                array_push($this->det_articulo,$det->getArticulo());
                array_push($this->det_alicuota,$det->getAlicuota());
                array_push($this->importeiva, array_sum($det->getIva()));
                array_push($this->importeneto,array_sum($det->getNeto()));
                array_push($this->total,array_sum($det->getTotal()));
                array_push($this->neto0,array_sum($det->getNeto0()));
                array_push($this->neto10,array_sum($det->getNeto10()));
                array_push($this->neto21,array_sum($det->getNeto21()));
                array_push($this->iva0,array_sum($det->getIva0()));
                array_push($this->iva10,array_sum($det->getIva10()));
                array_push($this->iva21,array_sum($det->getIva21()));
                
                array_push($this->importeivar, array_sum($det->getIvar()));
                array_push($this->importenetor,array_sum($det->getNetor()));
                array_push($this->totalremito,array_sum($det->getTotalremito()));
                array_push($this->netor0,array_sum($det->getNetor0()));
                array_push($this->netor10,array_sum($det->getNetor10()));
                array_push($this->netor21,array_sum($det->getNetor21()));
                array_push($this->ivar0,array_sum($det->getIvar0()));
                array_push($this->ivar10,array_sum($det->getIvar10()));
                array_push($this->ivar21,array_sum($det->getIvar21()));
//                array_push($this->idela,$det->getIdela());
//                array_push($this->idenv,$det->getIdenv());
                if($reg->faena==1)
                    $xidela=$det->getFrm_idela();
                else
                    $xidela=$det->getCrm_idela();
                $fela=array();
                for($e=0;$e<count($xidela);$e++) {
                    if($xidela[$e]>0) {
                        $ssql="select * from adm_ela where id=".$xidela[$e];
                        //echo "adm_rem: $ssql\n";
                        $rel=$conx->consultaBase($ssql, $conn);
                        $rele= mysqli_fetch_object($rel);
                        array_push($fela,$rele->fecha);
                    } else
                        array_push($fela,"");
                }
                array_push($this->fechaela,$fela);
                
                if($reg->faena==1)
                    $xidenv=$det->getFrm_idenv();
                else
                    $xidenv=$det->getCrm_idenv();
                $fenv=array();
                for($e=0;$e<count($xidenv);$e++) {
                    if($xidenv[$e]>0) {
                        $ssql="select * from adm_env where id=".$xidenv[$e];
//                        echo "adm_rem: $ssql\n";
                        $rel=$conx->consultaBase($ssql, $conn);
                        $rele= mysqli_fetch_object($rel);
                        array_push($fenv,$rele->fechaing);
                    } else
                        array_push($fenv,"");
                }
                array_push($this->fechaenv,$fenv);
                
                
                
                
                $xart=$det->getIdart();
                if(count($xart)>0) {
                    if($xart[0]==0)
                        array_push($this->faena,1);
                    else
                        array_push($this->faena,0);
                } else {
                    $xart=array(0);
                    array_push($this->faena,1);
                }
                if($xart[0]==0) {
                    array_push($this->crm_cantidad,$det->getFrm_cantidad());
                    array_push($this->crm_temperatura,$det->getFrm_temperatura());
                    array_push($this->crm_observaciones,$det->getFrm_observaciones());
                    array_push($this->crm_idart,$det->getFrm_idart());
                    array_push($this->crm_articulo,$det->getFrm_articulo());
                    array_push($this->crm_unidad,$det->getFrm_unidad());
                    array_push($this->crm_unidaddes,$det->getFrm_unidaddes());
                    array_push($this->crm_idela,$det->getFrm_idela());
                    array_push($this->crm_idenv,$det->getFrm_idenv());
                } else {
                    array_push($this->crm_cantidad,$det->getCrm_cantidad());
                    array_push($this->crm_temperatura,$det->getCrm_temperatura());
                    array_push($this->crm_observaciones,$det->getCrm_observaciones());
                    array_push($this->crm_idart,$det->getCrm_idart());
                    array_push($this->crm_articulo,$det->getCrm_articulo());
                    array_push($this->crm_unidad,$det->getCrm_unidad());
                    array_push($this->crm_unidaddes,$det->getCrm_unidaddes());
                    array_push($this->crm_idela,$det->getCrm_idela());
                    array_push($this->crm_idenv,$det->getCrm_idenv());
                }
                array_push($this->seleccion,$reg->seleccion);
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getIdprv() {
        return $this->idprv;
    }
  
    function getFecha() {
        return $this->fecha;
    }
    
    function getProveedor() {
        return $this->proveedor;
    }
    
    function getDireccion() {
        return $this->direccion;
    }    
  
    function getTotal() {
        return $this->total;
    }
    
    function getIdcom() { return $this->idcom; }
    
    function getFaena() { return $this->faena; }
    
    function getDet_id() { return $this->det_id; }
    function getDet_idrem() { return $this->det_idrem; }
    function getDet_descripcion() { return $this->det_descripcion; }
    function getDet_animales() { return $this->det_animales; }
    function getDet_kilos() { return $this->det_kilos; }
    function getDet_idart() { return $this->det_idart; }
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_unidad() { return $this->unidad; }
    function getDet_unidaddes() { return $this->det_unidaddes; }
    function getDet_precio() { return $this->det_precio; }
    function getDet_preciosiva() { return $this->det_preciosiva; }
    function getDet_importe() { return $this->det_importe; }
    function getDet_total() { return $this->det_total; }
    function getDet_articulo() { return $this->det_articulo; }
    function getDet_alicuota() { return $this->det_alicuota; }
    
    function getCrm_cantidad() { return $this->crm_cantidad; }
    function getCrm_temperatura() { return $this->crm_temperatura; }
    function getCrm_observaciones() { return $this->crm_observaciones; }
    function getCrm_idart() { return $this->crm_idart; }
    function getCrm_articulo() { return $this->crm_articulo; }
    function getCrm_unidad() { return $this->crm_unidad; }
    function getCrm_unidaddes() { return $this->crm_unidaddes; }
    function getCrm_idela() { return $this->crm_idela; }
    function getCrm_idenv() { return $this->crm_idenv; }
  
    function getImporteiva() { return $this->importeiva; }
    function getImporteneto() { return $this->importeneto; }
    function getNeto0() { return $this->neto0; }
    function getNeto10() { return $this->neto10; }
    function getNeto21() { return $this->neto21; }
    function getIva0() { return $this->iva0; }
    function getIva10() { return $this->iva10; }
    function getIva21() { return $this->iva21; }


    function getImporteivar() { return $this->importeivar; }
    function getImportenetor() { return $this->importenetor; }
    function getNetor0() { return $this->netor0; }
    function getNetor10() { return $this->netor10; }
    function getNetor21() { return $this->netor21; }
    function getIvar0() { return $this->ivar0; }
    function getIvar10() { return $this->ivar10; }
    function getIvar21() { return $this->ivar21; }

    function getTotalremito() { return $this->totalremito; }
    function getFaenac() { return $this->faenac; }
    function getPatente() { return $this->patente; }
    function getPtovta() { return $this->ptovta; }
    function getNumero() { return $this->numero; }
    
    function getSeleccion() { return $this->seleccion; }
    
    function getControlado() { return $this->controlado; }
    function getCertificado() { return $this->certificado; }
    
//    function getIdela() { return $this->idela; }
//    function getIdenv() { return $this->idenv; }
    function getFechaela() { return $this->fechaela; }
    function getFechaenv() { return $this->fechaenv; }
    function getPaises() { return $this->paises; }
    
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

class adm_rem_det {
    var $idart=array();
    var $articulo=array();
    var $pais=array();
    var $kilos=array();
    var $fecha=array();
    var $certificado=array();
    
    function __construct($ssql, $conn="0") {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $rs=$conx->consultaBase($ssql, $conn);
        while($reg= mysqli_fetch_object($rs)) {
            array_push($this->idart,$reg->idart);
        //    $ssql="select adm_crm_det.* from adm_crm_det inner join adm_crm_det.idcrm=adm_crm.id inner join adm_rem on adm_crm.idrem=adm_rem.id where adm_crm.idart=".$reg->idart;
        //    echo $ssql."<br>";
        //    $rcc=$conx->consultaBBase($ssql, $conn);
            array_push($this->kilos,$reg->cantidad);
            $ssql="select * from adm_art where id=".$reg->idart;
            $raa=$conx->consultaBBase($ssql, $conn);
            array_push($this->articulo,$raa->descripcion);
            $a_pais=explode("|",$reg->paises);
            $cadenapais="";
            for($p=0;$p<count($a_pais);$p++) {
                if($a_pais[$p]!="") {
                    $ssql="select * from tablas where valor=".$a_pais[$p]." and codtab='PAI'";
                    $rpp=$conx->consultaBBase($ssql, $conn);
                    $cadenapais.=$rpp->descripcion." / ";
                }
            }
            if($cadenapais!="") $cadenapais=substr($cadenapais,0,strlen($cadenapais)-3);
            array_push($this->pais,$cadenapais);
            array_push($this->fecha,$reg->fecha);
            array_push($this->certificado,$reg->certificado);
        }
    }
    
    function getIdart() { return $this->idart; }
    function getArticulo() { return $this->articulo; }
    function getPais() { return $this->pais; }
    function getFecha() { return $this->fecha; }
    function getCertificado() { return $this->certificado; }
    function getKilos() { return $this->kilos; }
}

?>
