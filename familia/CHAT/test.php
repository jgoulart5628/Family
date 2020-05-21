<?php if(!isset($_SESSION)) session_start(); ?>
define('CHATADD', 1);
if(CHATADD !== 1) {
    if(isset($_SESSION['username'])) define('CHATUSER', $_SESSION['username']);
}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
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
