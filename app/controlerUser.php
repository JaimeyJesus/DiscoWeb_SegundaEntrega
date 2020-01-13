<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------
include_once 'config.php';
include_once 'modeloUser.php';
include_once 'controlerFile.php';


function  ctlUserInicio(){
    $msg   = "";
    $user  = "";
    $clave = "";
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['user']) && isset($_POST['clave'])){
            $user  = $_POST['user'];
            $clave = $_POST['clave'];
            if ( modeloOkUser($user,$clave)){
                $_SESSION['user'] = $user;
                $_SESSION['tipouser'] = modeloObtenerTipo($user);
                if ( $_SESSION['tipouser'] == 3){
                    $_SESSION['modo'] = GESTIONUSUARIOS;
                    header('Location:index.php?orden=VerUsuarios');
                }
                else {
                   $_SESSION['modo'] = GESTIONFICHEROS;
                   header('Location:index.php?orden=Mis Archivos');
                }
            }
            else {
                
                $msg="Error: usuario y contraseña no válidos.";
           }  
        }
    }
    
    include_once 'plantilla/facceso.php';
}

// Cierra la sesión y vuelva los datos
function ctlUserCerrar(){
    modeloUserSave();
    session_destroy();
    header('Location:index.php');
}


// Muestro la tabla con los usuario 
function ctlUserVerUsuarios (){
    // Obtengo los datos del modelo
    $usuarios = modeloUserGetAll(); 
    // Invoco la vista 
    include_once 'plantilla/verusuariosp.php';
}


//Borra un usuario y llama a ver la tabla actualizada
function ctlUserBorrar(){
    $user=$_GET['id'];
    if(modeloUserDel($user)){
        $msg="La operación se realizó correctamente.";
    }else{
            $msg="No se pudo relaizar la operación.";
        }
        ctlFileBorrarDir($user);    //al borrar el usuario se borrar también su carpeta de archivos.
        modeloUserSave(); 
        ctlUserVerUsuarios();
    
}


//Comprueba si hay envio de formulario, de no ser así muestra el formulario nuevo, 
//y sino trata los datos enviados desde este para crear el nuevo usuario.
function ctlUserAlta(){
    //si no hay id enviado por post, muestro formulario
    if(!isset($_POST['id'])){
        include_once 'plantilla/nuevo.php';
        }else{
            //si hay datos enviados por post, y no es el boton de vuelta a atras, doy de alta al usuario
          if(!isset($_POST['atras'])){
            $msg = "";
            $usuarioid      =  $_POST['id']; 
            $passrepetida   =  $_POST['password2'];
            $valoresUsuario = [$_POST['password'] ,$_POST['nombre'],$_POST['mail'], $_POST['plan'], $_POST['estado']];
            if(modeloUserComprobacionesNuevo($usuarioid, $valoresUsuario, $passrepetida, $msg)) {//comprueba valores introducidos
                if(modeloUserNuevo($usuarioid, $valoresUsuario)){
                    $msg="Usuario dado de alta correctamente";
                    modeloUserSave();
                    ctlUserVerUsuarios();
                    modeloUserCrearDir($usuarioid);
                    }else{
                        $msg="No se pudo relaizar la operación.";
                     }
              }else{//si los valores no son correctos se muestra el formulario otra vez
                 include_once 'plantilla/nuevo.php';
              }
          }else{//si se le da a atras se vuelve a la pantalla de ver usuarios
            ctlUserVerUsuarios();
        }
    }
}


//Comprobamos si hay Post, de ser asi modificamos el usuario, y sino mostramos el formulario de modificación
function ctlUserModificar(){
    $msg="";
    //si no hay post, se accede a la plantilla
    if(!isset($_POST['nombre'])){
        $usuarioid = $_GET['id'];
        $usuarios  = modeloUserGetAll();
        include_once 'plantilla/Modificar.php';
        }else{   
            //si no hay orden atras, se modifica el usuario    
            if(!isset($_POST['Atrás'])){
                $usuarioid = $_POST['id'];
                $usuarios  = modeloUserGetAll();
                $valoresUsuario = [$_POST['clave'] ,$_POST['nombre'],$_POST['email'], $_POST['plan'], $_POST['estado']];
                if(modeloUserComprobacionesModificar($valoresUsuario, $msg)){
                    modeloUserUpdate($usuarioid, $valoresUsuario);
                    modeloUserSave();
                    //si es administrador, después de modificar se muestra ver usuarios
                    if($_SESSION['modo']==GESTIONUSUARIOS){
                        ctlUserVerUsuarios();
                    }else{//si es un usuario normal se muestra ver ficheros
                        ctlFileVerFicheros();
                    }
                }else{
                    include_once 'plantilla/Modificar.php';
                }
            }else{ 
                //lo mismo, si es admin o usuario normal, en este caso al darle al botón atrás.
                if ( $_SESSION['modo'] == GESTIONUSUARIOS){
                ctlUserVerUsuarios();
                }else{
                    ctlFileVerFicheros();
            }
        }
    }
}


//Muestra detalles del usuario en cuestión
function ctlUserdetalles(){
    $usuarios = modeloUserGetAll();
    $msg="Gestión de usuarios";
    include_once 'plantilla/detalles.php';
}

function ctlUserNuevo() {
    if(!isset($_POST['id'])){
        include_once 'plantilla/registro.php';
    }else{
        $msg = "";
        $usuarioid      =  $_POST['id'];
        $passrepetida   =  $_POST['password2'];
        $valoresUsuario = [$_POST['password'] ,$_POST['nombre'],$_POST['mail'], $_POST['plan'], "B"];
        if(modeloUserComprobacionesNuevo($usuarioid, $valoresUsuario, $passrepetida, $msg)) {//comprueba valores introducidos
            if(modeloUserNuevo($usuarioid, $valoresUsuario)){
                $msg="Usuario dado de alta correctamente";
                modeloUserSave();
                modeloUserCrearDir($usuarioid);                 
                header('Location:index.php');
            }else{
                $msg="No se pudo realizar la operación.";
            }
        }else{//si los valores no son correctos se muestra el formulario otra vez
            include_once 'plantilla/registro.php';
        }
    }
}






