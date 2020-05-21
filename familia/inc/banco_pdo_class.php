<?php
   ini_set('display_errors', true);
    /**  
    * @classe    banco_mysql.php  
    * @descrição Classe de acesso ao banco de dados MySQL  
    * @autor     Joao Goulart 
    * @email     goulart.joao@gmail.com
    * @data      Outubro/2013 
    * @copyright (c) 2013 by Joao Goulart
    */ 
 class banco_mysql  {
        //parâmetros de conexão 
        var $cfg;
        var $db; 
        var $dbhost; 
        var $dbuser; 
        var $dbpasswd; 
        var $msg;         
        //handle da conexão 
        var $mydb; 
         
        //resultado das Queries 
        var $sql; 
        var $arr; 
        
  // conecta ao banco  
  function __construct() {
     $cfg = parse_ini_file("banco.ini",true); 
     $this->dbhost    = $cfg['MYSQL']['host'];
     $this->dbpasswd  = $cfg['MYSQL']['passwd'];
     $this->dbuser    = $cfg['MYSQL']['user'];
     $this->db        = $cfg['MYSQL']['db'];
     $this->msg       =  "<h1><font color='red'>Não conectou banco de dados, Help. '.$this->dbhost.'-'.$this->dbuser.'</font></h1>"; 
     $this->options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
      try { 
        $this->mydb = new PDO("mysql:host=$this->dbhost;dbname=$this->db", $this->dbuser, $this->dbpasswd, $this->options);
      }   catch(Exception $e) 
          {  $er = $e->getMessage(); return $this->erro($er, $this->msg, '');   }
  }

  function mydb_query($query, $mode='sql', $tela='') {
    $this->mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $this->mydb->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
    if (!$sql = $this->mydb->prepare($query)) { $msg = $this->mydb->errorInfo(); $this->erro($msg, $query,$tela); return 2;  exit;  }
    $this->sql = $sql;
    if (!$sql = $this->sql->execute()) { $msg = $this->mydb->errorInfo(); $this->erro($msg, $query,$tela); return 2;  exit;  }
//  try  {  $this->sql->execute();  }
//  catch (PDOException $msg)  { erro($msg, $query,$tela); return 2;  exit;  }          
  switch ($mode)   { 
      case "sql"     :  // $this->mydb->commit(); 
                        return 1; 
      case "array"   :  $arr  = $this->sql->fetchAll();  break;  
      case "single"  :  $arr  = $this->sql->fetch(); break; 
      case "nrows"   :  $arr  = $this->sql->fetchAll(); return count($arr); exit;
      case "unico"   :  $arr  = $this->sql->fetchColumn();  break;
 }     
  $this->arr = $arr; 
  return $this->arr;
}

function mydb_query_blob($query, $column,$blob_data,$tela='') {
    $sql = $this->mydb->prepare($query);
    $sql->bindValue($column, $blob_data, PDO::PARAM_LOB);
    $this->sql = $sql;
    if (!$this->sql = $this->sql->execute()) { $msg = $this->mydb->errorInfo(); $this->erro($msg, $query,$tela); return 2;  exit;  }
    return 1;
}

public function erro($msg, $query, $tela='') {
      if (is_object($tela))  {
                $tela->script(' var myWin  = window.open("../erro_sql.php?tipo=Erro de SQL.&msg='.$msg[1].'&sql='.$msg[2].'", "Erro.", "status = 1, height = 400, width = 500, resizable = 0, scrollbars=1" );
                 myWin.focus(); ');
      }  else {
      echo( '<script>
               var myWin  = window.open("../erro_sql.php?tipo=Erro de SQL.&msg='.$msg[1].'&sql='.$msg[2].'", "Erro.", "status = 1, height = 400, width = 500, resizable = 0, scrollbars=1" );
                 myWin.focus();
                </script>');
      } 
     return false;
     exit;
 }
}
?>
