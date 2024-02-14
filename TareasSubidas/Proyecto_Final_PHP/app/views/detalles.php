
<hr>
<button onclick="location.href='./'" > Volver </button>
<br><br>
<table>
 <tr><td>id:</td> 
 <td><input type="number" name="id" value="<?=$cli->id ?>"  readonly > </td>
 <td rowspan="8"><img src="<?= mostrarImagenCliente($cli->id) ?>" alt="foto"></img></td> 
 </tr>
 <tr><td>first_name:</td> 
 <td><input type="text" name="first_name" value="<?=$cli->first_name ?>" readonly ></td>
 </tr>
 <tr><td>last_name:</td> 
 <td><input type="text" name="last_name" value="<?=$cli->last_name ?>" readonly ></td>
 </tr>
 <tr><td>email:</td> 
 <td><input type="email" name="email" value="<?=$cli->email ?>"   readonly  ></td>
 </tr>
 <tr><td>gender</td> 
 <td><input type="text" name="gender" value="<?=$cli->gender ?>" readonly ></td>
 </tr>
 <tr><td>ip_address:</td> 
 <td><input type="text" name="ip_address" value="<?=$cli->ip_address ?>" readonly ></td>
 </tr>
 <tr><td>telefono:</td> 
 <td><input type="tel" name="telefono" value="<?=$cli->telefono ?>" readonly ></td>
 </tr>
 <tr><td>pais:</td> 
 <td ><?= obtenerBandera($cli->ip_address) ?></img></td>
 </tr>
 </table>
 
<form>
<input  type="hidden" name="valor[]"   value="<?=$cli->id ?>">
<input  type="hidden" name="valor[]"   value="<?=$cli->first_name ?>">
<input  type="hidden" name="valor[]"   value="<?=$cli->last_name ?>">
<input  type="hidden" name="valor[]"   value="<?=$cli->email ?>">
<input  type="hidden" name="valor[]"   value="<?=$cli->gender ?>">
<input  type="hidden" name="valor[]"   value="<?=$cli->ip_address ?>">
<input  type="hidden" name="valor[]"   value="<?=$cli->telefono ?>">

<button type="submit" name="nav-detalles" value="Anterior"> Anterior << </button>
<button type="submit" name="nav-detalles" value="Siguiente"> Siguiente >> </button>
<button type="submit" name="orden" value="Imprimir"> Imprimir </button>
</form> 


