<?php
/*
 * Prgrama principal de navegação dos dados
 */
Header("Cache-control: private, no-cache");
Header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
Header("Pragma: no-cache");
// error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT));
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('default_charset','ISO-8859-1');
ini_set('display_errors', TRUE);
require_once 'classes/sessao.php';
$sessao    = new Session; 
require_once("Pessoas_classe.php");
$pessoa = new Pessoa_model();
include('classes/pega_meses_class.php');
include('Navega.php');
include('Login.php');
include('Funcoes_auxiliares.php');
include('Dados_Pessoas.php');
include('Dados_Imagens.php');
include('Aniversarios.php');
include('Casamentos.php');
include('Falecimentos.php');
include('arvore.php');
if(!function_exists("freichatx_get_hash")){
    function freichatx_get_hash($ses) {
    if(is_file("freichat/hardcode.php")){
      require "freichat/hardcode.php";
      $temp_id =  $ses . $uid;
      return md5($temp_id);
    }  else  {  echo "<script>alert('module freichatx says: hardcode.php file not found!');</script>";  }
    return 0;
  }
}
if ($sessao->get("login_familia") === 1)  { 
    $ses = $sessao->get("login_id");  //tell freichat the userid of the current user
    setcookie("freichat_user", "LOGGED_IN", time()+3600, "/"); // *do not change -> freichat code
} else {
    $ses = null; //tell freichat that the current user is a guest
    setcookie("freichat_user", null, time()+3600, "/"); // *do not change -> freichat code
} 

require_once("xajax05/xajax_core/xajax.inc.php");
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
$xajax->configure('javascript URI','../xajax05/');
$xajax->registerFunction("Tela");
$xajax->registerFunction("Lista");
$xajax->registerFunction("Geral");
$xajax->registerFunction("Aniver");
$xajax->registerFunction("Home");
$xajax->registerFunction("Retorna");
$xajax->registerFunction("Retorna_desiste");
$xajax->registerFunction("Altera");
$xajax->registerFunction("Inclui");
$xajax->registerFunction("Login");
$xajax->registerFunction("Logout");
$xajax->registerFunction("Valida");
$xajax->registerFunction("Casamentos");
$xajax->registerFunction("Exclui_Casamento");
$xajax->registerFunction("Dados_Casamento");
$xajax->registerFunction("Gravar_Dados");
$xajax->registerFunction("Falecimento");
$xajax->registerFunction("Dados_Falecimento");
$xajax->registerFunction("Listar_Pessoas");
$xajax->registerFunction("Arvore");
$xajax->registerFunction("Album_Fotos");
$xajax->registerFunction("Tela_Album");
$xajax->registerFunction("Tela_Foto");
$xajax->registerFunction("CRUD_Album");
$xajax->registerFunction("CRUD_Imagens");
$xajax->registerFunction("Lista_Fotos_Album");
$xajax->registerFunction("Monta_Album");
$xajax->configure('decodeUTF8Input',true);
// $xajax->configure('debug',true);
$xajax->processRequest();
//   App ID2: 616457815101504  facebook id
// 2354dc6f4f59eb0abebc88d5a2483099 senha usuario
//<script src="//www.parsecdn.com/js/parse-1.2.18.min.js"></script>
//<script type="text/javascript">function Parsa() {
//         Parse.initialize("M8M9Nz1Hm3rGQLLIDXcDW4ZvpA0geN9Esj1wmK9X",
//                          "FrJ2wloQsXXcCXogDY9MGWSDydgHfaAqgHHITmb9"); }</script>   
//
?>

<html>
<head>
<title> Família Goulart </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="http://localhost/familia/freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
<link href="css/familia.css" rel="stylesheet" type="text/css"></style>
<link rel="stylesheet" href="freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
<script type="text/javascript" language="javascipt" src="freichat/client/main.php?id=<?php echo $ses;?>&xhash=<?php echo freichatx_get_hash($ses); ?>"></script>
<script type="text/javascript" src="js/sorttable.js"></script>
<script type="text/javascript" src="js/jquery-1.2.1.pack.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.magnifier.js"></script>
<script type="text/javascript" src="js/familia.js"></script>
<script type="text/javascript" src="js/micoxUpload.js"></script>
<script type="text/javascript">
    function sorta()  {
        sorttable.makeSortable(table);
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
<?php $xajax->printJavascript('xajax05'); ?>
</head>
<body>
     <script type="text/javaScript">xajax_Tela('') </script>
     <form id="tela" name="tela" method="POST">
       <div id="cabeca"></div>
       <div id="div_login"></div>
       <div id="div_arvore"></div>
       <div id="principal" class="mostrar"></div>
       <div id="consulta"  class="mostrar"></div>
       <div id="footer">
           <div class="texto">Para auxílio: <input type="button" onclick="window.location=\'mailto:goulart.joao@gmail.com\'" value="Me Ajude!">
               &nbsp;&nbsp;&nbsp;&nbsp;<i>Familia Goulart:</i> Site de informações da Família</div>
           <a style="float: right;" href="http://www.000webhost.com/" target="_blank"><img src="http://www.000webhost.com/images/80x15_powered.gif" alt="Web Hosting" width="80" height="15" border="0" /></a>
       </div>
       <iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="js/ipopeng.htm" scrolling="no" frameborder="0"
          style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
     </form>
   </body>
</html>
