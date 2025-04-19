<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Abonos{


    //implementamos nuestro constructor
    public function __construct(){

    }

//metodo insertar registro
   
    public function provincia(){
        $sql="CALL sp_catalgo('spa2','0','', '',9)";
        return ejecutarConsultaSP($sql);
    }
   

    public function listar_abonos($ped_id){
        $sql="CALL sp_abonos(1, $ped_id);";
        //echo $sql;
        return ejecutarConsultaSP($sql);
    }


}