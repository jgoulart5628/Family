<?php
require_once("Chat_classe.php");
$cht = new Chat_model();
function Chat()  {
    $resp = new xajaxResponse();
    global $cht;
    global $sessao;
    $tela = '<textarea name="chat_entra" class="entra" cols="50" lines="3"></textarea>
             <input type="button" value="Enviar" onclick="xajax_Atualiza_Chat(xajax.getFormValues(\'tela\')); return false;">';
    $resp->assign("div_conversa","innerHTML",$tela); 
    $ultimo = $cht->SQL(" SELECT max(data) FROM chat ",'unico',$resp);
    $sessao->set("ultimo",$ultimo);
    $tela = $cht->Browse($resp);    
    $resp->assign("div_chats","innerHTML",$tela); 
    $script = 'setInterval("xajax_Update_Chat()", 5000)';
    $resp->script($script);
//    $resp->script("inicia()");
    return $resp;
}
function Atualiza_Chat($dados)  {
    $resp = new xajaxResponse();
    global $cht;
    global $sessao;
    $pessoa_id = $sessao->get("login_id");
    $nome      = $sessao->get("login_nome");
    $texto     = $dados['chat_entra'];
    if ($texto) { 
        $query = " insert into chat values($pessoa_id, CURRENT_TIMESTAMP, '$texto','$nome') ";
        $e = $cht->SQL($query, 'sql', $resp);
    }    
    $resp->script("xajax_Chat()");    
    return $resp;
}
function Update_Chat()  {
    $resp = new xajaxResponse();
    global $cht;
    global $sessao;
    $ultimo = $sessao->get("ultimo");
    $atual = $cht->SQL(" SELECT max(data) FROM chat ",'unico',$resp);
    if ($atual > $ultimo)  {
//    $hoje = $cht->SQL(" select now() as data ",'unico',$resp);
       $tela = $cht->Browse($resp);    
       $resp->assign("div_chats","innerHTML",$tela); 
    }   
    return $resp;
}
