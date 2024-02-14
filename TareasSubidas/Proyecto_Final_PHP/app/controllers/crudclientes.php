<?php
require_once 'vendor/tcpdf.php';

function crudBorrar ($id){    
    $db = AccesoDatos::getModelo();
    $resu = $db->borrarCliente($id);
    if ( $resu){
         $_SESSION['msg'] = " El usuario ".$id. " ha sido eliminado.";
    } else {
         $_SESSION['msg'] = " Error al eliminar el usuario ".$id.".";
    }

}

function crudTerminar(){
    AccesoDatos::closeModelo();
    session_destroy();
}
 
function crudAlta(){
    $cli = new Cliente();
    $orden= "Nuevo";
    include_once "app/views/formulario.php";
}

//DETALLES------------------------------------------------
function crudDetalles($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    include_once "app/views/detalles.php";
}

function crudDetallesSiguiente($valor){ //
    $campo=$_SESSION['ordenarpor'];
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($valor);

    if($cli==null){
        $cli = $db->getClientePrimero();
    }
    include_once "app/views/detalles.php";  
}

function crudDetallesAnterior($valor){
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($valor);

    if($cli==null){
        $cli = $db->getClienteUltimo();
    }
    include_once "app/views/detalles.php";
}

//Navegar por Detalles/Gender------------------
function crudDetallesSiguienteGender($gender,$id){ 
    $campo=$_SESSION['ordenarpor'];
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguienteGender($gender,$id);
    
    if($cli==null){
        $cli = $db->getClientePrimero();
    }
    include_once "app/views/detalles.php";
}

function crudDetallesAnteriorGender($gender,$id){ 
    $campo=$_SESSION['ordenarpor'];
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnteriorGender($gender,$id);
    
    if($cli==null){
        $cli = $db->getClientePrimero();
    }
    include_once "app/views/detalles.php";
}

//MODIFICAR---------------------------------------------------
function crudModificar($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $orden="Modificar";
    include_once "app/views/formulario.php";
}

function crudModificarSiguiente($valor){ 
    $orden="Modificar";
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($valor);

    if($cli==null){
        $cli = $db->getClientePrimero();
    }
    include_once "app/views/formulario.php";
}

function crudModificarAnterior($valor){ 
    $orden="Modificar";
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($valor);

    if($cli==null){
        $cli = $db->getClienteUltimo();
    }
    include_once "app/views/formulario.php";
}

//Navegar por Modificar/Gender-----------------------
function crudModificarSiguienteGender($gender,$id){ 
    $orden="Modificar";
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnteriorGender($gender,$id);

    if($cli==null){
        $cli = $db->getClientePrimero();
    }
    include_once "app/views/formulario.php";
}

function crudModificarAnteriorGender($gender,$id){ 
    $orden="Modificar";
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnteriorGender($gender,$id);

    if($cli==null){
        $cli = $db->getClienteUltimo();
    }
    include_once "app/views/formulario.php";
}

//POST----------------------------------------------------
function crudPostAlta(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código

    $db = AccesoDatos::getModelo(); 
    $correoOk = $db->validarCorreo($_POST['email'],$_POST['id']);
    $ipOk = $db->validarIp($_POST['ip_address']);
    $telefonoOk = $db->validarTelefono($_POST['telefono']);

    if($correoOk && $ipOk && $telefonoOk){
        $cli = new Cliente();
        $cli->id            =$_POST['id'];
        $cli->first_name    =$_POST['first_name'];
        $cli->last_name     =$_POST['last_name'];
        $cli->email         =$_POST['email'];	
        $cli->gender        =$_POST['gender'];
        $cli->ip_address    =$_POST['ip_address'];
        $cli->telefono      =$_POST['telefono'];
        $db = AccesoDatos::getModelo();
        if ( $db->addCliente($cli) ) {
            $_SESSION['msg'] = " El usuario ".$cli->first_name." se ha dado de alta ";
        } else {
            $_SESSION['msg'] = " Error al dar de alta al usuario ".$cli->first_name."."; 
        }
    }else{
        $_SESSION['msg'] = " Error al dar de alta al usuario, introduzca correctamente los datos.";
    }
}

function crudPostModificar(){
    limpiarArrayDeArrays($_POST); //Evito la posible inyección de código

    $db = AccesoDatos::getModelo(); 
    $correoOk = $db->validarCorreo($_POST['email'],$_POST['id']);
    $ipOk = $db->validarIp($_POST['ip_address']);
    $telefonoOk = $db->validarTelefono($_POST['telefono']);

    if($correoOk && $ipOk && $telefonoOk){
        $cli = new Cliente();

        $cli->id            =$_POST['id'];
        $cli->first_name    =$_POST['first_name'];
        $cli->last_name     =$_POST['last_name'];
        $cli->email         =$_POST['email'];	
        $cli->gender        =$_POST['gender'];
        $cli->ip_address    =$_POST['ip_address'];
        $cli->telefono      =$_POST['telefono'];
        $db = AccesoDatos::getModelo();
        if ( $db->modCliente($cli) ){
            $_SESSION['msg'] = " El usuario ha sido modificado. <br>";
        } else {
            $_SESSION['msg'] = " No se ha modificado el usuario. <br>";
        }   
    }else{
        $_SESSION['msg'] = " Error al modificar el usuario, introduzca correctamente los datos. <br>";
    }

    //Mando la funcion cargarFoto
    if($_FILES['foto']['size'] != 0) {
        cargarFotoCliente($_POST['id']);
    }
}

//OTRAS FUNCIONES--------------------------------------------------------------

//Establecer fotografia----------------------
function mostrarImagenCliente($id):string {
    $nombreArchivo = sprintf("./app/uploads/%08d.jpg", $id);

    if (file_exists($nombreArchivo)) {
            return $nombreArchivo;
    } else {
            return "https://robohash.org/"."$id"."?set=set4";
    }
}

//Subir Fotografia----------------------
function cargarFotoCliente($id){
    if($_FILES['foto']['error'] === UPLOAD_ERR_OK) {

        $nombreArchivo = $_FILES['foto']['name'];
        $tipoArchivo = $_FILES['foto']['type'];
        $pesoArchivo = $_FILES['foto']['size'];
        $nombreTempArchivo = $_FILES['foto']['tmp_name'];
        
        $permitidos = array('image/jpeg', 'image/png');
        $pesoMaximo = 500000; // 500 KB en bytes

        if(in_array($tipoArchivo, $permitidos) && $pesoArchivo <= $pesoMaximo) {
            $rutaDestino = sprintf("./app/uploads/%08d.jpg", $id);
            if (file_exists($rutaDestino)){
                unlink($rutaDestino);
            }
           
            if(move_uploaded_file($nombreTempArchivo, $rutaDestino)) {
                $_SESSION['msg'] .= " La foto del cliente ha sido subida correctamente.";
            } else {
                $_SESSION['msg'] .= " Error al subir la foto del cliente.";
            }
        } else {
            $_SESSION['msg'] .= " El archivo seleccionado no es una imagen válida o excede el tamaño permitido.";
        }    
    }else {
        $_SESSION['msg'] .= " No se ha seleccionado ningún archivo o ha ocurrido un error al subir la foto.";
    }
}

//Establecer bandera----------------------
function obtenerBandera($ip): string{
 $json = file_get_contents('http://ip-api.com/json/' . $ip);
    $obj = json_decode($json);
    if (property_exists($obj, "countryCode")) {
        $pais = strtolower($obj->countryCode);
        $bandera = '<img src="https://flagcdn.com/h120/' . $pais . '.jpg" alt="' . $obj->country . '" style="height:80px; width:146px;">';
    } else {
        $bandera ='<img src="https://prestashop.com/sites/default/files/wysiwyg/404_not_found.png" alt="bandera-no-encontrada" style="height:80px; width:146px;">';
    }         
    return $bandera;
}

//Generar PDF----------------------------
function generarPDF($valores) {
    $valores = $_GET["valor"];
    $id = $valores[0];
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);

    // Crear nuevo objeto TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Valeria');
    $pdf->SetTitle('Detalles del Cliente');
    $pdf->SetSubject('Detalles del Cliente');
    $pdf->SetKeywords('Cliente, Detalles');

    $pdf->SetMargins(10, 10, 10);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(0);

    $pdf->AddPage();

    //imagenes
    $bandera = obtenerBandera($cli->id); //corregir
    $fotoCliente='<img src="'.mostrarImagenCliente($cli->id).'" alt="foto" style="height:150px; width:145px;">';

    $html = '
    <hr><br>
    <table style="border: 2px solid grey; border-collapse: collapse; height:400px; width:350px; ">
        <tr>
            <td style="border: 1px solid grey;">Id:</td>
            <td style="border: 1px solid grey;">' . $cli->id . '</td>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">First name:</td>    
            <td style="border: 1px solid grey;">' . $cli->first_name . '</td>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Last name:</td>
            <td style="border: 1px solid black;">' . $cli->last_name . '</td>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Email:</td>
            <td style="border: 1px solid grey;">' . $cli->email . '</td>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Gender:</td>
            <td style="border: 1px solid grey;">' . $cli->gender . '</td>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Ip address:</td>
            <td style="border: 1px solid grey;">' . $cli->ip_address . '</td>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Telefono:</td>
            <td style="border: 1px solid black;">' . $cli->telefono . '</td>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Pais:</td>
            <td style="border: 1px solid grey;">' . $bandera . '</td>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Foto:</td>
            <td style="border: 1px solid grey;">' . $fotoCliente . '</td>
        </tr>
    </table><br>
    <hr>';


    // Agregamos el contenido al PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Salida del PDF (descarga)
    $pdf->Output('detalles_cliente.pdf', 'D');
}   
   