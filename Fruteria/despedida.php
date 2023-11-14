<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>LA FRUTERIA</title>
</head>
<body>
    <h1>La Frutería del siglo XXI</h1>
    <p>Este es su pedido:</p>
    <?= mostrarCompra() ?>
    <br> Muchas gracias, por su pedido. <br><br>
    <input type="button" value=" NUEVO CLIENTE " onclick="location.href='<?= $_SERVER['PHP_SELF']; ?>'">
</body>
</html>



