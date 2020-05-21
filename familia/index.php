<?php
/*
 * Prgrama principal de navegação dos dados
 */
Header("Cache-control: private, no-cache");
Header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set("memory_limit",-1);
ini_set('default_charset','UTF-8');
// Reports all errors
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
// error_reporting(E_ALL);
// Do not display errors for the end-users (security issue)
ini_set('display_errors','on');
// Set a logging file
ini_set('error_log','php_erro.log');
// Override the default error handler behavior
// ini_set('display_errors', true);
// $header = Header("Pragma: no-cache");
//error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
// error_reporting(E_ALL);
include("Pessoas_classe.php");
$pessoa = new Pessoa_model();
// var_dump($pessoa);
require_once 'classes/sessao.php';
$sessao    = new Session; 
include('classes/pega_meses_class.php');
include('Funcoes_auxiliares.php');
include('Dados_Pessoas.php');
include('Dados_Imagens.php');
include('Aniversarios.php');
include('Casamentos.php');
include('Falecimentos.php');
include('arvore.php');
include('Chat.php');
require_once("xajax/xajax_core/xajax.inc.php");
$xajax = new xajax();
// $xajax->configure('debug',true);
$xajax->register(XAJAX_FUNCTION,"Tela");
$xajax->register(XAJAX_FUNCTION,"Lista");
$xajax->register(XAJAX_FUNCTION,"Geral");
$xajax->register(XAJAX_FUNCTION,"Aniver");
$xajax->register(XAJAX_FUNCTION,"Home");
$xajax->register(XAJAX_FUNCTION,"Retorna");
$xajax->register(XAJAX_FUNCTION,"Retorna_desiste");
$xajax->register(XAJAX_FUNCTION,"Altera");
$xajax->register(XAJAX_FUNCTION,"Inclui");
$xajax->register(XAJAX_FUNCTION,"Login");
$xajax->register(XAJAX_FUNCTION,"Logout");
$xajax->register(XAJAX_FUNCTION,"Valida");
$xajax->register(XAJAX_FUNCTION,"Casamentos");
$xajax->register(XAJAX_FUNCTION,"Exclui_Casamento");
$xajax->register(XAJAX_FUNCTION,"Dados_Casamento");
$xajax->register(XAJAX_FUNCTION,"Gravar_Dados");
$xajax->register(XAJAX_FUNCTION,"Falecimento");
$xajax->register(XAJAX_FUNCTION,"Dados_Falecimento");
$xajax->register(XAJAX_FUNCTION,"Listar_Pessoas");
$xajax->register(XAJAX_FUNCTION,"Arvore");
$xajax->register(XAJAX_FUNCTION,"Album_Fotos");
$xajax->register(XAJAX_FUNCTION,"Tela_Album");
$xajax->register(XAJAX_FUNCTION,"Tela_Foto");
$xajax->register(XAJAX_FUNCTION,"CRUD_Album");
$xajax->register(XAJAX_FUNCTION,"CRUD_Imagens");
$xajax->register(XAJAX_FUNCTION,"Lista_Fotos_Album");
$xajax->register(XAJAX_FUNCTION,"Monta_Album");
$xajax->register(XAJAX_FUNCTION,"Chat");
$xajax->register(XAJAX_FUNCTION,"Atualiza_Chat");
$xajax->register(XAJAX_FUNCTION,"Update_Chat");
$xajax->configure('javascript URI','xajax/');
$xajax->processRequest();
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
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="DEAL Software">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Familia Goulart </title>

    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Our Website CSS Styles -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/familia.css">
    <script type="text/javaScript" src="js/jquery-1.11.1.min.js" ></script>
    <script type="text/javascript" src="js/jquery.magnifier.js"></script>
    <!--<script type="text/javascript" src="js/micoxUpload.js"></script -->
    <script type="text/javascript" src="js/familia.js"></script>
    <script type="text/javaScript" src="js/jquery.dataTables.min.js" ></script>
    <script type="text/javaScript" src="js/bootstrap.min.js" ></script> 
    <script type="text/javaScript" src="js/dataTables.bootstrap.js" ></script> 
    <script type="text/javascript">
    function tabela() {  
          $(document).ready(function() {
          $('#clicli').dataTable();
         } );
    }
    function inicia() {
       var tabela1 = new superTable("lista_chat", {
              colWidths : [40, 20, -1] });
    }
    function Saida(url){
        var form = document.createElement("form");
        form.setAttribute("action",url);
        form.setAttribute("method","GET");
        form.setAttribute("target","_blank");
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>
   <?php $xajax->printJavascript('xajax'); ?>
</head>
<body class="bg" style="padding-top: 1px;">
     <form id="tela"  name="tela" method="post"> 
      <div id="cabeca" class="transpar"></div>
      <div id="div_login"></div>
       <div id="div_arvore"></div>
       <div id="principal" class="mostrar" style="margin-left: 100px;"></div>
       <div id="consulta"  class="mostrar"></div>
       <div id="footer">
         <div class="texto">Para auxílio: <input type="button" onclick="window.location=\'mailto:joao_goulart@jgoulart.eti.br\'" value="Me Ajude!">
               &nbsp;&nbsp;&nbsp;&nbsp;<i>Familia Goulart:</i> Site de informações da Família</div>
        </div>    
     </form>   
     <script type="text/javaScript">xajax_Tela('') </script>
 </body>
</html>

<?php
function Tela($dados) {
    $resp = new xajaxResponse();
    $data_fim = date("d/m/Y");
//     echo $data_hoje.'-';
    $data_ini = date("d/m/Y");
    $h_inicio = date("G:i");
    global $sessao;
    global $pessoa;
//    var_dump($_COOKIE);
//                          , IFNULL((SELECT TIMESTAMPDIFF(HOUR,(addtime(DD_ABRE, concat(HORAS_SLA,':00'))), DD_FECHA)),0)) DIFER
    $query = " delete from sessao_login where ( TIMESTAMPDIFF(hour, data_sessao, now()) > 12) ";
    $pessoa->Sessao($query,$resp);
    if ($sessao->get("login_familia") !=1)   {  $resp->script("xajax_Login();"); return $resp; }
//    if (!isset($_COOKIE["Familia"])) { $resp->script('xajax_Logout()'); return $resp; } 
    $pessoa_id = $sessao->get("login_id");
    $nome      = $sessao->get("login_nome");
    $query =  " SELECT CONCAT(nome,' ', sobrenome,' ', sufixo) as nome, email, pessoa_id 
                             FROM pessoas  order by 1 ";

    $tela = '<nav class="navbar navbar-expand-lg navbar-static-top">
               <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div id="logo"><img src="images/goulart1.jpg" class="ca"><strong>Família Goulart&nbsp;'.date('d/m/y G:i').'</strong></div>
                     <ul class="nav navbar-nav ml-auto">
                       <li class="nav-item">
                           <a  class="nav-link" onclick="xajax_Home(); return false;"><img class="img" src="images/casa.png"><br><font class="tit">Início</font></a>
                      </li>
                      <li class="nav-item">
                         <a class="nav-link" onclick="xajax_Inclui(); return false;">
                         <img class="img" src="images/clientes.png"><br><font class="tit">Incluir</font></a>
                      </li>
                      <li class="nav-item" style="vertical-align: top;">
                       <a class="nav-link"><div>'.lista_pessoas($query,$resp).'</div></a>
                      </li>
                      <li class="nav-item">
                        <a  class="nav-link" onclick="xajax_Listar_Pessoas();"><img class="img" src="images/text-xml.png"><br><font class="tit">Lista</font></a>
                      </li class="nav-item">
                      <li class="nav-item">
                        <a  class="nav-link" onclick="xajax_Album_Fotos()"><img class="img" src="images/Album.png"><br><font class="tit">Albuns</font></a>
                     </li>
                       <li class="nav-item" style="float: right;">
                        <a class="nav-link" onclick="xajax_Logout(); return false;"><img class="img" src="images/exit1.png"><br><font class="tit">Sair</font></a>
                      </li class="nav-item">
                      <li class="nav-item" style="float: right;">
                       <a class="nav-link"><img class="img" src="images/lock.png"><br><font class="tit">Olá '.$nome.'</font></a>
                     </li>
                  </ul>                    
               </div>                   
              </nav>';
    $resp->assign("consulta","innerHTML", '');
    $resp->assign("cabeca","innerHTML", $tela);
//     $resp->addScript("jQuery(famx).imageMagnify({ magnifyby: 3 })");
//    $script = "document.getElementById('inputString').focus()";
//    $resp->script($script);
    $resp->script('xajax_Geral("")');
    return $resp;
}


function Login()  {
    $resp = new xajaxResponse();
    global $sessao;
    global $pessoa;
    $sessao->set("login_familia",0);
    $sessao->set("login_id",'');
    $sessao->set("login_nome",'');
    setcookie ("Familia", "", time() - 7200);
    $res = $pessoa->Busca_login($resp);
    if (!$res) { $resp->alert("Aqui ".print_r($res,true)); return $resp; }
    $telax = '<select name="pessoa_id" class="form-control">
                   <option selected value="eu" selected ></option>';
     foreach ($res as $pes)  {
          $telax .= '<option  value="'.$pes['pessoa_id'].'-'.$pes['nome'].'">'.$pes['nome'].'</option>';
       } 
     $telax .= '</select>';
     $tela = '<div class="modal-dialog modal-login ">
                <div class="modal-content transpar">
                   <div class="modal-header">       
                     <h4 class="modal-title">Login</h4>
                   </div>
                  <div class="modal-body">
                    <div class="form-group">
                        <i class="fa fa-user"></i>
                        '.$telax.'
                    </div>
                    <div class="form-group">
                     <i class="fa fa-lock"></i>
                     <input type="password" name="passwd" class="form-control" placeholder="Senha" required>
                     <b>Senha : ddmmaa de seu nascimento. </div>
                    <div class="form-group">
                     <input type="submit" class="btn btn-primary btn-block btn-lg" value="Entrar" onclick="xajax_Valida(xajax.getFormValues(\'tela\')); return false;">
                    </div>
                 </div>
                </div>
              </div>';
    $resp->assign("div_login","innerHTML", $tela); 
   return $resp;
}

function Valida($dados)  {
    $resp = new xajaxResponse();
    global $pessoa;
    global $sessao;
    $pess = explode('-',$dados['pessoa_id']);
    $pessoa_id = $pess[0];
    $nome        = $pess[1];
    $passwd     = strtolower($dados['passwd']);
    if ($pessoa_id === 'eu') { $resp->alert(" Escolha uma pessoa para autenticar"); return $resp; }    
    $dtnas = $pessoa->Data_Nasc($pessoa_id, $resp);
    $dd = date('dmy',strtotime($dtnas));
    if (!$passwd)    { $resp->alert(" Preencha a senha! "); return $resp; }    
    $cfg = parse_ini_file('familia.ini',TRUE);
    $senha   = $cfg['SEGURO']['passwd'];
    if ($passwd == $dd || $passwd == $senha || $passwd  == 'jogola01')  {
       $pass = true; }  else { $resp->alert(" Senha incorreta! "); return $resp; } 
    $sessao->nova();
    setcookie("Familia", $pessoa_id, date(), time()+(60*60*24*30) );  /* expira em 10 horas */    
//    $resp->alert('Aqui '); return $resp; 
    $sessao->set("login_familia",1);
    $sessao->set("login_id",$pessoa_id);
    $sessao->set("login_nome",$nome);
    $id          = session_id();
    $sessao->set("sessao",$id);
    $pessoa_id =  $sessao->get("login_id");
    $query = " delete from sessao_login where pessoa_id = $pessoa_id  ";
    $pessoa->Sessao($query);
    $query = " insert into sessao_login VALUES ($pessoa_id, '$id', CURRENT_TIMESTAMP) ";
    $sai = $pessoa->Sessao($query);
//    if ($pessoa_id !== 2)  {
//        $query = " insert into visitas VALUES ($pessoa_id, CURRENT_TIMESTAMP) ";
//        $sai = $pessoa->Sessao($query);
//    }    
//    $resp->redirect($_SERVER['PHP_SELF']);
    $resp->assign('div_login',"innerHTML","");
    $resp->script('xajax_Tela("")');
    return $resp;
}

function Logout() {
   $resp = new xajaxResponse();
   global $sessao;
   global $pessoa;
   $pessoa_id =  $sessao->get("login_id");
   $sessao->set("login_familia",0);
   session_destroy();
//   if ($unico)  {
   if ($pessoa_id)  {
      $pessoa->Sessao(" delete from sessao_login where pessoa_id = $pessoa_id ");
   }   
   $resp->redirect($_SERVER['PHP_SELF']);
   return $resp;
}
