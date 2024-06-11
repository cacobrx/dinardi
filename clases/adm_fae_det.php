<?php
/*
 * Creado el 28/01/2019 16:33:05
 * Autor: gus
 * Archivo: adm_fae_det.php
 * planbsistemas.com.ar
 */

class adm_fae_det_2 {
    var $id=array();
    var $idcrm=array();
    var $peso=array();
    var $idart=array();
    var $precio=array();
    var $total=array();
    var $articulo=array();
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
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->idcrm,$reg->idcrm);
                array_push($this->peso,$reg->peso);
                array_push($this->idart,$reg->idart);
                array_push($this->precio,$reg->precio);
                array_push($this->total,$reg->peso*$reg->precio);
                $art=new adm_art_1($reg->idart,$conn);       
                array_push($this->articulo,$art->getDescripcion());
            }    
        }
    }

    function getId() { return $this->id; }
    function getIdcrm() { return $this->idcrm; }
    function getPeso() { return $this->peso; }
    function getCantidad() { return $this->cantidad; }
    function getIdart() { return $this->idart; }
    function getArticulo() { return $this->articulo; }
    function getPrecio() { return $this->precio; }
    function getTotal() { return $this->total; }
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}
