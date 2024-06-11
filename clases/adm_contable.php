<?php
/*
 * creado el 22/11/2017 17:05:16
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_contable
 */



class sumasysaldos {
    var $codigo=array();
    var $nombre=array();
    var $debitos=array();
    var $creditos=array();
    var $letra=array();
    var $espacios=array();
    var $cantespacios=array();
    var $saldo=array();
    
    function __construct($centro, $fechaini, $fechafin) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cta.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_cta where centro=$centro";
//        $ssql.=" and left(codigo,2)='52'";
        $ssql.=" order by codigo";
//        echo $ssql;
        $cta=new adm_cta_2($ssql,$conn);
        $c_id=$cta->getId();
        $c_nom=$cta->getNombre();
        $c_cta=$cta->getCodigo();
        $c_tip=$cta->getTipo();
        for($i=0;$i<count($c_cta);$i++) { 
            $ceros=ltrim(rtrim(strlen($c_cta[$i])))-1;
            for($k=strlen($c_cta[$i])-1;$k>=0;$k--) {
                if(substr($c_cta[$i],$k,1)=="0")
                    $ceros--;
                else
                    break;
            }
            $espacios="";
            $cc=0;
            for($k=0;$k<$ceros;$k++) {
                $espacios.="&nbsp;";
                $cc=$cc+3;
            }
            if($c_tip[$i]==2)
                $tipoletra="letra6bold";
            else
                $tipoletra="letra6";
            $condicioncta=$this->getSqlcuenta0($c_cta[$i], $centro, "adm_mov2",$conn);
//            echo "condicioncta: $condicioncta\n";
            $ssqle="select sum(adm_mov2.importe) as totalentrada from adm_mov2, adm_mov1 where adm_mov2.tipo=1 and ($condicioncta) and (adm_mov1.fecha between '$fechaini' and '$fechafin') and adm_mov2.idmov=adm_mov1.id";
            $ssqls="select sum(adm_mov2.importe) as totalsalida from adm_mov2, adm_mov1 where adm_mov2.tipo=2 and ($condicioncta) and (adm_mov1.fecha between '$fechaini' and '$fechafin') and adm_mov2.idmov=adm_mov1.id";
//            echo $ssqle."\n";
            if($conx->getCantidadRegA($ssqle,$conn)>0) {
                $rs=$conx->consultaBase($ssqle, $conn);
                $reg=mysqli_fetch_object($rs);
                $entrada=$reg->totalentrada;
            } else
                $entrada=0;
            if($conx->getCantidadRegA($ssqls,$conn)>0) {
                $rs=$conx->consultaBase($ssqls, $conn);
                $reg=mysqli_fetch_object($rs);
                $salida=$reg->totalsalida;
            } else
                $salida=0;

            if($entrada>0 or $salida>0) {
                array_push($this->codigo,$c_cta[$i]);
                array_push($this->nombre,$c_nom[$i]);
                array_push($this->debitos,$entrada);
                array_push($this->creditos,$salida);
                array_push($this->espacios,$espacios);
                array_push($this->saldo,$entrada-$salida);
                array_push($this->letra,$tipoletra);
                array_push($this->cantespacios,$cc);
            }
        }
        
    }
    
    function getSqlcuenta0($codigo, $centro, $arc, $conn) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
//        echo substr($codigo,strlen($codigo)-2,strlen($codigo))."\n";
        if(substr($codigo,strlen($codigo)-2,strlen($codigo))=="00") {
            $codigosincero="";
            for($ii=0;$ii<strlen($codigo);$ii++) {
                if(substr($codigo,$ii,1)!="0")
                  $codigosincero.=substr($codigo,$ii,1);
            }
//            echo "codigosincero: $codigosincero\n";
            //echo strlen($codigosincero)."<br>";
            $ssql="select * from adm_cta where left(codigo,".strlen($codigosincero).")='$codigosincero' and centro=$centro";
            $rs=$conx->consultaBase($ssql, $conn);
            $condicion="";
            while($reg=mysqli_fetch_object($rs)) {
                $condicion.="$arc.idcta=".$reg->id." or ";
            }
        } else {
            $ssql="select * from adm_cta where codigo='$codigo' and centro=$centro";
//            echo $ssql."\n";
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $condicion="";
            $condicion.="$arc.idcta=".$reg->id." or ";
        }
        if($condicion!="")
            $condicion=substr($condicion,0,strlen($condicion)-4);
        return $condicion;
    }
      
    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDebitos() {
        return $this->debitos;
    }

    function getCreditos() {
        return $this->creditos;
    }

    function getLetra() {
        return $this->letra;
    }

    function getEspacios() {
        return $this->espacios;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
    
    function getCantespacios() {
        return $this->cantespacios;
    }

}

class libromayor {
    var $idcta=array();
    var $codigo=array();
    var $nombre=array();
    var $entrada=array();
    var $salida=array();
    var $saldo=array();
    var $det_fecha=array();
    var $det_descripcion=array();
    var $det_asiento=array();
    var $det_entrada=array();
    var $det_salida=array();
    var $det_saldo=array();
    
    function __construct($centro, $fechaini, $fechafin, $idcta) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cta.php';
        require_once 'clases/adm_mov.php';
        require_once 'clases/adm_mov2.php';
        require_once 'clases/support.php';
        $conx=new conexion();
        $sup=new support();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_cta where and tipo=1 and centro=$centro order by codigo";
        $cta=new adm_cta_2($ssql);
        $c_id=$cta->getId();
        $c_nom=$cta->getNombre();
        $c_cta=$cta->getCodigo();
        $c_des=array();
        for($i=0;$i<count($c_nom);$i++) {
            array_push($c_des,$c_cta[$i]." | ".$c_nom[$i]);
        }

        $condicioncon="";
        $xcta=explode("|",$idcta);
//        print_r($xcta);
        for($i=0;$i<count($xcta);$i++) { 
            if($xcta[$i]!="") {
//                echo "$i\n";
                $ssql="select adm_mov2.*, adm_mov1.detalle as descripcion, adm_mov1.fecha as fecha, adm_mov1.asiento from adm_mov2, adm_mov1 where adm_mov2.idcta='".$xcta[$i]."' and adm_mov1.fecha>='$fechaini' and adm_mov1.fecha<='$fechafin' and adm_mov2.idmov=adm_mov1.id $condicioncon and adm_mov1.centro=$centro order by adm_mov1.fecha, adm_mov2.id";
//                echo $ssql."\n";
//                echo $xcta[$i]."\n";
                $cta=new adm_cta_1($xcta[$i], $conn);
                array_push($this->idcta,$xcta[$i]);
                array_push($this->codigo,$cta->getCodigo());
                array_push($this->nombre,$cta->getNombre());
                $mov=new adm_mov2_may($ssql,$conn);
                $m_fec=$mov->getFecha();
                $m_des=$mov->getDescripcion();
                $m_asi=$mov->getAsiento();
                $m_tip=$mov->getTipo();
                $m_imp=$mov->getImporte();
                $saldo=0;
                $entrada=0;
                $salida=0;
                for($m=0;$m<count($m_fec);$m++) { 
                    if($m_tip[$m]==1) {
                        $saldo=(float)$saldo + $m_imp[$m];
                        $entrada=(float)$entrada + $m_imp[$m];
                    } else {
                        $saldo=(float)$saldo - $m_imp[$m];
                        $salida=(float)$salida + $m_imp[$m];
                    }
                }
                $nombrez=$sup->Obtener_Descripcion($xcta[$i], $c_cta, $c_nom);
//                array_push($this->idcta,$xcta[$i]);
//                array_push($this->nombre,$nombrez);
                array_push($this->entrada,$entrada);
                array_push($this->salida,$salida);
                array_push($this->saldo,$saldo);
                $saldo=0;
                $d_fecha=array();
                $d_descripcion=array();
                $d_asiento=array();
                $d_entrada=array();
                $d_salida=array();
                $d_saldo=array();
//                print_r($m_fec);
                for($m=0;$m<count($m_fec);$m++) { 
                    if($m_tip[$m]==1)
                        $saldo=(float)$saldo + $m_imp[$m];
                    else
                        $saldo=(float)$saldo - $m_imp[$m];
                    array_push($d_fecha,$m_fec[$m]);
                    array_push($d_asiento,$m_asi[$m]);
                    array_push($d_descripcion,$m_des[$m]);
                    if($m_tip[$m]==1) {
                        array_push($d_entrada,$m_imp[$m]);
                        array_push($d_salida,0);
                    } else {
                        array_push($d_entrada,0);
                        array_push($d_salida,$m_imp[$m]);
                    }
                    array_push($d_saldo,$saldo);
                }
                array_push($this->det_entrada,$d_entrada);
                array_push($this->det_salida,$d_salida);
                array_push($this->det_asiento,$d_asiento);
                array_push($this->det_descripcion,$d_descripcion);
                array_push($this->det_fecha,$d_fecha);
                array_push($this->det_saldo,$d_saldo);
            }
        }
    }
    
    function getIdcta() {
        return $this->idcta;
    }
    
    function getCodigo() {
        return $this->codigo;
    }
    
    function getNombre() {
        return $this->nombre;
    }
    
    function getEntrada() {
        return $this->entrada;
    }
    
    function getSalida() {
        return $this->salida;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
    
    function getDet_fecha() {
        return $this->det_fecha;
    }
    
    function getDet_asiento() {
        return $this->det_asiento;
    }
    
    function getDet_descripcion() {
        return $this->det_descripcion;
    }
    
    function getDet_entrada() {
        return $this->det_entrada;
    }
    
    function getDet_salida() {
        return $this->det_salida;
    }
    
    function getDet_saldo() {
        return $this->det_saldo;
    }
}

class diferencias_mov {
    var $fecha=array();
    var $asiento=array();
    var $id=array();
    var $descripcion=array();
    var $debe=array();
    var $haber=array();
    var $saldo=array();
    
    function __construct($centro, $fechaini, $fechafin) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_mov1 where fecha>='$fechaini' and fecha<='$fechafin' and centro=$centro order by asiento";
//        echo $ssql."<br>";
        $rs=$conx->consultaBase($ssql, $conn);
        while($reg=mysqli_fetch_object($rs)) {
            $ssql="select sum(importe) as totaldebe from adm_mov2 where idmov=".$reg->id." and tipo=1";
        //    echo $ssql."<br>";
            $rd=$conx->consultaBase($ssql, $conn);
            $rdd=  mysqli_fetch_object($rd);
            $totaldebe=$rdd->totaldebe;
            $ssql="select sum(importe) as totalhaber from adm_mov2 where idmov=".$reg->id." and tipo=2";
            $rh=$conx->consultaBase($ssql, $conn);
            $rhh=  mysqli_fetch_object($rh);
            $totalhaber=$rhh->totalhaber;
            if($totaldebe!=$totalhaber) {
                array_push($this->fecha,$reg->fecha);
                array_push($this->asiento,$reg->asiento);
                array_push($this->debe,$totaldebe);
                array_push($this->haber,$totalhaber);
                array_push($this->saldo,$totaldebe-$totalhaber);
                array_push($this->id,$reg->id);
                array_push($this->descripcion,$reg->detalle);
            }
//                echo "Asiento: ".$reg->asiento." | Fecha: ".$reg->fecha." | Debe: $totaldebe | Haber: $totalhaber"."<br>";
//            $ssql="select * from $mov2 where idmov1=".$reg->id;
//            if($conx->getCantidadRegA($ssql, $conn)==0) {
//                echo "No hay detalle asiento ".$reg->id." - Fecha: ".$reg->fecha."<br>";
//            }
        }
        
    }
    
    function getId() { return $this->id; }
    function getFecha() { return $this->fecha; }
    function getAsiento() { return $this->asiento; }
    function getDebe() { return $this->debe; }
    function getHaber() { return $this->haber; }
    function getSaldo() { return $this->saldo; }
    function getDescripcion() { return $this->descripcion; }
    
}
