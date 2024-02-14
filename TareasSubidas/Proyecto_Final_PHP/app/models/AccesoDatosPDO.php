<?php

/*
 * Acceso a datos con BD Usuarios : 
 * Usando la librería PDO *******************
 * Uso el Patrón Singleton :Un único objeto para la clase
 * Constructor privado, y métodos estáticos 
 */
class AccesoDatos {
    
    private static $modelo = null;
    private $dbh = null;
    
    public static function getModelo(){
        if (self::$modelo == null){
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo;
    }
    
    

   // Constructor privado  Patron singleton
    private function __construct(){
        try {
            $dsn = "mysql:host=".DB_SERVER.";dbname=".DATABASE.";charset=utf8";
            $this->dbh = new PDO($dsn,DB_USER,DB_PASSWD);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }  

    }

    // Cierro la conexión anulando todos los objectos relacioanado con la conexión PDO (stmt)
    public static function closeModelo(){
        if (self::$modelo != null){
            $obj = self::$modelo;
            // Cierro la base de datos
            $obj->dbh = null;
            self::$modelo = null; // Borro el objeto.
        }
    }


    // Devuelvo cuantos filas tiene la tabla
    public function numClientes ():int {
      $result = $this->dbh->query("SELECT id FROM Clientes");
      $num = $result->rowCount();  
      return $num;
    } 
    
    // SELECT Devuelvo la lista de Usuarios
    public function getClientes ($primero,$cuantos):array {
        $tuser = [];
        // Crea la sentencia preparada
        // echo "<h1> $primero : $cuantos  </h1>";
        $stmt_usuarios  = $this->dbh->prepare("select * from Clientes limit $primero,$cuantos");
        // Si falla termina el programa
        $stmt_usuarios->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
    
        if ( $stmt_usuarios->execute() ){
            while ( $user = $stmt_usuarios->fetch()){
               $tuser[]= $user;
            }
        }
        // Devuelvo el array de objetos
        return $tuser;
    }

    // SELECT Devuelvo un usuario o false
    public function getCliente (int $id) {
        $cli = false;
        $stmt_cli   = $this->dbh->prepare("select * from Clientes where id=:id");
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $stmt_cli->bindParam(':id', $id);
        if ( $stmt_cli->execute() ){
             if ( $obj = $stmt_cli->fetch()){
                $cli= $obj;
            }
        }
        return $cli;
    }

    public function getClientePrimero(){
        $campo = $_SESSION['ordenarpor'];
        $cli = false;
        
        $stmt_cli = $this->dbh->prepare("select * from Clientes order by $campo limit 1");
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        if ( $stmt_cli->execute() ){
            if ( $obj = $stmt_cli->fetch()){
               $cli= $obj;
           }
        }
        return $cli;
    }

    public function getClienteUltimo(){
        $campo = $_SESSION['ordenarpor'];
        $cli = false;
        
        $stmt_cli   = $this->dbh->prepare("select * from Clientes order by $campo DESC limit 1");
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        if ( $stmt_cli->execute() ){
            if ( $obj = $stmt_cli->fetch()){
               $cli= $obj;
           }
        }
        return $cli;
    }

    public function getClienteSiguiente($valor){ 
        $campo = $_SESSION['ordenarpor'];
        $cli = false;

        $stmt_cli   = $this->dbh->prepare("select * from Clientes where $campo > ? order by $campo limit 1");
        // Enlazo $id con el primer ? 
        $stmt_cli->bindParam(1,$valor);
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        if ( $stmt_cli->execute() ){
            if ( $obj = $stmt_cli->fetch()){
               $cli= $obj;
           }
        }
        return $cli;
    }

    public function getClienteAnterior($valor){ 
        $campo = $_SESSION['ordenarpor'];
        $cli = false;
        
        $stmt_cli   = $this->dbh->prepare("select * from Clientes where $campo < ? order by $campo DESC limit 1");
        // Enlazo $id con el primer ? 
        $stmt_cli->bindParam(1,$valor);
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        if ( $stmt_cli->execute() ){
           if ( $obj = $stmt_cli->fetch()){
              $cli= $obj;
          }
        }
       
        return $cli;
    }


    public function getClienteSiguienteGender($gender,$id){ 
        $cli = false;
        
        $stmt_cli   = $this->dbh->prepare("select * from Clientes where gender > ? or (gender = ? and id > ?) order by gender, id limit 1");
        // Enlazo $id con el primer ? 
        $stmt_cli->bindParam(1,$gender);
        $stmt_cli->bindParam(2,$gender);
        $stmt_cli->bindParam(3,$id);
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        if ( $stmt_cli->execute() ){
            if ( $obj = $stmt_cli->fetch()){
               $cli= $obj;
           }
        }
        return $cli;
    }

    public function getClienteAnteriorGender($gender,$id){ 
        $cli = false;
        
        $stmt_cli   = $this->dbh->prepare("select * from Clientes where gender < ? or (gender = ? and id < ?) order by gender desc, id desc limit 1");
        // Enlazo $id con el primer ? 
        $stmt_cli->bindParam(1,$gender);
        $stmt_cli->bindParam(2,$gender);
        $stmt_cli->bindParam(3,$id);
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        if ( $stmt_cli->execute() ){
            if ( $obj = $stmt_cli->fetch()){
               $cli= $obj;
           }
        }
        return $cli;
    }
    
    //Devuelve la lista de clientes ordenados por el campo y sentido que se pide
    public function getListaOrdenada($campo,$sentido):array{
        $_SESSION['ordenarpor'] = $campo;
        $_SESSION['sentido'] = $sentido;
        $posini = $_SESSION['posini']; //VER---------
        $cuantos = FPAG;
        $tuser = [];

        if($campo=="gender"){
            $stmt_usuarios= $this->dbh->prepare("select * from Clientes order by gender $sentido,id $sentido limit $posini,$cuantos");
        }else{
            $stmt_usuarios= $this->dbh->prepare("select * from Clientes order by $campo $sentido limit $posini,$cuantos");
        }

        $stmt_usuarios->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        
        if ( $stmt_usuarios->execute() ){
            while ( $user = $stmt_usuarios->fetch()){
               $tuser[]= $user;
            }
        }
        return $tuser;
    }

    //Validar Datos---------------------------------------------------
    public function validarCorreo($correo,$id):bool{
        $stmt_validarcorreo = $this->dbh->prepare("select email from Clientes where email=:email and id!=:id");
        $stmt_validarcorreo->bindValue(':email',$correo);
        $stmt_validarcorreo->bindValue(':id',$id);
        $stmt_validarcorreo->execute();

        $resul = ($stmt_validarcorreo->rowCount() == 0) ? true : false;
        return $resul;
    }
    
    public function validarIp($ip):bool{
        //$patron = '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/';
        $patron = '/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';

        $resul = (preg_match($patron, $ip)) ? true : false;
        return $resul;
    }

    public function validarTelefono($telefono):bool{
        $patron = '/^\d{3}-\d{3}-\d{4}$/';

        $resul = (preg_match($patron, $telefono)) ? true : false;
        return $resul;
    }

    // UPDATE TODO
    public function modCliente($cli):bool{
      
        $stmt_moduser   = $this->dbh->prepare("update Clientes set first_name=:first_name,last_name=:last_name".
        ",email=:email,gender=:gender, ip_address=:ip_address,telefono=:telefono WHERE id=:id");
        $stmt_moduser->bindValue(':first_name', $cli->first_name);
        $stmt_moduser->bindValue(':last_name'   ,$cli->last_name);
        $stmt_moduser->bindValue(':email'       ,$cli->email);
        $stmt_moduser->bindValue(':gender'      ,$cli->gender);
        $stmt_moduser->bindValue(':ip_address'  ,$cli->ip_address);
        $stmt_moduser->bindValue(':telefono'    ,$cli->telefono);
        $stmt_moduser->bindValue(':id'          ,$cli->id);

        $stmt_moduser->execute();
        $resu = ($stmt_moduser->rowCount () == 1);
        return $resu;
    }

    //INSERT 
    public function addCliente($cli):bool{
        // El id se define automáticamente por autoincremento.
        $stmt_crearcli  = $this->dbh->prepare(
            "INSERT INTO `Clientes`( `first_name`, `last_name`, `email`, `gender`, `ip_address`, `telefono`)".
            "Values(?,?,?,?,?,?)");
        $stmt_crearcli->bindValue(1,$cli->first_name);
        $stmt_crearcli->bindValue(2,$cli->last_name);
        $stmt_crearcli->bindValue(3,$cli->email);
        $stmt_crearcli->bindValue(4,$cli->gender);
        $stmt_crearcli->bindValue(5,$cli->ip_address);
        $stmt_crearcli->bindValue(6,$cli->telefono);    
        $stmt_crearcli->execute();
        $resu = ($stmt_crearcli->rowCount () == 1);
        return $resu;
    }

   
    //DELETE 
    public function borrarCliente(int $id):bool {
        $stmt_boruser   = $this->dbh->prepare("delete from Clientes where id =:id");

        $stmt_boruser->bindValue(':id', $id);
        $stmt_boruser->execute();
        $resu = ($stmt_boruser->rowCount () == 1);
        return $resu;
        
    }   
    
    
     // Evito que se pueda clonar el objeto. (SINGLETON)
    public function __clone()
    { 
        trigger_error('La clonación no permitida', E_USER_ERROR); 
    }

    
}



