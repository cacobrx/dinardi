<?php
/*
 * Creado el 29/08/2019 11:54:39
 * Autor: gus
 * Archivo: adm_crec.php
 * planbsistemas.com.ar
 */

class adm_crec1_1 {
    var $id=0;
    var $fecha=0;
    var $idcli=0;
    var $cliente='';
    var $direccion="";
    var $concepto="";
    var $importe=0;
    var $caja=0;
    var $cajades="";
    var $numero="";
    var $r3_id=array();
    var $r3_detalle=array();
    var $r3_detallepago=array();
    var $r3_detallepagodes=array();
    var $r3_idcht=array();
    var $r3_importe=array();
    var $r2_id=array();
    var $r2_comprobante=array();
    var $r2_fecha=array();
    var $r2_importe=array();
    var $r2_pagado=array();
    var $r2_idfis=array();
    var $cerrado=0;
    

    function __construct($id, $conn="0") { 
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cli.php';
        require_once 'clases/adm_caj.php';
        if($id>0) {
            $conx=new conexion();
            if($conn=="0") $conn=$conx->conectarBase ();
            $ssql='select * from adm_crec1 where id='.$id;
//            echo $ssql."<br>";
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->fecha=$reg->fecha;
            $this->idcli=$reg->idcli;
            $this->concepto=$reg->concepto;
            $this->numero=$reg->numero;
            $cli=new adm_cli_1($reg->idcli,$conn);
            $this->cliente=$cli->getApellido()." ".$cli->getNombre();
            $this->direccion=$cli->getDireccion()." ".$cli->getCiudaddes();
            $this->caja=$reg->caja;
            $caj=new adm_caj_1($reg->caja, $conn);
            $this->cajades=$caj->getNombre();

            $ssql="select * from adm_crec3 where idcrec=$id";
//            echo $ssql."<br>";
            $cr3=new adm_crec3_2($ssql, $conn);
            $this->r3_detalle=$cr3->getDetalle();
            $this->r3_detallepago=$cr3->getDetallepago();
            $this->r3_detallepagodes=$cr3->getDetallepagodes();
            $this->r3_idcht=$cr3->getIdcht();
            $this->r3_id=$cr3->getId();
            $this->r3_importe=$cr3->getImporte();

            $this->importe=array_sum($cr3->getImporte());
            
            $ssql="select * from adm_crec2 where idcrec=$id";
            $cr2=new adm_crec2_2($ssql, $conn);
            $this->r2_id=$cr2->getId();
            $this->r2_comprobante=$cr2->getComprobante();
            $this->r2_fecha=$cr2->getFecha();
            $this->r2_importe=$cr2->getImporte();
            $this->r2_pagado=$cr2->getImportepago();
            $this->r2_idfis=$cr2->getIdfis();
            $ssql="select * from adm_per where periodo='".date("Ym", strtotime($reg->fecha))."'";
            $this->cerrado=$conx->getCantidadRegA($ssql, $conn);

        }
    }

    function getId() { return $this->id; }
    function getFecha() { return $this->fecha; }
    function getCliente() { return $this->cliente; }
    function getDireccion() { return $this->direccion; }
    function getConcepto() { return $this->concepto; }
    function getIdcli() { return $this->idcli; }
    function getImporte() { return $this->importe; }
    function getCaja() { return $this->caja; }
    function getCajades() { return $this->cajades; }
    function getNumero() { return $this->numero; }
    
    function getR3_id() { return $this->r3_id; }
    function getR3_detalle() { return $this->r3_detalle; }
    function getR3_detallepago() { return $this->r3_detallepago; }
    function getR3_detallepagodes() { return $this->r3_detallepagodes; }
    function getR3_idcht() { return $this->r3_idcht; }
    function getR3_importe() { return $this->r3_importe; }
    
    function getR2_id() { return $this->r2_id; }
    function getR2_fecha() { return $this->r2_fecha; }
    function getR2_comprobante() { return $this->r2_comprobante; }
    function getR2_importe() { return $this->r2_importe; }
    function getR2_pagado() { return $this->r2_pagado; }
    function getR2_idfis() { return $this->r2_idfis; }
    
    function getCerrado() { return $this->cerrado; }

}

class adm_crec1_2 {
    var $id=array();
    var $fecha=array();
    var $idcli=array();
    var $cliente=array();
    var $direccion=array();
    var $concepto=array();
    var $importe=array();
    var $numero=array();
    var $caja=array();
    var $cajades=array();
    var $r3_id=array();
    var $r3_detalle=array();
    var $r3_detallepago=array();
    var $r3_detallepagodes=array();
    var $r3_idcht=array();
    var $r3_importe=array();
    var $r2_id=array();
    var $r2_comprobante=array();
    var $r2_fecha=array();
    var $r2_importe=array();
    var $r2_pagado=array();
    var $cerrado=array();
    
    var $maxregistros=0;

    function __construct($ssql, $conn="0") { 
        require_once 'clases/conexion.php';
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
//            echo $ssql."<br>";
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->fecha,$reg->fecha);
                array_push($this->idcli,$reg->idcli);
                array_push($this->concepto,$reg->concepto);
                array_push($this->numero,$reg->numero);
                $prv=new adm_cli_1($reg->idcli,$conn);
                array_push($this->cliente,$prv->getApellido()." ".$prv->getNombre());
                array_push($this->direccion,$prv->getDireccion()." ".$prv->getCiudaddes());
                array_push($this->cajades,$reg->caja);
                $caj=new adm_caj_1($reg->caja, $conn);
                array_push($this->cajades,$caj->getNombre());
                $ssql="select * from adm_crec3 where idcrec=".$reg->id;
                //echo $ssql."<br>";
                $cr3=new adm_crec3_2($ssql, $conn);
                array_push($this->r3_detalle,$cr3->getDetalle());
                array_push($this->r3_detallepago,$cr3->getDetallepago());
                array_push($this->r3_detallepagodes,$cr3->getDetallepagodes());
                array_push($this->r3_idcht,$cr3->getIdcht());
                array_push($this->r3_importe,$cr3->getImporte());
                array_push($this->r3_id,$cr3->getId());
                $ssql="select * from adm_crec2 where idcrec=".$reg->id;
                //echo $ssql."<br>";
                $cr2=new adm_crec2_2($ssql, $conn);
                array_push($this->r2_id,$cr2->getId());
                array_push($this->r2_comprobante,$cr2->getComprobante());
                array_push($this->r2_fecha,$cr2->getFecha());
                array_push($this->r2_importe,$cr2->getImporte());
                array_push($this->r2_pagado,$cr2->getImportepago());
                $ssql="select * from adm_per where periodo='".date("Ym", strtotime($reg->fecha))."'";
                array_push($this->cerrado,$conx->getCantidadRegA($ssql, $conn));
                array_push($this->importe, array_sum($cr3->getImporte()));
                
            }
        }
    }

    function getMaxRegistros() {
      return $this->maxregistros;
    }

    function getId() { return $this->id; }
    function getFecha() { return $this->fecha; }
    function getCliente() { return $this->cliente; }
    function getDireccion() { return $this->direccion; }
    function getConcepto() { return $this->concepto; }
    function getIdcli() { return $this->idcli; }
    function getImporte() { return $this->importe; }
    function getCaja() { return $this->caja; }
    function getCajades() { return $this->cajades; }
    function getNumero() { return $this->numero; }
    
    function getR3_id() { return $this->r3_id; }
    function getR3_detalle() { return $this->r3_detalle; }
    function getR3_detallepago() { return $this->r3_detallepago; }
    function getR3_detallepagodes() { return $this->r3_detallepagodes; }
    function getR3_idcht() { return $this->r3_idcht; }
    function getR3_importe() { return $this->r3_importe; }
  
    function getR2_id() { return $this->r2_id; }
    function getR2_fecha() { return $this->r2_fecha; }
    function getR2_comprobante() { return $this->r2_comprobante; }
    function getR2_importe() { return $this->r2_importe; }
    function getR2_pagado() { return $this->r2_pagado; }
    function getCerrado() { return $this->cerrado; }

}

class adm_crec2_1 {
    var $id=0;
    var $idcrec=0;
    var $fecha="";
    var $idfis=0;
    var $comprobante="";
    var $importe=0;
    var $importepago=0;
    
    function __construct($id, $conn="0") {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_fis.php';
        require_once 'clases/support.php';
        $conx=new conexion();
        $sup=new support();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql="select * from adm_crec2 where id=$id";
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->idcrec=$reg->idcrec;
        $this->idfis=$reg->idfis;
        $fis=new adm_fis_1($reg->idfis, $conn);
        $this->fecha=$fis->getFecha();
        $this->comprobante=$fis->getTipodes()."-".$fis->getLetra()."-".$sup->AddZeros($fis->getPtovta(), 4)."-".$sup->AddZeros($fis->getNumero(), 8);
        $this->importe=$reg->importe;
        $this->importepago=$reg->importepago;
    }
    
    function getId() { return $this->id; }
    function getIdcrec() { return $this->idcrec; }
    function getFecha() { return $this->fecha; }
    function getIdfis() { return $this->idfis; }
    function getComprobante() { return $this->comprobante; }
    function getImporte() { return $this->importe; }
    function getImportapago() { return $this->importepago; }
    
}

class adm_crec2_2 {
    var $id=array();
    var $fecha=array();
    var $idfis=array();
    var $comprobante=array();
    var $importe=array();
    var $importepago=array();
    
    function __construct($ssql, $conn="0") {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_fis.php';
        require_once 'clases/support.php';
        $conx=new conexion();
        $sup=new support();
//        echo $ssql."<br>";
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
                array_push($this->idfis,$reg->idfis);
                array_push($this->importe,$reg->importe);
                array_push($this->importepago,$reg->importepago);
                $fis=new adm_fis_1($reg->idfis, $conn);
                array_push($this->fecha,$fis->getFecha());
                array_push($this->comprobante,$fis->getTipodes()."-".$fis->getLetra()."-".$sup->AddZeros($fis->getPtovta(), 4)."-".$sup->AddZeros($fis->getNumero(), 8));
            }
        }
        
    }
    
    function getId() { return $this->id; }
    function getFecha() { return $this->fecha; }
    function getIdfis() { return $this->idfis; }
    function getImporte() { return $this->importe; }
    function getImportepago() { return $this->importepago; }
    function getComprobante() { return $this->comprobante; }
}

class adm_crec3_2 {
    var $id=array();
    var $idcrec=array();
    var $detalle=array();
    var $detallepago=array();
    var $detallepagodes=array();
    var $idcht=array();
    var $importe=array();
    var $maxregistros=0;
    
    function __construct($ssql, $conn="0") {
        require_once 'clases/conexion.php';
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
                array_push($this->idcrec,$reg->idcrec);
                if($reg->detalle=="")
                    array_push($this->detalle,"Efectivo");
                else
                    array_push($this->detalle,$reg->detalle);
                array_push($this->detallepago,$reg->detallepago);
                array_push($this->importe,$reg->importe);
                array_push($this->idcht,$reg->idcht);
                array_push($this->detallepagodes,$conx->getTextoValor($reg->detallepago, "DPG", $conn));
            }
        }
    }
        
    function getId() { return $this->id; }
    function getIdcrec() { return $this->idcrec; }
    function getDetalle() { return $this->detalle; }
    function getDetallepago() { return $this->detallepago; }
    function getDetallepagodes() { return $this->detallepagodes; }
    function getImporte() { return $this->importe; }
    function getIdcht() { return $this->idcht; }
    function getMaxregistros() { return $this->maxregistros; }
    
}

class adm_crec3_1 {
    var $id=0;
    var $idcrec=0;
    var $detalle="";
    var $detallepago=0;
    var $detallepagodes="array()";
    var $idcht=0;
    var $importe=0;
    
    function __construct($id, $conn="0") {
        require_once 'clases/conexion.php';
        require_once 'clases/support.php';
        $conx=new conexion();
        $sup=new support();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql="select * from adm_crec3 where id=$id";
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->idcrec=$reg->idcrec;
        $this->detalle=$reg->detalle;
        $this->detallepago=$reg->detallepago;
        $this->idcht=$reg->idcht;
        $this->importe=$reg->importe;
        $this->detallepagodes=$conx->getTextoValor($reg->detallepago, "DPG", $conn);
    }
    
    function getId() { return $this->id; }
    function getIdcrec() { return $this->idcrec; }
    function getDetalle() { return $this->detalle; }
    function getDetallepago() { return $this->detallepago; }
    function getIdcht() { return $this->idcht; }
    function getDetallepagodes() { return $this->detallepagodes; }
    function getImporte() { return $this->importe; }
}