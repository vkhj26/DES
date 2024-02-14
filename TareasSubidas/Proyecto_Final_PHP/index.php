<?php
session_start();
define('FPAG', 10); // Número de filas por página

require_once 'app/helpers/util.php';
require_once 'app/config/configDB.php';
require_once 'app/models/Cliente.php';
require_once 'app/models/AccesoDatosPDO.php';
require_once 'app/controllers/crudclientes.php';

if (!isset($_SESSION['ordenarpor']) && !isset($_SESSION['sentido'])) {
     $_SESSION['ordenarpor'] = "id";
     $_SESSION['sentido'] = "asc";
}

if (!isset($_SESSION['ordenar'])) {
    $_SESSION['ordenar'] = "asc";
}

//---- PAGINACIÓN ----
$midb = AccesoDatos::getModelo();
$totalfilas = $midb->numClientes();
if ($totalfilas % FPAG == 0) {
    $posfin = $totalfilas - FPAG;
} else {
    $posfin = $totalfilas - $totalfilas % FPAG;
}

if (!isset($_SESSION['posini'])) {
    $_SESSION['posini'] = 0;
}
$posAux = $_SESSION['posini'];
//------------

// Borro cualquier mensaje "
$_SESSION['msg'] = " ";

ob_start(); // La salida se guarda en el bufer
if ($_SERVER['REQUEST_METHOD'] == "GET") {

    // Proceso las ordenes de navegación----------------------
    if (isset($_GET['nav'])) {
        switch ($_GET['nav']) {
            case "Primero":
                $posAux = 0;
                break;
            case "Siguiente":
                $posAux += FPAG;
                if ($posAux > $posfin) $posAux = $posfin;
                break;
            case "Anterior":
                $posAux -= FPAG;
                if ($posAux < 0) $posAux = 0;
                break;
            case "Ultimo":
                $posAux = $posfin;
        }
        $_SESSION['posini'] = $posAux;
    }

    // Proceso de ordenes de CRUD clientes-----------------
    if (isset($_GET['orden'])) {
        switch ($_GET['orden']) {
            case "Nuevo":
                crudAlta();
                break;
            case "Borrar":
                crudBorrar($_GET['id']);
                break;
            case "Modificar":
                crudModificar($_GET['id']);
                break;
            case "Detalles":
                crudDetalles($_GET['id']);
                break;
            case "Imprimir":
                generarPDF($_GET['valor']);
                break;    
            case "Terminar":
                crudTerminar();
                break;    
        }
    }

    // Ordena la lista segun el campo y el sentido dado----------------
    if (isset($_GET['ordenar'])) {
        $_SESSION['ordenar']=$_GET['ordenar'];
        $db = AccesoDatos::getModelo();
        $tvalores = $db->getListaOrdenada($_GET['campo'],$_GET['ordenar']);
        require_once "app/views/list.php";
    }

    // Proceso las ordenes de navegación en Detalles-------------------
    if (isset($_GET['nav-detalles']) && isset($_GET['valor'])) { //array de get valores
        $valores = $_GET["valor"]; //Array ( [0] => 717 [1] => Zora [2] => Shinner [3] => zshinnerjw@blogtalkradio.com [4] => Female [5] => 232.43.139.229 [6] => 243-678-8126 )
        $campo = $_SESSION['ordenarpor'];

        switch ($campo) {
            case 'id':
                if($_GET['nav-detalles']=="Siguiente"){
                    crudDetallesSiguiente($valores[0]);
                }else if($_GET['nav-detalles']=="Anterior"){
                    crudDetallesAnterior($valores[0]);
                }
                break;
            case 'first_name':
                if($_GET['nav-detalles']=="Siguiente"){
                    crudDetallesSiguiente($valores[1]);
                }else if($_GET['nav-detalles']=="Anterior"){
                    crudDetallesAnterior($valores[1]);
                }
                break;
            case 'last_name':
                if($_GET['nav-detalles']=="Siguiente"){
                    crudDetallesSiguiente($valores[2]);
                }else if($_GET['nav-detalles']=="Anterior"){
                    crudDetallesAnterior($valores[2]);
                }
                break;    
            case 'email':
                if($_GET['nav-detalles']=="Siguiente"){
                    crudDetallesSiguiente($valores[3]);
                }else if($_GET['nav-detalles']=="Anterior"){
                    crudDetallesAnterior($valores[3]);
                }
                break;
            case 'gender':
                if($_GET['nav-detalles']=="Siguiente"){
                    crudDetallesSiguienteGender($valores[4],$valores[0]);
                }else if($_GET['nav-detalles']=="Anterior"){
                    crudDetallesAnteriorGender($valores[4],$valores[0]);
                }
                break;
            case 'ip_address':
                if($_GET['nav-detalles']=="Siguiente"){
                     crudDetallesSiguiente($valores[5]);
                }else if($_GET['nav-detalles']=="Anterior"){
                    crudDetallesAnterior($valores[5]);
                }
                break;
            case 'telefono':
                if($_GET['nav-detalles']=="Siguiente"){
                    crudDetallesSiguiente($valores[6]);
                }else if($_GET['nav-detalles']=="Anterior"){
                    crudDetallesAnterior($valores[6]);
                }
                break;                   
        }
    }

}
// POST Formulario 
else {
    if (isset($_POST['orden'])) {
        switch ($_POST['orden']) {
            case "Nuevo":
                crudPostAlta();
                break;
            case "Modificar":
                crudPostModificar();
                break;  
            case "Detalles":; // No hago nada
        } 
    }


    // Proceso las ordenes de navegación en Modificar-----------------
    if (isset($_POST['nav-modificar']) && isset($_POST['valor'])) { //array de get valores
        $valores = $_POST["valor"]; //Array ( [0] => 717 [1] => Zora [2] => Shinner [3] => zshinnerjw@blogtalkradio.com [4] => Female [5] => 232.43.139.229 [6] => 243-678-8126 )
        $campo = $_SESSION['ordenarpor'];

        switch ($campo) {
            case 'id':
                if($_POST['nav-modificar']=="Siguiente"){
                    crudModificarSiguiente($valores[0]);
                }else if($_POST['nav-modificar']=="Anterior"){
                    crudModificarAnterior($valores[0]);
                }
                break;
            case 'first_name':
                if($_POST['nav-modificar']=="Siguiente"){
                    crudModificarSiguiente($valores[1]);
                }else if($_POST['nav-modificar']=="Anterior"){
                    crudModificarAnterior($valores[1]);
                }
                break;
            case 'last_name':
                if($_POST['nav-modificar']=="Siguiente"){
                    crudModificarSiguiente($valores[2]);
                }else if($_POST['nav-modificar']=="Anterior"){
                    crudModificarAnterior($valores[2]);
                }
                break;    
            case 'email':
                if($_POST['nav-modificar']=="Siguiente"){
                    crudModificarSiguiente($valores[3]);
                }else if($_POST['nav-modificar']=="Anterior"){
                    crudModificarAnterior($valores[3]);
                }
                break;
            case 'gender':
                if($_POST['nav-modificar']=="Siguiente"){
                    crudModificarSiguienteGender($valores[4],$valores[0]);
                }else if($_POST['nav-modificar']=="Anterior"){
                    crudModificarAnteriorGender($valores[4],$valores[0]);
                }
                break;
            case 'ip_address':
                if($_POST['nav-modificar']=="Siguiente"){
                    crudModificarSiguiente($valores[5]);
                }else if($_POST['nav-modificar']=="Anterior"){
                    crudModificarAnterior($valores[5]);
                }
                break;
            case 'telefono':
                if($_POST['nav-modificar']=="Siguiente"){
                    crudModificarSiguiente($valores[6]);
                }else if($_POST['nav-modificar']=="Anterior"){
                    crudModificarAnterior($valores[6]);
                }
                break;                   
        }
    }

}

// Si no hay nada en la buffer 
// Cargo genero la vista con la lista por defecto
if (ob_get_length() == 0) {
    $db = AccesoDatos::getModelo();
    $posini = $_SESSION['posini'];
    $campo = $_SESSION['ordenarpor'];
    $sentido = $_SESSION['sentido'];
    $tvalores = $db->getListaOrdenada($campo,$sentido);
    require_once "app/views/list.php";
}
$contenido = ob_get_clean(); //Fin del bufer
//$ordenar=$_SESSION['ordenarpor'];
$msg = $_SESSION['msg'];
// Muestro la página principal con el contenido generado
require_once "app/views/principal.php";
