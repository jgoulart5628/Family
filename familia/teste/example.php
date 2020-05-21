<html>
<head>
</head>
<body>
<?php	
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT));
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('default_charset','ISO-8859-1');
ini_set('display_errors',"TRUE");
require_once '../classes/sessao.php';
$sessao    = new Session; 
$nome      = $sessao->get("login_nome");
require_once "class.Chat.php"; 
$chat = new Chat();
$chat->createChat($nome);
?>
</body>
</html>
