
<form>
<button type="submit" name="orden" value="Nuevo"> Cliente Nuevo </button><br>
</form>
<br>

<table>
<tr>
<th>id <a href="?ordenar=asc&campo=id">&#9206;</a>&nbsp;<a href="?ordenar=desc&campo=id">&#9207;</a></th>
<th>first_name <a href="?ordenar=asc&campo=first_name">&#9206;</a>&nbsp;<a href="?ordenar=desc&campo=first_name">&#9207;</a></th>
<th>email <a href="?ordenar=asc&campo=email">&#9206;</a>&nbsp;<a href="?ordenar=desc&campo=email">&#9207;</a></th>
<th>gender <a href="?ordenar=asc&campo=gender">&#9206;</a>&nbsp;<a href="?ordenar=desc&campo=gender">&#9207;</a></th>
<th>ip_address <a href="?ordenar=asc&campo=ip_address">&#9206;</a>&nbsp;<a href="?ordenar=desc&campo=ip_address">&#9207;</a></th>
<th>teléfono <a href="?ordenar=asc&campo=telefono">&#9206;</a>&nbsp;<a href="?ordenar=desc&campo=telefono">&#9207;</a></th>
</tr>
<?php foreach ($tvalores as $valor): ?>
<tr>
<td><?= $valor->id ?> </td>
<td><?= $valor->first_name ?> </td>
<td><?= $valor->email ?> </td>
<td><?= $valor->gender ?> </td>
<td><?= $valor->ip_address ?> </td>
<td><?= $valor->telefono ?> </td>
<td><a href="#" onclick="confirmarBorrar('<?=$valor->first_name?>',<?=$valor->id?>);" >Borrar</a></td>
<td><a href="?orden=Modificar&id=<?=$valor->id?>">Modificar</a></td>
<td><a href="?orden=Detalles&id=<?=$valor->id?>" >Detalles</a></td>
<tr>
<?php endforeach ?>
</table>

<form>
<br>
<button type="submit" name="nav" value="Primero"> << </button>
<button type="submit" name="nav" value="Anterior"> < </button>
<button type="submit" name="nav" value="Siguiente"> > </button>
<button type="submit" name="nav" value="Ultimo"> >> </button>
</form>
