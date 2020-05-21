<?php
require_once("Imagens_classe.php");
$img = new Imagens_model();
function Album_Fotos($album_ant='')  {
    $resp = new xajaxResponse();
    if (!isset($_COOKIE["Familia"])) { $resp->script('xajax_Logout()'); return $resp; } 
    global $img;
    // QUERY LISTA DE ALBUNS
    $query = " Select DISTINCT  a.album_id, a.nome_album
                 ,(select count(imagem_id) from imagens b where b.album_id = a.album_id) imgs 
                from album a ";  		
    $resul = $img->Browse($query,$resp);
    $oper = 'I';
    $tela .= '<table id="lista_album" border="1">
                <caption><a href="#"><input type="button" value="Novo Album" onclick="xajax_Tela_Album(xajax.getFormValues(\'tela\'),\'\',\''.I.'\',\'\'); return false;">
                 <span>Incluir Novo Album.</span></a></caption>
                <tr class="cab">
                    <th>Nome Album</th>
                    <th>Imagens</th>
                </tr>'; 
    $x = count($resul);
    for ($a = 0; $a < count($resul); $a++)  {
         if ($a == 0 || fmod($a, 2) == 0) $classe =  'class="t_line1"'; else $classe =  'class="t_line2"';
         $album_id   = $resul[$a]['album_id'];
         $nome_album = $resul[$a]['nome_album'];
         $qtd_img    = $resul[$a]['imgs'];
         $tela .= '<tr '.$classe.'>
                    <td><input type="text" class="entra" name="nome_album_'.$a.'" size="40" maxlength="40"value="'.$nome_album.'">'.$album_ant.'
                        <a href="#"><input type="image" src="images/edit-icon.png" border="0" width="24" height="24" onclick="xajax_CRUD_Album(xajax.getFormValues(\'tela\'),\''.$album_id.'\',\''.A.'\',\''.$a.'\'); return false;">
                        <span>Alterar o nome do Album.</span></a>
                        <a href="#"><input type="image" src="images/lixeira1.png"  border="0" width="24" height="24" onclick="xajax_CRUD_Album(xajax.getFormValues(\'tela\'),\''.$album_id.'\',\''.E.'\',\''.$a.'\'); return false;">
                        <span>Excluir Album.</span></a>
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;'.$qtd_img.'<a href="#" style="float: right;"><input type="image" src="images/Pictures-icon.png"  border="0" width="32" height="32" onclick="xajax_Lista_Fotos_Album(\''.$album_id.'\',\''.$a.'\',\''.$x.'\'); return false;">
                        <span>Manter fotos deste Album</span></a>
                        <a href="#"><input type="image" src="images/slideshow-icon.png"  border="0" width="32" height="32" onclick="xajax_Monta_Album(\''.$album_id.'\'); return false;"><span>Ver Slide Show das Fotos deste Album</span></a>     
                    </td>
                   </tr>
                   <tr><td><div id="fotos_album_'.$a.'"></div>';     
         if ($album_id === $album_ant) { $script = "xajax_Lista_Fotos_Album('$album_id','$a','$x')"; }
    }               
//    $resp->alert($script); return $resp;
    $tela .= '<tr '.$classe.'>
                <td><div id="inclui_album_99"></div></td>
              </tr>
           </table>';
    $resp->assign("div_arvore","innerHTML",''); 
    $resp->assign("principal","className","esconder"); 
    $resp->assign("consulta","className","mostrar"); 
    $resp->assign("consulta","innerHTML",$tela); 
    if ($album_ant) { $resp->script($script); }
return $resp;
}

function Monta_Album($album_id) {
    $resp = new xajaxResponse();
    $dir = './Album_'.$album_id.'/';
    foreach(new DirectoryIterator($dir) as $file)  {
       if (substr($file,0,1) <> '.')  {
          $ff = explode('.',$file); 
          if ($ff[1]  === 'jpg') { unlink($dir.$file); $lista .= $ff[0];}
       }
    }
    global $img;
    $query = " Select imagem_id, titulo, data, imagem
                from imagens  where album_id = $album_id order by data ";  	
    $resul = $img->Browse($query,$resp);
    for ($a = 0; $a < count($resul); $a++)  {
         $imagem_id   = $resul[$a]['imagem_id'];
         $titulo      = just_clean($resul[$a]['titulo']);
         $imagem      = $resul[$a]['imagem'];
         $nome_foto   = $titulo.'.jpg';
         if (!$titulo) { $nome_foto = 'Foto'.$imagem_id.'.jpg'; }
         $arq_foto = 'Album_'.$album_id.'/'.$nome_foto;
         if ($imagem)  { 
            $fh = fopen($arq_foto,'w');
            fwrite($fh,$imagem);
            fclose($fh);
         }
    }
//    <a href="Album_'.$album_id.'/phpshow.php" target="_blank"><img src="images/slideshow-icon.png"  border="0" width="32" height="32"><span>Ver Slide Show das Fotos deste Album</span></a>     
//    $resp->alert($lista);
//    $script = '<script type="text/javascript" id="runscript"> window.open("Album_'.$album_id.'/phpshow.php"); alert("running from main");
//               </script>';
    $url = 'https://'.$_SERVER['HTTP_HOST'].'/familia/Album_'.$album_id.'/phpshow.php';
    $resp->script("Saida('$url');");
    return $resp;     
}

function Tela_Album($dados, $album_id, $oper, $a)  {
    $resp = new xajaxResponse();
    $a = 99;
    $tela = '<input type="text" class="entra" name="nome_album_99" size="40" maxlength="40"value="">
             <a href="#"><input type="image" src="images/edit-icon.png" border="0" width="24" height="24" onclick="xajax_CRUD_Album(xajax.getFormValues(\'tela\'),\''.$album_id.'\',\''.I.'\',\''.$a.'\'); return false;">
             <span>Clique para Gravar!</span></a>';
//    $resp->alert($album_id.'-'.$oper.'-'.$dados['nome_album_'.$a]);    
    $resp->assign("inclui_album_99","innerHTML",$tela);
    return $resp;     
}

function  CRUD_Album($dados, $album_id, $oper,$a) {
    $resp = new xajaxResponse();
    global $img;
    $nome_album = $dados['nome_album_'.$a];
    switch ($oper) { 
     case 'A': if ($album_id && $nome_album) {  $query = " update album set nome_album = '$nome_album' where album_id = $album_id "; }
               break;
     case 'E': if ($album_id) {  $query = " delete from album  where album_id = $album_id "; } break;
     case 'I': $album_id = $img->Novo_Id_Album(); 
              if ($album_id && $nome_album ) {  $query = " insert into album values($album_id, '$nome_album') "; }
              break;
    }
    if ($query) { $e = $img->Inclui_Altera_Exclui($query,$resp); }
    if (!file_exists('Album_'.$album_id)) {
        mkdir('Album_'.$album_id, 0777, true);
    }    
    $srcFile = "phpshow.php";
    $dstFile = "Album_$album_id/phpshow.php";
    if (!file_exists($dstFile)) {
       if (!copy($srcFile, $dstFile)) {
          $resp->alert("Copia d programa falhou!");
       }   
    } 
//    $resp->alert($album_id.'-'.$nome_album.'-'.$dstFile);
    $resp->script('xajax_Album_Fotos()');
    return $resp;     
}

function Lista_Fotos_Album($album_id, $b, $x)  {
    $resp = new xajaxResponse();
//    $resp->alert($album_id.'-'.$a);
    for ($z = 0; $z < $x; $z++) {
        $resp->assign("fotos_album_$z","innerHTML",''); 
    }

    global $img;
    $query = " Select a.imagem_id, a.titulo, a.data, a.imagem
                from imagens a
                  where a.album_id = $album_id order by a.data ";  	
    $resul = $img->Browse($query,$resp);
    $tela .= '<table id="lista_fotos_'.$album_id.'" border="1">
                <caption><a href="#"><input type="button" value="Inclui imagem" onclick="xajax_Tela_Foto(xajax.getFormValues(\'tela\'),\''.$album_id.'\',\''.I.'\',\''.$b.'\'); return false;">
                 <span>Incluir Nova Imagem.</span></a></caption>
                 <tr class="t_line1">
                    <td colspan="3"><div id="inclui_foto_99_'.$album_id.'"></div></td>
                </tr>'; 
    for ($a = 0; $a < count($resul); $a++)  {
         if ($a == 0 || fmod($a, 2) == 0) $classe =  'class="t_line1"'; else $classe =  'class="t_line2"';
         $imagem_id   = $resul[$a]['imagem_id'];
         $titulo      = $resul[$a]['titulo'];
         $imagem      = $resul[$a]['imagem'];
         $arq_foto = 'Album_'.$album_id.'/Foto'.$imagem_id.'.jpg';
         if ($imagem)  { 
            $fh = fopen($arq_foto,'w');
            fwrite($fh,$imagem);
            fclose($fh);
            list($larg, $alt) = getimagesize($arq_foto);
            if ($larg > 96) { $larg = 96; }
            if ($alt > 96)  {$alt = 96; }
               $tel_foto = '<img src="'.$arq_foto.'" id="fotop_'.$album_id.'_'.$a.'"  class="magnify" width="'.$larg.'"  height="'.$alt.'">';
               }   else  {   $tel_foto = 'Carregue sua foto aqui! '; } 
//                                            <font style="font-size: 0.7em;">
//                             Carregar Imagem: <input type="file" class="entra" size="20" name="imagem_carga" onchange="micoxUpload(this.form,\'carga_arq.php?name='.$arq_foto.'\',\'recebe_up_3\',\'Carregando...\',\'Erro ao carregar\')" />
//                                <div id="recebe_up_3" class="recebe"></div>

         $tela .= '<tr '.$classe.'>
                    <td><div>'.$tel_foto.'<input type="hidden" name="album_id_'.$a.'" value="'.$album_id.'">
                             <input type="hidden" name="imagem_id_'.$album_id.'_'.$a.'" value="'.$imagem_id.'">
                             <input type="hidden" name="Foto_'.$album_id.'_'.$a.'" value="'.$arq_foto.'">
                            Titulo:<input type="text" class="entra" name="titulo_'.$album_id.'_'.$a.'" size="30" maxlength="30"value="'.$titulo.'"></font>
                     </div>  
                    <td><a href="#"><input type="image" src="images/edit-icon.png" border="0" width="24" height="24" onclick="xajax_CRUD_Imagens(xajax.getFormValues(\'tela\'),\''.$album_id.'\',\''.A.'\',\''.$a.'\'); return false;">
                      <span>Alterar o nome da Imagem.</span></a>
                        <a href="#"><input type="image" src="images/lixeira1.png"  border="0" width="24" height="24" onclick="xajax_CRUD_Imagens(xajax.getFormValues(\'tela\'),\''.$album_id.'\',\''.E.'\',\''.$a.'\'); return false;">
                        <span>Excluir Imagem.</span></a>
                    </td>
                   </tr>';
    }               
    $tela .= '</table>';
    $resp->assign("fotos_album_$b","innerHTML",$tela); 
    for ($a = 0; $a < count($resul); $a++)  {
        $var = $album_id.'_'.$a;
        $resp->script("jQuery(fotop_$var).imageMagnify({ magnifyby: 3 })");
    }
    return $resp;     
}

function Tela_Foto($dados, $album_id, $oper, $b)  {
    $resp = new xajaxResponse();
    $a = 99;
    global $img;
    $imagem_id = $img->Novo_Id_Imagem();
    if (!$imagem_id)  { $imagem_id = 1; }
    $arq_foto = 'Album_'.$album_id.'/Foto'.$imagem_id.'.jpg';
    $tela = '<div style="border: 3px outset;">
                <div style="float: left; border 3px outset;"><a href="#"><input type="image" src="images/edit-icon.png" border="0" width="32" height="32" onclick="xajax_CRUD_Imagens(xajax.getFormValues(\'tela\'),\''.$album_id.'\',\''.I.'\',\''.$a.'\'); return false;">
                   <span>Incluir os dados da Imagem.</span></a>
                </div>   
                   <input type="hidden" name="Foto_'.$album_id.'_99" value="'.$arq_foto.'">
                   <input type="hidden" name="imagem_id_'.$album_id.'_99" value="'.$imagem_id.'">
                <div>Titulo:<input type="text" class="entra" name="titulo_'.$album_id.'_99" size="30" maxlength="30"value=""></div>
                <div><font style="font-size: 0.7em;">
                     Carregar Imagem: <input type="file" class="entra" size="20" name="imagem_carga" onchange="micoxUpload(this.form,\'carga_arq.php?name='.$arq_foto.'\',\'recebe_up_3\',\'Carregando...\',\'Erro ao carregar\')" />
                     <div id="recebe_up_3" class="recebe"></div></font>
                </div>
             </div>';
//    $resp->alert($album_id.'-'.$oper.'-'.$dados['nome_album_'.$a]);    
    $resp->assign("inclui_foto_99_$album_id", "innerHTML", $tela);
    return $resp;     
}

function  CRUD_Imagens($dados, $album_id, $oper,$a) {
    $resp = new xajaxResponse();
    global $img;
    $titulo    = $dados['titulo_'.$album_id.'_'.$a];
    $imagem_id = $dados['imagem_id_'.$album_id.'_'.$a];
    $imagem    = $dados['Foto_'.$album_id.'_'.$a];
    $album_ant = '';
//    $resp->alert($titulo.'-'.$imagem_id.'-'.$album_id.'-'.$imagem.'-'.$a);  return $resp;  
    switch ($oper) { 
     case 'A': if ($titulo) {  $query = " update imagens set titulo = '$titulo'
                  where imagem_id = $imagem_id "; }
               $e = $img->Inclui_Altera_Exclui($query,$resp);
               break;
     case 'E': if ($imagem_id) {  $query = " delete from imagens where imagem_id = $imagem_id "; }
                                  $e = $img->Inclui_Altera_Exclui($query,$resp);
                                  if (is_file($imagem)) { unlink($imagem); }          
                                  break;
     case 'I': if ($imagem_id) { 
                  if (is_file($imagem)) {
                      $im = file_get_contents($imagem); 
                      $query = " insert into imagens (imagem_id, album_id, titulo, data, imagem)
                                      values ($imagem_id, $album_id, '$titulo', CURRENT_TIMESTAMP, :imagem ) "; 
                      $album_ant = $album_id;
                      $column = ':imagem';
                      $e = $img->BLOB_PDO($query, $column, $im, $resp);
                  } 
//                  $resp->alert('aqui - '.$query.'-'.$e);  return $resp;  
               }
    }
//    $resp->alert($query.'-'.$e);  return $resp;  
    /*
    if ($oper !== 'E')  {
       $e = $img->Inclui_Altera_Exclui($query,$resp);
       if (is_file($imagem)) {
          $im = file_get_contents($imagem);
          $where = ' imagem_id  = '.$imagem_id;
          $img->BLOB2('imagens','imagem',$im,$where,$resp);
          unlink($imagem);
       }          
   }  
     * 
     */
//    $resp->alert($query.'-'.$album_id.'-'.$oper.'-'.$dados['nome_album_'.$a].'-'.$a);    
    $resp->script("xajax_Album_Fotos('$album_ant')");
//    $resp->script("xajax_Lista_Fotos($album_id, $a, 0)");
    return $resp;         return $resp; 
}   
    