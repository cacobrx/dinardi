<?
/*
 *Created on 23/03/11 - 20:45:18
 *Author: Gustavo
 *File: edd_auditoria.php
 */

class auditoria_1 {
  var $id=0;
  var $fecha='';
  var $usuario=0;
  var $usuarionom="";
  var $centro=0;
  var $modulo='';
  var $descripcion='';

  function __construct($id) { 
    require_once('conexion.php');
    $conx=new conexion();
    $ssql='select * from auditoria where id='.$id;
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->fecha=$reg->fecha;
    $this->usuario=$reg->usuario;
    $this->centro=$reg->centro;
    $this->modulo=$reg->modulo;
    $this->descripcion=$reg->descripcion;
    $ssql="select * from edd_users where id=".$reg->usuario;
    $ru=$conx->getConsulta($ssql);
    $rug=mysqli_fetch_object($ru);
    $this->usuarionom=$rug->apellido." ".$rug->nombre;
  }

  function getId() {
    return $this->id;
  }

  function getFecha() {
    return $this->fecha;
  }

  function getUsuario() {
    return $this->usuario;
  }

  function getCentro() {
    return $this->centro;
  }

  function getModulo() {
    return $this->modulo;
  }

  function getDescripcion() {
    return $this->descripcion;
  }
  
  function getUsuarionom() {
    return $this->getUsuario;
  }

}

class auditoria_2 {
  var $id=array();
  var $fecha=array();
  var $usuario=array();
  var $centro=array();
  var $modulo=array();
  var $descripcion=array();
  var $usuarionom=array();
  var $maxregistros=0;

  function __construct($ssql) { 
    require_once('conexion.php');
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
        array_push($this->fecha,$reg->fecha);
        array_push($this->usuario,$reg->usuario);
        array_push($this->centro,$reg->centro);
        array_push($this->modulo,$reg->modulo);
        array_push($this->descripcion,$reg->descripcion);
        $ssql="select * from edd_users where id=".$reg->usuario;
        $ru=$conx->getConsulta($ssql);
        $rug=mysqli_fetch_object($ru);
        array_push($this->usuarionom,$rug->apellido." ".$rug->nombre);
      }
    }
  }

  function getMaxRegistros() {
    return $this->maxregistros;
  }

  function getId() {
    return $this->id;
  }

  function getFecha() {
    return $this->fecha;
  }

  function getUsuario() {
    return $this->usuario;
  }

  function getCentro() {
    return $this->centro;
  }

  function getModulo() {
    return $this->modulo;
  }

  function getDescripcion() {
    return $this->descripcion;
  }
  
  function getUsuarionom() {
    return $this->usuarionom;
  }

}

class registra_auditoria {
  function regAud($modulo, $usuario, $descripcion, $centro, $idcli=0) {
    require_once("clases/conexion.php");
    $conx=new conexion();
    $ssql="insert into auditoria (fecha, usuario, centro, modulo, descripcion, idcli) values ('".date("Y-m-d H:i:s")."', $usuario, $centro, '$modulo', '$descripcion', $idcli)";
    $conx->getConsulta($ssql);
  }
  
  function regAudC($modulo, $usuario, $descripcion, $centro, $conn, $idcli=0) {
    require_once("clases/conexion.php");
    $conx=new conexion();
    $ssql="insert into auditoria (fecha, usuario, centro, modulo, descripcion, idcli) values ('".date("Y-m-d H:i:s")."', $usuario, $centro, '$modulo', '$descripcion', $idcli)";
    $conx->consultaBase($ssql,$conn);
  }
}  
?>
