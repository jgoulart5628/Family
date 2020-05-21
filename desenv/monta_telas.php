<?php
// cadastro e manutenção de Pessoas
//error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT));
error_reporting(E_ALL & ~(E_NOTICE));
ini_set('log_errors', 1);
error_log("php_errors.log");
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('default_charset', 'UTF-8');
include('../autoload.php');
$db = new acesso_db('MYSQL_deal');

require_once("../xajax/xajax_core/xajax.inc.php");
$xajax = new xajax();
// $xajax->configure('debug',true);
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error_log.log');
$xajax->register(XAJAX_FUNCTION, "Tela");
$xajax->register(XAJAX_FUNCTION, "Gera_tela");
$xajax->register(XAJAX_FUNCTION, "Copiar");
$xajax->processRequest();
$xajax->configure('javascript URI', '../xajax/');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
    <!-- Meta-Information -->
    <title> Gerar  HTML Forms </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="DEAL Software">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/typeahead.css">
    <link rel="stylesheet" href="../css/main.css">
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script type="text/javaScript" src="../js/bootstrap.min.js" ></script> 
    <script type="text/javascript" src="../js/typeahead.js"></script>
    <script type="text/javascript">
    function busca_tabela()  {
        $('#tabela').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "pesq_tabela.php",
          data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
            result($.map(data, function (item) {
              return item;
                        }));
                    }
                });
            }
        });
    };
    function copiar() {
      var copyText = document.getElementById("texto");
          copyText.select();
          document.execCommand("copy");
          alert("texto copiado. " + copyText.value);
    }
    </script> 
    <?php $xajax->printJavascript('../xajax'); ?>
</head>

<body style="padding-top: 10px;">
   <form id="dados_tela" name="dados_tela" role="form" method="post">
     <div class="container-fluid   fundo" style="width: 99%;" >  
         <div id="tela_sel" class="col-sm-12" align="center"></div> 
         <div class="col-sm-12" style="background-color: white;"><b>Tela visualização básica</b></div>
         <div id="tela_manut" class="col-sm-12" align="center"></div> 
         <div class="col-sm-12" style="background-color: cyan;"><b>Texto para copia e colar no seu programa</b></div>
         <div id="tela_texto" class="col-sm-12" style="background-color: silver;" align="center"></div> 
         <hr>
         <div class="footer">
            <span class="glyphicon glyphicon-thumbs-up"></span>&#174; DealSw Web
        </div>
     </div>   
   </form>
   <script type="text/javaScript">xajax_Tela() </script>
</body>
</html>
<?php
function Tela()
{
    $resp = new xajaxResponse();
    $tela = '<div class="row" style="background-color: grey;">
             <div class="form-group col-sm-12">  
              <div class="col-sm-3">
                  <b>Nome Tabela :</b><input type="text" class="typeahead form-control" name="tabela" id="tabela" value="" placeholder="Escolha a Tabela">
              </div>    
              <div class="col-sm-1">
                  <button type="submit" class="btn btn-primary" style="margin-top: 20px;" onclick="xajax_Gera_tela(xajax.getFormValues(\'dados_tela\')); return false;">Confirma</button>
             </div>
            </div> 
            </div><div class="row" style="background-color: grey;">&nbsp;</div>';
    $resp->assign("tela_sel", "innerHTML", $tela);
    $resp->script('busca_tabela();');
    return $resp;
}
 
function Gera_tela($dados)
{
    $resp = new xajaxResponse();
//   $resp->alert('Aqui . '.print_r($dados,true)); return $resp;
    $tabel  =  $dados['tabela'];
    $tabs =  explode('-', $tabel);
    $tabela = strtolower($tabs[0]);
 //  $resp->alert('Aqui . '.print_r($dados,true)); return $resp;
    if (!$tabela) {
        $resp->alert(' Informe uma tabela!');
        return $resp;
    }
    global $db;
    $query  = " select * from adm_colunas where tabela =  '$tabela' ;";
    $res    =  $db->Executa_Query_Array($query, $resp);
//   $resp->alert('Aqui . '.print_r($res,true)); return $resp;
    if (count($res) == 0) {
        $resp->alert(' A tabela '.$tabela.' não existe!');
        return $resp;
    }
    foreach ($res as $tab) {
        $coluna[]   .= $tab['coluna'];
        if (!$tab['label']) {
            $tab['label'] =  ucfirst($tab['coluna']);
        }
        $label[]    .= $tab['label'];
        $tipo[]     .= $tab['tipo'];
        $valida[]   .= $tab['valida'];
    }
//      $telax = '<table>';
//      for ($a = 0; $a < count($coluna); $a++)  {
//          $telax .= '<tr><td>$'.$coluna[$a].' = $dados_pessoa[\''.$coluna[$a].'\'];</td></tr>';
//      }
//      $telax .='</table>';
//      $tela  = '$tela .= \'';
      $tela  = '';
      $telax = '';
    for ($a = 0; $a < count($coluna); $a++) {
        if (substr($coluna[$a], 0, 1) === 'x') {
            $rd = '$rd';
        }
        if ($a === 0 || fmod($b, 3) === 0) {
            $tela .= '<div class="row"><div class="col-sm-12">';
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
    $telax = '<button onclick="xajax_Copiar(); return false;">Copiar</button></p><textarea id="texto" cols="100" rows="'.$rows.'">'.$texto.'</textarea>';
    $telaz = str_replace("'.combo", '<input type="text" class="form-control" name="combo">combo', $tela);
    $resp->assign("tela_manut", "innerHTML", $telaz);
    $resp->assign("tela_texto", "innerHTML", $telax);
    return $resp;
}

function Copiar()
{
    $resp = new xajaxResponse;
    $resp->script('copiar();');
    return $resp;
}