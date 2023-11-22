<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
$msg = "";
//Codigo de errores  //307200
$codigosError = [
    UPLOAD_ERR_OK         => 'Subida correcta',  // Valor 0
    UPLOAD_ERR_INI_SIZE   => 'El tamaño del archivo excede el admitido por el servidor',  // directiva upload_max_filesize en php.ini
    UPLOAD_ERR_FORM_SIZE  => 'El tamaño del archivo excede el admitido por el cliente',  // directiva MAX_FILE_SIZE en el formulario HTML
    UPLOAD_ERR_PARTIAL    => 'El archivo no se pudo subir completamente',
    UPLOAD_ERR_NO_FILE    => 'No se seleccionó ningún archivo para ser subido',
    UPLOAD_ERR_NO_TMP_DIR => 'No existe un directorio temporal donde subir el archivo',
    UPLOAD_ERR_CANT_WRITE => 'No se pudo guardar el archivo en disco',  // permisos
    UPLOAD_ERR_EXTENSION  => 'Una extensión PHP evito la subida del archivo',  // extensión PHP
];

$directorio = "/Users/valeria/Desktop/imgusers"; //Directorio para guardar los ficheros

if (!isset($_FILES['archivos'])) {
    $msg = "ERROR: No se indicó el archivo";
} else {
    //Recorremos nuestro array de files
    for ($i = 0; $i < count($_FILES['archivos']['name']); $i++) {
        //Comprobando el tipo de fichero que nos piden
        if(mime_content_type($_FILES['archivos']['tmp_name'][$i])!="image/png" && mime_content_type($_FILES['archivos']['tmp_name'][$i])!="image/jpeg"){
            $msg = "ERROR: El tipo de archivo no es permitido <br><br>";
        }else if($_FILES['archivos']['size'][$i]>200000){ //Comprobando tamaño del fichero
            $msg = "ERROR: Se supera el tamaño máximo del fichero <br><br>";
        }else{
            $nombreFichero   =   $_FILES['archivos']['name'][$i];
            $tipoFichero     =   $_FILES['archivos']['type'][$i];
            $tamanioFichero  =   $_FILES['archivos']['size'][$i];
            $temporalFichero =   $_FILES['archivos']['tmp_name'][$i];
            $errorFichero    =   $_FILES['archivos']['error'][$i];

            $msg .= "Intentando subir el archivo ".  ($i+1) .  "<br>";
            $msg .= "- Nombre: ".$nombreFichero . "<br>";
            $msg .= "- Tamaño: " . number_format(($tamanioFichero / 1000), 1, ',', '.') . " KB <br>";
            $msg .= "- Tipo: ".$tipoFichero . "<br>";
            $msg .= "- Nombre archivo temporal: ".$temporalFichero."<br>";
            $msg .= "- Código de estado: ".$errorFichero."<br>";
            $msg .= "<br>RESULTADO<br>";

            if ($errorFichero > 0) {
                $msg .= "Se ha producido el error nº". $errorFichero.":". $codigosError[$errorFichero] ."<br>";
            }else{ //Si se ha subido correctamente el archivo temporal
                if (is_dir($directorio) && is_writable ($directorio)) { //Intento mover el archivo temporal al directorio indicado               
                    if (move_uploaded_file($temporalFichero,  $directorio ."/". $nombreFichero) == true) {
                    $msg .= "Archivo guardado en: " . $directorio ."/". $nombreFichero . "<br>";
                    } else {
                    $msg .= "ERROR: Archivo no guardado correctamente <br><br>";
                    }
                } else {
                $msg .= "ERROR: No es un directorio correcto o no se tiene permiso de escritura <br><br>";
                }
            }
        }
    }// fin for
}

?>
<body>
    <?= $msg; ?>
</body>
</html>