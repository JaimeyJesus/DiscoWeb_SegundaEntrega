<?php 

/* DATOS DE USUARIO
• Identificador ( 5 a 10 caracteres, no debe existir previamente, solo letras y números)
• Contraseña ( 8 a 15 caracteres, debe ser segura)
• Nombre ( Nombre y apellidos del usuario
• Correo electrónico ( Valor válido de dirección correo, no debe existir previamente)
• Tipo de Plan (0-Básico |1-Profesional |2- Premium| 3- Máster)
• Estado: (A-Activo | B-Bloqueado |I-Inactivo )
*/
// Inicializo el modelo 
// Cargo los datos del fichero a la session
function modeloUserInit(){
    
    /*
    $tusuarios = [ 
         "admin"  => ["12345"      ,"Administrado"   ,"admin@system.com"   ,3,"A"],
         "user01" => ["user01clave","Fernando Pérez" ,"user01@gmailio.com" ,0,"A"],
         "user02" => ["user02clave","Carmen García"  ,"user02@gmailio.com" ,1,"B"],
         "yes33" =>  ["micasa23"   ,"Jesica Rico"    ,"yes33@gmailio.com"  ,2,"I"]
        ];*/
    
   
    $datosjson = @file_get_contents(FILEUSER) or die("ERROR al abrir fichero de usuarios");
    $tusuarios = json_decode($datosjson, true);
    
     if(!isset($_SESSION['tusuarios'])){
    $_SESSION['tusuarios'] = $tusuarios;
    }

      
}

// Comprueba usuario y contraseña (boolean)
function modeloOkUser($user,$password){
    $tusuarios = $_SESSION['tusuarios'];
    foreach ($tusuarios as $clave => $valor){      
        if($clave==$user){
            if($tusuarios[$clave][0]==$password){
                return true;
            }
        }           
    }
    return false;
    
}

// Devuelve el plan de usuario (String)
function modeloObtenerTipo($user){
    return $_SESSION['tusuarios'][$user][3];
}

// Borrar un usuario (boolean)
function modeloUserDel($user){
    if(isset($_SESSION['tusuarios'][$user])){
        unset($_SESSION['tusuarios'][$user]);
        return true;
    }
    return false;
}

// Tabla de todos los usuarios para visualizar
function modeloUserGetAll (){
    // Genero lo datos para la vista que no muestra la contraseña ni los códigos de estado o plan
    // sino su traducción a texto
    $tuservista=[];
    foreach ($_SESSION['tusuarios'] as $clave => $datosusuario){
        $tuservista[$clave] = [$datosusuario[0],
                               $datosusuario[1],
                               $datosusuario[2],
                               PLANES[$datosusuario[3]],
                               ESTADOS[$datosusuario[4]]
                               ];
    }
    return $tuservista;
}

// Vuelca los datos al fichero
function modeloUserSave(){
    
    $datosjon = json_encode($_SESSION['tusuarios']);
    file_put_contents(FILEUSER, $datosjon) or die ("Error al escribir en el fichero.");
  
}

//Vuelca nuevo usuario en la session
function modeloUserNuevo($idusuario, $datosuser){
   
    $_SESSION['tusuarios'][$idusuario]=$datosuser;
    
    return true;
}

//Actualiza un usuario en la session
function modeloUserUpdate($id, $arrayValores){
    $_SESSION['tusuarios'][$id]=$arrayValores;
}

//Funcion que comprueba todas las entradas del formulario Nuevo
function modeloUserComprobacionesNuevo($usuarioid,$valoresusuario, $passrepetida ,&$msg){
    if(modeloUserComprobarId($usuarioid, $msg)){
        if(comprobarContraseñas($valoresusuario[0],$passrepetida, $msg)){
            if(modeloUserComprobarNombre($valoresusuario[1], $msg)){
                if(modeloUserComprobarMail($valoresusuario[2], $msg)){
                    return true;
                }
            }
        }
    }
    return false;
}

//Funcion que comprueba las entradas del formulario modificar
function modeloUserComprobacionesModificar($valoresusuario, &$msg){
    if(comprobarContraseñas($valoresusuario[0],$valoresusuario[0], $msg)){
        if(modeloUserComprobarNombre($valoresusuario[1], $msg)){
            if(ComprobarMailModificar($valoresusuario[2], $msg)){
                return true;
            }
        }   
    }
    return false;
}


function modeloUserComprobarId($id, &$msg){
    if(strlen($id)<5 || strlen($id)>10){
        $msg="El id de usuario debe tener entre 5 y 10 caracteres.";
        return false;
    }
    if(isset($_SESSION['tusuarios'][$id])){
        $msg="Ya existe un usuario con ese id.";
        return false;
    }
    if(!ctype_alnum($id)){
        $msg="El id solo debe contener letras y números.";
        return false;
    }
    return true;
}


function modeloUserComprobarNombre($nombre, &$msg){
    if(strlen($nombre)>20 || strlen($nombre)<1){
        $msg="El nombre de estar comprendido entre 1 y 20 caracteres.";
        return false;
    }
    return true;
}


function modeloUserComprobarMail($mail, &$msg){

    foreach($_SESSION['tusuarios'] as $clave => $valor){
        if($valor[2]===$mail){
            $msg="Ya existe un usuario con ese mail";
            return false;
        }
    }
    if(strpos($mail, "@") && strpos($mail, ".")){
        return true;
    }
    $msg="El email no es correcto.";
    return false;
    
}

function ComprobarMailModificar($mail, &$msg){
    if(strpos($mail, "@") && strpos($mail, ".")){
        return true;
    }
    $msg="El email no es correcto.";
    return false;
}


function comprobarContraseñas($contraseña1,$contraseña2, &$msg){
    if($contraseña1==$contraseña2){
        if(strlen($contraseña1)>=8 && strlen($contraseña1)<=15){
            if(ctype_upper($contraseña1)||ctype_lower($contraseña1)){
                    $msg="La contraseña debe contener al menos una minúscula y una mayúscula.";
                    return false;
            }elseif(ctype_alpha($contraseña1)){
                    $msg="La contraseña debe contener algún carácter numérico";
                    return false;
            }elseif(ctype_alnum($contraseña1)){
                    $msg="La contraseña debe contener algún carácter no alfanumérico";
                    return false;
                }else{
                    return true;
                }  
        }else{
            $msg="La contraseña debe contener al menos 8 carácteres.";
            return false;
            }
    }else{
        $msg="Las contraseñas no coinciden";
        return false;
        }
}


function modeloUSerCrearDir($usuarioid){
    $carpeta="app\\dat\\".$usuarioid;
    if(!file_exists($carpeta)){
        mkdir($carpeta, 0777, true);
        chmod($carpeta, 0777);
    }
}
