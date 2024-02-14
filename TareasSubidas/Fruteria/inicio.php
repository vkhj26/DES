<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>LA FRUTERIA</title>
</head>
<body>
    <?php
    session_start();

    if ($_REQUEST["accion"] == "Terminar") {
        include_once 'despedida.php';
        session_destroy();
        exit();
    }

    if (isset($_SESSION['cliente'])) {
        include_once 'compra.php';
        exit();
    }

    include_once 'bienvenida.php';

    

    //FUNCIONES------------------------------------------------------------
    function mostrarCompra(){
        echo ("<table style=\"border: solid;\">");
        foreach ($_SESSION["compra"] as $fruta => $cantidad) {
            echo ("<tr>");
            echo ("<td><b> $fruta </b></td>");
            echo ("<td> $cantidad </td>");
            echo ("</tr>");
        }
        echo ("</table>");
    }

    ?>
</body>
</html>