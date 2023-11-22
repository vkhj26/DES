<?php
function usuarioOk($usuario, $contraseña): bool{
   if (strlen($usuario) > 7) {
      return (strrev($usuario) == $contraseña);
   } else {
      return false;
   }
}

function numPalabras($comentario){
   return str_word_count($comentario, 0);
}

function letraRepetida($comentario){
   $comentario =str_replace(' ', '', $comentario);
   $arraycomentario = count_chars($comentario, 1);
   $mayor = max($arraycomentario);
   $nuevoarray = array_flip($arraycomentario);

   return chr($nuevoarray[$mayor]);
}

function palabraRepetida($comentario){
   $minusculas = strtolower($comentario);
   $arrayPalabras = str_word_count($minusculas, 1);
   $arrayRepeticiones = array_count_values($arrayPalabras); //palabra => repeticion
   $mayor = max($arrayRepeticiones); // mayor repeticion
   $nuevoarray = array_flip($arrayRepeticiones); //  repeticiones => palabra

   return $nuevoarray[$mayor];
}
