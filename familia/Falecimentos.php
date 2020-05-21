<?php
function Falecimento($pessoa_id,$data_falecimento)  {
  $resp = new xajaxResponse();
  if ($data_falecimento !== '0000-00-00') { return $resp; }
//  $resp->alert($data_casamento.'-'.$local_casamento.'-'.$oper.'-'.$pessoa_id); return $resp;
  $tela  = '<fieldset>
               Data Falecimento :<input type="date" class="entra"  size="11" name="data_falecimento" id="data_falecimento" value="'.$data_falecimento.'">
               &nbsp;&nbsp;&nbsp; Local : <input type"txt" class="entra" name="local_falecimento" size="30 maxlenght="30" value="'.$local_falecimento.'">
               &nbsp;&nbsp;&nbsp;<input type="button" value="Confirma" onclick="xajax_Dados_Falecimento(xajax.getFormValues(\'tela\'),\''.$pessoa_id.'\'); return false;">
               </div>
            </fieldset>'; 
//                      <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.tela.data_falecimento);return false;" HIDEFOCUS><img class="PopcalTrigger" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
     
   $resp->assign("casados","innerHTML",$tela);    
  return $resp;
}

function Dados_Falecimento($dados, $pessoa_id)  {
  $resp = new xajaxResponse();
  if ($dados["data_falecimento"]) {
       $anoN              = substr($dados["data_falecimento"],6,4);
       $mesN              = substr($dados["data_falecimento"],3,2);
       $diaN              = substr($dados["data_falecimento"],0,2);
       $data_falecimento   = $anoN.'-'.$mesN.'-'.$diaN;
    } else {   $data_falecimento = '0000-00-00';  }
  $local_falecimento = $dados['local_falecimento']; 
  $query = " update pessoas set data_falecimento = '$data_falecimento', local_falecimento = '$local_falecimento' 
           where pessoa_id = $pessoa_id "; 
  global $pessoa;
  $e =  $pessoa->Inclui_Altera($query,$resp);
  $resp->script("xajax_Altera('',$pessoa_id)");
//  $resp->alert($oper.'-'.$sexo.'-'.$conjuge_id.'-'.$noivo_id.'-'.$data_casamento.'-'.$local_casamento);
//  global $pessoa; 
  return $resp;
}
