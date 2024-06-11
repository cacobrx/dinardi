<?php
/*
 * creado el 29 abr. 2024 12:25:17
 * Usuario: gus
 * Archivo: asistencias
 */

class asistencias {
    var $idemp=0;
    var $empleado=0;
    var $horaentrada=array();
    var $horasalida=array();
    var $fecha=array();
    var $totaltiempo=array();
    var $extras=array();
    
    function __construct($idemp, $anomes) {
        require_once 'clases/conexion.php';
        require_once 'clases/support.php';
        $conx=new conexion();
        $sup=new support();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_empleados where id=$idemp";
        $remp=$conx->consultaBBase($ssql, $conn);
        $this->idemp=$idemp;
        $this->empleado=$remp->apellido." ".$remp->nombre;
        $xano=substr($anomes,0,4);
        $xmes=substr($anomes,4,2);
        $ssql="select * from horarios where idemp=$idemp and year(fecha)=$xano and month(fecha)=$xmes  order by fechaaplica, fecha";
//        echo $ssql;
        $rs=$conx->consultaBase($ssql, $conn);
        while($reg=mysqli_fetch_object($rs)) {
            $search= array_search($reg->fechaaplica, $this->fecha);
            if($search===false) {
                array_push($this->fecha,$reg->fechaaplica);
                array_push($this->horaentrada,$reg->fecha);
                array_push($this->horasalida,"");
            } else {
                $this->horasalida[$search]=$reg->fecha;
            }
            
        }
        
        for($i=0;$i<count($this->fecha);$i++) {
            $hora_entrada_manana = $this->horaentrada[$i];
            $hora_salida_manana = $this->horasalida[$i];

            // Convertir las horas a objetos DateTime
            $entrada_manana_dt = new DateTime($hora_entrada_manana);
            $salida_manana_dt = new DateTime($hora_salida_manana);

            // Calcular la diferencia de tiempo entre la mañana y la tarde
            $diferencia_manana = $entrada_manana_dt->diff($salida_manana_dt);

            // Sumar las diferencias para obtener el tiempo total transcurrido
            $total_horas = $diferencia_manana->h;
            $total_minutos = $diferencia_manana->i;

            // Si los minutos superan 60, agregar una hora y restar 60 minutos
            if ($total_minutos >= 60) {
                $total_horas++;
                $total_minutos -= 60;
            }

            // Imprimir el tiempo total transcurrido
            array_push($this->totaltiempo,$total_horas.":".$sup->AddZeros($total_minutos,2));
            //echo "El tiempo total transcurrido es: " . $total_horas . " horas y " . $total_minutos . " minutos.";
            $ext=$total_horas - 9;
            array_push($this->extras,$ext.":".$sup->AddZeros($total_minutos,2));
        }
    }
    
    function getIdemp() { return $this->idemp; }
    function getEmpleado() { return $this->empleado; }
    function getFecha() { return $this->fecha; }
    function getHoraentrada() { return $this->horaentrada; }
    function getHorasalida() { return $this->horasalida; }
    function getTotaltiempo() { return $this->totaltiempo; }
    function getExtras() { return $this->extras; }
}