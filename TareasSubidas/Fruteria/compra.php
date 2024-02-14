<?php
if (!isset($_SESSION["compra"])) {
  $_SESSION["compra"]=[];
}

if (isset($_REQUEST["fruta"]) && isset($_REQUEST["cantidad"])) {
  $fruta = $_REQUEST["fruta"];
  $cantidad = $_REQUEST["cantidad"];

  if (isset($_REQUEST["accion"])) {
    switch ($_REQUEST["accion"]) {
      case 'Anotar':
        if(!array_key_exists($fruta, $_SESSION["compra"])){
          $_SESSION["compra"][$fruta]=$cantidad;
        }else{
          $_SESSION["compra"][$fruta]=$_SESSION["compra"][$fruta]+$cantidad;
        }
        break;

      case 'Terminar':
        header("Refresh:0; url=\"" . $_SERVER['PHP_SELF'] . "\"");
        break;
    }
  }
}


?>
<html>

<head>
  <meta charset="UTF-8">
  <title>LA FRUTERIA</title>
</head>
<body>
  <h1> La Frutería del siglo XXI</h1>
  <p>Este es su pedido:</p>
  <?= mostrarCompra() ?>
  <B><br> REALICE SU COMPRA <?= $_SESSION['cliente'] ?></B><br>
  <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
    <b>Selecciona la fruta: <select name="fruta">
        <option value="Platanos">Platanos</option>
        <option value="Naranjas">Naranjas</option>
        <option value="Limones">Limones</option>
        <option value="Manzanas">Manzanas</option>
      </select>
      Cantidad: <input name="cantidad" type="number" value=0 size=4>
      <input type="submit" name="accion" value="Anotar">
      <input type="submit" name="accion" value="Terminar">
  </form>
</body>

</html>