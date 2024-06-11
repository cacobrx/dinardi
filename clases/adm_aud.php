<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_aud.php
 */
 
class adm_aud_1 {
  var $id=0;
  var $centro=0;
  var $usuario=0;
  var $fecha="";
  var $descripcion="";
  var $modulo="";
  var $centrodes="";
    
  function __construct($id) {
    require_once "clases/conexion.php";
    require_once 'clases/usuarios.php';
    require_once 'clases/adm_centro.php';
    $conx=new conexion();
    $ssql="select * from auditoria where id=$id";
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->centro=$reg->centro;
    $this->usuario=$reg->usuario;
    $this->fecha=$reg->fecha;
    $this->modulo=$reg->modulo;
    $this->descripcion=$reg->descripcion;
 
   
  }

  function getId() {
    return $this->id;
  }
  
  function getCentro() {
    return $this->centro;
  }
  
  function getModulo() {
    return $this->modulo;
  }
  
  function getUsuario() {
    return $this->usuario;
  }
  
  function getDescripcion() {
      return $this->descripcion;
  }
  
  function getFecha() {
    return $this->fecha;
  }
  
  function getCentrodes() {
      return $this->centrodes;
  }
}

class adm_aud_2 {
  var $id=array();
  var $centro=array();
  var $centronom=array();
  var $fecha=array();
  var $usuario=array();
  var $usuarionom=array();
  var $modulo=array();
  var $descripcion=array();
  var $maxregistros=0;
 

    
  function __construct($ssql) {
    require_once "clases/conexion.php";
    require_once "clases/usuarios.php";
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
        array_push($this->centro,$reg->centro);
        array_push($this->fecha,$reg->fecha);
        array_push($this->usuario,$reg->usuario);
        array_push($this->modulo,$reg->modulo);
        array_push($this->descripcion,$reg->descripcion);
        array_push($this->centronom,"MADEDERA FORESTAL TIGRE");
        $usu=new usuarios_1($reg->usuario);
        array_push($this->usuarionom, $usu->getNombre()." ".substr($usu->getApellido(),0,1).".");
      }
    }
  }

  function getId() {
    return $this->id;
  }
  
  function getCentro() {
    return $this->centro;
  }
  
  function getUsuario() {
    return $this->usuario;
  }
  
  function getFecha() {
    return $this->fecha;
  }
  
  function getModulo() {
      return $this->modulo;
  }
  
  function getDescripcion() {
    return $this->descripcion;
  }
  
  
  function getMaxRegistros() {
    return $this->maxregistros;
  }
  
  function getUsuarionom() {
    return $this->usuarionom;
  }
  
  function getCentronom() {
      return $this->centronom;
  }
  
}


?>
