<?php

class Cifrador{

    public static function cifrar($clave){
        return password_hash($clave, PASSWORD_DEFAULT, ['cost' => 10]);
    }

    public static function verificar($clave, $clavecifrada){
        return password_verify($clave, $clavecifrada);
    }
}
?>