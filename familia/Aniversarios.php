<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function Aniver($dados, $mes='')  {
      $resp = new xajaxResponse();
      $mes  = $dados['mes'];
      if (!$mes) $mes = date('m');
     $ano = date('Y');
     $tela = mostra_aniver($mes,$ano, $resp);
     $resp->assign("div_aniver","innerHTML",$tela);
     return $resp;
}

function mostra_aniver($mes,$ano, $resp)  {
    global $pessoa;
    $res = $pessoa->Busca_Birth($mes);
    $tela  = '</br><table border="1" width="100" cellspacing="0" cellpadding="0" class="sSky" id="aniver">
                    <caption>Aniversários do mes :  '.combo_meses($mes).' </caption>';
    if ($res)  {
       $tela .= '<thead>
                      <tr align="Center">
                      <th> Nome </th>
                      <th> Nascimento </th>
                      <th> Idade </th>
                   </tr>
                </thead>
             <tbody>';
       $a = 0;
       foreach ($res as $pes)  {
         if ($a == 0 || fmod($a, 2) == 0) $classe =  'class="t_line1"'; else $classe =  'class="t_line2"';
          $data_nas =  date("d/m/Y",strtotime($pes['data_nascimento']));
          $pessoa_id =  $pes['pessoa_id'];
          $nome       =  $pes['nome'];
          $mes1      =  $pes['mes'];
          $dia         =  $pes['dia'];
          $idade     =  ($ano.'-'.$mes1.'-'.$dia) - ($pes['data_nascimento']);
          $tela .= '<tr '.$classe.'>
                      <td align="left"><a href="#"  onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$pessoa_id.'\'); return false;">' .$nome.'</a></td>
                      <td align="center">'.$data_nas.'</td>
                      <td align="center">'.$idade.'</td>
                    </tr>';
          $a++; 
       } 
       $tela .= '</tbody>';
       
    }
// casamentos
    $res = $pessoa->Busca_Marriage($mes);
    if ($res)  {
       $tela .= '<thead>
                      <tr align="Center">
                      <th> Casal </th>
                      <th> Casamento </th>
                      <th> Anos </th>
                   </tr>
                </thead>
             <tbody>';
       $a = 0;
       foreach ($res as $pes)  {
         if ($a == 0 || fmod($a, 2) == 0) $classe =  'class="t_line1"'; else $classe =  'class="t_line2"';
          $data_cas =  date("d/m/Y",strtotime($pes['data_casamento']));
          $marido   = $pes['marido'];
          $marido_id  = $pes['marido_id'];
          $esposa   = $pes['esposa'];
          $esposa_id   = $pes['esposa_id'];
          $mes1      =  $pes['mes'];
          $dia         =  $pes['dia'];
          $idade     =  ($ano.'-'.$mes1.'-'.$dia) - ($pes['data_casamento']);
          $tela .= '<tr '.$classe.'>
                      <td align="left"><a href="#"  onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$marido_id.'\'); return false;">' .$marido.'</a><br>
                          <a href="#"  onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$esposa_id.'\'); return false;">' .$esposa.'</a></td>
                      <td align="center">'.$data_cas.'</td>
                      <td align="center">'.$idade.'</td>
                    </tr>';
          $a++; 
       } 
       $tela .= '</tbody>';
    }
    $res = $pessoa->Busca_Death($mes);
    if ($res)  {
       $tela .= '<thead>
                      <tr align="Center">
                      <th> Nome </th>
                      <th> Falecimento </th>
                      <th> Anos </th>
                   </tr>
                </thead>
             <tbody>';
       $a = 0;
       foreach ($res as $pes)  {
         if ($a == 0 || fmod($a, 2) == 0) $classe =  'class="t_line1"'; else $classe =  'class="t_line2"';
          $data_fal =  date("d/m/Y",strtotime($pes['data_falecimento']));
          $pessoa_id =  $pes['pessoa_id'];
          $nome       =  $pes['nome'];
          $mes1      =  $pes['mes'];
          $dia         =  $pes['dia'];
          $dif         = abs(strtotime(date('Y-m-d')) - strtotime($pes['data_falecimento']));
          $anos      = floor($dif / (365*60*60*24));
          $meses    = floor(($dif - $anos * 365*60*60*24) / (30*60*60*24));
          $dias       = floor(($dif - $anos * 365*60*60*24 - $meses*30*60*60*24)/ (60*60*24));
//          $idade    = printf("%d anos, %d meses, %d dias", $anos, $meses, $dias);
//          $idade     =  ($ano.'-'.$mes1.'-'.$dia) - ($pes['data_falecimento']);
          $tela .= '<tr '.$classe.'>
                      <td align="left"><a href="#"  onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$pessoa_id.'\'); return false;">' .$nome.'</a></td>
                      <td align="center">'.$data_fal.'</td>
                      <td align="center">'.$anos.'</td>
                    </tr>';
          $a++; 
       } 
       $tela .= '</tbody>';
    }
    $tela .= '</table>';   
    return $tela;    
}

