<div>
    <b> Detalles:</b><br>
    <table>
        <tr>
            <td>Longitud: </td>
            <td><?= strlen($_REQUEST['comentario']) ?></td>
        </tr>
        <tr>
            <td>Nº de palabras: </td>
            <td><?= numPalabras($_REQUEST['comentario'])  ?></td>
        </tr>
        <tr>
            <td>Letra + repetida: </td>
            <td><?= letraRepetida($_REQUEST['comentario']) ?></td>
        </tr>
        <tr>
            <td>Palabra + repetida:</td>
            <td><?= palabraRepetida($_REQUEST['comentario']) ?></td>
        </tr>
    </table>
</div>