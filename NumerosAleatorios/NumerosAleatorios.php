<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            background-color:pink;
            border-color: purple;
            border-style: solid;
            border-width: 3px;
        }
        body {
            height: 100vh;
            background: linear-gradient(#e5629d, #fc8e44);
        }
    </style>
</head>

<body>

    <?php
    $lista = array();

    echo '<table class="default" border="1"><tr>'; //crea la tabla

    for ($cont = 0; $cont < 20; $cont++) {
        $lista[$cont] = random_int(1, 10);

        echo '<td>'.$lista[$cont].'</td>';
    }

    echo '</tr></table>'; //cerramos la tabla

    $lisRepe = (array_count_values($lista));

    function masRepetido($lisRepe){
        $max = 0;
        $posicion = 0;

        foreach ($lisRepe as $key => $value) {
            if ($max < $lisRepe[$key]) {
                $max = $lisRepe[$key];
                $posicion++;
            }
        }

        $cont = 1;
        foreach ($lisRepe as $key => $value) {
            if ($cont == $posicion) {
                echo $key;
            }
            $cont++;
        }
    }

    //print_r($lista);
    //echo "<br>";
    //print_r($lisRepe);
    //echo "<br>";
    echo "El numero mayor es " .max($lista);
    echo "<br>";
    echo "El numero menor es " .min($lista);
    echo "<br>";
    echo "El numero que mas veces se repite es ";
    echo masRepetido($lisRepe);

    ?>
</body>

</html>