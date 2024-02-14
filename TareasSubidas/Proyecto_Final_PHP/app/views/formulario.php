
<hr>
<form method="POST" enctype="multipart/form-data">
<table>
 <tr><td>id:</td> 
 <td><input type="number" name="id" value="<?=$cli->id ?>"  readonly  ></td></tr>
 </tr>
 <tr><td>first_name:</td> 
 <td><input type="text" name="first_name" value="<?=$cli->first_name ?>" autofocus  ></td></tr>
 </tr>
 <tr><td>last_name:</td> 
 <td><input type="text" name="last_name" value="<?=$cli->last_name ?>"  ></td></tr>
 </tr>
 <tr><td>email:</td> 
 <td><input type="email" name="email" value="<?=$cli->email ?>"  ></td></tr>
 </tr>
 <tr><td>gender</td> 
 <td><input type="text" name="gender" value="<?=$cli->gender ?>"  ></td></tr>
 </tr>
 <tr><td>ip_address:</td> 
 <td><input type="text" name="ip_address" value="<?=$cli->ip_address ?>"  ></td></tr>
 </tr>
 <tr><td>telefono:</td> 
 <td><input type="tel" name="telefono" value="<?=$cli->telefono ?>"  ></td></tr>
 </tr>
</table><br>
<?php if ($orden != "Nuevo") { ?> 
 <input  type="hidden" name="valor[]"   value="<?=$cli->id ?>">
 <input  type="hidden" name="valor[]"   value="<?=$cli->first_name ?>">
 <input  type="hidden" name="valor[]"   value="<?=$cli->last_name ?>">
 <input  type="hidden" name="valor[]"   value="<?=$cli->email ?>">
 <input  type="hidden" name="valor[]"   value="<?=$cli->gender ?>">
 <input  type="hidden" name="valor[]"   value="<?=$cli->ip_address ?>">
 <input  type="hidden" name="valor[]"   value="<?=$cli->telefono ?>">
<?php } ?>

 <input type="submit"  name="orden" value="<?=$orden?>">
 <input type="submit"  name="orden" value="Volver">&nbsp;&nbsp;
 <label for="subirfoto">
    Subir fotografia
    <input type="file" name="foto" id="subirfoto" accept="image/jpeg, image/png" size="5000000">
 </label>
 <br><br>

<?php if ($orden == "Modificar") { ?>
 <button type="submit" name="nav-modificar" value="Anterior"> Anterior << </button>
 <button type="submit" name="nav-modificar" value="Siguiente"> Siguiente >> </button>
<?php } ?>

</form> 

