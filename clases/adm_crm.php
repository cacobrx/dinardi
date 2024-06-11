<?php
/*
 * Creado el 17/01/2019 17:28:09
 * Autor: gus
 * Archivo: adm_crm.php
 * planbsistemas.com.ar
 */

class adm_crm_1 {
    var $id=0;
    var $fecha='';
    var $idrem=0;
    var $estado="";
    var $idope="";
    var $operarios="";
    var $horainicio="";
    var $horafin="";
    var $recipientes;
    var $observaciones;
    var $remito="";
    var $responsable="";
    var $faena=0;
    var $det_id=array();
    var $det_idcrm=array();
    var $det_idart=array();
    var $det_cantidad=array();
    var $det_peso=array();
    var $det_temperatura=array();
    var $det_observaciones=array();
    var $det_articulo=array();
    var $fae_idart=array();
    var $fae_articulo=array();
    var $fae_peso=array();
    var $fae_precio=array();
    var $fae_total=array();
    var $fae_precio1=array();
    var $fae_precio2=array();
    var $hayfaena=0;
    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_rem.php';
        require_once 'clases/adm_crm_det.php';
        require_once 'clases/datesupport.php';
        require_once 'clases/usuarios.php';
        require_once 'clases/adm_prv_pre.php';
        require_once 'clases/adm_fae_det.php';
        $dsup=new datesupport();
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_crm where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->fecha=$reg->fecha;
        $this->idrem=$reg->idrem;
        $this->observaciones=$reg->observaciones;
        $this->estado=$reg->estado;
        $this->horainicio=$reg->horainicio;
        $this->horafin=$reg->horafin;
        $this->idope=$reg->idope;
        $this->operarios=$reg->operarios;
        $this->recipientes=$reg->recipientes;
        $this->faena=$reg->faena;
        $ssql="select * from adm_crm_det where idcrm=".$reg->id;
        $det=new adm_crm_det_2($ssql, $conn);
        $this->det_id=$det->getId();
        $this->det_peso=$det->getpeso();
        $this->det_idart=$det->getIdart();
        $this->det_cantidad=$det->getCantidad();
        $this->det_temperatura=$det->getTemperatura();
        $this->det_articulo=$det->getArticulo();
        $this->det_observaciones=$det->getObservaciones();
        $rem=new adm_rem_1($reg->idrem,$conn);
        $ssql="select * from adm_fae_det where idcrm=".$reg->id;
        $fae=new adm_fae_det_2($ssql, $conn);
        $ff_idart=$fae->getIdart();
        $ff_art=$fae->getArticulo();
        $ff_pes=$fae->getPeso();
        $ff_pre=$fae->getPrecio();
        $ff_tot=$fae->getTotal();
        $ff_pre1=array();
        $ff_pre2=array();
        for($f=0;$f<count($ff_idart);$f++) {
            $ppp=new adm_prv_pre_1($rem->getIdprv(), $ff_idart[$f], $conn);
            array_push($ff_pre1,$ppp->getPreciominimo());
            array_push($ff_pre2,$ppp->getPreciomaximo());
        }
        $this->hayfaena=1;
        if(count($ff_idart)==0) {
            $this->hayfaena=0;
            $f_idart=$det->getIdart();
            $f_art=$det->getArticulo();
            $f_pes=$det->getCantidad();
            $ff_idart=array();
            $ff_art=array();
            $ff_pes=array();
            $ff_pre=array();
            $ff_tot=array();
            $ff_pre1=array();
            $ff_pre2=array();
            for($f=0;$f<count($f_idart);$f++) {
                $search= array_search($f_idart[$f], $ff_idart);
                if($search===false) {
                    array_push($ff_idart, $f_idart[$f]);
                    array_push($ff_art,$f_art[$f]);
                    array_push($ff_pes,$f_pes[$f]);
                    $ppp=new adm_prv_pre_1($rem->getIdprv(), $f_idart[$f], $conn);
                    array_push($ff_pre,$ppp->getImporte());
                    array_push($ff_tot,$ppp->getImporte()*$f_pes[$f]);
                    array_push($ff_pre1,$ppp->getPreciominimo());
                    array_push($ff_pre2,$ppp->getPreciomaximo());
                } else {
                    $ff_pes[$search]+=$f_pes[$f];
                }
            }
        }
        $this->fae_articulo=$ff_art;
        $this->fae_idart=$ff_idart;
        $this->fae_peso=$ff_pes;
        $this->fae_precio=$ff_pre;
        $this->fae_total=$ff_tot;
        $this->fae_precio1=$ff_pre1;
        $this->fae_precio2=$ff_pre2;
        $this->remito="#".$reg->idrem." ".$dsup->getFechaNormalCorta($rem->getFecha())." ".$rem->getProveedor();
        if($reg->idope>0) {
            $usu=new usuarios_1($reg->idope,$conn);
            $this->responsable=$usu->getApellido()." ".$usu->getNombre();
        }    
        
    }

    function getId() {
        return $this->id;
    }
  
    function getIdrem() {
        return $this->idrem;
    }
  
    function getFecha() {
        return $this->fecha;
    }
    
    function getEstado() {
        return $this->estado;
    }
  
    function getHorainicio() {
        return $this->horainicio;
    }
    
    function getHorafin() { return $this->horafin; }
    function getIdope() { return $this->idope; }
    function getOperarios() { return $this->operarios; }
    function getRecipientes() { return $this->recipientes; }
    
    
    function getObservaciones() { return $this->observaciones; }
    function getRemito() { return $this->remito; }
    function getResponsable() { return $this->responsable; }
    function getFaena() { return $this->faena; }
    
    function getDet_id() { return $this->det_id; }
    function getDet_idcrm() { return $this->det_idcrm; }
    function getDet_peso() { return $this->det_peso; }
    function getDet_idart() { return $this->det_idart; }
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_temperatura() { return $this->det_temperatura; }
    function getDet_articulo() { return $this->det_articulo; }
    function getDet_observaciones() { return $this->det_observaciones; }
    
    function getFae_idart() { return $this->fae_idart; }
    function getFae_peso() { return $this->fae_peso; }
    function getFae_articulo() { return $this->fae_articulo; }
    function getFae_precio() { return $this->fae_precio; }
    function getFae_total() { return $this->fae_total; }
    function getFae_precio1() { return $this->fae_precio1; }
    function getFae_precio2() { return $this->fae_precio2; }
    function getHayfaena() { return $this->hayfaena; }
}

class adm_crm_2 {
    var $id=array();
    var $fecha=array();
    var $idrem=array();
    var $remito=array();
    var $horainicio=array();
    var $observaciones=array();
    var $horafin=array();
    var $idope=array();
    var $responsable=array();
    var $operarios=array();
    var $recipientes=array();
    var $estado=array();
    var $faena=array();
    var $totalremito=array();
    
    var $det_id=array();
    var $det_idcrm=array();
    var $det_peso=array();
    var $det_idart=array();
    var $det_cantidad=array();
    var $det_temperatura=array();
    var $det_articulo=array();
    var $det_observaciones=array();
    var $det_idela=array();
    var $det_idenv=array();
    
    var $fae_idart=array();
    var $fae_articulo=array();
    var $fae_peso=array();
    var $fae_precio=array();
    var $fae_total=array();
    var $fae_precio1=array();
    var $fae_precio2=array();
    
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_rem.php';
        require_once 'clases/adm_crm_det.php';
        require_once 'clases/datesupport.php';
        require_once 'clases/usuarios.php';
        require_once 'clases/adm_fae_det.php';
        require_once 'clases/adm_prv_pre.php';
        
        $dsup=new datesupport();
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
                array_push($this->fecha,$reg->fecha);
                array_push($this->idrem,$reg->idrem);
                array_push($this->faena,$reg->faena);
                array_push($this->observaciones,$reg->observaciones);
                array_push($this->horainicio,$reg->horainicio);
                array_push($this->horafin,$reg->horafin);
                array_push($this->estado,$reg->estado);
                array_push($this->idope,$reg->idope);
                array_push($this->operarios,$reg->operarios);
                array_push($this->recipientes,$reg->recipientes);
                $ssql="select * from adm_crm_det where idcrm=".$reg->id;
                $det=new adm_crm_det_2($ssql, $conn);
                array_push($this->det_id,$det->getId());
                array_push($this->det_idcrm,$det->getIdcrm());
                array_push($this->det_peso,$det->getPeso());
                array_push($this->det_idart,$det->getIdart());
                array_push($this->det_cantidad,$det->getCantidad());
                array_push($this->det_temperatura,$det->getTemperatura());
                array_push($this->det_articulo,$det->getArticulo());
                array_push($this->det_observaciones,$det->getObservaciones());
                array_push($this->det_idela,$det->getIdela);
                array_push($this->det_idenv,$reg->idenv);
                $rem=new adm_rem_1($reg->idrem,$conn);
                array_push($this->remito,"#".$reg->idrem." ".$dsup->getFechaNormalCorta($rem->getFecha())." ".$rem->getProveedor());
                array_push($this->totalremito,$rem->getTotal());
                if($reg->idope>0) {
                    $usu=new usuarios_1($reg->idope,$conn);
                    array_push($this->responsable,$usu->getApellido()." ".$usu->getNombre());
                } else
                    array_push($this->responsable,"");
                
                $ssql="select * from adm_fae_det where idcrm=".$reg->id;
                $fae=new adm_fae_det_2($ssql, $conn);
                $ff_idart=$fae->getIdart();
                $ff_art=$fae->getArticulo();
                $ff_pes=$fae->getPeso();
                $ff_pre=$fae->getPrecio();
                $ff_tot=$fae->getTotal();
                $ff_pre1=array();
                $ff_pre2=array();
                for($f=0;$f<count($ff_idart);$f++) {
                    $ppp=new adm_prv_pre_1($rem->getIdprv(), $ff_idart[$f], $conn);
                    array_push($ff_pre1,$ppp->getPreciominimo());
                    array_push($ff_pre2,$ppp->getPreciomaximo());
                }
                $this->hayfaena=1;
                if(count($ff_idart)==0) {
                    $this->hayfaena=0;
                    $f_idart=$det->getIdart();
                    $f_art=$det->getArticulo();
                    $f_pes=$det->getCantidad();
                    $ff_idart=array();
                    $ff_art=array();
                    $ff_pes=array();
                    $ff_pre=array();
                    $ff_tot=array();
                    $ff_pre1=array();
                    $ff_pre2=array();
                    for($f=0;$f<count($f_idart);$f++) {
                        $search= array_search($f_idart[$f], $ff_idart);
                        if($search===false) {
                            array_push($ff_idart, $f_idart[$f]);
                            array_push($ff_art,$f_art[$f]);
                            array_push($ff_pes,$f_pes[$f]);
                            $ppp=new adm_prv_pre_1($rem->getIdprv(), $f_idart[$f], $conn);
                            array_push($ff_pre,$ppp->getImporte());
                            array_push($ff_tot,$ppp->getImporte()*$f_pes[$f]);
                            array_push($ff_pre1,$ppp->getPreciominimo());
                            array_push($ff_pre2,$ppp->getPreciomaximo());
                        } else {
                            $ff_pes[$search]+=$f_pes[$f];
                        }
                    }
                }
                array_push($this->fae_articulo,$ff_art);
                array_push($this->fae_idart,$ff_idart);
                array_push($this->fae_peso,$ff_pes);
                array_push($this->fae_precio,$ff_pre);
                array_push($this->fae_total,$ff_tot);
                array_push($this->fae_precio1,$ff_pre1);
                array_push($this->fae_precio2,$ff_pre2);
                
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getIdrem() {
        return $this->idprv;
    }
  
    function getFecha() {
        return $this->fecha;
    }
    
    function getEstado() {
        return $this->estado;
    }
  
    function getHorainicio() {
        return $this->horainicio;
    }
    
    function getHorafin() { return $this->horafin; }
    function getIdope() { return $this->idope; }
    function getOperarios() { return $this->operarios; }
    function getRecipientes() { return $this->recipientes; }
    function getRemito() { return $this->remito; }
    function getResponsable() { return $this->responsable; }
    function getFaena() { return $this->faena; }
   
    function getObservaciones() { return $this->observaciones; }
    
    function getDet_id() { return $this->det_id; }
    function getDet_idcrm() { return $this->det_idcrm; }
    function getDet_peso() { return $this->det_peso; }
    function getDet_idart() { return $this->det_idart; }
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_temperatura() { return $this->det_temperatura; }
    function getDet_articulo() { return $this->det_articulo; }
    function getDet_observaciones() { return $this->det_observaciones; }
    function getDet_idela() { return $this->idela; }
    function getDet_idenv() { return $this->idenv; }
  
    function getFae_idart() { return $this->fae_idart; }
    function getFae_peso() { return $this->fae_peso; }
    function getFae_articulo() { return $this->fae_articulo; }
    function getFae_precio() { return $this->fae_precio; }
    function getFae_total() { return $this->fae_total; }
    function getFae_precio1() { return $this->fae_precio1; }
    function getFae_precio2() { return $this->fae_precio2; }
    
    function getTotalremito() { return $this->totalremito; }
    
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>
