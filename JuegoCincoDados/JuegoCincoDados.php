<?php
$jugador1 = ["&#9856;", "&#9857;", "&#9858;", "&#9859;", "&#9860;", "&#9861;"];
$jugador2 = ["&#9856;", "&#9857;", "&#9858;", "&#9859;", "&#9860;", "&#9861;"];

$array1 = [];
$array2 = [];

function MostrarDados($jugador, &$array)
{
    for ($cont = 0; $cont < 5; $cont++) {
        $num = random_int(0, 5);
        echo $jugador[$num] . " ";
        $array[$cont] = ($num + 1);
    }
}

$suma1 = 0;
$suma2 = 0;
function Suma($array, &$suma)
{
    sort($array);
    for ($cont = 1; $cont < 4; $cont++) {
        $suma += $array[$cont];
    }
    echo $suma . " ";
}

function Resultado($suma1, $suma2)
{
    if ($suma1 > $suma2) {
        echo "¡Ha ganado el Jugador 1!";
    } else if($suma1 < $suma2){
        echo "!Ha ganado el Jugador 2!";
    } else{
        echo "¡Empate!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>&#127922; Cinco dados &#127922;</h2>
    <p>Actualice la página para mostrar una nueva tirada</p>
    <h3>Jugador 1&nbsp;&nbsp;&nbsp;<?= MostrarDados($jugador1, $array1) ?> Total:<?= Suma($array1, $suma1) ?></h3>
    <h3>Jugador 2&nbsp;&nbsp;&nbsp;<?= MostrarDados($jugador2, $array2) ?> Total:<?= Suma($array2, $suma2) ?></h3>
    <h3>Resultado</h3>
    <h2><?= Resultado($suma1, $suma2) ?></h2>
</body>

</html>