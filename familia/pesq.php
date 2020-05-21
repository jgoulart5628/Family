<?php
 ini_set('display_errors', false);
 ini_set('default_charset', "ISO-8859-1");
 require_once("Pessoas_classe.php");
 $pessoa = new Pessoa_model();
// include('inc/banco_ado_class.php');
  global $pessoa;
  if(isset($_POST['queryString'])) {
    $qstring = strtoupper($_POST['queryString']);
    if (strlen($qstring) >1) {
          $list = $pessoa->AutoComplete($qstring);
          for ($a = 0; $a < count($list); $a++) {
              $nome    = $list[$a]['nomex'];
              $id      = $list[$a]['pessoa_id'];
              $res1    = $nome.'-'.$id;
     	    echo '<li onClick="fill(\''.$res1.'\');">'.$nome.'</li><br>';
         }
       }  // é maior que 2
  }  // post da query
