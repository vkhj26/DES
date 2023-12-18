/**
 * Funciones auxiliares de javascripts 
 */
function confirmarBorrar(nombre,id){
  if (confirm("¿Quieres eliminar el usuario:  "+nombre+"?"))
  {
   document.location.href="?orden=Borrar&id="+id;
  }
}

function mostrarclave() {
  let tipo = document.getElementById("clave_id").type;
  let checkbox = document.getElementsByTagName("input")[3];

  if (tipo == "password" && checkbox.checked) {
    document.getElementById("clave_id").type = "text";
  }
  else if (tipo == "text" && !checkbox.checked) {
    document.getElementById("clave_id").type = "password";
  }
} 