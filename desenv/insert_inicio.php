<?php
/* 
 * Modelo básico de início de programa php
 * com insert do xajax
 * após incluir no programa criar as entradas xajax das funções.
 */
   Header("Cache-control: private, no-cache");
   Header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
   ini_set('date.timezone', 'America/Sao_Paulo');
   ini_set("memory_limit",-1);
   ini_set('default_charset','UTF-8');
   error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
   //   error_reporting(E_ALL & ~(E_NOTICE));
   define('ROOT', dirname(__DIR__) ); 
   define('DS', DIRECTORY_SEPARATOR);
   include(ROOT.DS.'autoload.php');
   // Session; 
   $sessao    = new sessao();
   // Banco de dados   Classe name = nome da tabela
   $db = new pessoa_41010('MYSQL_deal');

   
   require_once("../xajax/xajax_core/xajax.inc.php");
   $xajax = new xajax();
   // $xajax->configure('debug',true);
   $xajax->configure( 'errorHandler', true );
   $xajax->configure( 'logFile', 'xajax_error.log' );  
   $xajax->register(XAJAX_FUNCTION,"Tela_Inicial");
   $xajax->register(XAJAX_FUNCTION, "Manut_CRUD");
   $xajax->register(XAJAX_FUNCTION, "Excluir");
   $xajax->register(XAJAX_FUNCTION, "Alterar");
   $xajax->register(XAJAX_FUNCTION, "Incluir");
   $xajax->processRequest();
   $xajax->configure('javascript URI','../xajax/');
?>
<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{TITULO da TELA}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/Empresa-Form.css">
    <link rel="stylesheet" href="../css/Navigation-with-Search.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      function tabela() {   
        $('#tabclas').dataTable( 
           { "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "Todos"]], 
             "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json" }
           }          
         );
      }
     </script>
   <?php $xajax->printJavascript('xajax'); ?>
 </head>
 <body>
        <nav class="navbar navbar-light">
        <div class="container-fluid">
            <h3 class="centro" >Cadastro Empresas</h3>
        </div>             
    </nav>
   <div class="empresa-clean"> 
     <form id="dados_tela" name="dados_tela">
      <div id="tela_principal" ></div> 
     </form>
   </div>
   <div class="footer"><span class="glyphicon glyphicon-thumbs-up"></span>&#174; DealSw Web </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>  
   <script type="text/javaScript">xajax_Tela_Inicial() </script>
  </body>
</html>
<?php
function Tela_Inicial() {
     $resp    = new xajaxResponse();
     $tela   = "Aqui começa a navegação";
     /*
      * Modelo básico para tela grid de leitura de tabelas. 
     $res    = $db->Monta_lista($resp);
      * 
      *  
      *  // obtem cabecalho da tabela 
   *     foreach($res[0] as $key=>$value) {
       $cab[]  .=  $key;
    }
//    $resp->alert('Aqui : '.print_r($res,true)); return $resp;
// monta cabeçalho  lista    
    $tela   = '<button type="submit"  class="btn btn-primary" onclick="xajax_Tela_Inicial(\'\'); return false;">Retornar</button>
               <div class="form-group">
                 <table  id="tabclas" class="table table-striped table-bordered">
                     <thead><tr>
                     <th>Op.</th>';
    foreach($cab as $col)  {
        $tela .=  '<th style="text-align: center;" data-field="'.$col.'" data-sortable="true">'.ucfirst($col).'</th>';
    }
    $tela .= '</tr></thead><tbody>';
    for ($a = 0; $a < count($res); $a++)  { 
        $tela .= '<tr>
                  <td data-field="botoes"  style="text-align: center;" data-sortable="false">
                   <input type="image" src="../img/edit-icon.png" border="0" width="32" height="24" data-toggle="tooltip" data-placement="bottom" title="Altera Coluna" onclick="xajax_Manut_CRUD(\''.$tabela.'\',\''.$res[$a][$cab[0]].'\'); return false;"></td>';
        foreach($cab as $col)  {
          $tela .= '<td data-field="'.$col.'" data-sortable="true">'.$res[$a][$col].'</td>';
        }
        $tela .= '</tr>';
    }
    $tela .= '</tbody></table></div>';    
     */
     $tela   .= '<button type="submit"  class="btn btn-primary" onclick="xajax_Manut_CRUD(0,\'I\'); return false;">Incluir Registro</button>';
     $resp->assign("tela_principal", "innerHTML", $tela);
     // ativa o javascript para bavegar em tabelas longas.
//     $resp->script('tabela()');
     return $resp;
}    
function Manut_CRUD($id, $oper) {
    $resp = new xajaxResponse();
    // global $db;
    // tratar tela de dados
    $tela = '<button type="submit"  class="btn btn-primary" onclick="xajax_Incluir(xajax.getFormValues(\'dados_tela\')); return false;">Incluir</button>
             <button type="submit"  class="btn btn-primary" onclick="xajax_Alterar(xajax.getFormValues(\'dados_tela\')); return false;">Alterar</button>
             <button type="submit"  class="btn btn-primary" onclick="xajax_Excluir(\'\'); return false;">Excluir</button>
             <button type="submit"  class="btn btn-primary" onclick="xajax_Tela_Inicial(\'\'); return false;">Cancelar</button>';

    $resp->assign("tela_principal", "innerHTML", $tela);
    return $resp;
}

function Excluir($id) {
    $resp = new xajaxResponse();
//    global $db;
//    $resp->confirmCommands(1, " Confirma exclusão do Registro ($id) ? ");
//    $db->Excluir_Registro($id, $resp);
    $resp->script("xajax_Tela_inicial()");
    return $resp;
}


function Alterar($dados) {
    $resp = new xajaxResponse();
    //  inserir validações
    //  global $db;
    //  $db->Alterar_Registro($dados, $resp);
    $resp->script("xajax_Tela_Inicial();");
    return $resp;
}

function Incluir($dados) {
    $resp = new xajaxResponse();
    // inserir validações
    // 
    // global $db;
    // $db->Incluir_Registro($dados, $resp);
    $resp->script("xajax_Tela_Inicial()");
    return $resp;
}
