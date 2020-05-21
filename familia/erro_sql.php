<?php
require_once 'classes/sessao.php';
?>
<html>
<header>
    <title> Erro </title>
</header>
<body>
<?php

    //parametros do erro
    $tipo   = urldecode($_GET['tipo']);
    $msg    = urldecode($_GET['msg']);
    $sql    = urldecode($_GET['sql']);
    //usuario
    $sessao    = new Session; 
    $usu    = $sessao->get("login_nome");
    //dados da sessao
    $ori   = $_SERVER["HTTP_REFERER"];
    $brw   = $_SERVER["HTTP_USER_AGENT"];
    $ip    = $_SERVER["REMOTE_ADDR"];
    $pos   = 0;
    // montando o texto
    if ($pos>0) {
      $ltr_ini = strrpos(substr($sql,0,$pos), ' ');
      $ltr_fim = strpos($sql, ' ', $pos);

      $txt    = substr($sql,0, ($ltr_ini)).'<font color=red>';
      $txt   .= substr($sql,$ltr_ini,($ltr_fim-$ltr_ini)).'</font>';
      $txt   .= substr($sql,$ltr_fim);
    } else {
      $txt    = $sql;
    }

      $from     = "Erro <joao.goulart@pettenati.com.br>";
      $to       = "goulart.joao@gmail.com";
      $subj     = "Controle de Erros ";

      $body     = '<html><head></head><body>
                   <p>O usuário: '.$usu.'
                   <p>Na Máquina: '.$ip.'
                   <p>Usando o Browser: '.$brw.'
                   <p>Página: '.$ori.'
                   <p>Erro: '.$msg.'
                   <p><b>'.$sql.'</b></body></hmtl>';

      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $headers .= "From: $from";
//      mail( $to, $subj, $body, $headers);
?>
<div style="width:100%; height:50px; background:#FFFF99; vertical-align:top; line-height:60px;" >
    &nbsp;
    <img src="img/alerta_erro.gif" width="40px" height="40px"/>
    &nbsp;
    Atenção! <?php echo($tipo);?>
</div>
  <p> <?php echo($msg); ?> </p>
  <p> &nbsp;<?php echo($txt);?> </p>
  <br />
  &nbsp;Responsável Avisado.
  &nbsp;
  <a href="javascript: window.close()" target="_self" >Fechar Tela</a>
</body>
</html>