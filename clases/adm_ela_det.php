<?
/*
 * Creado el 28/05/2020 10:34:01
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_ela.php
 */
 
class adm_ela_det_1 {
    var $id=0;
    var $idart=0;
    var $fechaing='';
    var $idprv=0;
    var $kgdescarte=0;
    var $kgfinal=0;
    var $empleados=0;
    var $idela=0;

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_ela where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->idart=$reg->idart;
        $this->fechaing=$reg->fechaing;
        $this->idprv=$reg->idprv;
        $this->kgdescarte=$reg->kgdescarte;
        $this->kgfinal=$reg->kgfinal;
        $this->empleados=$reg->empleados;
        $this->idela=$reg->idela;
    }

    function getId() {
        return $this->id;
    }
  
    function getIdart() {
        return $this->idart;
    }
  
    function getFechaing() {
        return $this->fechaing;
    }
  
    function getIdprv() {
        return $this->idprv;
    }
  
    function getKgdescarte() {
        return $this->kgdescarte;
    }
  
    function getKgfinal() {
        return $this->kgfinal;
    }
    
    function getIdela() {
        return $this->idela;
    }
    
    function getEmpleados() {
        return $this->empleados;
    }
  
}

class adm_ela_det_2 {
    var $id=array();
    var $idart=array();
    var $articulo=array();
    var $fechaing=array();
    var $kgdescarte=array();
    var $kgfinal=array();
    var $idela=array();
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
                array_push($this->fechaing,$reg->fechaing);
                array_push($this->kgdescarte,$reg->kgdescarte);
                array_push($this->kgfinal,$reg->kgfinal);
                array_push($this->idela,$reg->idela);
                $art=new adm_art_1($reg->idart);
                array_push($this->articulo,$art->getDescripcion());
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getIdart() {
        return $this->idart;
    }
    
    function getIdela() { 
        return $this->idela;
    }
  
    function getFechaing() {
        return $this->fechaing;
    }
  
    function getKgdescarte() {
        return $this->kgdescarte;
    }
  
    function getKgfinal() {
        return $this->kgfinal;
    }
    
    function getArticulo() {
        return $this->articulo;
    }
    
    function getMaxRegistros() {
        return $this->maxregistros;
    }
    
}

?>
