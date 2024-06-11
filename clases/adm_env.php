<?
/*
 * Creado el 07/07/2020 12:59:43
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_env.php
 */
 
class adm_env_1 {
    var $id=0;
    var $idart=0;
    var $tenvasado1=0;
    var $tenvasado2=0;
    var $tenvasado3=0;
    var $fechaing='';
    var $idprv=0;
    var $idprv1=0;
    var $idprv2=0;
    var $kgdescarte=0;
    var $lote=0;
    var $cantidad=0;
    var $proveedor="";
    var $proveedor1="";
    var $proveedor2="";
    var $articulo="";
    var $kilos=0;
    var $tunel=0;

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_art.php';
        require_once 'clases/adm_prv.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_env where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->idart=$reg->idart;
        $this->tenvasado1=$reg->tenvasado1;
        $this->tenvasado2=$reg->tenvasado2;
        $this->tenvasado3=$reg->tenvasado3;
        $this->fechaing=$reg->fechaing;
        $this->idprv=$reg->idprv;
        $this->idprv1=$reg->idprv1;
        $this->idprv2=$reg->idprv2;
        $this->kgdescarte=$reg->kgdescarte;
        $this->lote=$reg->lote;
        $this->cantidad=$reg->cantidad;
        $this->kilos=$reg->kilos;
        $this->tunel=$reg->tunel;
        $pro=new adm_prv_1($reg->idprv);
        $this->proveedor=$pro->getNombre()." ".$pro->getApellido();
        $pro=new adm_prv_1($reg->idprv1);
        $this->proveedor1=$pro->getNombre()." ".$pro->getApellido();
        $pro=new adm_prv_1($reg->idprv2);
        $this->proveedor2=$pro->getNombre()." ".$pro->getApellido();
        $art=new adm_art_1($reg->idart);
        $this->articulo=$art->getDescripcion();
    }

    function getId() {
        return $this->id;
    }
  
    function getIdart() {
        return $this->idart;
    }
  
    function getTenvasado1() {
        return $this->tenvasado1;
    }
  
    function getTenvasado2() {
        return $this->tenvasado2;
    }
  
    function getTenvasado3() {
        return $this->tenvasado3;
    }
  
    function getFechaing() {
        return $this->fechaing;
    }
  
    function getIdprv() {
        return $this->idprv;
    }
  
    function getIdprv1() {
        return $this->idprv1;
    }
  
    function getIdprv2() {
        return $this->idprv2;
    }
  
    function getKgdescarte() {
        return $this->kgdescarte;
    }
  
    function getLote() {
        return $this->lote;
    }
  
    function getCantidad() {
        return $this->cantidad;
    }
    
    function getProveedor() {
        return $this->proveedor;
    }
    
    function getProveedor1() {
        return $this->proveedor1;
    }
    
    function getProveedor2() {
        return $this->proveedor2;
    }
    
    function getArticulo() {
        return $this->articulo;
    }
    
    function getKilos() { return $this->kilos; }
    function getTunel() { return $this->tunel; }
  
}

class adm_env_2 {
    var $id=array();
    var $idart=array();
    var $tenvasado1=array();
    var $tenvasado2=array();
    var $tenvasado3=array();
    var $fechaing=array();
    var $idprv=array();
    var $idprv1=array();
    var $idprv2=array();
    var $kgdescarte=array();
    var $lote=array();
    var $cantidad=array();
    var $proveedor=array();
    var $proveedor1=array();
    var $proveedor2=array();
    var $articulo=array();
    var $kilos=array();
    var $tunel=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_art.php';
        require_once 'clases/adm_prv.php';        
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
                array_push($this->tenvasado1,$reg->tenvasado1);
                array_push($this->tenvasado2,$reg->tenvasado2);
                array_push($this->tenvasado3,$reg->tenvasado3);
                array_push($this->fechaing,$reg->fechaing);
                array_push($this->idprv,$reg->idprv);
                array_push($this->idprv1,$reg->idprv1);
                array_push($this->idprv2,$reg->idprv2);
                array_push($this->kgdescarte,$reg->kgdescarte);
                array_push($this->lote,$reg->lote);
                array_push($this->cantidad,$reg->cantidad);
                array_push($this->kilos,$reg->kilos);
                array_push($this->tunel,$reg->tunel);
                $art=new adm_art_1($reg->idart);
                array_push($this->articulo,$art->getDescripcion());
                $pro=new adm_prv_1($reg->idprv);
                $pp=$pro->getApellido();
                if($pp=="") $pp=$pro->getNombre ();
                array_push($this->proveedor,$pp);
                $pro=new adm_prv_1($reg->idprv1);
                $pp=$pro->getApellido();
                if($pp=="") $pp=$pro->getNombre ();
                array_push($this->proveedor1,$pp);
                $pro=new adm_prv_1($reg->idprv2);
                $pp=$pro->getApellido();
                if($pp=="") $pp=$pro->getNombre ();
                array_push($this->proveedor2,$pp);
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getIdart() {
        return $this->idart;
    }
  
    function getTenvasado1() {
        return $this->tenvasado1;
    }
  
    function getTenvasado2() {
        return $this->tenvasado2;
    }
  
    function getTenvasado3() {
        return $this->tenvasado3;
    }
  
    function getFechaing() {
        return $this->fechaing;
    }
  
    function getIdprv() {
        return $this->idprv;
    }
  
    function getIdprv1() {
        return $this->idprv1;
    }
  
    function getIdprv2() {
        return $this->idprv2;
    }
  
    function getKgdescarte() {
        return $this->kgdescarte;
    }
  
    function getLote() {
        return $this->lote;
    }
  
    function getCantidad() {
        return $this->cantidad;
    }
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
    
    function getProveedor() {
        return $this->proveedor;
    }
    
    function getProveedor1() {
        return $this->proveedor1;
    }
    
    function getProveedor2() {
        return $this->proveedor2;
    }
    
    function getArticulo() {
        return $this->articulo;
    }    
    
    function getKilos() { return $this->kilos; }
    function getTunel() { return $this->tunel; }
}

class total_env {
    var $kilos=0;
    var $cajas=0;
    function __construct($ssql) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ssqlt=explode("where ", $ssql);
        $ssql="select sum(kilos) as totkil, sum(cantidad) as totcaj from adm_env where ".$ssqlt[1];
        $rs=$conx->getConsulta($ssql);
        $reg=mysqli_fetch_object($rs);
        $this->kilos=$reg->totkil;
        $this->cajas=$reg->totcaj;
    }
    
    function getKilos() { return $this->kilos; }
    function getCantidad() { return $this->cajas; }
}


?>
