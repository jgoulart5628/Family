<?php
ini_set("memory_limit","512M");
ini_set('display_errors', true);
if (!isset($_GET['name'])) { $arq = "ARQUIVO"; } else { $arq = $_GET['name']; }
if (file_exists($arq)) { unlink($arq); }
$imagem_carga = $_FILES['imagem_carga']['tmp_name'];
$imagem_tipo  = $_FILES['imagem_carga']['type'];
if (is_file($imagem_carga)) { rename($imagem_carga, $arq); }
else { echo $arq.'-'.$imagem_carga.'-'.$imagem_tipo; 
       print_r($_FILES);
}