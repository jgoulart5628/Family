<?php
 $dados = '';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function Home() {
    $resp = new xajaxResponse();
    $resp->redirect($_SERVER['PHP_SELF']);    Return $resp;
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

function Geral($dados) {
    $resp = new xajaxResponse();
    if (!$dados) { $mes = date('m'); } else {  $mes  = $dados['mes']; }
//    if (!$mes) $mes = date('m');
    global $pessoa;
    global $sessao;
    $ano = date('Y');
    $query = " SELECT DISTINCT pessoas.pessoa_id, CONCAT(nome,' ', sobrenome) as nome
                  FROM pessoas, sessao_login
               where pessoas.pessoa_id = sessao_login.pessoa_id "; 
    $res = $pessoa->Browse($query,$resp);
    $ip = $_SERVER["REMOTE_ADDR"];
    if (count($res) === 0) { 
        $resp->script("xajax_Home();");
        $sessao->set("login_familia",0);
        $sessao->set("login_id",'');
        $sessao->set("login_nome",'');
//        unset($_COOKIE("Familia"));
       return $resp; }
    $query =  " SELECT CONCAT(nome,' ', sobrenome,' ', sufixo) as nome, email, pessoa_id 
                             FROM pessoas  order by 1 ";
    $tela = '<div id="pagina" style="display: block; float: none;">
                <div id="sobre_brasao" class="gradient"><h2>O sobrenome GOULART<h2><p>"Ao contrário do que a sonoridade francesa do sobrenome GOULART pode surgerir, a família, na verdade, é de origem holandesa.
                     O nome original veio de um colono holandês,JOZ GOUILWARD, que fez parte da comitiva de um dos três donatários dos Açores,
                     a saber: WILLEN VAN DER HAAGEN (Ilha Terceira, JOZ VAN HUESTER (Ilha do Pico) e JOZ VAN AERTRICJCKE (Ilha do Faial).
                     O nome original GOUILWARD transformou-se ao longo do tempo em GALARD(E), GOLART(E),GOULART(E) e GULARTE".
                </div>
                <div id="left">
                     <div ><cite>Os Goulart, em Janeiro de 1975.(!)</cite>
                          <img src="images/famx.jpg" id="famx" class="magnify" height="309" width="314" border="0" style="border: outset 4px;" alt="A turma toda"></div>
                </div>         
                <div id="right">
                     <div id="div_aniver">'.mostra_aniver($mes,$ano,$resp).'</div>
                     <br><br>    
                    <div id="Logins" class="tit1">Pessoas conectadas: <a href="#"><input type="image" src="images/chat2.png" width="32" heigth="32" onclick="xajax_Chat(xajax.getFormValues(\'tela\')); return false;">
                      <span>Vamos conversar?</span></a><br>';
                    for ($i=0; $i < count($res); $i++) {
                        $pessoa_id = $res[$i]['pessoa_id'];        
                        $nome      = $res[$i]['nome'];        
                        $tela .= '<input type="button" style="width: 200px" onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$pessoa_id.'\'); return false;" value="'.$nome.'"><br>';
                    }
                    $tela .= '</div><div id="div_conversa"></div><div id="div_chats"></div>';    
                    $tela .= '<p>Seu IP: '.$_SERVER["REMOTE_ADDR"].'</div></div>
           </div>';
    $resp->assign("principal","className","mostrar"); 
    $resp->assign("principal","innerHTML",$tela); 
    $resp->script("jQuery(famx).imageMagnify({ magnifyby: 3 })");
    return $resp;
}

function lista_pessoas($query,$resp)  {
      global $pessoa; 
      $res = $pessoa->Browse($query,$resp);
      $conta = count($res);
      $tela   = '<img src="images/fileblue.png" width="24" heigth="24" border="0" ><font class="tit">Procure aqui!</font>
                       <select name="cmb_pessoa" id="cmb_pessoa" class="form-control" onchange="xajax_Altera(xajax.getFormValues(\'tela\')); return false;">
                       <option selected value=" " selected></option>';
      foreach ($res as $pes)  {
          $tela .= '<option  value="'.$pes['nome'].'-'.$pes['pessoa_id'].'">'.$pes['nome'].'</option>';
       } 
       $tela .= '</select>'
               . '<div><font class="tit">Total de pessoas no cadastro: '.$conta.'</font></div>';
    return $tela;
}

function combo_meses($mes)  {
    $meses   =   array('01','02','03','04','05','06','07','08','09','10','11','12');
    $mes_ext   =   array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
    if (!$mes) { $mesatu  =   date('m');  } else { $mesatu = $mes; } 
    $ret .= ' <select class="entra" name="mes" id="mes" onclick="xajax_Aniver(xajax.getFormValues(\'tela\')); return false;"> 
                     <option value ="" class="f_texto" ></option> ';
     for ($i=0; $i < count($meses); $i++) { 
         if ($mesatu == $meses[$i])  {  $sel = ' selected '; } else { $sel = ''; }
         $ret .= '<option value="'.$meses[$i].'" '.$sel.' class="f_texto"> '.$mes_ext[$i].' </option> ';
    }
    $ret .= '</select>';
   return $ret;   
}

function combo_pessoa($parent_id,$tipo, $volta) {
    global $pessoa;
    if ($tipo == 'P')  {
        $nome = $pessoa->Busca_Pai_Mae($parent_id);
        return $nome; 
    }    
    $res = $pessoa->Browse_Genero($tipo); 
    $ret .= ' <select class="entra" name="'.$volta.'" id="'.$volta.'"> <option value ="" class="f_texto" ></option> ';
    $sel = '';
    for ($i=0; $i < count($res); $i++) {
          $pessoa_id = $res[$i]['pessoa_id'];        
          $nome      = $res[$i]['nome'];        
          $idade     = date('Y-m-d') - $res[$i]['data_nascimento'];
    	  if ($parent_id != '' && $pessoa_id === $parent_id) { $sel = ' selected '; } else { $sel = ''; }
          if ($idade > 17) { $ret .= '<option value="'.$pessoa_id.'" '.$sel.' class="f_texto"> '.$nome.' </option> '; }
    }
    $ret .= '</select> ';
    return $ret;
}

function combo_conjuge($pessoa_id, $sexo, $volta, $resp='') {
  // tipo = P-Pai,mae, C-Conjuge, G-Geral 
  //    $resp->alert('Aqui '.$query.' - '.print_r($res,true)); return $resp;
    global $pessoa;
    $query = " SELECT DISTINCT pessoa_id, CONCAT(nome,' ', sobrenome,' ', sufixo) as nome
                  FROM pessoas
                 WHERE MONTH( data_falecimento ) =00
                   AND sexo != '$sexo'
                   AND NOT EXISTS ( SELECT 1 FROM casamentos
                                     WHERE (pessoa_id = noivo_id
                                        OR pessoa_id = noiva_id)
                   ) order by nome ";
    $res = $pessoa->Browse($query, $resp);
    $ret .= ' <select class="entra" name="'.$volta.'" id="'.$volta.'"> <option value ="" class="f_texto" ></option> ';
    $sel = '';
    for ($i=0; $i < count($res); $i++) {
          $pessoa_id = $res[$i]['pessoa_id'];        
          $nome      = $res[$i]['nome'];        
          $idade     = date('Y-m-d') - $res[$i]['data_nascimento'];
          if ($idade > 17) { $ret .= '<option value="'.$pessoa_id.'" '.$sel.' class="f_texto"> '.$nome.' </option> '; }
    }
    $ret .= '</select> ';
    return $ret;
}

function just_clean($string) {
// Replace other special chars
   $specialCharacters = array("'"=> '','"'=>'', '#' => '','$' => '','%' => '','&' =>'','@' =>'','.' =>'','?' =>'','+' =>'','=' =>'','�' =>'','/' =>'');
   while (list($character, $replacement) = each($specialCharacters)) {
          $string = str_replace($character, ' ' . $replacement . ' ', $string);
          $string = strtr($string,"������?����������������������������������������������","AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");
   }
// Remove all remaining other unknown characters
   $string = preg_replace('/[^a-zA-Z0-9-]/', ' ', $string);
   $string = preg_replace('/^[-]+/', '', $string);
   $string = preg_replace('/[-]+$/', '', $string);
   $string = preg_replace('/[-]{2,}/', ' ', $string);
   return $string;
}
 