function Girar() {
    let numero = Math.floor(Math.random() * 6 + 1);
    document.getElementById("dado").src = ("imagenes/dado" + numero + ".png");
}