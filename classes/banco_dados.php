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
 class banco_dados  {
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
     $bd = 'LOCAL';
 //     if ($_SERVER['SERVER_ADDR'] == "::1") { $bd = 'LOCAL'; } else { $bd = "REMOTO"; }
     $cc = $_SERVER['DOCUMENT_ROOT'] . '/Family/config/banco.ini';
     if (!file_exists($cc)) {
        return $this->erro('Arquivo banco.ini não encontrado', '', '');
     }

     $cfg = parse_ini_file($cc,true); 
     $this->dbhost    = $cfg[$bd]['host'];
     $this->dbpasswd  = $cfg[$bd]['passwd'];
     $this->dbuser    = $cfg[$bd]['user'];
     $this->db        = $cfg[$bd]['db'];
     $this->msg       =  "<h1><font color='red'>Não conectou banco de dados, Help. '.$this->dbhost.'-'.$this->dbuser.'</font></h1>"; 
     $this->options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
      try { 
        $this->mydb = new PDO("mysql:host=$this->dbhost;dbname=$this->db", $this->dbuser, $this->dbpasswd, $this->options);
      }   catch(Exception $e) 
          {  $er = $e->getMessage();   return $this->erro('Erro nos Parâmetros de Conexão, verifique!', $er, '');   }
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

public function erro($msg, $query, $tela = '')   {
        $msgx = urlencode($msg);
        $sql  = urlencode($query);
        $arq  = './erro.php';
        if (is_object($tela)) {
            $tela->script(' var myWin  = window.open("'.$arq.'?tipo=Erro de SQL.&msg='.$msgx.'&sql='.$sql.'", "Erro.", "status = 1, height = 400, width = 500, resizable = 0, scrollbars=1" );
                 myWin.focus(); ');
        } else {
            echo( '<script>
               var myWin  = window.open("'.$arq.'?tipo=Erro de SQL.&msg='.$msgx.'&sql='.$sql.'", "Erro.", "status = 1, height = 400, width = 500, resizable = 0, scrollbars=1" );
                 myWin.focus();
                </script>');
        }
        return false;
        exit;
    }

}
