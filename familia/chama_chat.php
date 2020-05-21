<?php
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('default_charset','ISO-8859-1');
ini_set('display_errors', TRUE);
require_once 'classes/sessao.php';
$sessao    = new Session; 
// <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
//  xmlns="http://www.w3.org/1999/xhtml" lang="en">
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Chat online</title>
<meta name="description" content="Script for chat simple, online, made with php and javascript, ajax" />
<meta name="keywords" content="chat script, chat simple, chat online" />
<link rel="stylesheet" type="text/css" href="chatfiles/chatstyle.css" />
</head>
<body>
<?php include('chat.php'); ?>
</body>
</html>
