<?
/*
 * Creado el 28/05/2020 10:34:01
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_ela.php
 */
 
class adm_ela_1 {
    var $id=0;
    var $fecha=0;
    var $horaing='';
    var $horaegr=0;
    var $horaing1='';
    var $horaegr1=0;
    var $empleados=0;
    var $observacion1='';
    var $observacion2='';
    var $turno=0;
    var $telaborado1=0;
    var $telaborado2=0;
    var $telaborado3=0;
    var $tiempoelaboracion=0;
    var $turnodes="";
    var $det_id=array();
    var $det_articulo=array();
    var $det_fechaing=array();
    var $det_proveedor=array();
    var $det_kgdescarte=array();
    var $det_kilos=array();
    var $prv_id=array();
    var $prv_idprv=array();
    var $prv_proveedor=array();
    
    

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_ela_det.php';
        require_once 'clases/datesupport.php';
        $conx=new conexion();
        $dsup=new datesupport();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_ela where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->fecha=$reg->fecha;
        $this->horaing=$reg->horaing;
        $this->horaegr=$reg->horaegr;
        $this->horaing1=$reg->horaing1;
        $this->horaegr1=$reg->horaegr1;
        $this->empleados=$reg->empleados;
        $this->observacion1=$reg->observacion1;
        $this->observacion2=$reg->observacion2;
        $this->turno=$reg->turno;
        $this->telaborado1=$reg->telaborado1;
        $this->telaborado2=$reg->telaborado2;
        $this->telaborado3=$reg->telaborado3;     
        $fecha1=$reg->fecha." ".$reg->horaing;
        $fecha2=$reg->fecha." ".$reg->horaegr;
        $fecha3=$reg->fecha." ".$reg->horaing1;
        $fecha4=$reg->fecha." ".$reg->horaegr1;
        //echo "fechadif: ".$dsup->getFechaDif($fecha2, $fecha1, "h");
       
        if($reg->turno==1) $this->turnodes="Mañana";
        if($reg->turno==2) $this->turnodes="Tarde";
        $ssql="select * from adm_ela_det where idela=".$reg->id;
//        echo "ede: $ssql<br>";
        $ela=new adm_ela_det_2($ssql, $conn);
        $this->det_id=$ela->getId();
        $this->det_articulo=$ela->getArticulo();
        $this->det_fechaing=$ela->getFechaing();
        $this->det_kgdescarte=$ela->getKgdescarte();
        $this->det_kilos=$ela->getKgfinal();
        $xdet_id=$ela->getId();
//        print_r($xdet_id);
        for($d=0;$d<count($xdet_id);$d++) {
            $p_id=array();
            $p_idprv=array();
            $p_proveedor=array();
            $ssql="select * from adm_ela_prv where idela=".$reg->id." and iddet=".$xdet_id[$d];
//            echo $ssql."<br>";
            $rp=$conx->consultaBase($ssql, $conn);
            while($rpp=mysqli_fetch_object($rp)) {
                array_push($p_id,$rpp->id);
                array_push($p_idprv,$rpp->idprv);
                $prv=new adm_prv_1($rpp->idprv, $conn);
                array_push($p_proveedor,$prv->getApellido()." ".$prv->getNombre());
            }
            array_push($this->prv_id,$p_id);
            array_push($this->prv_idprv,$p_idprv);
            array_push($this->prv_proveedor,$p_proveedor);
        }
        
    }

    function getId() {
        return $this->id;
    }
  
    function getFecha() {
        return $this->fecha;
    }
  
    function getHoraing() {
        return $this->horaing;
    }
  
    function getHoraegr() {
        return $this->horaegr;
    }
  
    function getHoraing1() {
        return $this->horaing1;
    }
  
    function getHoraegr1() {
        return $this->horaegr1;
    }
  
    function getEmpleados() {
        return $this->empleados;
    }
  
    function getObservacion1() {
        return $this->observacion1;
    }
    function getObservacion2() {
        return $this->observacion2;
    }

    function getTelaborado1() {
        return $this->telaborado1;
    }
  
    function getTelaborado2() {
        return $this->telaborado2;
    }
  
    function getTelaborado3() {
        return $this->telaborado3;
    }    
    
    function getTurnodes() {
        return $this->turnodes;
    }
    
    function getDet_articulo() {
        return $this->det_articulo;
    }
    
    function getDet_proveedor() {
        return $this->det_proveedor;
    }
    
    function getDet_fechaing() {
        return $this->det_fechaing;
    }
    
    function getDet_kgdescarte() {
        return $this->det_kgdescarte;
    }
    
    function getDet_kilos() {
        return $this->det_kilos;
    }
    function getTurno() {
        return $this->turno;
    }
    
    function getDet_id() { return $this->det_id; }
    function getPrv_id() { return $this->prv_id; }
    function getPrv_idprv() { return $this->prv_idprv; }
    function getPrv_proveedor() { return $this->prv_proveedor; }
    
  
}

class adm_ela_2 {
    var $id=array();
    var $fecha=array();
    var $horaing=array();
    var $horaegr=array();
    var $horaing1=array();
    var $horaegr1=array();
    var $empleados=array();
    var $observacion1=array();
    var $observacion2=array();
    var $det_articulo=array();
    var $det_fechaing=array();
    var $det_proveedor=array();
    var $det_kgdescarte=array();
    var $turnodes=array();
    var $telaborado1=array();
    var $telaborado2=array();
    var $telaborado3=array();    
    var $det_kilos=array();
    var $prv_id=array();
    var $prv_idprv=array();
    var $prv_proveedor=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_prv.php';
        require_once 'clases/adm_art.php';
        require_once 'clases/adm_ela_det.php';
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
                array_push($this->horaing,$reg->horaing);
                array_push($this->horaegr,$reg->horaegr);
                array_push($this->horaing1,$reg->horaing1);
                array_push($this->horaegr1,$reg->horaegr1);
                array_push($this->empleados,$reg->empleados);
                array_push($this->observacion1,$reg->observacion1);
                array_push($this->observacion2,$reg->observacion2);
                array_push($this->telaborado1,$reg->telaborado1);
                array_push($this->telaborado2,$reg->telaborado2);
                array_push($this->telaborado3,$reg->telaborado3);                
                if($reg->turno==1) array_push($this->turnodes,"Mañana");
                if($reg->turno==2) array_push($this->turnodes,"Tarde");
                $ssql="select * from adm_ela_det where idela=".$reg->id;
                $ela=new adm_ela_det_2($ssql,$conn);
                array_push($this->det_articulo,$ela->getArticulo());
                array_push($this->det_fechaing,$ela->getFechaing());
                array_push($this->det_kgdescarte,$ela->getKgdescarte());
                array_push($this->det_kilos,$ela->getKgfinal());  
                
                
                $xdet_id=$ela->getId();
        //        print_r($xdet_id);
                $prv_proveedor=array();
                $prv_id=array();
                $prv_idprv=array();
                for($d=0;$d<count($xdet_id);$d++) {
                    $p_id=array();
                    $p_idprv=array();
                    $p_proveedor=array();
                    $ssql="select * from adm_ela_prv where idela=".$reg->id." and iddet=".$xdet_id[$d];
        //            echo $ssql."<br>";
                    $rp=$conx->consultaBase($ssql, $conn);
                    while($rpp=mysqli_fetch_object($rp)) {
                        array_push($p_id,$rpp->id);
                        array_push($p_idprv,$rpp->idprv);
                        $prv=new adm_prv_1($rpp->idprv, $conn);
                        array_push($p_proveedor,$prv->getApellido()." ".$prv->getNombre());
                    }
                    array_push($prv_id,$p_id);
                    array_push($prv_idprv,$p_idprv);
                    array_push($prv_proveedor,$p_proveedor);
                }
                array_push($this->prv_proveedor,$prv_proveedor);
                array_push($this->prv_idprv,$prv_idprv);
                array_push($this->prv_id,$prv_id);
                
                
                
//                $p_id=array();
//                $p_idprv=array();
//                $p_proveedor=array();
//                $ssql="Select * from adm_ela_prv where idela=".$reg->id;
//                $rp=$conx->consultaBase($ssql, $conn);
//                while($rpp=mysqli_fetch_object($rp)) {
//                    array_push($p_id,$rpp->id);
//                    array_push($p_idprv,$rpp->idprv);
//                    $prv=new adm_prv_1($rpp->idprv, $conn);
//                    array_push($p_proveedor,$prv->getApellido()." ".$prv->getNombre());
//                }
//                array_push($this->prv_id,$p_id);
//                array_push($this->prv_idprv,$p_idprv);
//                array_push($this->prv_proveedor,$p_proveedor);
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getFecha() {
        return $this->fecha;
    }
  
    function getHoraing() {
        return $this->horaing;
    }
  
    function getHoraegr() {
        return $this->horaegr;
    }
  
    function getHoraing1() {
        return $this->horaing1;
    }
  
    function getHoraegr1() {
        return $this->horaegr1;
    }
  
    function getEmpleados() {
        return $this->empleados;
    }
  
    function getObservacion1() {
        return $this->observacion1;
    }
    
    function getObservacion2() {
        return $this->observacion2;
    }
    
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
    
        function getTurnodes() {
        return $this->turnodes;
    }
    
  
    function getTelaborado1() {
        return $this->telaborado1;
    }
  
    function getTelaborado2() {
        return $this->telaborado2;
    }
  
    function getTelaborado3() {
        return $this->telaborado3;
    }    
    
    function getDet_articulo() {
        return $this->det_articulo;
    }
    
    function getDet_proveedor() {
        return $this->det_proveedor;
    }
    
    function getDet_fechaing() {
        return $this->det_fechaing;
    }
    
    function getDet_kgdescarte() {
        return $this->det_kgdescarte;
    }
    
    function getDet_kilos() {
        return $this->det_kilos;
    }
    
    function getPrv_id() { return $this->prv_id; }
    function getPrv_idprv() { return $this->prv_id; }
    function getPrv_proveedor() { return $this->prv_proveedor; }
}

class total_ela {
    var $total=0;
    
    function __construct($fechaini, $fechafin) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ssql="select sum(adm_ela_det.kgfinal) as totkil from adm_ela_det, adm_ela where adm_ela.fecha>='$fechaini' and adm_ela.fecha<='$fechafin'";
        $rs=$conx->getConsulta($ssql);
        $reg=mysqli_fetch_object($rs);
        $this->total=$reg->totkil;
    }
    
    function getTotal() { return $this->total; }
}

?>
