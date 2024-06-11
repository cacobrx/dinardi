<?
/*
 * Creado el 16/12/2012 20:08:52
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: planb_config.php
 */
 
class planb_config_1 {
    var $id=0;
    var $titulo='';
    var $cabecera='';
    var $color1='';
    var $colorbarra='';
    var $limmax=0;
    var $piepagina='';
    var $alturamarco=0;
    var $puntodecimal="";
    var $tipoletra=1;
    var $empresa="";
    var $telefono="";
    var $email="";
    var $diasvencimientocht=0;
    var $diasfinalcht=0;
    var $saldoinicialcaja=0;
    var $fiscalpuntoventa=0;
    var $fiscalfantasia=""; 
    var $fiscalnombre="";    
    var $fisalactivo=0;
    var $fiscalcuit="";
    var $fiscaliibb="";
    var $fiscaliva=0;
    var $fiscaldireccion="";
    var $fiscalciudad="";
    var $fiscaltelefono="";
    var $fiscalmail="";
    var $fiscalcopia=0;
    var $fiscalformato=0;
    var $fiscalfechainicio="";
    var $fiscalfacturadirecta=0;
    var $fiscalresponsable="";
    var $fiscalcargo="";
    var $cuentaentradaop=0;
    var $cuentasalidaop=0;
    var $servidorafip="http://190.184.224.217/servicios/afip/dinardi";
    var $cbu="";
    var $aliascbu="";
    var $fiscalpuntoventafce=0;
    var $minimoretenciones=0;
    var $minimoretencionesser=0;
    var $fechainicioctacte="";
    var $colordescriptor1='';
    var $colordescriptor2='';
    var $colordescriptor3='';
    var $colordescriptor4='';

    function __construct($id) {
        require_once "clases/conexion.php";
        $conx=new conexion();
        $ssql="select * from planb_config where id=$id";
        $rs=$conx->getConsulta($ssql);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->titulo=$reg->titulo;
        $this->cabecera=$reg->cabecera;
        $this->color1=$reg->color1;
        $this->colorbarra=$reg->colorbarra;
        $this->limmax=$reg->limmax;
        $this->piepagina=$reg->piepagina;
        $this->alturamarco=$reg->alturamarco;
        $this->puntodecimal=$reg->puntodecimal;
        $this->tipoletra=$reg->tipoletra;
        $this->empresa=$reg->empresa;
        $this->telefono=$reg->telefono;
        $this->email=$reg->email;
        $this->diasvencimientocht=$reg->diasvencimientocht;
        $this->diasfinalcht=$reg->diasfinalcht;
        $this->saldoinicialcaja=$reg->saldoinicialcaja;
        $this->fiscalnombre=$reg->fiscalnombre;        
        $this->fiscalpuntoventa=$reg->fiscalpuntoventa;
        $this->fiscalfantasia=$reg->fiscalfantasia;   
        $this->fiscalactivo=$reg->fiscalactivo;
        $this->fiscalcuit=$reg->fiscalcuit;
        $this->fiscaliibb=$reg->fiscaliibb;
        $this->fiscaliva=$reg->fiscaliva;
        $this->fiscaldireccion=$reg->fiscaldireccion;
        $this->fiscalciudad=$reg->fiscalciudad;
        $this->fiscaltelefono=$reg->fiscaltelefono;
        $this->fiscalmail=$reg->fiscalmail;
        $this->fiscalcopia=$reg->fiscalcopia;
        $this->fiscalformato=$reg->fiscalformato;
        $this->fiscalfechainicio=$reg->fiscalfechainicio;
        $this->fiscalfacturadirecta=$reg->fiscalfacturadirecta;
        $this->fiscalresponsable=$reg->fiscalresponsable;
        $this->fiscalcargo=$reg->fiscalcargo;
        $this->cuentaentradaop=$reg->cuentaentradaop;
        $this->cuentasalidaop=$reg->cuentasalidaop;
        $this->cbu=$reg->cbu;
        $this->aliascbu=$reg->aliascbu;
        $this->fiscalpuntoventafce=$reg->fiscalpuntoventafce;
        $this->minimoretenciones=$reg->minimoretenciones;
        $this->minimoretencionesser=$reg->minimoretencionesser;
        $this->fechainicioctacte=$reg->fechainicioctacte;
        $this->colordescriptor1=$reg->colordescriptor1;
        $this->colordescriptor2=$reg->colordescriptor2;
        $this->colordescriptor3=$reg->colordescriptor3;
        $this->colordescriptor4=$reg->colordescriptor4;
    }

    function getId() {
      return $this->id;
    }

    function getTitulo() {
      return $this->titulo;
    }

    function getCabecera() {
      return $this->cabecera;
    }

    function getColor1() {
      return $this->color1;
    }

    function getColorbarra() {
      return $this->colorbarra;
    }

    function getLimmax() {
      return $this->limmax;
    }

    function getPiepagina() {
      return $this->piepagina;
    }

    function getAlturamarco() {
      return $this->alturamarco;
    }
    
    function getPuntodecimal() {
        return $this->puntodecimal;
    }
    
  
    function getTipoletra() { return $this->tipoletra; }
    function getEmpresa() { return $this->empresa; }
    function getTelefono() { return $this->telefono; }
    function getEmail() { return $this->email; }
    function getSaldoinicialcaja() { return $this->saldoinicialcaja; }    
    function getDiasvencimientocht() { return $this->diasvencimientocht; }
    function getDiasfinalcht() { return $this->diasfinalcht; }
    
    function getFiscalpuntoventa() { return $this->fiscalpuntoventa; }
    
    function getFiscalfantasia() { return $this->fiscalfantasia; }  
    
    function getFiscalnombre() { return $this->fiscalnombre; }    
    function getFiscalactivo() { return $this->fiscalactivo; }
    function getFiscalcuit() { return $this->fiscalcuit; }
    function getFiscalcopia() { return $this->fiscalcopia; }
    function getFiscalciudad() { return $this->fiscalciudad; }
    function getFiscaldireccion() { return $this->fiscaldireccion; }
    function getFiscalfacturadirecta() { return $this->fiscalfacturadirecta; }
    function getFiscalfechainicio() { return $this->fiscalfechainicio; }
    function getFiscalformato() { return $this->fiscalformato; }
    function getFiscaliibb() { return $this->fiscaliibb; }
    function getFiscaliva() { return $this->fiscaliva; }
    function getFiscalmail() { return $this->fiscalmail; }
    function getFiscaltelefono() { return $this->fiscaltelefono; }
    function getFiscalresponsable() { return $this->fiscalresponsable; }
    function getFiscalcargo() { return $this->fiscalcargo; }
    
    function getCuentaentradaop() { return $this->cuentaentradaop; }
    function getCuentasalidaop() { return $this->cuentasalidaop; }
    
    function getServidorafip() { return $this->servidorafip; }
    function getCbu() { return $this->cbu; }
    function getAliascbu() { return $this->aliascbu; }
    function getFiscalpuntoventafce() { return $this->fiscalpuntoventafce; }
    function getMinimoretenciones() { return $this->minimoretenciones; }
    function getMinimoretencionesser() { return $this->minimoretencionesser; }
    function getFechainicioctacte() { return $this->fechainicioctacte; }
    function getColordescriptor1() { return $this->colordescriptor1; }
    function getColordescriptor2() { return $this->colordescriptor2; }
    function getColordescriptor3() { return $this->colordescriptor3; }
    function getColordescriptor4() { return $this->colordescriptor4; }
}

class planb_config_2 {
  var $id=array();
  var $titulo=array();
  var $cabecera=array();
  var $color1=array();
  var $colorbarra=array();
  var $limmax=array();
  var $piepagina=array();
  var $alturamarco=array();
  var $maxregistros=0;
    
  function __construct($ssql) {
    require_once "clases/conexion.php";
    $conx=new conexion();
    if($conx->getCantidadReg($ssql)>0) {
      if(strpos($ssql,'limit')=='')
        $ssqltot=$ssql;
      else
        $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
      $this->maxregistros=$conx->getCantidadReg($ssqltot);
      $rs=$conx->getConsulta($ssql);
      while($reg=mysqli_fetch_object($rs)) {
        array_push($this->id,$reg->id);
        array_push($this->titulo,$reg->titulo);
        array_push($this->cabecera,$reg->cabecera);
        array_push($this->color1,$reg->color1);
        array_push($this->colorbarra,$reg->colorbarra);
        array_push($this->limmax,$reg->limmax);
        array_push($this->piepagina,$reg->piepagina);
        array_push($this->alturamarco,$reg->alturamarco);
      }    
    }
  }

  function getId() {
    return $this->id;
  }
  
  function getTitulo() {
    return $this->titulo;
  }
  
  function getCabecera() {
    return $this->cabecera;
  }
  
  function getColor1() {
    return $this->color1;
  }
  
  function getColorbarra() {
    return $this->colorbarra;
  }
  
  function getLimmax() {
    return $this->limmax;
  }
  
  function getPiepagina() {
    return $this->piepagina;
  }
  
  function getAlturamarco() {
    return $this->alturamarco;
  }
  
  function getMaxRegistros() {
    return $this->maxregistros;
  }
  
}

?>
