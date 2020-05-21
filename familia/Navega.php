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
    $e = $pessoa->Sessao($query,$resp);
    if ($sessao->get("login_familia") !=1)   {  $resp->script("xajax_Login();"); return $resp; }
//    $resp->alert('Aqui ..'.$e.' - '.print_r($sessao, true)); return $resp;

//    if (!isset($_COOKIE["Familia"])) { $resp->script('xajax_Logout()'); return $resp; } 
    $pessoa_id = $sessao->get("login_id");
    $nome      = $sessao->get("login_nome");
//    $resp->alert('Aqui ..'.$pessoa_id.' - '.$nome); return $resp;
    $query =  " SELECT CONCAT(nome,' ', sobrenome,' ', sufixo) as nome, email, pessoa_id  FROM pessoas  order by 1 ";
    $tela .= '<div id="header">
               <div id="logo"><img src="images/goulart1.jpg" class="ca"><font class="tit">Família Goulart&nbsp;'.date('d/m/y G:i').'</font></div>
               <div id="menu_bar">
                  <ul>
                    <li>
                        <a  onclick="xajax_Home(); return false;"><img class="img" src="images/casa.png"><br><font class="tit">Home</font>
                       <span>Recarrega a Tela.</span></a>
                   </li>
                   <li>
                       <a onclick="xajax_Inclui(); return false;">
                       <img class="img" src="images/clientes.png"><br><font class="tit">Incluir</font><span>Incluir nova Pessoa.</span></a>
                   </li>
                   <li style="vertical-align: top;">
                       <a><div>'.lista_pessoas($query,$resp).'</div></a>
                   </li>
                   <li>
                     <a  onclick="xajax_Listar_Pessoas();"><img class="img" src="images/text-xml.png"><br><font class="tit">Lista</font>
                       <span>Lista completa das pessoas</span></a>
                   </li>
                   <li>
                     <a  onclick="xajax_Album_Fotos()"><img class="img" src="images/Album.png"><br><font class="tit">Albuns</font>
                       <span>Ver e atualizar Albuns de fotos</span></a>
                   </li>
                   <li style="float: right;">
                     <a onclick="xajax_Logout(); return false;"><img class="img" src="images/exit1.png"><br><font class="tit">Sair</font></a>
                   </li>
                   <li style="float: right;">
                     <a><img class="img" src="images/lock.png"><br><font class="tit">Olá '.$nome.'</font></a>
                   </li>
                  </ul>                    
               </div>                   
             </div>';
  
    $resp->assign("consulta","innerHTML", '');
    $resp->assign("cabeca","innerHTML", $tela);
//     $resp->addScript("jQuery(famx).imageMagnify({ magnifyby: 3 })");
//    $script = "document.getElementById('inputString').focus()";
//    $resp->script($script);
    $resp->script('xajax_Geral("");');
    return $resp;
}
