<?
/*
 *Created on 12/11/12 - 12:28:49
 *Author: Gustavo
 *File: adm_opg1.php
 */

class adm_rec1_1 {
  var $id=0;
  var $centro=0;
  var $fecha=0;
  var $idcli=0;
  var $cliente='';
  var $direccion="";
  var $concepto="";
  var $idmov=0;
  var $idmov3=0;
  var $importe=0;
  var $numero=0;
  var $numeroadj=0;
  var $tipocontabilidad=0;
  var $caja=0;
  var $cajades="";

  function __construct($id, $conn="0") { 
    require_once('conexion.php');
    require_once 'clases/adm_cli.php';
    require_once 'clases/adm_caj.php';
    if($id>0) {
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql='select * from adm_rec1 where id='.$id;
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->fecha=$reg->fecha;
        $this->idcli=$reg->idcli;
        $this->importe=$reg->importe;
        $this->concepto=$reg->concepto;
        $this->idmov=$reg->idmov;
        $this->numero=$reg->numero;
        $this->tipocontabilidad=$reg->tipocontabilidad;
        $cli=new adm_cli_1($reg->idcli,$conn);
        $this->cliente=$cli->getApellido()." ".$cli->getNombre();
        $this->direccion=$cli->getDireccion()." ".$cli->getCiudaddes();
        $this->caja=$reg->caja;
        $caj=new adm_caj_1($reg->caja, $conn);
        $this->cajades=$caj->getNombre();
    }
    
  }

  function getId() {
    return $this->id;
  }

  function getCentro() {
    return $this->centro;
  }

  function getFecha() {
    return $this->fecha;
  }

  function getCliente() {
    return $this->cliente;
  }
  
  function getDireccion() {
      return $this->direccion;
  }
  
  function getConcepto() {
      return $this->concepto;
  }
  
  function getIdcli() {
      return $this->idcli;
  }
  
  function getImporte() {
      return $this->importe;
  }
  
  function getIdmov() {
      return $this->idmov;
  }
  
  function getIdmov3() {
      return $this->idmov3;
  }
  
  function getNumero() {
      return $this->numero;
  }
  
  function getNumeroadj() {
      return $this->numeroadj;
  }
  
  function getTipocontabilidad() {
      return $this->tipocontabilidad;
  }
  
  function getCaja() { return $this->caja; }
  function getCajades() { return $this->cajades; }

}

class adm_rec1_2 {
  var $id=array();
  var $centro=array();
  var $fecha=array();
  var $cliente=array();
  var $direccion=array();
  var $totalimporte=array();
  var $concepto=array();
  var $idcli=array();
  var $idmov=array();
  var $idmov3=array();
  var $importe=array();
  var $numero=array();
  var $numeroadj=array();
  var $caja=array();
  var $cajades=array();
  var $maxregistros=0;

  function __construct($ssql, $conn="0") { 
    require_once('conexion.php');
    require_once 'clases/adm_cli.php';
    require_once 'clases/adm_caj.php';
    $conx=new conexion();
    if($conn=="0") $conn=$conx->conectarBase ();
    if($conx->getCantidadRegA($ssql,$conn)>0) {
      if(strpos($ssql,'limit')=='')
        $ssqltot=$ssql;
      else
        $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
      $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
      $rs=$conx->consultaBase($ssql, $conn);
      while($reg=mysqli_fetch_object($rs)) {
        array_push($this->id,$reg->id);
        array_push($this->centro,$reg->centro);
        array_push($this->fecha,$reg->fecha);
        array_push($this->idcli,$reg->idcli);
        array_push($this->importe,$reg->importe);
        array_push($this->concepto,$reg->concepto);
        array_push($this->idmov,$reg->idmov);
        array_push($this->numero,$reg->numero);
        $ssql="select sum(importe) as totalimporte from adm_rec2 where idrec=".$reg->id;
        //echo $ssql."<br>";
        $ro=$conx->consultaBase($ssql, $conn);
        $rot=mysqli_fetch_object($ro);
        array_push($this->totalimporte,$rot->totalimporte);
        $prv=new adm_cli_1($reg->idcli,$conn);
        array_push($this->cliente,$prv->getApellido()." ".$prv->getNombre());
        array_push($this->direccion,$prv->getDireccion()." ".$prv->getCiudaddes());
        array_push($this->cajades,$reg->caja);
        $caj=new adm_caj_1($reg->caja, $conn);
        array_push($this->cajades,$caj->getNombre());
      }
    }
  }

  function getMaxRegistros() {
    return $this->maxregistros;
  }

  function getId() {
    return $this->id;
  }

  function getCentro() {
    return $this->centro;
  }

  function getFecha() {
    return $this->fecha;
  }

  function getCliente() {
    return $this->cliente;
  }
  
  function getImporte() {
      return $this->importe;
  }
  
  function getDireccion() {
      return $this->direccion;
  }
  
  function getConcepto() {
      return $this->concepto;
  }
  
  function getIdcli() {
      return $this->idcli;
  }
  
  function getTotalimporte() {
      return $this->totalimporte;
  }
  
  function getIdmov() {
      return $this->idmov;
  }
  
  function getIdmov3() {
      return $this->idmov3;
  }
  
  function getNumero() {
      return $this->numero;
  }
  
  function getNumeroadj() {
      return $this->numeroadj;
  }
  
  function getCaja() { return $this->caja; }
  function getCajades() { return $this->cajades; }
  

}

class adm_rec_detalle {
    var $fecha=array();
    var $pedido=array();
    var $importe=array();
    var $pagado=array();
    var $fechacom=array();
    var $comprobante=array();
    
    function __construct($ssql, $tipocontabilidad) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cped.php';
        require_once 'clases/adm_vta.php';
        $conx=new conexion();
        if($conx->getCantidadReg($ssql)>0) {
	    $rs=$conx->getConsulta($ssql);
	    while($reg=mysqli_fetch_object($rs)) {
   	        array_push($this->fecha,$reg->fecha);
                array_push($this->pedido,$reg->idcped);
         	array_push($this->pagado,$reg->importe);
                if($tipocontabilidad==1) {
                    $vta=new adm_vta_1($reg->idcped);
                    array_push($this->importe,$vta->getTotaltotal());
                    array_push($this->comprobante,$vta->getTipocomdes()."-".$vta->getLetra()."-".$vta->getPtovta()."-".$vta->getNumero());
                    array_push($this->fechacom,$vta->getFecha());
                } else {
                    $cped=new adm_cped_1($reg->idcped);
                    array_push($this->importe,$cped->getImporte()-$cped->getDescuento()+$cped->getRecargo());
                    array_push($this->comprobante,"Pedido: ".$cped->getId());
                    array_push($this->fechacom,$cped->getFecha());
                }
            }
        }
    }
    
    function getFecha() {
        return $this->fecha;
    }
    
    function getPedido() {
        return $this->pedido;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getPagado() {
        return $this->pagado;
    }
    
    function getComprobante() {
        return $this->comprobante;
    }
    
    function getFechacom() { return $this->fechacom; }
}
?>
