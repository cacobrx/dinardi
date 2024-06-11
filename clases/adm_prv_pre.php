<?php
/*
 * Creado el 14/12/2018 12:27:23
 * Autor: gus
 * Archivo: adm_prv_pre.php
 * planbsistemas.com.ar
 */

class adm_prv_pre_1 {
    var $importe=0;
    var $preciomaximo=0;
    var $preciominimo=0;
    var $alicuota=0;
    var $preciofinal=0;
    var $seleccionado=0;
    
    function __construct($idprv, $idart, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_prv_pre where idprv=$idprv and idart=$idart";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql,$conn);
            $reg=mysqli_fetch_object($rs);
            $this->importe=$reg->importe;
            $this->preciominimo=$reg->preciominimo;
            $this->preciomaximo=$reg->preciomaximo;
            $this->alicuota=$reg->alicuota;
            $this->preciofinal=$reg->importe+$reg->importe*$reg->alicuota/100;
            $this->seleccionado=$reg->seleccionado;            
        }
    }

    function getImporte() {
        return $this->importe;
    }
    
    function getPreciominimo() { return $this->preciominimo; }
    function getPreciomaximo() { return $this->preciomaximo; }
    function getAlicuota() { return $this->alicuota; }
    function getPreciofinal() { return $this->preciofinal; }
    function getSeleccionado() { return $this->seleccionado; }
  
}

class adm_prv_pre_2 {
    var $id=array();
    var $importe=array();
    var $descripcion=array();
    var $idart=array();
    var $codigo=array();
    var $rubro=array();
    var $alicuota=array();
    var $preciofinal=array();
    var $seleccionado=array();
    
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
                array_push($this->importe,$reg->importe);
                array_push($this->idart,$reg->idart);
                $art=new adm_art_1($reg->idart, $conn);
                array_push($this->descripcion,$art->getDescripcion());
                array_push($this->codigo,$art->getCodigodinardi());
                array_push($this->rubro,$art->getRubrodes());
                array_push($this->alicuota,$reg->alicuota);
                array_push($this->preciofinal,$reg->importe+$reg->importe*$reg->alicuota/100);
                array_push($this->seleccionado,$reg->seleccionado);                
            }    
        }
    }
    
    function getId() { return $this->id; }
    function getDescripcion() { return $this->descripcion; }
    function getImporte() { return $this->importe; }
    function getRubro() { return $this->rubro; }
    function getIdart() { return $this->idart; }
    function getCodigo() { return $this->codigo; }
    function getAlicuota() { return $this->alicuota; }
    function getPreciofinal() { return $this->preciofinal; }
    function getSeleccionado() { return $this->seleccionado; }
    
}