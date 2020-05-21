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
   require ROOT.DS.'autoload.php';
   // Session;
   $sessao    = new sessao();
   // Banco de dados   Classe name = nome da tabela
   $db = new adm_valida('MYSQL_deal');
//   $db = new adm_valida('ORACLE_dealora');

   
   require_once "../xajax/xajax_core/xajax.inc.php";
   $xajax = new xajax();
   // $xajax->configure('debug',true);
   $xajax->configure('errorHandler', true);
   $xajax->configure('logFile', 'xajax_error.log');
   $xajax->register(XAJAX_FUNCTION, "Tela_Inicial");
   $xajax->register(XAJAX_FUNCTION, "Manut_CRUD");
   $xajax->register(XAJAX_FUNCTION, "Alterar_Coluna");
   $xajax->register(XAJAX_FUNCTION, "Excluir_Coluna");
   $xajax->register(XAJAX_FUNCTION, "Confirma_Excluir_Coluna");
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
      $(document).on('keydown', 'input[pattern]', function(e){
           var input = $(this);
           var oldVal = input.val();
           var regex = new RegExp(input.attr('pattern'), 'g');
          setTimeout(function(){
             var newVal = input.val();
             if(!regex.test(newVal)){
                input.val(oldVal); 
             }
          }, 0);
      });
     </script>
    <?php $xajax->printJavascript('xajax'); ?>
 </head>
 <body>
   <nav class="navbar navbar-light"></nav>
    <div class="container empresa-clean"> 
     <div class="header centro"><h3>Validação Tabelas</h3></div>             
     <form id="dados_tela" name="dados_tela">
      <div style="background-color: cyan;">
        <div id="tela_show"></div>
        <div id="tela_copia"></div>
      </div>
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
     $tela   = '<div class="table-responsive">
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
                 <div class="form-group col-sm-3">
                      <label for="label">Comment/Label</label>
                      <input type="text"   class="form-control" name="label" id="label" value="'.$adm_colunas['label'].'" >
                 </div>
                  <div class="form-group col-sm-3">
                     <label for="valida">Regra Validação</label>
                     <input type="text"   class="form-control" name="valida" id="valida" value="'.$adm_colunas['valida'].'" >
                    </div>
                  <div class="form-group col-sm-3">
                     <label for="filtro">Filtro Valida</label>
                     <input type="text"   class="form-control" name="filtro" id="filtro" value="'.$adm_colunas['filtro'].'" >
                    </div>
                  <div class="form-group col-sm-3">
                    <label for="definido">Default</label>
                     <input type="text"   class="form-control" name="definido" id="definido" value="'.$adm_colunas['definido'].'" >
                 </div>
               </div>
               <button type="submit"  class="btn btn-primary" onclick="xajax_Alterar_Coluna(xajax.getFormValues(\'dados_tela\')); return false;">Alterar</button>
             <button type="submit"  class="btn btn-warning" onclick="xajax_AbreListaColunas(\''.$tabela.'\'); return false;">Cancelar</button>
             <button type="submit"  class="btn btn-danger" onclick="xajax_Excluir_Coluna(\''.$tabela.'\',\''.$coluna.'\'); return false;">Excluir</button>
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
    $tela   = '<h4><b>Tabela: '.$tabela.'</b></h4>
               <button type="submit"  class="btn btn-primary" onclick="xajax_Tela_Inicial(\'\'); return false;">Retornar</button>
               <div class="table-responsive">
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

function Excluir_Coluna($tabela, $coluna)
{
    $resp = new xajaxResponse();
    $resp->confirmCommands(1, " Confirma exclusão da Coluna ($tabela , $coluna) ? ");
    $resp->call('xajax_Confirma_Excluir_Coluna($tabela, $coluna)');
    return $resp;
}

function Confirma_Excluir_Coluna($tabela, $coluna)
{
    $resp = new xajaxResponse();
    global $db;
    $qq    = " select valida from  adm_valida  where tabela = '".$tabela."' and coluna = '".$coluna."' ";
    $res   = $db->Leitura_Valida($qq, $resp);
    if ($res) {
        $query = " delete from  adm_valida  where tabela = '".$tabela."' and coluna = '".$coluna."'";
        $e = $db->Atualiza_Valida($query, $resp);
    }
    $resp->script("xajax_AbreListaColunas('$tabela')");
    return $resp;
}
     

function Alterar_Coluna($dados)
{
    $resp = new xajaxResponse();
    $tabela =  $dados['tabela'];
    $coluna =  $dados['coluna'];
    $ordem  =  $dados['ordem'];
    $valida =  $dados['valida'];
    $filtro =  $dados['filtro'];
    $label  =  $dados['label'];
    $defalt =  $dados['definido'];
    global $db;
    $adm_colunas = $db->Busca_Dados_Coluna($tabela, $coluna, $resp);
    if ($defalt) {
        if ($defalt !== $adm_colunas['definido']) {
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
                $query = " insert into  adm_valida values('".$tabela."', '".$coluna."', '".$valida."' , '".$filtro."')";
            }
            $e = $db->Atualiza_Valida($query, $resp);
        }
    }
    if ($filtro) {
        if ($filtro !== $adm_colunas['filtro']) {
            $qq    = " select valida from  adm_valida  where tabela = '".$tabela."' and coluna = '".$coluna."' ";
            $res   = $db->Leitura_Valida($qq, $resp);
            //            $resp->alert(' Aqui '.print_r($res,true)); return $resp;
            if ($res) {
                $query = " update adm_valida set filtro = '".$filtro."' where tabela = '".$tabela."' and coluna = '".$coluna."'";
            } else {
                $query = " insert into  adm_valida values('".$tabela."', '".$coluna."', '".$valida."' , '".$filtro."')";
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
        $filtro[]   .= $tab['filtro'];
    }
    $telai  = '<button type="submit"  class="btn btn-primary centro" onclick="xajax_Tela_Inicial(\'\'); return  false;">Retornar</button>
      <div class="col-sm-12" style="background-color: white;"><b>Tela <h4  class="btn btn-info">'.$tabela.'</h4> visualização básica</b> - Colunas: '.count($coluna).'</div>';
    $guarda_html = array();
    $guarda_tela = array();
    $tela  = '';
    $telax = '';
    for ($a = 0; $a < count($coluna); $a++) {
        if (substr($coluna[$a], 0, 1) === 'x') {
            $rd = '$rd';
        }
        $lista = explode('|', $valida[$a]);
        $vv    = explode(' ', $valida[$a]);
        $nn    = explode('_', $tabela);
        $val   = '.$dados_'.$tabela.'[\''.$coluna[$a].'\'].';
        $valx  = '$dados_'.$tabela.'[\''.$coluna[$a].'\']';
        $fecha = '';
        $xy    = '';
        $vvx   = strtolower($vv[1]);
        $pref  = '$'.$tabela.'->';
        $combo = 'Busca_Combo(TABELA, \''.$coluna[$a].'\', '.$valx.', $resp, $oper)';
        if ((strtolower($vv[0]) == 'tabela') || (count($lista) > 1)) {
            $guarda_html[$a] = '<div class="form-group col-sm-2"><label for="'.$coluna[$a].'">'.$label[$a].'</label>';
            $guarda_html[$a] .= '\'.'.$pref.$combo.'.\'</div>';
            $guarda_tela[$a] = '<div class="form-group col-sm-2"><label for="'.$coluna[$a].'">'.$label[$a].'</label>';
            $guarda_tela[$a] .= '<input type="text" class="form-control"  name="'.$coluna[$a].'" id="'.$coluna[$a].'"  placeholder="Combo">'.$fecha.'</div>';
        } else {
            if (substr($vv[0], 0, 4) !== 'bool') {
                if (substr($tipo[$a], 0, 4) == 'text') {
                    $guarda_html[$a] =  '<div class="form-group col-sm-2">
                           <label for="'.$coluna[$a].'">'.$label[$a].'</label>
                           <textarea  cols="45" rows="3"  class="form-control" name="'.$coluna[$a].'" id="'.$coluna[$a].'" >\''.$val.'\'</textarea></div>';
                    $guarda_tela[$a] = $guarda_html[$a];
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
                    $guarda_html[$a] = '<div class="form-group col-sm-2">
                    <label for="'.$coluna[$a].'">'.$label[$a].'</label>
                     <input type="'.$type.'"  '.$xy.' class="form-control" name="'.$coluna[$a].'" id="'.$coluna[$a].'" value="\''.$val.'\'" >'.$fecha.'</div>';
                    $guarda_tela[$a] = $guarda_html[$a];
                }
            }
        }
        if (substr($vv[0], 0, 4) == 'bool') {
            $telax .= '            $'.$coluna[$a].'S = \'\'; $'.$coluna[$a].'N = \'\' ;
            if ('.$valx.' == 0) { $'.$coluna[$a].'S  = \'checked="true"\'; }   
            if ('.$valx.' == 1) { $'.$coluna[$a].'N = \'checked="true"\'; } '.PHP_EOL;
            $guarda_html[$a] = '<div class="form-group col-sm-2">
                        <label for="'.$coluna[$a].'">'.$label[$a].'</label>
                        <div class="form-check"> 
                          <input type="radio" class="form-check-input" name="'.$coluna[$a].'" id="'.$coluna[$a].'0" value="0" \'.$'.$coluna[$a].'S.\'> &nbsp;
                          <label class="form-check-label" for="'.$coluna[$a].'0">Sim</label>&nbsp;&nbsp;
                          <input type="radio" class="form-check-control-input" name="'.$coluna[$a].'" id="'.$coluna[$a].'1" value="1" \'.$'.$coluna[$a].'N.\'> &nbsp;
                          <label class="form-check-control-label" for="'.$coluna[$a].'">Não</label>
                       </div>
                    </div>';
             $guarda_tela[$a] = $guarda_html[$a];
            // TODO   booleano
        }
    }

//    $resp->alert(print_r($guarda_html, true));
//    return $resp;
    foreach ($guarda_html as $linha) {
        $tela .= $linha;
    }
    foreach ($guarda_tela as $linha) {
        $telaz .= $linha;
    }

    $texto = htmlentities($telax).PHP_EOL;
    $texto .= ' /* Aqui começa o código HTML com as variaáveis de tela */ '.PHP_EOL;
    $texto .= ' $tela = \''.htmlentities($tela).'\';';
    $rows  = ceil(strlen($texto) / 100);
    $telax = '<div class="col-sm-12" style="background-color: white;">
              <b>Texto para copia e colar no seu programa</b>    <button onclick="xajax_Copiar(); return false;">Copiar</button></div>
              </p><textarea id="texto" cols="100" rows="'.$rows.'">'.$texto.'</textarea>';
    $resp->assign("tela_principal", "innerHTML", '');
    $resp->assign("tela_show", "innerHTML", $telai.'<div class="row">'.$telaz.'</div>');
    $resp->assign("tela_copia", "innerHTML", $telax);
    return $resp;
}

function Copiar()
{
    $resp = new xajaxResponse;
    $resp->script('copiar();');
    return $resp;
}
