<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>LA FRUTERIA</title>
</head>
<body>
    <H1> La Frutería del siglo XXI</H1>
    <B>BIENVENIDO A NUESTRA FRUTERÍA</B><br>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
        Introduzca su nombre:<input name="cliente" type="text"><br>
    </form>
</body>
</html>

<?php

if (isset($_REQUEST['cliente'])) {
    $_SESSION['cliente']=$_REQUEST['cliente'];
    header("Refresh:0; url=\"" . $_SERVER['PHP_SELF'] . "\"");
}

?>