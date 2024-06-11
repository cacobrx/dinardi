<?
/*
 * Creado el 05/06/2020 14:54:24
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_band.php
 */
 
class adm_band_1 {
    var $id=0;
    var $idart=0;
    var $fecha='';
    var $idprv=0;
    var $hielo=0;
    var $kg=0;
    var $temperatura=0;
    var $tunel=0;
    var $control=0;
    var $contaminante=0;
    var $kgrechazo=0;
    var $proveedor="";
    var $articulo="";

    
    function __construct($id, $conn="0") {
    require_once "clases/conexion.php";
    require_once 'clases/adm_prv.php';
    require_once 'clases/adm_art.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_band where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->idart=$reg->idart;
        $this->fecha=$reg->fecha;
        $this->idprv=$reg->idprv;
        $this->kg=$reg->kg;
        $this->hielo=$reg->hielo;
        $this->temperatura=$reg->temperatura;
        $this->tunel=$reg->tunel;
        $this->control=$reg->control;
        $this->contaminante=$reg->contaminante;
        $this->kgrechazo=$reg->kgrechazo;
        $art=new adm_art_1($reg->idart);
        $this->articulo=$art->getDescripcion();
        $prv=new adm_prv_1($reg->idprv);
        $this->proveedor=$prv->getApellido()." ".$prv->getNombre();
    }

    function getId() {
        return $this->id;
    }
  
    function getIdart() {
        return $this->idart;
    }
    
    function getProveedor() {
        return $this->proveedor;
    }
    
    function getArticulo() {
        return $this->articulo;
    }


    function getFecha() {
        return $this->fecha;
    }
  
    function getIdprv() {
        return $this->idprv;
    }
  
    function getHielo() {
        return $this->hielo;
    }
  
    function getTemperatura() {
        return $this->temperatura;
    }
  
    function getTunel() {
        return $this->tunel;
    }
  
    function getControl() {
        return $this->control;
    }
  
    function getContaminante() {
        return $this->contaminante;
    }
    
    function getKg() {
        return $this->kg;
    }
  
    function getKgrechazo() {
        return $this->kgrechazo;
    }
  
}

class adm_band_2 {
    var $id=array();
    var $idart=array();
    var $fecha=array();
    var $idprv=array();
    var $hielo=array();
    var $temperatura=array();
    var $tunel=array();
    var $control=array();
    var $kg=array();
    var $contaminante=array();
    var $kgrechazo=array();
    var $proveedor=array();
    var $articulo=array();
    var $hielodes=array();
    var $controldes=array();
    var $contaminantedes=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_prv.php';
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
                array_push($this->idart,$reg->idart);
                array_push($this->fecha,$reg->fecha);
                array_push($this->idprv,$reg->idprv);
                array_push($this->kg,$reg->kg);
                array_push($this->hielo,$reg->hielo);
                array_push($this->temperatura,$reg->temperatura);
                array_push($this->tunel,$reg->tunel);
                array_push($this->control,$reg->control);
                array_push($this->contaminante,$reg->contaminante);
                array_push($this->kgrechazo,$reg->kgrechazo);
                $art=new adm_art_1($reg->idart);
                $prv=new adm_prv_1($reg->idprv); 
                array_push($this->proveedor,$prv->getApellido()." ".$prv->getNombre());
                array_push($this->articulo,$art->getDescripcion());
                if($reg->hielo==1) {
                    array_push($this->hielodes,"Si");
                } else {
                    array_push($this->hielodes,"No");
                }
                if($reg->contaminante==1) {
                    array_push($this->contaminantedes,"Si");
                } else {
                    array_push($this->contaminantedes,"No");
                }
                if($reg->control==1) {
                    array_push($this->controldes,"Si");
                } else {
                    array_push($this->controldes,"No");
                }
                    
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getIdart() {
        return $this->idart;
    }
  
    function getFecha() {
        return $this->fecha;
    }
  
    function getIdprv() {
        return $this->idprv;
    }
  
    function getHielo() {
        return $this->hielo;
    }
  
    function getTemperatura() {
        return $this->temperatura;
    }
  
    function getTunel() {
        return $this->tunel;
    }
  
    function getControl() {
        return $this->control;
    }
    
    function getControldes() {
        return $this->controldes;
    }
    
    function getHielodes() {
        return $this->hielodes;
    }
    
    function getContaminantedes() {
        return $this->contaminantedes;
    }
  
    function getContaminante() {
        return $this->contaminante;
    }
  
    function getKgrechazo() {
        return $this->kgrechazo;
    }
  
    function getKg() {
        return $this->kg;
    }
    
    function getProveedor() {
        return $this->proveedor;
    }
    
    function getArticulo() {
        return $this->articulo;
    }    
    
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>
