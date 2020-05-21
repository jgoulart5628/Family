<?php
function Exclui_Casamento($pessoa_id)  {
  $resp = new xajaxResponse();
  global $pessoa; 
  $resp->confirmCommands(1, " Confirma exclusão deste casamento? "); 
  $e = $pessoa->Elimina_Casamento($pessoa_id);
  $resp->script('xajax_Geral("")');
  return $resp;
} 

function Casamentos($pessoa_id, $sexo, $oper)  {
  $resp = new xajaxResponse();
  global $pessoa; 
  $tela  = '<fieldset id="casar"><input type="hidden" name="opera" value="'.$oper.'" ><input type="hidden" name="sexo" value="'.$sexo.'"><div>Conjuge :';
  if ($oper === 'A')  {
     $resul = $pessoa->Busca_Casamento($pessoa_id);
     if ($resul)  {
         $marido = $resul['marido'];
         $esposa = $resul['esposa'];
         $marido_id = $resul['marido_id'];
         $esposa_id = $resul['esposa_id'];
         $data_casamento = date('d/m/Y',strtotime($resul['data_casamento']));
         $local_casamento = $resul['local_casamento'];
     }
     $opera = 'Alterar';
  }   
//  $resp->alert($pessoa_id.'-'.$oper.'-'.$tela); return $resp;  
  if ($oper === 'I')  {
     $opera = 'Incluir';
 //    $resp->alert($pessoa_id.'-'.$oper.'-'.$sexo.' - '.$tela); return $resp;  
     $ret = combo_conjuge($pessoa_id, $sexo, 'conjuge_id', $resp);
     $tela .= $ret;
  }
  $tela .= ' Data Casamento : <input type="date" class="entra"  size="11" name="data_casamento" id="data_casamento" value="'.$data_casamento.'">
            &nbsp;&nbsp;&nbsp; Local : <input type"txt" class="entra" name="local_casamento" size="30 maxlenght="30" value="'.$local_casamento.'">
               &nbsp;&nbsp;&nbsp;<input type="button" align="right" class="caixa_sombra" value="'.$opera.'" onclick="xajax_Dados_Casamento(xajax.getFormValues(\'tela\'),\''.$pessoa_id.'\'); return false;">
               </div>
            </fieldset>'; 
  $resp->assign("casados", "innerHTML", $tela);    
  return $resp;
}

function Dados_Casamento($dados, $pessoa_id)  {
  $resp = new xajaxResponse();
  $conjuge_id  =   $dados['conjuge_id']; 
  $oper        =   $dados['opera'];
  $sexo        =   $dados['sexo'];
  if ($sexo === 'M')  {
      $noivo_id = $pessoa_id;
      $noiva_id = $conjuge_id;
  } else {
      $noivo_id = $conjuge_id;
      $noiva_id = $pessoa_id;
  }
  if ($dados["data_casamento"]) {
       $anoN              = substr($dados["data_casamento"],6,4);
       $mesN              = substr($dados["data_casamento"],3,2);
       $diaN              = substr($dados["data_casamento"],0,2);
       $data_casamento   = $anoN.'-'.$mesN.'-'.$diaN;
    } else {   $data_casamento = '0000-00-00';  }
  $local_casamento = $dados['local_casamento']; 
  if ($oper === 'A') {
     $query = " update casamentos set data_casamento = '$data_casamento', local_casamento = '$local_casamento' 
                where noivo_id = $pessoa_id or noiva_id = $pessoa_id  "; 
  } else {
     $query = " insert into casamentos  values($noivo_id, $noiva_id, '$data_casamento', '$local_casamento','','') ";
  }
//  $resp->alert($data_casamento.'-'.$local_casamento.'-'.$oper.'-'.$pessoa_id.'-'.$query); return $resp;
  global $pessoa;
  $e =  $pessoa->Inclui_Altera($query,$resp);
  $resp->script("xajax_Altera('',$pessoa_id)");
  return $resp;
}
