<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";

class Usuario
{
    //implementamos nuestro constructor
    public function __construct()
    {

    }

    public function verificar($usu_login, $usu_clave)
    {
        $sql = "call sp_logeo('$usu_login','$usu_clave');";
        // return $sql;
        return ejecutarConsultaSP($sql);
    }

//metodo para listar permmisos marcados de un usuario especifico
    public function listarmarcados($cat_id_rol)
    {
        $sql = "CALL sp_permisos(3, $cat_id_rol, 0, 0, 0, 0, 0)";
        //$sql="SELECT * FROM usuario_permiso WHERE idusuario=$usu_id";
        return ejecutarConsultaSP($sql);
    }

//listar registros
    public function listar()
    {
        $sql = "call  sp_usuarios(0,0,0,0,0,0,0,0,0)";
        return ejecutarConsultaSP($sql);
    }

    public function desactivar($usu_id)
    {
        $sql = "call sp_usuarios(1,$usu_id,0,0,0,0,0,0,0)";
        return ejecutarConsultaSP($sql);
    }

    public function activar($usu_id)
    {
        $sql = "call sp_usuarios(2,$usu_id,0,0,0,0,0,0,0)";
        return ejecutarConsultaSP($sql);
    }

    public function cargos()
    {
        $sql = "CALL sp_catalgo('spa2','0','', '',4)";
        return ejecutarConsultaSP($sql);
    }

    public function mostrar($usu_id)
    {
        $sql = "call sp_usuarios(5,$usu_id,0,0,0,0,0,0,0)";
        $row = ejecutarConsultaSP($sql);
        //$sql="SELECT * FROM usuario where usu_id=usu_id";
        return $row->fetch_row();
        //ejecutarConsultaSimpleFila($sql));
    }

//metodo insertar regiustro
    public function insertar($usu_nombre, $usu_cedula, $usu_telefono, $usu_correo, $usu_cargo, $usu_login, $usu_clave)
    {
        $sql = "call  sp_usuarios(3,0,'$usu_nombre','$usu_cedula','$usu_telefono','$usu_correo','$usu_cargo','$usu_login','$usu_clave')";
        return ejecutarConsultaSP($sql);

    }

    public function editar($usu_id, $usu_nombre, $usu_cedula, $usu_telefono, $usu_correo, $usu_cargo, $usu_login, $usu_clave)
    {
        $sql = "CALL sp_usuarios(4,$usu_id,'$usu_nombre','$usu_cedula','$usu_telefono','$usu_correo','$usu_cargo','$usu_login','$usu_clave')";
        return ejecutarConsultaSP($sql);

    }

}