<?php
/*
 * Prgrama principal de navegação dos dados
 */
Header("Cache-control: private, no-cache");
Header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set("memory_limit",-1);
ini_set('default_charset','UTF-8');
ini_set('display_errors','on');
ini_set('error_log','php_erro.log');
// Reports all errors
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
// error_reporting(E_ALL);
define('ROOT', dirname(__DIR__) ); 
define('DS', DIRECTORY_SEPARATOR);
include('autoload.php');
$sessao    = new Sessao; 
$pessoa     = new Pessoas();
// var_dump($pessoa);
// include('Funcoes_auxiliares.php');
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
$xajax->configure( 'errorHandler', true );
$xajax->configure( 'logFile', 'xajax_error.log' );  
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
//    <script type="text/javaScript" src="js/jquery-1.11.1.min.js" ></script>
//    <script type="text/javascript" src="js/jquery.magnifier.js"></script>
//    <!--<script type="text/javascript" src="js/micoxUpload.js"></script -->
//    <script type="text/javascript" src="js/familia.js"></script>
//    <script type="text/javaScript" src="js/jquery.dataTables.min.js" ></script>
//    <script type="text/javaScript" src="js/bootstrap.min.js" ></script> 
//    <script type="text/javaScript" src="js/dataTables.bootstrap.js" ></script> 

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="JGWeb Software">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Familia Goulart </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/grid_familia.css">
    <link rel="stylesheet" href="css/familia-form.css">
    <link rel="stylesheet" href="css/Navigation-with-Search.css">
    <link rel="stylesheet" href="css/styles.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.magnifier.js"></script>
    <!-- Our Website CSS Styles -->
    <script type="text/javascript">
    function tabela() {  
        $('#tabclas').dataTable( 
           { "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "Todos"]], 
             "language":  ["json/Portuguese-Brasil.json"] 
           }          
         );
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
    <h1 class="text-center text-white d-none d-lg-block"><span class="site-heading-lower">Família Goulart</span></h1>
    <nav class="navbar navbar-light navbar-expand-lg bg-dark py-lg-2" style="text-transform: none;" id="mainNav">                    
     <div id="cabeca" class="container"></div>
    </nav>
    <section class="page-section clearfix">
        <div id="div_login"></div>
        <div id="div_arvore"></div>
        <div id="principal" class="mostrar" style="margin-left: 100px;"></div>
        <div class="familia-clean">
           <div id="consulta"  class="esconder"></div>
        </div>   
      </section>  
      <footer class="footer text-faded text-center py-3">
        <div class="container">
            <div class="texto">Para auxílio: <input type="button" onclick="window.location=\'mailto:joao_goulart@jgoulart.eti.br\'" value="Me Ajude!">
               &nbsp;&nbsp;&nbsp;&nbsp;<i>Familia Goulart:</i> Site de informações da Família</div>
         </div>
      </footer>      
     </form>   
     <script type="text/javaScript" src="js/bootstrap.bundle.min.js"></script>
     <script type="text/javaScript" src="js/jquery.dataTables.min.js" ></script>
     <script type="text/javaScript" src="js/dataTables.bootstrap4.min.js" ></script>
     <script type="text/javaScript">xajax_Tela() </script>
 </body>
</html>

<?php
function Tela() {
    $resp = new xajaxResponse();
    $data_fim = date("d/m/Y");
//     echo $data_hoje.'-';
    $data_ini = date("d/m/Y");
    $h_inicio = date("G:i");
    global $sessao;
    global $pessoa;
//    var_dump($_COOKIE);
    $query = " delete from sessao_login where ( TIMESTAMPDIFF(hour, data_sessao, now()) > 12) ";
    $pessoa->Sessao($query,$resp);
    if ($sessao->get("login_familia") !=1)   {  $resp->script("xajax_Login();"); return $resp; }
//    if (!isset($_COOKIE["Familia"])) { $resp->script('xajax_Logout()'); return $resp; } 
    $pessoa_id = $sessao->get("login_id");
    $nome      = $sessao->get("login_nome");
    $res       = $pessoa->Busca_Logados($resp);
  //  $resp->alert('Aqui - '.print_r($res,true)); return $resp;
    if (count($res) == 0) { 
        $resp->script("xajax_Home();");
        $sessao->set("login_familia",0);
        $sessao->set("login_id",'');
        $sessao->set("login_nome",'');
        $resp->script('xajax_Home()');
        return $resp;
    }
    $ip = $_SERVER["REMOTE_ADDR"];
    /*
                    <div id="Logins" class="tit1">Pessoas conectadas: <a href="#"><input type="image" src="img/chat2.png" width="32" heigth="32" onclick="xajax_Chat(xajax.getFormValues(\'tela\')); return false;">
                      <span>Vamos conversar?</span></a><br>';
                    for ($i=0; $i < count($res); $i++) {
                        $pessoa_id = $res[$i]['pessoa_id'];        
                        $nome      = $res[$i]['nome'];        
                        $tela .= '<input type="button" style="width: 200px" onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$pessoa_id.'\'); return false;" value="'.$nome.'"><br>';
                    }
                    $tela .= '</div><div id="div_conversa"></div><div id="div_chats"></div>';    
                    $tela .= '<p>Seu IP: '.$_SERVER["REMOTE_ADDR"].'</div></div>
*/

    $tela = ' <div  class="collapse navbar-collapse" id="navbarResponsive">
                    <a class="navbar-brand"><i class="fa fa-user"></i><font class="tit">&nbsp;Olá </font></a>
                    <input type="button" style="width: 200px"  value="'.$nome.'">
                    <a class="navbar-brand" href="#">'.date("d/m/y G:i").'</a>
                    <button data-toggle="collapse" data-target="#navbarResponsive" class="navbar-toggler" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Muda Navegação"><span class="navbar-toggler-icon"></span></button>
                    <ul class="nav navbar-nav mx-auto">
                      <li class="nav-item" role="presentation">
                       <a  class="nav-link" onclick="xajax_Home(); return false;" href="#"><img class="img" src="img/casa.png"><br><font class="tit">Início</font></a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a  class="nav-link" onclick="xajax_Listar_Pessoas();" href="#"><img class="img" src="img/clientes.png"><br><font class="tit">Cadastro Pessoas</font></a>
                      </li class="nav-item" role="presentation">
                      <li class="nav-item">
                        <a  class="nav-link" onclick="xajax_Album_Fotos()" href="#"><img class="img" src="img/Album.png"><br><font class="tit">Albuns</font></a>
                     </li>
                     <li class="nav-item" role="presentation" style="float: right;">
                        <a class="nav-link" onclick="xajax_Logout(); return false;" href="#"><img class="img" src="img/exit1.png"><br><font class="tit">Sair</font></a>
                      </li>  
                  </ul>   
                    <p class="navbar-brand"><i class="fas fa-comments"></i><font class="tit">&nbsp;Seu IP: '.$_SERVER["REMOTE_ADDR"].'</font>
                </div>';
 //          <li class="nav-item" style="vertical-align: top;">
 //                      <a class="nav-link"><div>'.lista_pessoas($query,$resp).'</div></a>
 //                     </li>
 
    $resp->assign("consulta","innerHTML", '');
    $resp->assign("cabeca","innerHTML", $tela);
    $resp->script('xajax_Geral()');
    return $resp;
}

function Inclui() {
    $resp = new xajaxResponse();
    $resp->alert('Incluir?'); 
    return $resp;
}

function Geral() {
    $resp = new xajaxResponse();
    $mes  = date('m');
    global $pessoa;
    global $sessao;
    $ano = date('Y');
//    $resp->alert('Aqui '); return $resp;


    $tela = '<form name="principal" method="post">
             <div class="container" id="pagina" style="display: block;">
              <div  class="intro" style="float: left;">
               <div id="sobre" class="rounded bg-faded">
                  <h5>Suposta origem do nome "GOULART"</h5>
                  <p>"Ao contrário do que a sonoridade francesa do sobrenome GOULART pode surgerir, a família, na verdade, é de origem holandesa.
                     O nome original veio de um colono holandês,JOZ GOUILWARD, que fez parte da comitiva de um dos três donatários dos Açores,
                     a saber: WILLEN VAN DER HAAGEN (Ilha Terceira, JOZ VAN HUESTER (Ilha do Pico) e JOZ VAN AERTRICJCKE (Ilha do Faial).
                     O nome original GOUILWARD transformou-se ao longo do tempo em GALARD(E), GOLART(E),GOULART(E) e GULARTE".
                  </p>   
               </div>
               <div id="left">
                <img class="img-fluid mb-3 mb-lg-0 rounded" src="img/famx.jpg" id="famx" class="magnify" alt="A turma toda" height="309" width="314"><cite>Os Goulart, em Janeiro de 1975.(!)</cite>
              </div>
             </div>   
            </div>  
            <div id="right">
               <div id="aniver">'.mostra_aniver($mes,$ano,$resp).'</div>
           </div>
           </form>';
    $resp->assign("principal","className","mostrar"); 
    $resp->assign("principal","innerHTML",$tela); 
    $resp->script("jQuery(famx).imageMagnify({ magnifyby: 3 })");
    return $resp;
}


function combo_meses($mes)  {
    $meses   =   array('01','02','03','04','05','06','07','08','09','10','11','12');
    $mes_ext   =   array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
    if (!$mes) { $mesatu  =   date('m');  } else { $mesatu = $mes; } 
    $ret .= ' <select class="entra" name="mes" id="mes" onchange="xajax_Aniver(xajax.getFormValues(\'principal\')); return false;"> 
                     <option value ="" class="f_texto" ></option> ';
     for ($i=0; $i < count($meses); $i++) { 
         if ($mesatu == $meses[$i])  {  $sel = ' selected '; } else { $sel = ''; }
         $ret .= '<option value="'.$meses[$i].'" '.$sel.' class="f_texto"> '.$mes_ext[$i].' </option> ';
    }
    $ret .= '</select>';
   return $ret;   
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
                   <option hidden value="eu">Clique para escolher</option>';
     foreach ($res as $pes)  {
          $telax .= '<option  value="'.$pes['pessoa_id'].'-'.$pes['nome'].'">'.$pes['nome'].'</option>';
       } 
     $telax .= '</select>';
     $tela = '<form name="formLogin" id="formLogin" methos="post">
               <div class="modal-dialog modal-login">
               <div class="modal-content">
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
                     <b>Senha : ddmmaa de seu nascimento.</b> 
                   </div>  
                   <div class="form-group">
                   <button type="submit"  class="btn btn-primary btn-block btn-lg" onclick="xajax_Valida(xajax.getFormValues(\'formLogin\')); return  false;">Entrar</button>
                   </div>  
                 </div>
                </div>
              </div>
            </form>';
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

function Aniver($dados, $mes='')  {
      $resp = new xajaxResponse();
      $mes = $dados['mes'];
      if (!$mes) $mes = date('m');
      $ano = date('Y');
      $tela = mostra_aniver($mes,$ano, $resp);
      $resp->assign("aniver","innerHTML",$tela);
      return $resp;
}

function mostra_aniver($mes,$ano, $resp)  {
    global $pessoa;
    $res = $pessoa->Busca_Birth($mes, $resp);
    $tela  = '<b>Aniversários do mes :  </b>'.combo_meses($mes).'</br>
              <table class="table table-striped table-bordered">';
    if ($res)  {
       $tela .= '<thead>
                      <tr align="Center">
                      <th> Nome </th>
                      <th> Nascimento </th>
                      <th> Idade </th>
                   </tr>
                </thead>
             <tbody>';
       $a = 0;
       foreach ($res as $pes)  {
         if ($a == 0 || fmod($a, 2) == 0) $classe =  'class="t_line1"'; else $classe =  'class="t_line2"';
          $data_nas =  date("d/m/Y",strtotime($pes['data_nascimento']));
          $pessoa_id =  $pes['pessoa_id'];
          $nome       =  $pes['nome'];
          $mes1      =  $pes['mes'];
          $dia         =  $pes['dia'];
          $idade     =  ($ano.'-'.$mes1.'-'.$dia) - ($pes['data_nascimento']);
          $tela .= '<tr '.$classe.'>
                      <td align="left"><a href="#"  onclick="xajax_Altera(xajax.getFormValues(\'principal\'),\''.$pessoa_id.'\'); return false;">' .$nome.'</a></td>
                      <td align="center">'.$data_nas.'</td>
                      <td align="center">'.$idade.'</td>
                    </tr>';
          $a++; 
       } 
       $tela .= '</tbody>';
       
    }
// casamentos
    $res = $pessoa->Busca_Marriage($mes, $resp);
    if ($res)  {
       $tela .= '<thead>
                      <tr align="Center">
                      <th> Casal </th>
                      <th> Casamento </th>
                      <th> Anos </th>
                   </tr>
                </thead>
             <tbody>';
       $a = 0;
       foreach ($res as $pes)  {
         if ($a == 0 || fmod($a, 2) == 0) $classe =  'class="t_line1"'; else $classe =  'class="t_line2"';
          $data_cas =  date("d/m/Y",strtotime($pes['data_casamento']));
          $marido   = $pes['marido'];
          $marido_id  = $pes['marido_id'];
          $esposa   = $pes['esposa'];
          $esposa_id   = $pes['esposa_id'];
          $mes1      =  $pes['mes'];
          $dia         =  $pes['dia'];
          $idade     =  ($ano.'-'.$mes1.'-'.$dia) - ($pes['data_casamento']);
          $tela .= '<tr '.$classe.'>
                      <td align="left"><a href="#"  onclick="xajax_Altera(xajax.getFormValues(\'principal\'),\''.$marido_id.'\'); return false;">' .$marido.'</a><br>
                          <a href="#"  onclick="xajax_Altera(xajax.getFormValues(\'principal\'),\''.$esposa_id.'\'); return false;">' .$esposa.'</a></td>
                      <td align="center">'.$data_cas.'</td>
                      <td align="center">'.$idade.'</td>
                    </tr>';
          $a++; 
       } 
       $tela .= '</tbody>';
    }
    $res = $pessoa->Busca_Death($mes, $resp);
    if ($res)  {
       $tela .= '<thead>
                      <tr align="Center">
                      <th> Nome </th>
                      <th> Falecimento </th>
                      <th> Anos </th>
                   </tr>
                </thead>
             <tbody>';
       $a = 0;
       foreach ($res as $pes)  {
         if ($a == 0 || fmod($a, 2) == 0) $classe =  'class="t_line1"'; else $classe =  'class="t_line2"';
          $data_fal =  date("d/m/Y",strtotime($pes['data_falecimento']));
          $pessoa_id =  $pes['pessoa_id'];
          $nome       =  $pes['nome'];
          $mes1      =  $pes['mes'];
          $dia         =  $pes['dia'];
          $dif         = abs(strtotime(date('Y-m-d')) - strtotime($pes['data_falecimento']));
          $anos      = floor($dif / (365*60*60*24));
          $meses    = floor(($dif - $anos * 365*60*60*24) / (30*60*60*24));
          $dias       = floor(($dif - $anos * 365*60*60*24 - $meses*30*60*60*24)/ (60*60*24));
//          $idade    = printf("%d anos, %d meses, %d dias", $anos, $meses, $dias);
//          $idade     =  ($ano.'-'.$mes1.'-'.$dia) - ($pes['data_falecimento']);
          $tela .= '<tr '.$classe.'>
                      <td align="left"><a href="#"  onclick="xajax_Altera(xajax.getFormValues(\'principal\'),\''.$pessoa_id.'\'); return false;">' .$nome.'</a></td>
                      <td align="center">'.$data_fal.'</td>
                      <td align="center">'.$anos.'</td>
                    </tr>';
          $a++; 
       } 
       $tela .= '</tbody>';
    }
    $tela .= '</table>';   
    return $tela;    
}

function Listar_Pessoas()  {
    $resp = new xajaxResponse();
    global $pessoa;
    $resul = $pessoa->Browse($resp);
    if (is_array($resul))  {
       $tela  = '<id class="familia-clean"><table id="tabclas" data-toggle="table" class="table table-striped table-bordered"  data-sort-name="Tabela" data-sort-order="desc" />
                    <caption> Pessoas Cadastradas : '.count($resul).'<button type="submit" class="btn btn-primary" onclick="xajax_Retorna_desiste();" style="float: right;">Fechar</button></caption>
                   <thead> 
                    <tr align="Center">
                      <th data-field="nome" data-sortable="true"> Nome</th>
                      <th data-field="data_nasc"   data-sortable="true"> Data Nasc. </th>
                      <th data-field="local_nasc"    data-sortable="true"> Local Nasc.</th>
                      <th data-field="email"      data-sortable="true"> Email </th>
                   </tr></thead>';
      $a = 0; 
      foreach ($resul as $pes)  {
         $pessoa_id = $pes['pessoa_id']; 
         $tela .= '<tr>
                   <td data-field="nome" data-sortable="true" style="text-align: left;" nowrap><input type="image" width="20" height="20" style="border: 2px outset;vertical-align: top;" src="img/icono_buscar.png" onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$pessoa_id.'\'); return false;">&nbsp;&nbsp;'.$pes['nome'].'</td>
                   <td data-field="data_nasc"  data-sortable="true" style="text-align: center;">'.date('d/m/Y',strtotime($pes['data_nascimento'])).'&nbsp;</td>
                   <td data-field="local_nasc" data-sortable="true" style="text-align: left;">'.$pes['local_nascimento'].'&nbsp;</td>
                   <td data-field="email"  data-sortable="true" style="text-align: left;">'.$pes['email'].'&nbsp;</td>
                  </tr>';
         $a++;
      }   
      $tela .= '<tr></tr></table></id>'; 
 }
     $resp->assign("div_arvore","innerHTML",''); 
     $resp->assign("principal","className","esconder"); 
     $resp->assign("consulta","className","mostrar"); 
     $resp->assign("consulta","innerHTML",$tela); 
     $resp->script('tabela()');
 return $resp;
}



function Home() {
    $resp = new xajaxResponse();
    $resp->redirect($_SERVER['PHP_SELF']); 
    Return $resp;
}

function Retorna() {
    $resp = new xajaxResponse();
    $resp->assign("div_arvore","innerHTML",'');
    $resp->assign("consulta","className","mostrar");
    Return $resp;
}

function Retorna_desiste() {
    $resp = new xajaxResponse();
    $resp->assign("consulta","className","esconder");
    $resp->assign("principal","className","mostrar");
    Return $resp;
}
