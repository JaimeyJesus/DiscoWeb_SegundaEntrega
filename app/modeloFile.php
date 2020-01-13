<?php

function modeloFileUpFile($archivo,$userId, &$msg){
    $resu = true;
    $codigosErrorSubida= [
        0 => 'Subida correcta',
        1 => 'El tamaño del archivo excede el admitido por el servidor',  // directiva upload_max_filesize en php.ini
        2 => 'El tamaño del archivo excede el admitido por el cliente',  // directiva MAX_FILE_SIZE en el formulario HTML
        3 => 'El archivo no se pudo subir completamente',
        4 => 'No se seleccionó ningún archivo para ser subido',
        6 => 'No existe un directorio temporal donde subir el archivo',
        7 => 'No se pudo guardar el archivo en disco',  // permisos
        8 => 'Una extensión PHP evito la subida del archivo'  // extensión PHP
    ];
    $msg = '';

        $directorioSubida = "app/dat/".$userId; 
        $nombreFichero    = $archivo['name'];
        $temporalFichero  = $archivo['tmp_name'];
        $errorFichero     = $archivo['error'];
        
        // Obtengo el código de error de la operación, 0 si todo ha ido bien
        if ($errorFichero > 0) {
            $msg .= "Se a producido el error: $errorFichero: "
            . $codigosErrorSubida[$errorFichero] . ' <br />';
            $resu = false;
        } else { // subida correcta del temporal
            // si es un directorio y tengo permisos
            if ( is_dir($directorioSubida) && is_writable ($directorioSubida)) {
                
                //Intento mover el archivo temporal al directorio indicado
                if (move_uploaded_file($temporalFichero,  $directorioSubida .'/'. $nombreFichero) == true) {
                    $msg .= 'Archivo guardado en: ' . $directorioSubida .'/'. $nombreFichero . ' <br />';
                    
                } else {
                    $msg .= 'ERROR: Archivo no guardado correctamente <br />';
                    $resu = false;
                }
            } else {
                    $resu = FALSE;
            }
        }  
        return $resu;
}


function modeloFileBorrar($fichero) {
    if(unlink($fichero)){
        return true;
    }else{
        return false;
    }
    
}


function modeloFileCambiarNombre($fichero, $NuevoNombre){
    if(is_file($fichero)){
        $arrayExtension=explode('.',$fichero);
        $extension=end($arrayExtension);
        rename($fichero, "app/dat/".$NuevoNombre.'.'.$extension);
        return true;
    }
    return false;
}