<?php
/*
 * Creado el 17/01/2019 17:43:11
 * Autor: gus
 * Archivo: adm_crm_det.php
 * planbsistemas.com.ar
 */

class adm_crm_det_2 {
    var $id=array();
    var $idcrm=array();
    var $descr=array();
    var $peso=array();
    var $idart=array();
    var $temperatura=array();
    var $cantidad=array();
    var $articulo=array();
    var $observaciones=array();
    var $unidad=array();
    var $unidaddes=array();
    var $idela=array();
    var $idenv=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_art.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql,$conn);
//            echo "crm_det: $ssql\n";
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->idcrm,$reg->idcrm);
                array_push($this->peso,$reg->peso);
                array_push($this->idart,$reg->idart);
                array_push($this->cantidad,$reg->cantidad);
                array_push($this->temperatura,$reg->temperatura);
                array_push($this->observaciones,$reg->observaciones);
                array_push($this->idela,$reg->idela);
                array_push($this->idenv,$reg->idenv);
                $art=new adm_art_1($reg->idart,$conn);       
                array_push($this->articulo,$art->getDescripcion());
                array_push($this->unidad,$reg->unidad);
//                echo "uni: ".$reg->unidad."<br>";
                array_push($this->unidaddes,$conx->getTextoValor($reg->unidad, "UNI", $conn));
//                echo $conx->getTextoValor($reg->unidad, "UNI", $conn)."<br>";
            }    
        }
    }

    function getId() { return $this->id; }
    function getIdcrm() { return $this->idcrm; }
    function getPeso() { return $this->peso; }
    function getCantidad() { return $this->cantidad; }
    function getIdart() { return $this->idart; }
    function getArticulo() { return $this->articulo; }
    function getTemperatura() { return $this->temperatura; }
    function getObservaciones() { return $this->observaciones; }
    function getUnidad() { return $this->unidad; }
    function getUnidaddes() { return $this->unidaddes; }
    function getIdela() { return $this->idela; }
    function getIdenv() { return $this->idenv; }
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}
