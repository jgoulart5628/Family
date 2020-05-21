<?php
 function Arvore($pessoa_id)  {        
   $resp = new xajaxResponse();
   $nivel = '0  ';
   $lista[] = $nivel.'-'.$pessoa_id;
   $pais = busca_pais($pessoa_id);
   $nivel = '1  ';
   $pai   =  $pais['pai_id'];
   $mae  = $pais['mae_id'];
   $lista[] = '1P  -'.$pai;
   $lista[] = '1M  -'.$mae;
//arvore pai
   if ($pai !== '00000') { monta_arvore($pai,'P',$lista); }
   if ($mae !== '00000') { monta_arvore($mae,'M',$lista); }
   array_multisort($lista);
//   print_r($lista);
//  if (is_array($lista)) {       
//     foreach ($lista as $dados)  {
//       $tela .= $dados.' *** ';      
//     }
//     $tela .= '</br>';
//  }   
//   $resp->alert(var_dump($lista)); return $resp;      
   $cols = count($lista);
// Dados da pessoa selecionada -- ponto de partida
   $nome = busca_nome(substr($lista[0],5,5),$resp);
   $tela = '<div id="PP" class="celula_indiv"></br><a href="#" style="color: black; text-decoration: none;" onclick="xajax_Retorna();">
                      '.$nome.'<span>Clique para retornar!</span></a></div>
             <div id="PP_Ponta" class="Ponta"></div>       
             <div id="PP_Linha" class="Linha"></div>';
  if (is_array($lista)) {       
     foreach ($lista as $pais)  {
       if (substr($pais,0,2) == '1P')  {
           $tela .= '<div id="P1P" class="celula_indiv">'.busca_nome(substr($pais,5,5),$resp).'</div>
                       <div id="P1P_Ponta_Left" class="Ponta"></div>';
      }     
      if (substr($pais,0,2) == '1M')  {
           $tela .= '<div id="P1M" class="celula_indiv">'.busca_nome(substr($pais,5,5),$resp).'</div>
                       <div id="P1M_Ponta_Left" class="Ponta"></div>';
       }     
        
    }
    foreach ($lista as $avos)  {
       if (substr($avos,0,1) == '2')  {
          $cadeia = substr($avos,0,3);
          $cadeiax = substr($avos,0,2);
          $pessoax = substr($avos,5,5);
          if ($cadeiax === '2M')  { $tela .= '<div id="P1M_Linha" class="Linha"></div><div id="P1M_Ponta_Right"  class="Ponta"></div>';
          }      
          if ($cadeiax === '2P')  { $tela .= '<div id="P1P_Linha" class="Linha"></div><div id="P1P_Ponta_Right" class="Ponta"></div>';
          }      
          $tela .=  '<div id="G'.$cadeia.'" class="celula_indiv">'.busca_nome($pessoax,$resp).'</div><div id="G'.$cadeia.'_Ponta_Left" class="Ponta"></div>';       
      }     
         
    }
    foreach ($lista as $bavos)  {
      // bisavos paternos
       if (substr($bavos,0,1) == '3')   {
          $cadeia = substr($bavos,0,4);
          $cadeiax = substr($bavos,0,3);
          $pessoax = substr($bavos,5,5);
          $nome   = substr(busca_nome($pessoax,$resp),0,40);     
          $tela .= '<div id="G'.$cadeiax.'_Linha" class="Linha"></div><div id="G'.$cadeiax.'_Ponta_Right" class="Ponta"></div>';
          $tela .= '<div id="G'.$cadeia.'" class="celula_indiv">'.$nome.'</div><div id="G'.$cadeia.'_Ponta_Left" class="Ponta"></div>';
     }    
   }
  }
   $resp->assign("consulta","className","esconder");
   $resp->assign("div_arvore","innerHTML",$tela);
   return $resp;      
 }

 function monta_arvore($pessoa_id,$p,&$lista)  {
    $nivel = '2'.$p;
    $pais = busca_pais($pessoa_id);
    $pai2 = $pais['pai_id'];
    $mae2 = $pais['mae_id'];
    if ($pai2 !== '00000') { $lista[]   = $nivel.'P -'.$pai2; }
    if ($mae2 !== '00000') { $lista[]  =  $nivel.'M -'.$mae2; }
// pais do pai
  if ($pai2 !== '00000')  {
     $nivel = '3'.$p.'P';
     $pais = busca_pais($pai2);
     $pai3 = $pais['pai_id'];
     $mae3 = $pais['mae_id'];
     if ($pai3 !== '00000') { $lista[]   = $nivel.'P-'.$pai3; }
     if ($mae3 !== '00000') { $lista[]  =  $nivel.'M-'.$mae3; }
  }
  if ($mae2 !== '00000')  {
   // pais da mae
     $nivel = '3'.$p.'M';
     $pais = busca_pais($mae2);
     $pai23 = $pais['pai_id'];
     $mae23 = $pais['mae_id'];
     if ($pai23 !== '00000') { $lista[]   = $nivel.'P-'.$pai23; }
     if ($mae23 !== '00000') { $lista[]  =  $nivel.'M-'.$mae23; }
 
 }
}

function busca_pais($chave) {
    global $pessoa; 
    $query = " select mae_id, pai_id from pessoas where pessoa_id = $chave ";
    $pais = $pessoa->SQL($query,'single');
    return $pais;     
}

function busca_nome($pessoa_id, $resp) {
   if ($pessoa_id) { 
      global $pessoa; 
      $query = "  SELECT  CONCAT(pessoas.nome,' ',pessoas.sobrenome,' ',pessoas.sufixo) as nome
                    FROM pessoas  where pessoa_id = $pessoa_id  ";
//   echo $query;
     $nome = $pessoa->SQL($query,'unico',$resp);
     return $nome;
     } else { return false; }
}
