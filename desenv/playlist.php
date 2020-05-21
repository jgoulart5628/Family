<?php
/*
 * Modelo básico de início de programa php
 * com insert do xajax
 * após incluir no programa criar as entradas xajax das funções.
 */
   Header("Cache-control: private, no-cache");
   Header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
   ini_set('date.timezone', 'America/Sao_Paulo');
   ini_set("memory_limit", -1);
   ini_set('default_charset', 'UTF-8');
   error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
   //   error_reporting(E_ALL & ~(E_NOTICE));
   define('ROOT', dirname(__DIR__));
   define('DS', DIRECTORY_SEPARATOR);
   include(ROOT.DS.'autoload.php');
   // Session;
   $sessao    = new sessao();
   // Banco de dados   Classe name = nome da tabela
   $db = new acesso_db('MYSQL_curso');
   /*
   Cria tabela de canais apartir de arquivo m3u.
   $a = 0;
   $b = 0;
if ($file = fopen("../lista_30257808973.m3u", "r")) {
    while (!feof($file)) {
        $line = fgets($file);
        $a++;
        if ($a > 1) {
            if (substr($line, 0, 1) == '#') {
                if ($b > 0) {
                    $query = " insert into canais values(null, null, '$canal', '$site', 1) ";
                    $e = $db->Executa_Query_SQL($query);
                    echo $e.'</br>';
                }
                $xx = explode(',', $line);
                $canal  = addslashes(rtrim($xx[1], "\x0a"));
            } else {
                $site = rtrim($line, "\x0a");
                $b = 1;
            }
        }
//        if ($a > 20) {
//            break;
//            ;
//    }
        # do same stuff with the $line
    }
       fclose($file);
}
exit;
*/
   
   require_once("../xajax/xajax_core/xajax.inc.php");
   $xajax = new xajax();
   // $xajax->configure('debug',true);
   $xajax->configure('errorHandler', true);
   $xajax->configure('logFile', 'xajax_error.log');
   $xajax->register(XAJAX_FUNCTION, "Tela_Inicial");
   $xajax->register(XAJAX_FUNCTION, "Gerar_PlayList");
   $xajax->register(XAJAX_FUNCTION, "Seta_Favorito");
   $xajax->processRequest();
   $xajax->configure('javascript URI', '../xajax/');
?>
<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Playlists</title>
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
            <h3 class="centro" >PlayLists</h3>
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
   <script type="text/javaScript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" ></script>
   <script type="text/javaScript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" ></script>
   <script type="text/javaScript">xajax_Tela_Inicial() </script>
  </body>
</html>
<?php
function Tela_Inicial()
{
     $resp    = new xajaxResponse();
     global  $db;
     $res   = $db->Executa_Query_Array("select id, nome, site, favorito  from canais where grupo is null order by 1", $resp);
//    $resp->alert('Aqui : '.print_r($res,true)); return $resp;
// monta cabeçalho  lista
    $tela   = '<button type="submit"  class="btn btn-primary" onclick="xajax_Gerar_PlayList(\'\'); return false;">Gerar PlayList</button>
               <div class="form-group">
                 <table  id="tabclas" class="table table-striped table-bordered">
                     <thead><tr>
                     <th data-sortable="false">Favorito</th>
                     <th style="text-align: center;" data-field="nome" data-sortable="true">Nome</th>
                     <th style="text-align: center;"   data-field="site" data-sortable="true">Site</th>
                   </tr></thead><tbody>';
    for ($a = 0; $a < count($res); $a++) {
        $id   =  $res[$a]['id'];
        $nome =  $res[$a]['nome'];
        $site =  $res[$a]['site'];
        $favorito = $res[$a]['favorito'];
        if ($res[$a]['favorito']) {
            $fav = 'checked';
        } else {
            $fav = '';
        }
        $tela .= '<tr>
                  <td style="text-align: center;" data-sortable="false">
                   <input type="checkbox" id="fav_'.$id.'" class="form-check-input" data-toggle="tooltip" '.$fav.' data-placement="bottom" title="Seta Favorito" onchange="xajax_Seta_Favorito(\''.$id.'\', \''.$favorito.'\',); return true;"></td>
                  <td data-field="nome" data-sortable="true">'.$nome.'</td>
                  <td data-field="site" data-sortable="true">'.$site.'</td>
                 </tr>';
    }
    $tela .= '</tbody></table></div>';
    $resp->assign("tela_principal", "innerHTML", $tela);
     // ativa o javascript para bavegar em tabelas longas.
     $resp->script('tabela()');
     return $resp;
}

function Seta_Favorito($id, $fav)
{
    $resp = new xajaxResponse();
    global $db;
    if ($fav) {
        $fav = 0;
    } else {
        $fav = 1;
    }
    $query = "update canais set favorito = $fav where id = $id ";
    $db->Executa_Query_SQL($query, $resp);
    return $resp;
}


function Gerar_PlayList()
{
    $resp = new xajaxResponse();
    global $db;
    $linha1    = '#EXTM3U';
    $linha2    = '#EXTINF:-1 ,';
    $playlist  =  ROOT.DS.'playlist_teste.m3u';
//    if (file_exists($playlist)) {
//        @unlink($playlist);
//    }
    $fh     =  fopen($playlist, "w");
    fwrite($fh, $linha1.PHP_EOL);
    $query = " select nome, site from canais where grupo is null and favorito = 1 ";
    $resul = $db->Executa_Query_Array($query, $resp);
    $i = 0;
    foreach ($resul as $res) {
        fwrite($fh, $linha2.$res['nome'].PHP_EOL);
        fwrite($fh, $res['site'].PHP_EOL);
        $i++;
    }
    fclose($fh);
    if (file_exists($playlist)) {
        $resp->alert('Arquivo '.$playlist.' Gerado. '.$i.' Registros');
    } else {
        $resp->alert('Onde está o Arquivo '.$playlist.' ?');
    }
    return $resp;
}
