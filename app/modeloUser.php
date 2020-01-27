<?php 
include_once 'plantilla/Cifrador.php';
include_once 'plantilla/Usuario.php';
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
    
   
   /* $datosjson = @file_get_contents(FILEUSER) or die("ERROR al abrir fichero de usuarios");
    $tusuarios = json_decode($datosjson, true);
    
     if(!isset($_SESSION['tusuarios'])){
    $_SESSION['tusuarios'] = $tusuarios;
    }
*/
      
}

function abrirBD(){
    $conex = new mysqli("192.168.105.11", "root", "root", "usuarios"); // Abre una conexión
    if ($conex->connect_errno) {
        // Comprueba conexión
        printf("Conexión fallida: %s\n", mysqli_connect_error());
        exit();
    }
    $conex->set_charset("utf8");
    return $conex;
}

// Comprueba usuario y contraseña (boolean)
function modeloOkUser($user,$password){
   /* $tusuarios = $_SESSION['tusuarios'];
    foreach ($tusuarios as $clave => $valor){      
        if($clave==$user){
            //if($tusuarios[$clave][0]==$password){ ==> Para que funcione con contraseñas sin cifrar
           if(Cifrador::verificar($password,$tusuarios[$clave][0])){
                return true;
            }
        }
        }           
    return false;*/
    $bd=abrirBD();
    $consultaClave=$bd->prepare("SELECT clave FROM usuarios WHERE user=?;");
    $consultaClave->bind_param("s",$user);
    $consultaClave->execute();
    if($result=$consultaClave->get_result()){
       if( $fila=$result->fetch_array()){
        echo $fila[0];
           if(password_verify($password,$fila[0])){echo "true";}else{echo "false";}
          
           if(Cifrador::verificar($password,$fila[0])){
               return true;
           }return false;
       }
    }
}

// Devuelve el plan de usuario (String)
function modeloObtenerTipo($user){
    $bd=abrirBD();
    $tipo=$bd->prepare("SELECT tipo FROM usuarios WHERE user=?;");
    $tipo->bind_param("s", $user);
    $tipo->execute();
    if($result=$tipo->get_result()){
        if($fila=$result->fetch_array()){
            return $fila[0];
        }
    }
}

function modeloUserObtenerEstado($user){
    $bd=abrirBD();
    $tipo=$bd->prepare("SELECT estado FROM usuarios WHERE user=?;");
    $tipo->bind_param("s", $user);
    $tipo->execute();
    if($result=$tipo->get_result()){
        if($fila=$result->fetch_array()){
            return $fila[0];
        }
    }
}

// Borrar un usuario (boolean)
function modeloUserDel($user){
    $bd=abrirBD();
    $tipo=$bd->prepare("DELETE FROM usuarios WHERE user=?;");
    $tipo->bind_param("s", $user);
    if ($tipo->execute()){
        return true;
    }
    return false;
}

// Tabla de todos los usuarios para visualizar
function modeloUserGetAll (){
    // Genero lo datos para la vista que no muestra la contraseña ni los códigos de estado o plan
    // sino su traducción a texto
    $i=0;
    $tuservista=[];
    $bd=abrirBD();
    $tipo=$bd->prepare("SELECT * FROM usuarios");
    $tipo->execute();
    if($result=$tipo->get_result()){
        while($datosusuario=$result->fetch_assoc()){
            $tuservista[]= new Usuario($datosusuario["user"],$datosusuario["clave"],
            $datosusuario["nombre"],
            $datosusuario["correo"],
            PLANES[$datosusuario["tipo"]],
            ESTADOS[$datosusuario["estado"]]
        );
        }
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
   
    $bd=abrirBD();
    $tipo=$bd->prepare("INSERT INTO usuarios VALUES (?,?,?,?,?,?);");
    $tipo->bind_param("ssssss", $idusuario, $datosuser[0],$datosuser[1],$datosuser[2],$datosuser[3],$datosuser[4]);
    return $tipo->execute();

}
    


//Actualiza un usuario en la session
function modeloUserUpdate($id, $datosuser){
    $bd=abrirBD();
    $tipo=$bd->prepare("UPDATE usuarios SET clave=?, nombre=?, correo=?, tipo=?, estado=? WHERE user=?;");
    $tipo->bind_param("ssssss", $datosuser[0],$datosuser[1],$datosuser[2],$datosuser[3],$datosuser[4],$id);
    return $tipo->execute();
}



//Funcion que comprueba todas las entradas del formulario Nuevo
function modeloUserComprobacionesNuevo($usuarioid,$valoresusuario, $passrepetida ,&$msg){
    if(modeloUserComprobarId($usuarioid, $msg)){
        if(comprobarContraseñas($valoresusuario[0],$passrepetida, $msg)){
            if(modeloUserComprobarNombre($valoresusuario[1], $msg)){
                if(modeloUserComprobarMail($valoresusuario[2], $msg, "")){
                    return true;
                }
            }
        }
    }
    return false;
}

function modeloUserCifrar($clave){
  
    return Cifrador::cifrar($clave);
    
}

//Funcion que comprueba las entradas del formulario modificar
function modeloUserComprobacionesModificar($valoresusuario, &$msg, $datosUsuario){
    if(modeloUserComprobarNombre($valoresusuario[1], $msg)){
        if(modeloUserComprobarMail($valoresusuario[2], $msg, $datosUsuario[2])){
            if($datosUsuario[0]!=$valoresusuario[0]){//condicion para ver si se cambio la contraseña y de ser asi se comprueba la nueva
                if(comprobarContraseñas($valoresusuario[0],$valoresusuario[0], $msg)){   
                    return true;}
                }else{
                    return true;
                }   }    }return false;
}


function modeloUserComprobarId($id, &$msg){
    if(strlen($id)<5 || strlen($id)>10){
        $msg="El id de usuario debe tener entre 5 y 10 caracteres.";
        return false;
    }
    $bd=abrirBD();
    $user=$bd->prepare("SELECT user FROM usuarios");
    $user->execute();
    if($result=$user->get_result()){
        while($fila=$result->fetch_array()){
            if($fila['user']==$id){
                $msg="Ya existe un usuario con ese id.";
                return false;
            }
        }
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


function modeloUserComprobarMail($mail, &$msg, $mailuser){
    if($mail!=$mailuser){
        $bd=abrirBD();
        $correo=$bd->prepare("SELECT correo FROM usuarios");
        $correo->execute();
        if($result=$correo->get_result()){
            while($fila=$result->fetch_array()){
                if($fila['correo']==$mail){
                    $msg="Ya existe un usuario con ese mail";
                    return false;
                }
            }
        }
    }
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
