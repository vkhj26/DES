<?php

/*
 *  Funciones para limpiar la entrada de posibles inyecciones
 */

function limpiarEntrada(string $entrada):string{
    $salida = trim($entrada); // Elimina espacios antes y después de los datos
    $salida = strip_tags($salida); // Elimina marcas
    return $salida;
}

// Función para limpiar todos elementos de un array
function limpiarArrayEntrada(array &$entrada){
    foreach ($entrada as $key => $value ) {
        $entrada[$key] = limpiarEntrada($value);
    }
}


function limpiarArrayDeArrays(array &$entrada){
    if (!is_array($entrada)) {
        return; // Si no es un array, no hacemos nada
    }
    
    foreach ($entrada as &$subArray) {
        if (!is_array($subArray)) {
            continue; // Si no es un array, pasamos al siguiente elemento
        }
        
        foreach ($subArray as $key => $value) {
            $subArray[$key] = limpiarEntrada($value);
        }
    }
}