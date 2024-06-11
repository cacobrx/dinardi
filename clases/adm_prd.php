<?
/*
 * Creado el 01/02/2019 13:27:59
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prd.php
 */
 
class adm_prd_1 {
    var $id=0;
    var $centro=0;
    var $descripcion='';
    var $precioventa='';
    var $estadoproducto=0;
    var $estadoproductodes="";
    var $unidad=0;
    var $unidaddes="";
    var $unidadxanimal=0;
    var $kilosxanimal=0;
    var $presentacion=0;
    var $presentaciondes="";
    var $codigoproducto='';
    var $fechacreate='';
    var $fechamod='';
    var $rubro=0;
    var $elaborado=0;
    var $envasado=0;
    var $rubrodes="";
    var $artproveedor=0;
    var $artcliente=0;
    var $colorcamara="";
    var $colorletra="";
    var $posicionx=array();
    var $posiciony=array();
    var $posicionz=array();
    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_prd where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->descripcion=$reg->descripcion;
        $this->precioventa=$reg->precioventa;
        $this->estadoproductodes=$conx->getTextoValor($reg->estadoproducto, "ESP", $conn);
        $this->unidad=$reg->unidad;
        $this->unidadxanimal=$reg->unidadxanimal;
        $this->kilosxanimal=$reg->kilosxanimal;
        $this->presentaciondes=$conx->getTextoValor($reg->presentacion, "PRP", $conn);
        $this->unidaddes=$conx->getTextoValor($reg->unidad, "UNP", $conn);
        $this->codigoproducto=$reg->codigoproducto;
        $this->fechacreate=$reg->fechacreate;
        $this->fechamod=$reg->fechamod;
        $this->rubro=$reg->rubro;
        $this->rubrodes=$conx->getTextoValor($reg->rubro, "RUB", $conn);
        $this->artproveedor=$reg->artproveedor;
        $this->artcliente=$reg->artcliente;
        $this->envasado=$reg->envasado;
        $this->elaborado=$reg->elaborado;
        $this->colorcamara=$reg->colorcamara;
        $this->colorletra=$reg->colorletra;
        $ssql="select * from adm_ubi where idart=".$reg->id;
        $rx=$conx->consultaBase($ssql, $conn);
        while($rxx= mysqli_fetch_object($rx)) {
            array_push($this->posicionx,$rxx->posicionx);
            array_push($this->posiciony,$rxx->posiciony);
            array_push($this->posicionz,$rxx->posicionz);
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
    
    function getEnvasado() {
        return $this->envasado;
    }
    
    function getElaborado() {
        return $this->elaborado;
    }
  
    function getDescripcion() {
        return $this->descripcion;
    }
  
    function getPrecioventa() {
        return $this->precioventa;
    }
  
    function getEstadoproducto() {
        return $this->estadoproducto;
    }
    
    function getEstadoproductodes() {
        return $this->estadoproductodes;
    }    
  
    function getUnidad() {
        return $this->unidad;
    }
    
    function getUnidaddes() { return $this->unidaddes; }
  
    function getUnidadxanimal() {
        return $this->unidadxanimal;
    }
  
    function getKilosxanimal() {
        return $this->kilosxanimal;
    }
  
    function getPresentacion() {
        return $this->presentacion;
    }
    
    function getPresentaciondes() {
        return $this->presentaciondes;
    }     
  
    function getCodigoproducto() {
        return $this->codigoproducto;
    }
  
    function getFechacreate() {
        return $this->fechacreate;
    }
  
    function getFechamod() {
        return $this->fechamod;
    }
    
    function getRubro() { return $this->rubro; }
    function getRubrodes() { return $this->rubrodes; }
    function getArtproveedor() { return $this->artproveedor; }
    function getArtcliente() { return $this->artcliente; }
    function getColorcamara() { return $this->colorcamara; }
    function getColorletra() { return $this->colorletra; }
    function getPosicionx() { return $this->posicionx; }
    function getPosiciony() { return $this->posiciony; }
    function getPosicionz() { return $this->posicionz; }
}

class adm_prd_2 {
    var $id=array();
    var $centro=array();
    var $descripcion=array();
    var $precioventa=array();
    var $estadoproducto=array();
    var $estadoproductodes=array();
    var $unidad=array();
    var $unidadxanimal=array();
    var $kilosxanimal=array();
    var $presentacion=array();
    var $presentaciondes=array();
    var $codigoproducto=array();
    var $envasado=array();
    var $elaborado=array();
    var $fechacreate=array();
    var $fechamod=array();
    var $rubro=array();
    var $rubrodes=array();
    var $artproveedor=array();
    var $artcliente=array();
    var $colorcamara=array();
    var $colorletra=array();
    var $posicionx=array();
    var $posiciony=array();
    var $posicionz=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
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
                array_push($this->centro,$reg->centro);
                array_push($this->descripcion,$reg->descripcion);
                array_push($this->precioventa,$reg->precioventa);
                array_push($this->estadoproductodes,$conx->getTextoValorA($reg->estadoproducto, "ESP", $conn));
                array_push($this->unidad,$reg->unidad);
                array_push($this->unidadxanimal,$reg->unidadxanimal);
                array_push($this->kilosxanimal,$reg->kilosxanimal);
                array_push($this->presentaciondes,$conx->getTextoValorA($reg->presentacion, "PRE", $conn));
                array_push($this->codigoproducto,$reg->codigoproducto);
                array_push($this->fechacreate,$reg->fechacreate);
                array_push($this->fechamod,$reg->fechamod);
                array_push($this->rubro,$reg->rubro);
                array_push($this->rubrodes,$conx->getTextoValor($reg->rubro, "RUB", $conn));
                array_push($this->artproveedor,$reg->artproveedor);
                array_push($this->artcliente,$reg->artcliente);
                array_push($this->elaborado,$reg->elaborado);
                array_push($this->envasado,$reg->envasado);
                array_push($this->colorcamara,$reg->colorcamara);
                array_push($this->colorletra,$reg->colorletra);
                $xubix=array();
                $xubiy=array();
                $xubiz=array();
                $ssql="select * from adm_ubi where idart=".$reg->id;
                $rx=$conx->consultaBase($ssql, $conn);
                while($rxx= mysqli_fetch_object($rx)) {
                    array_push($xubix,$rxx->posicionx);
                    array_push($xubiy,$rxx->posiciony);
                    array_push($xubiz,$rxx->posicionz);
                }
                array_push($this->posicionx,$xubix);
                array_push($this->posiciony,$xubiy);
                array_push($this->posicionz,$xubiz);
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getDescripcion() {
        return $this->descripcion;
    }
  
    function getPrecioventa() {
        return $this->precioventa;
    }
  
    function getEstadoproducto() {
        return $this->estadoproducto;
    }

    function getEstadoproductodes() {
        return $this->estadoproductodes;
    }    
  
    function getUnidad() {
        return $this->unidad;
    }
  
    function getUnidadxanimal() {
        return $this->unidadxanimal;
    }
  
    function getKilosxanimal() {
        return $this->kilosxanimal;
    }
    
    function getElaborado() {
        return $this->elaborado;
    }
    
    function getEnvasado() {
        return $this->envasado;
    }
  
    function getPresentacion() {
        return $this->presentacion;
    }
    
    function getPresentaciondes() {
        return $this->presentaciondes;
    }    
  
    function getCodigoproducto() {
        return $this->codigoproducto;
    }
  
    function getFechacreate() {
        return $this->fechacreate;
    }
  
    function getFechamod() {
        return $this->fechamod;
    }
    
    function getRubro() { return $this->rubro; }
    function getRubrodes() { return $this->rubrodes; }
    function getArtproveedor() { return $this->artproveedor; }
    function getArtcliente() { return $this->artcliente; }
    function getColorcamara() { return $this->colorcamara; }
    function getColorletra() { return $this->colorletra; }
    function getPosicionx() { return $this->posicionx; }
    function getPosiciony() { return $this->posiciony; }
    function getPosicionz() { return $this->posicionz; }
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>
