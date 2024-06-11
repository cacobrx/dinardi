<?php
/*
 * Creado el 28/06/2019 20:00:50
 * Autor: gus
 * Archivo: ajuste.php
 * planbsistemas.com.ar
 */

class ajusteinflacion {
    var $codigo=array();
    var $nombre=array();
    var $importedebe=array();
    var $importehaber=array();
    var $anomes=array();
    var $coeficientemes=array();
    var $coeficientecierre=array();
    var $coeficientefin=array();
    var $importereexp=array();
    var $reexpresion=array();
    
    function __construct($idemp, $fechaini, $fechafin) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cta.php';
        require_once 'clases/inflacion.php';
        $fechaf=date("Y-m-01", strtotime("$fechafin"));
        //$fechaf=date("Y-m-d", strtotime("$fechafin - 1 month"));
        $conx=new conexion();
        $ssql="select * from adm_cta where idemp=$idemp and tipo=1 and left(codigo,1)>=3 order by codigo";
        //echo $ssql."\n";
        $cta=new adm_cta_2($ssql);
        $c_id=$cta->getId();
        $c_cod=$cta->getCodigo();
        $c_nom=$cta->getNombre();
        $ssql="select * from inflacion order by fecha";
        $inf=new inflacion_2($ssql);
        $i_coe=$inf->getCoeficiente();
        $i_fec=$inf->getFecha();
        $xanomes=array();
        $fini=date("Y-m-01", strtotime($fechaini));
        while($fini<=$fechafin) {
            array_push($xanomes,date("Ym", strtotime($fini)));
            $fini=date("Y-m-d", strtotime("$fini + 1 month"));
        }
        $search2= array_search($fechaf, $i_fec);
//        echo "$fechaf: search2: $search2 | ".$i_coe[$search2]."\n";
        
        $conn=$conx->conectarBase();
        //$xanomes=$this->anomes;
        for($i=0;$i<count($c_id);$i++) {
            for($x=0;$x<count($xanomes);$x++) {
                $f1=substr($xanomes[$x],0,4)."-".substr($xanomes[$x],4,2)."-01";
                $f2=date("Y-m-d", strtotime("$f1 + 1 month"));
                $f2=date("Y-m-d", strtotime("$f2 - 1 day"));
                $ssql="select sum(adm_mov4.importep) as totdebe from adm_mov4, adm_mov3 where adm_mov4.tipo=0 and adm_mov4.idcta=".$c_id[$i]." and adm_mov3.fecha>='$f1' and adm_mov3.fecha<='$f2' and adm_mov3.id=adm_mov4.idmov1";
//                echo $ssql."\n";
                $reg=$conx->consultaBase($ssql,$conn);
                $rdeb=mysqli_fetch_object($reg);
                $ssql="select sum(adm_mov4.importep) as tothaber from adm_mov4, adm_mov3 where adm_mov4.tipo=1 and adm_mov4.idcta=".$c_id[$i]." and adm_mov3.fecha>='$f1' and adm_mov3.fecha<='$f2' and adm_mov3.id=adm_mov4.idmov1";
//                echo $ssql."\n";
                $reg=$conx->consultaBase($ssql,$conn);
                $rhab=mysqli_fetch_object($reg);
//                echo $c_cod[$i]." | ".$rdeb->totdebe." | ".$rhab->tothaber." | ".$c_id[$i]." | ".$c_nom[$i]." | $f1 | $f2\n";
                $importe=$rdeb->totdebe - $rhab->tothaber;
                if(number_format(abs($importe),2)!="0.00") {
//                    echo "**** AGREGAR ".$c_nom[$i]."\n";
//                    echo "fecha: $f1<br>";
                    array_push($this->anomes,date("Ym", strtotime($f1)));
                    //array_push($this->anomes,$f1);
                    array_push($this->codigo,$c_cod[$i]);
                    array_push($this->nombre,$c_nom[$i]);
                    if($importe>0) {
                        array_push($this->importedebe,abs($importe));
                        array_push($this->importehaber,0);
                    } else {
                        array_push($this->importedebe,0);
                        array_push($this->importehaber,abs($importe));
                    }
                    $search1= array_search($f1, $i_fec);
                    array_push($this->coeficientemes, $i_coe[$search1]);
                    array_push($this->coeficientecierre, $i_coe[$search2]);
                    $cc=$i_coe[$search2]/$i_coe[$search1];
                    $i1=$importe*$cc;
                    array_push($this->coeficientefin,$cc);

                    array_push($this->importereexp,$i1);
                    array_push($this->reexpresion, $i1-$importe);
                }
                    
                
            }
        }
    }
    
    function getAnomes() { return $this->anomes; }
    function getCodigo() { return $this->codigo; }
    function getNombre() { return $this->nombre; }
    function getImportedebe() { return $this->importedebe; }
    function getImportehaber() { return $this->importehaber; }
    function getCoeficientemes() { return $this->coeficientemes; }
    function getCoeficientecierre() { return $this->coeficientecierre; }
    function getCoeficientefin() { return $this->coeficientefin; }
    function getImportereexp() { return $this->importereexp; }
    function getReexpresion() { return $this->reexpresion; }
    
    
}