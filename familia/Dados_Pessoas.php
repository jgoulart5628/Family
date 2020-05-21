 <?php
function Inclui()  {
    $resp = new xajaxResponse();
    $oper = 'I';
    $pessoax = '';
    $tela  = tela_dados($pessoax,$oper,$resp);
    $resp->assign("div_arvore","innerHTML",''); 
    $resp->assign("principal","className","esconder"); 
    $resp->assign("consulta","className","mostrar"); 
    $resp->assign("consulta","innerHTML",$tela); 
return $resp;
}

function Altera($dados,$chave='')  {
    $resp = new xajaxResponse();
    global $pessoa;
 //   $resp->alert($dados['cmb_pessoax']); return $resp; 
    $dat  = explode('-',$dados['cmb_pessoa']);
    if (!$dat[0]) { $dat  = explode('-',$dados['cmb_pessoax']); }
    if (!$dados['cmb_pessoa'] && !$chave) { $resp->alert(" Escolha uma pessoa para ver os dados"); return $resp; }    
    $pessoa_id = $dat[1];
//    if (!$pessoa_id) { $pessoa_id = $dados['pessoa_id']; }
    if ($chave) { $pessoa_id = $chave; }
    if (!$pessoa_id) { $resp->alert(" Escolha uma pessoa para ver os dados"); return $resp; }    
//     $resp->alert($dados['cmb_pessoa'].'-'.$pessoa_id); return $resp;  // $dat[0].'-'.$dat[1]);    
        
    $pessoax =  $pessoa->Busca_Pessoa($pessoa_id);
    $oper = 'A';
    $tela  = tela_dados($pessoax,$oper,$resp);
    $resp->assign("div_arvore","innerHTML",''); 
    $resp->assign("principal","className","esconder"); 
    $resp->assign("consulta","className","mostrar"); 
    $resp->assign("consulta","innerHTML",$tela); 
    $resp->script("jQuery(fotop).imageMagnify({ magnifyby: 3 })");
    return $resp;
}

function tela_dados($pessoax,$oper,&$resp)   {
   global $pessoa;
  if ($oper == 'A')   {
      $pessoa_id              = $pessoax["pessoa_id"];
      $nome                   = $pessoax["nome"];
      $sobrenome              = $pessoax["sobrenome"];
      $sufixo                 = $pessoax["sufixo"];
      $data_nascimento        = $pessoax["data_nascimento"];
      $idade   = date('Y-m-d') - $pessoax["data_nascimento"];
      $data_falecimento       = $pessoax["data_falecimento"];
      $local_nascimento   = $pessoax["local_nascimento"];
//      if ($pessoax["data_falecimento"] !== '0000-00-00')  { 
//         $data_falecimento   = date('d/m/Y',strtotime($pessoax["data_falecimento"]));
 //     } else {   $data_falecimento   = '0000-00-00'; } 
      $local_falecimento   = $pessoax["local_falecimento"];
      $sexo                       = $pessoax["sexo"];
      $mae_id                     = $pessoax["mae_id"];
      if ($mae_id > 0) {
          $nome_mae = combo_pessoa($mae_id,'P','mae_id'); 
          $tela .=  '<input type="hidden" name="mae_id" value="'.$mae_id.'">';
      }  else  { $nome_mae = combo_pessoa($mae_id,'F','mae_id'); } 
      $pai_id                    = $pessoax["pai_id"];
      if ($pai_id > 0) {
          $nome_pai = combo_pessoa($pai_id,'P','pai_id'); 
          $tela .=  '<input type="hidden" name="pai_id" value="'.$pai_id.'">';
      } else  { $nome_pai = combo_pessoa($pai_id,'M','pai_id'); } 
      $localizar                = $pessoax["localizar"];
      $atualizado             = $pessoax["atualizado"];
      $criador_id             = $pessoax["criador_id"];
      $editor                   = $pessoax["editor"];
      $email                    = $pessoax["email"];
      $foto                     = $pessoax["foto"];
      $titulo                   = 'Alteração';
  }   else { $titulo = 'Inclusão'; $nome_mae = combo_pessoa($mae_id,'F','mae_id'); $nome_pai = combo_pessoa($pai_id,'M','pai_id'); } 
  $arq_foto = 'images/foto_'.$pessoa_id.'.jpg';
   if ($foto)  { 
       $fh = fopen($arq_foto,'w');
       fwrite($fh,$foto);
       fclose($fh);
       list($larg, $alt) = getimagesize($arq_foto);
       if ($larg > 96) { $larg = 96; }
       if ($alt > 96)  {$alt = 96; }
      $tel_foto = '<img src="'.$arq_foto.'" id="fotop"  class="magnify" width="'.$larg.'"  height="'.$alt.'">';
  }   else  {   $tel_foto = 'Carregue sua foto aqui! '; } // if (is_file($arq_foto = 'images/img/anonimo.jpg'; $larg = 64; $alt = 48; }
  $checkM = ''; $checkF = '';
  if ($sexo == 'M') { $checkM = 'checked="true"'; }
  if ($sexo == 'F') { $checkF = 'checked="true"'; }
  $tela  .= '<div id="tela_dados">
                 <input type="hidden" name="pessoa_id" value='.$pessoa_id.'>
                 <input type="hidden" name="Foto" value="'.$arq_foto.'">
                 <fieldset class="caixa"> 
                   <legend>'.$titulo.'  : '.$nome.'&nbsp;&nbsp;&nbsp;&nbsp;'.$pessoa_id.'</legend>
                    <ol>
                      <li>
                         <label for="Nome">Nome : </label>
                         <input type="txt"  class="entra" id="nome" name="Nome" size="30" maxlength="30" value="'.$nome.'">
                         Sobrenome :<input type="txt"  class="entra" id="sobrenome" name="Sobrenome" size="20" maxlength="20" value="'.$sobrenome.'">
                         Sufixo: <input type="txt"  class="entra" id="sufixo" name="Sufixo" size="10" maxlength="10" value="'.$sufixo.'">
                      </li>
                      <li>
                         <label for="Data_Nascimento">Data de Nasc. :</label>
                        <input type="date" class="entra"  size="11" name="Data_Nascimento" id="Data_Nascimento" value="'.$data_nascimento.'">&nbsp;&nbsp;Sexo: 
                          <input type="radio" name="sexo" value="M" '.$checkM.'> Masculino <input type="radio" name="sexo" value="F" '.$checkF.'> Feminino 
                      </li>
                      <li>
                         <label for="local_nascimento">Local Nasc. : </label>
                         <input type="txt"  class="entra" id="local_nascimento" name="local_nascimento" size="40" maxlength="40" value="'.$local_nascimento.'">
                      </li> ';
  //   esposos e esposas
      if ($oper == 'A')  {
        $resul = $pessoa->Busca_Casamento($pessoa_id);
        $solt = '';
        if (!count($resul) > 0) { $solt = true; }
        if ($resul)  {
            $marido = $resul['marido'];
            $esposa = $resul['esposa'];
            $marido_id = $resul['marido_id'];
            $esposa_id = $resul['esposa_id'];
            $data_casamento = date('d/m/Y',strtotime($resul['data_casamento']));
            $local_casamento = $resul['local_casamento'];
            if (substr($resul['fal_esposa'],0,4) === '0000') { $fal_esp = ''; } else {
                $fal_esp = '<img src="images/luto.jpg" witdth="24" height="24" style="border: 2px outset;vertical-align: top;">';
            } 
            if (substr($resul['fal_marido'],0,4) === '0000') { $fal_mar = ''; } else {
                $fal_mar = '<img src="images/luto.jpg" witdth="24" height="24" style="border: 2px outset;vertical-align: top;">';
            } 
            $tela .= '<li>';
            if ($pessoa_id == $marido_id)  {
                $tela .=  '<label for="esposa">Esposa : </label>
                               <input type="button" onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$esposa_id.'\'); return false;"  value="' .$esposa.'">'
                            .$fal_esp.'&nbsp;&nbsp;Data Casamento: '.$data_casamento.' Local: '.$local_casamento;
            } else {
                $tela .=  '<label for="marido">Marido : </label>
                                   <input type="button" onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$marido_id.'\'); return false;" value="' .$marido.'" >'
                                   .$fal_mar.'&nbsp;&nbsp;Data Casamento: '.$data_casamento.' Local: '.$local_casamento;
           } 
           $tela .= '&nbsp;&nbsp;&nbsp;<a href="#"><button type="button"><img src="images/icono_buscar.png" width="26" height="26" onclick="xajax_Casamentos(\''.$pessoa_id.'\',\''.$sexo.'\',\'A\'); return false;"></button><span>Alterar dados Casamento.</span></a>    
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><button type="button"><img src="images/casamento_off.jpg" width="26" height="26" onclick="xajax_Exclui_Casamento('.$pessoa_id.'); return false;">
                       </button><span>Excluir o casamento.</span></a>    
                   </li>';
        }
        $tela .= '<div id="casados"></div>';
        // else {   $tela .= '<li><label></label><div id="casados"></div></li>'; }
        // filhos
        $resul = $pessoa->Busca_Filhos($pessoa_id);
        if ($resul)  {
          $tela .=  '<li><label for="Filhos">Filhos : </label>';
           for ($a = 0; $a <count($resul); $a++)  {
                $filho = $resul[$a]['filho'];            
                $filho_id =  $resul[$a]['filho_id'];
                if (substr($resul[$a]['data_falecimento'],0,4) === '0000') { $fal = ''; } else {
                    $fal = '<img src="images/luto.jpg" witdth="24" height="24" style="border: 2px outset;vertical-align: top;">';
                } 
               $tela .= '<input type="button" onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$filho_id.'\'); return false;" value="' .$filho.'">'.$fal.'&nbsp;&nbsp;&nbsp;&nbsp;';
           }
           $tela .=  '</li>';
        }
        // irmaos
        $resul = $pessoa->Busca_Irmaos($pessoa_id,$mae_id);
        if ($resul)  {
          $tela .=  '<li><label for="Irmaos">Irmãos : </label>';
           for ($a = 0; $a <count($resul); $a++)  {
                $irmao = $resul[$a]['irmao'];            
                $irmao_id =  $resul[$a]['irmao_id'];
                if (substr($resul[$a]['data_falecimento'],0,4) === '0000') { $fal = ''; } else {
                    $fal = '<img src="images/luto.jpg" witdth="24" height="24" style="border: 2px outset;vertical-align: top;">';
                } 
               $tela .= '<input type="button" onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$irmao_id.'\'); return false;" value="' .$irmao.'" >'.$fal.'&nbsp;';
           }
           $tela .=  '</li>';
        }
        if ($data_falecimento !== '0000-00-00')   {
                         $tela .= '<li>
                                          <label for="Data_Falecimento">Data de Falec. :</label>
                        <input type="date"  class="entra" size="11" name="Data_Falecimento" id="Data_Falecimento" value="'.$data_falecimento.'">
                       <li>
                         <label for="local_falecimento">Local Falec. : </label>
                         <input type="txt"  class="entra" id="local_falecimento" name="local_falecimento" size="40" maxlength="40" value="'.$local_falecimento.'">
                      </li> ';
        } else { $tela .= '<input type="hidden" name="Data_Falecimento" value="0000-00-00">'; } 
      }  
      $tela .=   '<li>
                         <label for="mae_id">Nome Mãe : </label>
                         '.$nome_mae.'
                      </li>
                      <li>
                        <label for="pai_id">Nome Pai : </label>
                         '.$nome_pai.'
                      </li>
                      <li>
                        <label for="localizar">Localização : </label>
                          <textarea cols="70" rows="5" id="localizar"  class="entrabox" name="localizar" >'.$localizar.'</textarea>
                      </li>
                      <li>
                        <label for="email">EMail : </label>
                          <input type="email"  class="entra" id="email" name="email" size="30" maxlength="30" value="'.$email.'">
                      </li>
                      <li>
                         <label for="anexos">Foto : </label>
                            <div id="anexos">
                               '.$tel_foto.'  
                                 <input type=hidden name="pessoa_id" value="'.$pessoa_id.'">
                                 <input type=hidden name="oper" value="'.$oper.'">
                                 Carregar foto: <input type="file" class="entra" size="20" name="imagem_carga" onchange="micoxUpload(this.form,\'carga_arq.php?name='.$arq_foto.'\',\'recebe_up_3\',\'Carregando...\',\'Erro ao carregar\')" />
                                 <div id="recebe_up_3" class="recebe"></div>
                            </div>  
                          </li>       
                       </ol>';
  //-------------------------
  
  $tela .= '<input type="button" class="caixa_sombra"  value="Gravar  os dados"  onclick="xajax_Gravar_Dados(xajax.getFormValues(\'tela\')); return false;" >
            &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="caixa_sombra"  value="Desiste e retorna"  onclick="xajax_Retorna_desiste();" >';
  if ($idade > 0 && $idade > 18 ) {  
      $tela .= '&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="caixa_sombra" Value="Casamento" onclick="xajax_Casamentos(\''.$pessoa_id.'\',\''.$sexo.'\',\'I\'); return false;" >';  
  }
  if ($oper === 'A') {
      $tela .=  '<input type="button" class="caixa_sombra" value="Árvore" onclick="xajax_Arvore(\''.$pessoa_id.'\'); return false;">';
      if ($data_falecimento === '0000-00-00') { $tela .= '<input type="image" src="images/luto.jpg" class="luto" onclick="xajax_Falecimento(\''.$pessoa_id.'\',\''.$data_falecimento.'\'); return false;">'; }
  }      
  $tela .=  '</fieldset></div>';
  return $tela;
}                                                          

function Gravar_Dados($dados)  {
    $resp = new xajaxResponse();
    $oper = $dados['oper'];
    global $sessao;
    global $pessoa;
    if ($sessao->get("login_familia") !=1)   {  $resp->alert("Sem login!");     $resp->redirect($_SERVER['PHP_SELF']);   return $resp; }
    $pessoa_id         = $dados["pessoa_id"];
    $nome              = $dados["Nome"];
    $sobrenome         = $dados["Sobrenome"];
    $sufixo            = $dados["Sufixo"];
    if ($dados["Data_Nascimento"]) {  $data_nascimento = $dados["Data_Nascimento"];  }

    $local_nascimento  = $dados["local_nascimento"];
    if ($dados["Data_Falecimento"]) { $data_falecimento  = $dados["Data_Falecimento"]; }
    $local_falecimento = $dados["local_falecimento"];
    $sexo              = $dados["sexo"];
    $mae_id = $dados["mae_id"];
    $pai_id = $dados["pai_id"];
    if (!$mae_id) { $mae_id = 0; }  
    if (!$pai_id) { $pai_id = 0; }  
    $localizar         = $dados["localizar"];
    $data_atu          = date("Y-m-d G:i");
    $atualizado        = $data_atu;
    if ($oper == 'I') {
        $criador_id = $sessao->get("login_id"); 
       } else {   if (!$dados["criador_id"]) {  $criador_id  = 2; } else {
               $criador_id  = $dados["criador_id"]; }
     }           
    $editor            = $sessao->get("login_id");
    $email             = $dados["email"];
    $arq               = $dados["Foto"];
    if ($oper == 'A')  {
        $monta = '';
        $x = 0;
        $pessoax =  $pessoa->Busca_Pessoa($pessoa_id);
        if ($nome     !== $pessoax["nome"])      { $monta .= ", nome      = '$nome' "; $x++; }
        if ($sobrenome !== $pessoax["sobrenome"]) { $monta .= ", sobrenome = '$sobrenome' "; $x++;}
        if ($sufixo   !== $pessoax["sufixo"])    { $monta .= ", sufixo = '$sufixo' "; $x++;}
        if ($data_nascimento  !== $pessoax["data_nascimento"])     { $monta .= ", data_nascimento = '$data_nascimento' "; $x++;}
        if ($local_nascimento !== $pessoax["local_nascimento"])    { $monta .= ", local_nascimento = '$local_nascimento' "; $x++;}
        if ($data_falecimento !== $pessoax["data_falecimento"])    { $monta .= ", data_falecimento = '$data_falecimento' "; $x++;}
        if ($local_falecimento)  { $monta .= ", local_falecimento = '$local_falecimento' "; $x++;}         
        if ($sexo   !== $pessoax["sexo"])    { $monta .= ", sexo = '$sexo' "; $x++;}
        if ($mae_id !== $pessoax["mae_id"])    { $monta .= ", mae_id = '$mae_id' "; $x++;}
        if ($pai_id !== $pessoax["pai_id"])    { $monta .= ", pai_id = '$pai_id' "; $x++;}
        if ($localizar !== $pessoax["localizar"])    { $monta .= ", localizar = '$localizar' "; $x++;}
        if ($email     !== $pessoax["email"])    { $monta .= ", email  = '$email' "; $x++;}
        if (is_file($arq))   { $x++;}
    //    $resp->alert($local_falecimento.'-'.$pessoax['local_falecimento']); return $resp;
        if ($x > 0) { $query = " update pessoas set  atualizado  = '$data_atu' ,editor_id  = '$editor' $monta  where pessoa_id  = $pessoa_id  "; } 
        else  { $resp->script('xajax_Retorna_desiste("")');  return $resp; }
    }
    if ($oper == 'I')  {
        $pessoa_id =  $pessoa->Novo_Id();
        $query = " insert into pessoas  ( pessoa_id , nome , sobrenome , sufixo , data_nascimento , local_nascimento ,
                                              data_falecimento , local_falecimento , sexo , mae_id , pai_id , localizar , atualizado ,
                                              criador_id ,  editor_id , email )
                           VALUES ( $pessoa_id , '$nome', '$sobrenome', '$sufixo', '$data_nascimento', '$local_nascimento',
                                            '', '', '$sexo', $mae_id, $pai_id, '$localizar',
                                             CURRENT_TIMESTAMP , $criador_id , $editor , '$email' ) ";
   }
//   $resp->alert($query); return $resp;
   if ($query) { $e =   $pessoa->Inclui_Altera($query,$resp);  }
   if (is_file($arq)) {
       global $img;
       $im = file_get_contents($arq);
       $query = " update pessoas set foto = :foto where pessoa_id = $pessoa_id ";
       $column = ':foto';
       $e = $img->BLOB_PDO($query, $column, $im, $resp);
       unlink($arq);
   }          
   if ($oper == 'I') { $resp->redirect($_SERVER['PHP_SELF']); // "consulta","innerHTML",$tela); 
   } else { $resp->script('xajax_Retorna_desiste("")'); }
    return $resp;
}

function Listar_Pessoas()  {
    $resp = new xajaxResponse();
    global $pessoa;
    $query = " select pessoa_id, concat(nome, ' ', sobrenome) as nome, 
                data_nascimento, data_falecimento, local_nascimento, localizar, email from pessoas 
                order by nome ";
    $resul = $pessoa->Browse($query,$resp);
    if (is_array($resul))  {
       $tela  = '<table id="clicli" data-toggle="table" class="table table-striped table-bordered"  data-sort-name="Tabela" data-sort-order="desc" />
                    <caption> Pessoas Cadastradas : '.count($resul).'<button type="submit" class="btn btn-primary" onclick="xajax_Retorna_desiste();" style="float: right;">Fechar</button></caption>
                   <thead> 
                    <tr align="Center">
                      <th data-field="nome" data-sortable="true"> Nome</th>
                      <th data-field="data_nasc"   data-sortable="true"> Data Nasc. </th>
                      <th data-field="local_nasc"    data-sortable="true"> Local Nasc.</th>
                      <th data-field="email"      data-sortable="true"> Email </th>
                      <th data-field="endereço"   data-sortable="true"> Endereço </th>
                   </tr></thead>';
      $a = 0; 
      foreach ($resul as $pes)  {
         $pessoa_id = $pes['pessoa_id']; 
         if ($a == 0 || fmod($a, 2) == 0) { $classe =  'class="t_line1"'; } else { $classe =  'class="t_line2"'; }
         $tela .= '<tr '.$classe.'>
                   <td data-field="nome" data-sortable="true" style="text-align: left;" nowrap><input type="image" width="20" height="20" style="border: 2px outset;vertical-align: top;" src="images/icono_buscar.png" onclick="xajax_Altera(xajax.getFormValues(\'tela\'),\''.$pessoa_id.'\'); return false;">&nbsp;&nbsp;'.$pes['nome'].'</td>
                   <td data-field="data_nasc"  data-sortable="true" style="text-align: center;">'.date('d/m/Y',strtotime($pes['data_nascimento'])).'&nbsp;</td>
                   <td data-field="local_nasc" data-sortable="true" style="text-align: left;">'.$pes['local_nascimento'].'&nbsp;</td>
                   <td data-field="email"  data-sortable="true" style="text-align: left;">'.$pes['email'].'&nbsp;</td>
                   <td data-field="endereço"   data-sortable="true" style="text-align: left;">'.$pes['localizar'].'&nbsp;</td>
                  </tr>';
         $a++;
      }   
      $tela .= '<tr></tr></table>'; 
 }
     $resp->assign("div_arvore","innerHTML",''); 
     $resp->assign("principal","className","esconder"); 
     $resp->assign("consulta","className","mostrar"); 
     $resp->assign("consulta","innerHTML",$tela); 
     $resp->script('tabela()');
 return $resp;
}

