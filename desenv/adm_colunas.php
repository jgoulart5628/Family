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
   $db = new adm_valida('MYSQL_deal');

   
   require_once("../xajax/xajax_core/xajax.inc.php");
   $xajax = new xajax();
   // $xajax->configure('debug',true);
   $xajax->configure('errorHandler', true);
   $xajax->configure('logFile', 'xajax_error.log');
   $xajax->register(XAJAX_FUNCTION, "Tela_Inicial");
   $xajax->register(XAJAX_FUNCTION, "Manut_CRUD");
   $xajax->register(XAJAX_FUNCTION, "Alterar_Coluna");
   $xajax->register(XAJAX_FUNCTION, "AbreListaColunas");
   $xajax->register(XAJAX_FUNCTION, "AlteraComment");
   $xajax->register(XAJAX_FUNCTION, "AbreListaColunas");
   $xajax->register(XAJAX_FUNCTION, "Copiar");
   $xajax->register(XAJAX_FUNCTION, "Gera_Tela");
   $xajax->processRequest();
   $xajax->configure('javascript URI', '../xajax/');
//              "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]]

?>
<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Validação Tabelas</title>
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
      function copiar() {
         var copyText = document.getElementById("texto");
             copyText.select();
            document.execCommand("copy");
             alert("texto copiado. " + copyText.value);
      }
     </script>
    <?php $xajax->printJavascript('xajax'); ?>
 </head>
 <body>
   <nav class="navbar navbar-light"></nav>
    <div class="container empresa-clean"> 
     <div class="header centro"><h3>Validação Tabelas</h3></div>             
     <form id="dados_tela" name="dados_tela">
      <div id="tela_tabela" style="background-color: cyan;"></div>
      <div id="tela_principal" ></div> 
     </form>
   </div>
   <div class="footer centro"><span class="glyphicon glyphicon-thumbs-up"></span>&#174; DealSw Web </div>
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
     global $db;
     $res    = $db->Monta_lista($resp);
     $tela   = '<div class="form-group">
                 <table  id="tabclas" class="table table-striped table-bordered">
                     <thead>  
                       <tr>
                        <th style="width: 10%; text-align: center;">Gerar HTML</th>
                        <th style="width: 30%; text-align: center;" data-field="tabela"  data-sortable="true">Tabela</th>
                        <th style="width: 60%; text-align: center;" data-field="titulo"  data-sortable="true">Titulo</th>
                       </tr></thead><tbody>';
    if (is_array($res)) {
          $tt = count($res);
        for ($a = 0; $a < $tt; $a++) {
            $tabela     =  $res[$a]['tabela'];
            $titulo     =  $res[$a]['titulo'];
            $tela .= '<tr> 
                      <td><input type="image" src="../img/edit-icon.png" border="0" width="32" height="32" data-toggle="tooltip" data-placement="bottom" title="Gera Form HTML para Inserir App" onclick="xajax_Gera_Tela(\''.$tabela.'\'); return false;"></td>
                     <td data-field="tabela" data-sortable="true"><button type="submit" class="btn btn-info" name="tabela_'.$a.'" value="'.$tabela.'" onclick="xajax_AbreListaColunas(\''.$tabela.'\'); return false;">'.$tabela.'</button></td>
                     <td data-field="titulo" data-sortable="true"><input type="text" class="form-control" value="'.$titulo.'" name="titulo_'.$a.'" onchange="xajax_AlteraComment(xajax.getFormValues(\'dados_tela\'),\''.$a.'\'); return false;"></td>
                  </tr>';
        }
    }
     $tela .= '</tbody></table></div>';
     $resp->assign("tela_tabela", "innerHTML", '');
     $resp->assign("tela_principal", "innerHTML", $tela);
     $resp->script('tabela()');
     return $resp;
}
function Manut_CRUD($tabela, $coluna)
{
    $resp = new xajaxResponse();
    global $db;
    $adm_colunas = $db->Busca_Dados_Coluna($tabela, $coluna, $resp);
    
    $tela = '<div class="row">
                 <div class="form-group col-sm-2">
                     <label for="tabela">Tabela</label>
                     <h3  class="form-control" id="tabela"><b>'.$tabela.'</b></h3>
                 </div>    
                 <div class="form-group col-sm-2">
                     <label for="coluna">Coluna</label>
                     <h3 class="form-control" id="coluna"><b>'.$coluna.'</b></h3>
                 </div>
                 <div class="form-group col-sm-2">
                    <label for="ordem">Ordem</label>
                      <h3 class="form-control" name="ordem" id="ordem"><b>'.$adm_colunas['ordem'].'</b></h3>
                    </div>
                 <div class="form-group col-sm-2">
                     <label for="tipo">Tipo Coluna</label>
                     <h3  class="form-control" name="tipo" id="tipo" ><b>'.$adm_colunas['tipo'].'</b></h3>
                  </div>
             </div>      
              <div class="row">
                 <div class="form-group col-sm-4">
                      <label for="label">Comment/Label</label>
                      <input type="text"   class="form-control" name="label" id="label" value="'.$adm_colunas['label'].'" >
                 </div>
                  <div class="form-group col-sm-4">
                     <label for="valida">Regra Validação</label>
                     <input type="text"   class="form-control" name="valida" id="valida" value="'.$adm_colunas['valida'].'" >
                    </div>
                 <div class="form-group col-sm-2">
                    <label for="defalt">Default</label>
                     <input type="text"   class="form-control" name="defalt" id="defalt" value="'.$adm_colunas['defalt'].'" >
                 </div>
               </div>
               <button type="submit"  class="btn btn-primary" onclick="xajax_Alterar_Coluna(xajax.getFormValues(\'dados_tela\')); return false;">Alterar</button>
             <button type="submit"  class="btn btn-primary" onclick="xajax_AbreListaColunas(\''.$tabela.'\'); return false;">Cancelar</button>
             <input type="hidden" name="tabela" value="'.$tabela.'">
             <input type="hidden" name="coluna" value="'.$coluna.'">
             <input type="hidden" name="ordem"  value="'.$adm_colunas['ordem'].'">';

    $resp->assign("tela_principal", "innerHTML", $tela);
    return $resp;
}

function AbreListaColunas($tabela)
{
    $resp = new xajaxResponse();
    global $db;
    $res    = $db->Monta_Colunas($tabela, $resp);
    foreach ($res[0] as $key => $value) {
        $cab[]  .=  $key;
    }
//    $resp->alert('Aqui : '.print_r($res,true)); return $resp;
// monta cabeçalho  lista
    $tela   = '<button type="submit"  class="btn btn-primary" onclick="xajax_Tela_Inicial(\'\'); return false;">Retornar</button>
               <div class="form-group">
                 <table  id="tabclas" class="table table-striped table-bordered">
                     <thead><tr>
                     <th>Op.</th>';
    foreach ($cab as $col) {
        $tela .=  '<th style="text-align: center;" data-field="'.$col.'" data-sortable="true">'.ucfirst($col).'</th>';
    }
    $tela .= '</tr></thead><tbody>';
    for ($a = 0; $a < count($res); $a++) {
        $tela .= '<tr>
                  <td data-field="botoes"  style="text-align: center;" data-sortable="false">
                   <input type="image" src="../img/edit-icon.png" border="0" width="32" height="24" data-toggle="tooltip" data-placement="bottom" title="Altera Coluna" onclick="xajax_Manut_CRUD(\''.$tabela.'\',\''.$res[$a][$cab[1]].'\'); return false;"></td>';
        foreach ($cab as $col) {
            $tela .= '<td data-field="'.$col.'" data-sortable="true">'.$res[$a][$col].'</td>';
        }
        $tela .= '</tr>';
    }
    $tela .= '</tbody></table></div>';
    $resp->assign("tela_principal", "innerHTML", $tela);
    $resp->script('tabela()');
    return $resp;
}

function Alterar_Coluna($dados)
{
    $resp = new xajaxResponse();
    $tabela =  $dados['tabela'];
    $coluna =  $dados['coluna'];
    $ordem  =  $dados['ordem'];
    $valida =  $dados['valida'];
    $label  =  $dados['label'];
    $defalt =  $dados['defalt'];
    global $db;
    $adm_colunas = $db->Busca_Dados_Coluna($tabela, $coluna, $resp);
    if ($defalt) {
        if ($defalt !== $adm_colunas['defalt']) {
            $query = " alter table $tabela alter $coluna set default '".$defalt."'";
            $e = $db->Busca_DDL($query, $resp);
        }
    }
    if ($label) {
        if ($label  !== $adm_colunas['label']) {
            $query = " select concat('alter table ', '".$tabela."', ' modify column ', '".$coluna."' ,' ', "
            .   "  a.COLUMN_TYPE, (case when a.IS_NULLABLE = 'NO' then ' not null ' else ' null ' end),  "
            .   "ifnull(a.COLUMN_DEFAULT, ' '), ' comment ', '\"".$label."\"' ) as altera  "
            .   "from information_schema.columns a  where  a.TABLE_SCHEMA = 'deal' and TABLE_NAME = '".$tabela."' "
            .   " and COLUMN_NAME  = '".$coluna."'";
            $e = $db->Busca_DDL($query, $resp);
        }
    }
    if ($valida) {
        if ($valida !== $adm_colunas['valida']) {
            $qq    = " select valida from  adm_valida  where tabela = '".$tabela."' and coluna = '".$coluna."' ";
            $res   = $db->Leitura_Valida($qq, $resp);
//            $resp->alert(' Aqui '.print_r($res,true)); return $resp;
            if ($res) {
                $query = " update adm_valida set valida = '".$valida."' where tabela = '".$tabela."' and coluna = '".$coluna."'";
            } else {
                $query = " insert into  adm_valida values('".$tabela."', '".$coluna."', '".$valida."' )";
            }
            $e = $db->Atualiza_Valida($query, $resp);
        }
    }
    $resp->script("xajax_AbreListaColunas('$tabela')");
    return $resp;
}


function AlteraComment($dados, $ind)
{
    $resp = new xajaxResponse();
    $tabela = $dados['tabela_'.$ind];
    $titulo = $dados['titulo_'.$ind];
    $query = " alter table ".$tabela." comment='$titulo'";
    global $db;
    $e = $db->Altera_Comment($query, $resp);
//    $resp->alert('Resultado: '.$e);
    $resp->script("xajax_Tela_Inicial()");
    return $resp;
}

function Gera_tela($tabela)
{
    $resp = new xajaxResponse();
    global $db;
    $res    = $db->Monta_Colunas($tabela, $resp);
    foreach ($res as $tab) {
        $coluna[]   .= $tab['coluna'];
        if (!$tab['label']) {
            $tab['label'] =  ucfirst($tab['coluna']);
        }
        $label[]    .= $tab['label'];
        $tipo[]     .= $tab['tipo'];
        $valida[]   .= $tab['valida'];
    }
    $telai  = '<button type="submit"  class="btn btn-primary" onclick="xajax_Tela_Inicial(\'\'); return  false;">'.$tabela.' Retornar</button>
      <div class="col-sm-12" style="background-color: white;"><b>Tela visualização básica</b></div>';
    $tela  = '';
    $telax = '';
//         <div id="tela_texto" class="col-sm-12" style="background-color: silver;" align="center"></div>

//      $telax = '<table>';
//      for ($a = 0; $a < count($coluna); $a++)  {
//          $telax .= '<tr><td>$'.$coluna[$a].' = $dados_pessoa[\''.$coluna[$a].'\'];</td></tr>';
//      }
//      $telax .='</table>';
//      $tela  = '$tela .= \'';
    for ($a = 0; $a < count($coluna); $a++) {
        if (substr($coluna[$a], 0, 1) === 'x') {
            $rd = '$rd';
        }
        if ($a === 0 || fmod($b, 3) === 0) {
            $tela .= '<div class="row">';
        }
        $lista  = explode('|', $valida[$a]);
        $vv  = explode(' ', $valida[$a]);
        $nn  = explode('_', $tabela);
        $val   = '.$'.$tabela.'[\''.$coluna[$a].'\'].';
        $valx  = '$'.$tabela.'[\''.$coluna[$a].'\']';
        $fecha = '';
        $xy = '';
        $vvx = strtolower($vv[1]);
        $combo = 'combo_geral($tabela, \''.$coluna[$a].'\', '.$valx.', $resp)';
        if ((strtolower($vv[0]) == 'tabela') || (count($lista) > 1)) {
            $tela .= '<div class="form-group col-sm-2">
                      <label for="'.$coluna[$a].'">'.$label[$a].'</label>';
                    $tela .= '\'.'.$combo.'.\'</div>';
//                      <label for="'.$coluna[$a].'">'.$label[$a].'</label>'\'.$this->combo_'.strtolower($vv[1]).'('.$valx.' , $resp).\'
        } else {
            if (substr($vv[0], 0, 4) !== 'bool') {
                if (substr($tipo[$a], 0, 4) == 'text') {
                     $tela .= '<div class="form-group col-sm-2">
                           <label for="'.$coluna[$a].'">'.$label[$a].'</label>
                           <textarea  cols="45" rows="3"  class="form-control" name="'.$coluna[$a].'" id="'.$coluna[$a].'" >\''.$val.'\'</textarea></div>';
                } else {
                    switch (substr($tipo[$a], 0, 3)) {
                        case 'dat':
                            $type = "date";
                            break;
                        case 'int':
                        case 'dec':
                            $type = "number";
                            break;
                        default:
                            $type = "text";
                            break;
                    }
                    $tela .= '<div class="form-group col-sm-2">
                    <label for="'.$coluna[$a].'">'.$label[$a].'</label>
                     <input type="'.$type.'"  '.$xy.' class="form-control" name="'.$coluna[$a].'" id="'.$coluna[$a].'" value="\''.$val.'\'" >'.$fecha.'
                    </div>';
                }
            }
        }
        if (substr($vv[0], 0, 4) == 'bool') {
            $telax .= '            $'.$coluna[$a].'S = \'\'; $'.$coluna[$a].'N = \'\' ;
             if ('.$valx.' == 0) { $'.$coluna[$a].'S  = \'checked="true"\'; }   
             if ('.$valx.' == 1) { $'.$coluna[$a].'N = \'checked="true"\'; } '.PHP_EOL;
            $tela .= '<div class="form-group col-sm-2">
                        <label for="'.$coluna[$a].'">'.$label[$a].'</label>
                        <div class="custom-control custom-radio custom-control-inline"> 
                          <input type="radio" class="custom-control-input" name="'.$coluna[$a].'" id="'.$coluna[$a].'0" value="0" \'.$'.$coluna[$a].'S.\'> &nbsp;
                          <label class="custom-control-label" for="'.$coluna[$a].'0">Sim</label>&nbsp;&nbsp;
                          <input type="radio" class="custom-control-input" name="'.$coluna[$a].'" id="'.$coluna[$a].'1" value="1" \'.$'.$coluna[$a].'N.\'> &nbsp;
                          <label class="custom-control-label" for="'.$coluna[$a].'">Não</label>
                       </div>
                    </div>';
  // TODO   booleano
        }
    }
//      '.PHP_EOL
    $tela .= '</div></div>';
    $texto = htmlentities($telax).PHP_EOL;
    $texto .= ' /* Aqui começa o código HTML com as variaáveis de tela */ '.PHP_EOL;
    $texto .= ' $tela = \''.htmlentities($tela).'\';';
    $rows  = ceil(strlen($texto) / 100);
//    $telay = str_replace('</div>', '</div>p>', $tela);
    $telax = '<button onclick="xajax_Copiar(); return false;">Copiar</button>
              <div class="col-sm-12" style="background-color: cyan;">
              <b>Texto para copia e colar no seu programa</b></div>
              </p><textarea id="texto" cols="100" rows="'.$rows.'">'.$texto.'</textarea>';
    $telaz = str_replace("'.combo", '<input type="text" class="form-control" name="combo">combo', $tela);
    $telay = $telai.$telaz.$telax;
    $resp->assign("tela_principal", "innerHTML", '');
    $resp->assign("tela_tabela", "innerHTML", $telay);
    return $resp;
}

function Copiar()
{
    $resp = new xajaxResponse;
    $resp->script('copiar();');
    return $resp;
}
