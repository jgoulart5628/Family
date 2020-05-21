<?php 
error_reporting(0);
require_once "../inc/banco_pdo_class.php";
$db = new banco_mysql;
$db->mydb_connect();
$ip=$_SERVER['REMOTE_ADDR'];
$d=date("Y-m-d H:i:s",time());
$d10=date("Y-m-d H:i:s",time()-864000);
if ($op=="insert"){
  if ($text!="") { $query = "insert into chat (date,name,text,ip,color) values ('$d','$name','$text','$ip','$color' ) ";
      $e =  $db->mydb_query($query,'sql'); 
      echo $query.'-'.$e;
  }
}
$db->mydb_query("delete from chat where date < '$d10' ",'sql');
$result = $db->mydb_query("select date,name,text,color from chat order by date desc limit 10",'array');
$data .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"1\">";
for ($i = 0; $i < count($result); $i++)  {
     $color  = $result[$i]['color'];  
     $data   = $result[$i]['date'];  
     $nome   = $result[$i]['name'];  
     $texto  = $result[$i]['text'];  
 $data .= "<tr style=\"color:black;font:bold 8px Tahoma;background-color:$color;\"><td valign=\"top\" align=\"left\" style=\"width:50px;\">$data</td>";
  $data .= "<td valign=\"top\" align=\"left\">$nome</td>";
  $data .= "<td valign=\"top\" style=\"width:200px;text-wrap:hard-wrap;\" align=\"left\">".wordwrap($texto, 40, '<br>',true)."</td><tr>";
}
$data .="</table>";
print $data;
?>
