<?
/*
 *Created on 12/11/12 - 12:28:49
 *Author: Gustavo
 *File: adm_opg1.php
 */

class adm_opg1_1 {
    var $id=0;
    var $centro=0;
    var $fecha=0;
    var $idprv=0;
    var $proveedor='';
    var $direccion="";
    var $cuit="";
    var $concepto="";
    var $idmov=0;
    var $idmov3=0;
    var $importe=0;
    var $numero=0;
    var $numeroadj=0;
    var $transferencia=0;
    var $d_idcom=array();
    var $d_importetotal=array();
    var $d_importecancelado=array();
    var $d_fecha=array();
    var $d_comprobante=array();
    var $d_neto=array();
    var $d_tipo=array();
    var $e_detalle=array();
    var $e_importe=array();
    var $e_id=array();
    var $e_tipopago=array();
    var $e_chequet=array();
    var $e_chequep=array();
    var $tipo=array();
    var $tipodes=array();
    var $caja=array();
    var $cajades=array();
    var $retencioniibb="";
    var $retencionganancia="";
    var $numeroret=0;
    var $alicuotaret=0;
    var $numeroretg=0;
    var $cerrado=0;
    var $facturam=0;
    var $tiposer=0;
    var $tiposerdes="";

    function __construct($id) { 
        require_once 'clases/conexion.php';
        require_once 'clases/adm_prv.php';
        require_once 'clases/adm_com.php';
        require_once 'clases/adm_opg2.php';
        require_once 'clases/adm_caj.php';
        if($id>0) {
            $conx=new conexion();
            $ssql='select * from adm_opg1 where id='.$id;
//            echo $ssql."<br>";
            $rs=$conx->getConsulta($ssql);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->fecha=$reg->fecha;
            $this->idprv=$reg->idprv;
//            $this->importe=$reg->importe;
            $this->concepto=$reg->concepto;
            $this->idmov=$reg->idmov;
            $this->idmov3=$reg->idmov3;
            $this->numero=$reg->numero;
            $this->numeroadj=$reg->numeroadj;
            $prv=new adm_prv_1($reg->idprv);
//            echo "ccc; ".$prv->getApellido();
            $this->proveedor=$prv->getApellido()." ".$prv->getNombre();
            $this->direccion=$prv->getDireccion()." ".$prv->getCiudad();
            $this->cuit=$prv->getCuit();
            $ssql="select * from adm_com where idopg=$id order by id";
            $opg3=new adm_com_2($ssql);
            $this->d_comprobante=$opg3->getComprobantetodo();
            $this->d_fecha=$opg3->getFecha();
            $this->d_importetotal=$opg3->getTotaltotal();
            $this->d_importecancelado=$opg3->getImportepag();
            $this->d_idcom=$opg3->getId();
            $this->d_neto=$opg3->getNeto();
            $this->d_tipo=$opg3->getTipocom();
            $fm=$opg3->getLetra();
            if(count($fm)>0)
                $this->facturam=$fm[0];
            else
                $this->facturam="A";
            $ssql="select * from adm_opg2 where idop=$id order by id";
//            echo $ssql;
            $opg2=new adm_opg2_2($ssql);
            $this->e_detalle=$opg2->getDetalle();
            $this->e_importe=$opg2->getImporte();
            $this->e_id=$opg2->getId();
            $this->e_tipopago=$opg2->getTipopago();
            $this->e_chequet=$opg2->getIdcht();
            $this->e_chequep=$opg2->getIdche();
            $this->tipo=$reg->tipo;
            $this->caja=$reg->caja;
            $caj=new adm_caj_1($reg->caja);
            $this->cajades=$caj->getNombre();
            $this->retencioniibb=$reg->retencioniibb;
            $this->retencionganancia=$reg->retencionganancia;
            $this->numeroret=$reg->numeroret;
            $this->alicuotaret=$reg->alicuotaret;
            $this->numeroretg=$reg->numeroretg;
            $this->importe=array_sum($this->e_importe);
            if($reg->tipo==1) $this->tipodes="Compra"; else $this->tipodes="Gasto";
            $ssql="select * from adm_per where periodo='".date("Ym", strtotime($reg->fecha))."'";
            $this->cerrado=$conx->getCantidadReg($ssql);
            $t_des=$opg2->getDetalle();
            $t_imp=$opg2->getImporte();
            for($t=0;$t<count($t_des);$t++) {
                if($t_des[$t]=="Transferencia") $this->transferencia+=$t_imp[$t];
            }
            $this->tiposer=$reg->tiposer;
            if($reg->tiposer==1) $this->tiposerdes="Bienes"; else $this->tiposerdes="Servicios";
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

    function getProveedor() {
        return $this->proveedor;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getConcepto() {
        return $this->concepto;
    }

    function getIdprv() {
        return $this->idprv;
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

    function getD_fecha() {
        return $this->d_fecha;
    }

    function getD_comprobante() {
        return $this->d_comprobante;
    }

    function getD_idcom() {
        return $this->d_idcom;
    }

    function getD_importetotal() {
        return $this->d_importetotal;
    }

    function getD_importecancelado() {
        return $this->d_importecancelado;
    }
    
    function getD_tipo() { return $this->d_tipo; }
    
    function getE_detalle() {
        return $this->e_detalle;
    }
    
    function getE_importe() {
        return $this->e_importe;
    }
    
    function getTipo() { return $this->tipo; }
    function getTipodes() { return $this->tipodes; }
    function getCaja() { return $this->caja; }
    function getCajades() { return $this->cajades; }
    function getRetencioniibb() { return $this->retencioniibb; }
    function getNumeroret() { return $this->numeroret; }
    function getCuit() { return $this->cuit; }
    function getD_neto() { return $this->d_neto; }
    function getAlicuotaret() { return $this->alicuotaret; }
    function getE_id() { return $this->e_id; }
    function getE_tipopago() { return $this->e_tipopago; }
    function getE_chequet() { return $this->e_chequet; }
    function getE_chequep() { return $this->e_chequep; }
    
    function getRetencionganancia() { return $this->retencionganancia; }
    function getNumeroretg() { return $this->numeroretg; }
    function getCerrado() { return $this->cerrado; }
    function getFacturam() { return $this->facturam; } 
    function getTranferencia() { return $this->transferencia; }
    function getTiposer() { return $this->tiposer; }
    function getTiposerdes() { return $this->tiposerdes; }

}

class adm_opg1_2 {
  var $id=array();
  var $centro=array();
  var $fecha=array();
  var $idemp=array();
  var $proveedor=array();
  var $direccion=array();
  var $totalimporte=array();
  var $concepto=array();
  var $idprv=array();
  var $idmov=array();
  var $idmov3=array();
  var $importe=array();
  var $numero=array();
  var $numeroadj=array();
  var $tipo=array();
  var $tipodes=array();
  var $retencioniibb=array();
  var $porcentajeret=array();
  var $numeroret=array();
  var $retencionganancia=array();
  var $cuit=array();
  var $numeroretg=array();
  var $cerrado=array();
  var $facturam=array();
  var $netos=array();
  var $tiposer=array();
  var $tiposerdes=array();
  var $maxregistros=0;

  function __construct($ssql, $conn="0") { 
    require_once('conexion.php');
    require_once 'clases/adm_prv.php';
    $conx=new conexion();
    if($conn=="0") $conn=$conx->conectarBase ();
    if($conx->getCantidadRegA($ssql, $conn)>0) {
      if(strpos($ssql,'limit')=='')
        $ssqltot=$ssql;
      else
        $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
      $this->maxregistros=$conx->getCantidadRegA($ssqltot, $conn);
      $rs=$conx->consultaBase($ssql, $conn);
      while($reg=mysqli_fetch_object($rs)) {
        array_push($this->id,$reg->id);
        array_push($this->centro,$reg->centro);
        array_push($this->fecha,$reg->fecha);
        array_push($this->idprv,$reg->idprv);
        array_push($this->importe,$reg->importe);
        array_push($this->concepto,$reg->concepto);
        array_push($this->idmov,$reg->idmov);
        array_push($this->idmov3,$reg->idmov3);
        array_push($this->numero,$reg->numero);
        array_push($this->idemp,$reg->idemp);
        array_push($this->numeroadj,$reg->numeroadj);
        array_push($this->tipo,$reg->tipo);
        array_push($this->retencioniibb,$reg->retencioniibb);
        array_push($this->numeroret,$reg->numeroret);
        array_push($this->numeroretg,$reg->numeroretg);
        array_push($this->retencionganancia,$reg->retencionganancia);
        if($reg->tipo==1)
            array_push($this->tipodes,"Compra");
        else
            array_push($this->tipodes,"Gasto");
        
        $ssql="select sum(importe) as totalimporte from adm_opg2 where idop=".$reg->id;
        //echo $ssql."<br>";
        $ro=$conx->consultaBase($ssql, $conn);
        $rot=mysqli_fetch_object($ro);
        array_push($this->totalimporte,$rot->totalimporte);
        $prv=new adm_prv_1($reg->idprv, $conn);
        array_push($this->proveedor,$prv->getApellido()." ".$prv->getNombre());
        array_push($this->direccion,$prv->getDireccion()." ".$prv->getCiudad());
        array_push($this->cuit,$prv->getCuit());
        array_push($this->porcentajeret,$prv->getRetencioniibb());
        $ssql="select * from adm_per where periodo='".date("Ym", strtotime($reg->fecha))."'";
        array_push($this->cerrado,$conx->getCantidadRegA($ssql, $conn));
        $ssql="select * from adm_com where idopg=".$reg->id." limit 1";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rc=$conx->consultaBase($ssql, $conn);
            $rcc=mysqli_fetch_object($rc);
            array_push($this->facturam,$rcc->letra);
        } else
            array_push($this->facturan,"A");
        
        $ssql="select sum(neto21 + neto10 + neto27) as totneto from adm_com where idopg=".$reg->id;
        $rn=$conx->consultaBase($ssql, $conn);
        $rnn=mysqli_fetch_object($rn);
        array_push($this->netos, $rnn->totneto);
        array_push($this->tiposer,$reg->tiposer);
        if($reg->tiposer==1) array_push($this->tiposerdes,"Bienes"); else array_push($this->tiposerdes,"Servicios");
        
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

  function getProveedor() {
    return $this->proveedor;
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
  
  function getIdprv() {
      return $this->idprv;
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
  
  function getIdemp() {
      return $this->idemp;
  }
  
  function getNumeroadj() {
      return $this->numeroadj;
  }
  
  function getTipo() { return $this->tipo; }
  function getRetencioniibb() { return $this->retencioniibb; }
  function getNumeroret() { return $this->numeroret; }
  function getCuit() { return $this->cuit; }
  function getTipodes() { return $this->tipodes; }
  function getPorcentajeret() { return $this->porcentajeret; }
  function getRetencionganancia() { return $this->retencionganancia; }
  function getNumeroretg() { return $this->numeroretg; }
  function getCerrado() { return $this->cerrado; }
  function getFacturam() { return $this->facturam; }
  function getNetos() { return $this->netos; }
    function getTiposer() { return $this->tiposer; }
    function getTiposerdes() { return $this->tiposerdes; }

}
?>
