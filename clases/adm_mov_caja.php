<?
/*
 * Creado el 19/05/2014 13:04:13
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_mov_caja.php
 */
 
class adm_mov_caja_1 {
    var $id='';
    var $centro=0;
    var $fecha='';
    var $detalle='';
    var $importe=0;
    var $tipocaja=0;
    var $idmov=0;
    var $tipomov=1;
    var $tipocajades="";
    var $descriptor1=0;
    var $descriptor2=0;
    var $descriptor3=0;
    var $descriptor4=0;
    var $segmento1=0;
    var $segmento2=0;
    var $segmento3=0;
    var $segmento4=0;
    var $oficina=0;
    var $descriptor1des="";
    var $descriptor2des="";
    var $descriptor3des="";
    var $descriptor4des="";
    var $segmento1des="";
    var $segmento2des="";
    var $segmento3des="";
    var $segmento4des="";
    var $oficinades="";
    var $tipopago=0;
    var $tipopagodes="";
    var $indice="";
    var $idopg=0;
    var $idrec=0;

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_clasif.php';
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from adm_mov_caja where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->fecha=$reg->fecha;
        $this->detalle=$reg->detalle;
        //$this->importe=$reg->importe;
        $this->tipocaja=$reg->tipocaja;
        $this->idmov=$reg->idmov;
        $this->tipomov=$reg->tipomov;
        $this->indice=$reg->indice;
        if($reg->tipomov==0) {
            $this->tipomovdes="Entrada";
            $this->importe=$reg->importe;
        } else {
            $this->tipomovdes="Salida";
            $this->importe=$reg->importe*-1;
        }
        $this->tipocajades=$conx->getTextoValor($reg->tipocaja, "CAJA",$conn);
        $this->descriptor1=$reg->descriptor1;
        $this->descriptor2=$reg->descriptor2;
        $this->descriptor3=$reg->descriptor3;
        $this->descriptor4=$reg->descriptor4;
        $this->segmento1=$reg->segmento1;
        $this->segmento2=$reg->segmento2;
        $this->segmento3=$reg->segmento3;
        $this->segmento4=$reg->segmento4;
        $this->oficina=$reg->oficina;
        $this->tipopago=$reg->tipopago;
        $this->tipopagodes=$conx->getTextoValor($reg->tipopago, "MEDIO", $conn);
        $cla=new adm_clasif_1($reg->descriptor1);
        $this->descriptor1des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->descriptor2);
        $this->descriptor2des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->descriptor3);
        $this->descriptor3des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->descriptor4);
        $this->descriptor4des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->segmento1);
        $this->segmento1des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->segmento2);
        $this->segmento2des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->segmento3);
        $this->segmento3des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->segmento4);
        $this->segmento4des=$cla->getTexto();
        $this->oficinades=$conx->getTextoValor($reg->oficina, "OFIN1", $conn);
        $this->idopg=$reg->idopg;
        $this->idrec=$reg->idrec;

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

    function getDetalle() {
        return $this->detalle;
    }

    function getImporte() {
        return $this->importe;
    }

    function getTipocaja() {
        return $this->tipocaja;
    }

    function getIdmov() {
        return $this->idmov;
    }

    function getTipomov() {
        return $this->tipomov;
    }

    function getTipomovdes() {
        return $this->tipomovdes;
    }

    function getTipocajades() {
        return $this->tipocajades;
    }
    
    function getDescriptor1() {
        return $this->descriptor1;
    }

    function getDescriptor2() {
        return $this->descriptor2;
    }

    function getDescriptor3() {
        return $this->descriptor3;
    }

    function getDescriptor4() {
        return $this->descriptor4;
    }
    
    function getSegmento1() {
        return $this->segmento1;
    }

    function getSegmento2() {
        return $this->segmento2;
    }

    function getSegmento3() {
        return $this->segmento3;
    }

    function getSegmento4() {
        return $this->segmento4;
    }

    function getOficina() {
        return $this->oficina;
    }
    
    function getDescriptor1des() {
        return $this->descriptor1des;
    }

    function getDescriptor2des() {
        return $this->descriptor2des;
    }

    function getDescriptor3des() {
        return $this->descriptor3des;
    }

    function getDescriptor4des() {
        return $this->descriptor4des;
    }
    
    function getSegmento1des() {
        return $this->segmento1des;
    }

    function getSegmento2des() {
        return $this->segmento2des;
    }

    function getSegmento3des() {
        return $this->segmento3des;
    }

    function getSegmento4des() {
        return $this->segmento4des;
    }

    function getOficinades() {
        return $this->oficinades;
    }
    
    
    function getTipopago() {
        return $this->tipopago;
    }
    
    function getTipopagodes() {
        return $this->tipopagodes;
    }
    
    function getIndice() {
        return $this->indice;
    }
    
    function getIdopg() {
        return $this->idopg;
    }
    
    function getIdrec() {
        return $this->idrec;
    }


}

class adm_mov_caja_opg_1 {
    var $id='';
    var $centro=0;
    var $fecha='';
    var $detalle='';
    var $importe=0;
    var $tipocaja=0;
    var $idmov=0;
    var $tipomov=1;
    var $tipocajades="";
    var $descriptor1=0;
    var $descriptor2=0;
    var $descriptor3=0;
    var $descriptor4=0;
    var $segmento1=0;
    var $segmento2=0;
    var $segmento3=0;
    var $segmento4=0;
    var $oficina=0;
    var $descriptor1des="";
    var $descriptor2des="";
    var $descriptor3des="";
    var $descriptor4des="";
    var $segmento1des="";
    var $segmento2des="";
    var $segmento3des="";
    var $segmento4des="";
    var $oficinades="";
    var $tipopago=0;
    var $tipopagodes="";
    var $indice="";

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_clasif.php';
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from adm_mov_caja where idopg=$id";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql,$conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->fecha=$reg->fecha;
            $this->detalle=$reg->detalle;
            //$this->importe=$reg->importe;
            $this->tipocaja=$reg->tipocaja;
            $this->idmov=$reg->idmov;
            $this->tipomov=$reg->tipomov;
            $this->indice=$reg->indice;
            if($reg->tipomov==0) {
                $this->tipomovdes="Entrada";
                $this->importe=$reg->importe;
            } else {
                $this->tipomovdes="Salida";
                $this->importe=$reg->importe*-1;
            }
            $this->tipocajades=$conx->getTextoValor($reg->tipocaja, "CAJA",$conn);
            $this->descriptor1=$reg->descriptor1;
            $this->descriptor2=$reg->descriptor2;
            $this->descriptor3=$reg->descriptor3;
            $this->descriptor4=$reg->descriptor4;
            $this->segmento1=$reg->segmento1;
            $this->segmento2=$reg->segmento2;
            $this->segmento3=$reg->segmento3;
            $this->segmento4=$reg->segmento4;
            $this->oficina=$reg->oficina;
            $this->tipopago=$reg->tipopago;
            $this->tipopagodes=$conx->getTextoValor($reg->tipopago, "MEDIO", $conn);
            $cla=new adm_clasif_1($reg->descriptor1);
            $this->descriptor1des=$cla->getTexto();
            $cla=new adm_clasif_1($reg->descriptor2);
            $this->descriptor2des=$cla->getTexto();
            $cla=new adm_clasif_1($reg->descriptor3);
            $this->descriptor3des=$cla->getTexto();
            $cla=new adm_clasif_1($reg->descriptor4);
            $this->descriptor4des=$cla->getTexto();
            $cla=new adm_clasif_1($reg->segmento1);
            $this->segmento1des=$cla->getTexto();
            $cla=new adm_clasif_1($reg->segmento2);
            $this->segmento2des=$cla->getTexto();
            $cla=new adm_clasif_1($reg->segmento3);
            $this->segmento3des=$cla->getTexto();
            $cla=new adm_clasif_1($reg->segmento4);
            $this->segmento4des=$cla->getTexto();
            $this->oficinades=$conx->getTextoValor($reg->oficina, "OFIN1", $conn);
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

    function getDetalle() {
        return $this->detalle;
    }

    function getImporte() {
        return $this->importe;
    }

    function getTipocaja() {
        return $this->tipocaja;
    }

    function getIdmov() {
        return $this->idmov;
    }

    function getTipomov() {
        return $this->tipomov;
    }

    function getTipomovdes() {
        return $this->tipomovdes;
    }

    function getTipocajades() {
        return $this->tipocajades;
    }
    
    function getDescriptor1() {
        return $this->descriptor1;
    }

    function getDescriptor2() {
        return $this->descriptor2;
    }

    function getDescriptor3() {
        return $this->descriptor3;
    }

    function getDescriptor4() {
        return $this->descriptor4;
    }
    
    function getSegmento1() {
        return $this->segmento1;
    }

    function getSegmento2() {
        return $this->segmento2;
    }

    function getSegmento3() {
        return $this->segmento3;
    }

    function getSegmento4() {
        return $this->segmento4;
    }

    function getOficina() {
        return $this->oficina;
    }
    
    function getDescriptor1des() {
        return $this->descriptor1des;
    }

    function getDescriptor2des() {
        return $this->descriptor2des;
    }

    function getDescriptor3des() {
        return $this->descriptor3des;
    }

    function getDescriptor4des() {
        return $this->descriptor4des;
    }
    
    function getSegmento1des() {
        return $this->segmento1des;
    }

    function getSegmento2des() {
        return $this->segmento2des;
    }

    function getSegmento3des() {
        return $this->segmento3des;
    }

    function getSegmento4des() {
        return $this->segmento4des;
    }

    function getOficinades() {
        return $this->oficinades;
    }
    
    
    function getTipopago() {
        return $this->tipopago;
    }
    
    function getTipopagodes() {
        return $this->tipopagodes;
    }
    
    function getIndice() {
        return $this->indice;
    }


}


class adm_mov_caja_2 {
    var $id=array();
    var $centro=array();
    var $fecha=array();
    var $detalle=array();
    var $importe=array();
    var $tipocaja=array();
    var $idmov=array();
    var $tipomov=array();
    var $tipomovdes=array();
    var $maxregistros=0;
    var $descriptor1=array();
    var $descriptor2=array();
    var $descriptor3=array();
    var $descriptor4=array();
    var $segmento1=array();
    var $segmento2=array();
    var $segmento3=array();
    var $segmento4=array();
    var $oficina=array();
    var $descriptor1des=array();
    var $descriptor2des=array();
    var $descriptor3des=array();
    var $descriptor4des=array();
    var $segmento1des=array();
    var $segmento2des=array();
    var $segmento3des=array();
    var $segmento4des=array();
    var $oficinades=array();
    var $tipopago=array();
    var $tipopagodes=array();
    var $indice=array();
    var $idrec=array();
    var $idopg=array();

    function __construct($ssql, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_clasif.php';
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
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
                array_push($this->detalle,$reg->detalle);
                //array_push($this->importe,$reg->importe);
                array_push($this->tipocaja,$reg->tipocaja);
                array_push($this->idmov,$reg->idmov);
                array_push($this->tipomov,$reg->tipomov);
                if($reg->tipomov==0) {
                    array_push($this->tipomovdes,"Entrada");
                    array_push($this->importe,$reg->importe);
                } else {
                    array_push($this->tipomovdes,"Salida");
                    array_push($this->importe,$reg->importe*-1);
                }
                array_push($this->descriptor1,$reg->descriptor1);
                array_push($this->descriptor2,$reg->descriptor2);
                array_push($this->descriptor3,$reg->descriptor3);
                array_push($this->descriptor4,$reg->descriptor4);
                array_push($this->segmento1,$reg->segmento1);
                array_push($this->segmento2,$reg->segmento2);
                array_push($this->segmento3,$reg->segmento3);
                array_push($this->segmento4,$reg->segmento4);
                array_push($this->oficina,$reg->oficina);
                $cla=new adm_clasif_1($reg->descriptor1,$conn);
                array_push($this->descriptor1des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor2,$conn);
                array_push($this->descriptor2des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor3,$conn);
                array_push($this->descriptor3des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor4,$conn);
                array_push($this->descriptor4des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->segmento1,$conn);
                array_push($this->segmento1des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->segmento2,$conn);
                array_push($this->segmento2des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->segmento3,$conn);
                array_push($this->segmento3des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->segmento4,$conn);
                array_push($this->segmento4des,$cla->getTexto());
                array_push($this->oficinades,$conx->getTextoValor($reg->oficina,"OFIN1",$conn));
                array_push($this->tipopago,$reg->tipopago);
                array_push($this->tipopagodes,$conx->getTextoValor($reg->tipopago, "MEDIO", $conn));
                array_push($this->indice,$reg->indice);
                array_push($this->idrec,$reg->idrec);
                array_push($this->idopg,$reg->idopg);
            }    
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

    function getDetalle() {
      return $this->detalle;
    }

    function getImporte() {
      return $this->importe;
    }

    function getTipocaja() {
      return $this->tipocaja;
    }

    function getIdmov() {
      return $this->idmov;
    }

    function getTipomov() {
        return $this->tipomov;
    }

    function getTipomovdes() {
        return $this->tipomovdes;
    }



    function getMaxRegistros() {
      return $this->maxregistros;
    }
  
    function getDescriptor1() {
        return $this->descriptor1;
    }

    function getDescriptor2() {
        return $this->descriptor2;
    }

    function getDescriptor3() {
        return $this->descriptor3;
    }

    function getDescriptor4() {
        return $this->descriptor4;
    }
    
    function getSegmento1() {
        return $this->segmento1;
    }

    function getSegmento2() {
        return $this->segmento2;
    }

    function getSegmento3() {
        return $this->segmento3;
    }

    function getSegmento4() {
        return $this->segmento4;
    }

    function getOficina() {
        return $this->oficina;
    }

    function getDescriptor1des() {
        return $this->descriptor1des;
    }

    function getDescriptor2des() {
        return $this->descriptor2des;
    }

    function getDescriptor3des() {
        return $this->descriptor3des;
    }

    function getDescriptor4des() {
        return $this->descriptor4des;
    }
    
    function getSegmento1des() {
        return $this->segmento1des;
    }

    function getSegmento2des() {
        return $this->segmento2des;
    }

    function getSegmento3des() {
        return $this->segmento3des;
    }

    function getSegmento4des() {
        return $this->segmento4des;
    }

    function getOficinades() {
        return $this->oficinades;
    }
    
    function getTipopago() {
        return $this->tipopago;
    }
    
    function getTipopagodes() {
        return $this->tipopagodes;
    }
    
    function getIndice() {
        return $this->indice;
    }
    
    function getIdrec() {
        return $this->idrec;
    }
    
    function getIdopg() {
        return $this->idopg;
    }
    
  
}

?>
