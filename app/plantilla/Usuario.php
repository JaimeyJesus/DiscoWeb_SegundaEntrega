<?php

class Usuario{
    public $user;
    public $clave;
    public $nombre;
    public $correo;
    public $estado;
    public $plan;

    function __construct(String $user,String $clave,String $nombre,String $correo,String $plan,String $estado)
    {
        $this->user=$user;
        $this->clave=$clave;
        $this->nombre=$nombre;
        $this->correo=$correo;
        $this->plan=$plan;
        $this->estado=$estado;
    }

    public function __get($atributo){
        if(property_exists($this, $atributo)) {
            return $this->$atributo;
        }
        trigger_error("Atributo no definido ", E_USER_NOTICE);
        return null;
    }
    public function __set($atributo, $valor){
        if(property_exists($this, $atributo)) {
            $this->$atributo=$valor;
        }
        trigger_error("Atributo no definido ", E_USER_NOTICE);
        return null;
    }
}