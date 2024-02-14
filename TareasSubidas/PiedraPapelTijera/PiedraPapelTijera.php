<?php
define('PIEDRA1',  "&#x1F91C;");
define('PIEDRA2',  "&#x1F91B;");
define('TIJERAS',  "&#x1F596;");
define('PAPEL',    "&#x1F91A;");

$jugador1 = [PIEDRA1, TIJERAS, PAPEL];
$jugador2 = [PIEDRA2, TIJERAS, PAPEL];

$jugador1 = $jugador1[random_int(0, 2)];
$jugador2 = $jugador2[random_int(0, 2)];

function Ganador($jugador1, $jugador2)
{
    $mensaje = array("¡Empate!", "¡Gana Jugador 1!", "¡Gana Jugador 2!");

    if ($jugador1 == $jugador2 || ($jugador1 == PIEDRA1 && $jugador2 == PIEDRA2)) {
        return $mensaje[0];
    } elseif (
        ($jugador1 == PIEDRA1 && $jugador2 == TIJERAS) ||
        ($jugador1 == PAPEL && $jugador2 == PIEDRA2) ||
        ($jugador1 == TIJERAS && $jugador2 == PAPEL)
    ) {
        return $mensaje[1];
    } else {
        return $mensaje[2];
    }
}
?>
<!------------HTML---------------->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piedra Papel Tijera</title>
</head>

<body>
    <h2>Piedra Papel o Tijera</h2>
    <p>Actualice la pagina para volver a jugar</p>
    <h3>Jugador 1&nbsp;&nbsp;&nbsp;&nbsp;Jugador 2</h3>
    <h1 style="font-size: 60px;"><?= $jugador1 ?>&nbsp;&nbsp;<?= $jugador2 ?></h1>
    <h2><?= Ganador($jugador1, $jugador2); ?></h2>
</body>

</html>

<!--

    define('PIEDRA1',  "&#x1F91C;");
    define('PIEDRA2',  "&#x1F91B;");
    define('TIJERAS',  "&#x1F596;");
    define('PAPEL',    "&#x1F91A;");

    $jugador1 = [PIEDRA1, TIJERAS, PAPEL];
    $jugador2 = [PIEDRA2, TIJERAS, PAPEL];
    $ganador = 0;

    $jugador1 = $jugador1[random_int(0, 2)];
    $jugador2 = $jugador2[random_int(0, 2)];
    echo "<h2>Piedra Papel o Tijera</h2>";
    echo "<h1>".$jugador1.$jugador2."</h1>";
    
        if ($jugador1==$jugador2 || ($jugador1 == PIEDRA1 && $jugador2 == PIEDRA2)) {
            echo "<p>¡Empate!</p>";
        }elseif (
            ($jugador1 == PIEDRA1 && $jugador2 == TIJERAS) ||
            ($jugador1 == PAPEL && $jugador2 == PIEDRA2) ||
            ($jugador1 == TIJERAS && $jugador2 == PAPEL)
        ){
            echo "<p>¡Gana Jugador 1!</p>";
        } else {
            echo "<p>¡Gana Jugador 2!</p>";
        } 
-->