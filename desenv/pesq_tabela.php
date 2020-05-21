<?php
    error_reporting(E_ALL & ~(E_NOTICE));
    ini_set('log_errors', 1);
    error_log("php_errors.log");
    ini_set('date.timezone', 'America/Sao_Paulo');
    ini_set('default_charset', 'UTF-8');
    $keyword = strval($_POST['query']);
//    if (isset($_GET['q']))  {  $qq = " where tabela like '%$q%' "; }  else { $qq = ''; }
    $search_param = "{$keyword}%";
  include('../autoload.php');
  $conn = new acesso_db('MYSQL_deal');
    $query = " SELECT tabela FROM adm_tabelas WHERE tabela LIKE '$search_param' ";
    $result = $conn->Executa_Query_Array($query);
if (is_array($result)) {
    if (count($result) > 0) {
        foreach ($result as $res) {
            $tabelas[] = $res['tabela'];
        }
          echo json_encode($tabelas);
    }
}
