<?php
/**
 * Descrição tabela Imagem_info :  Informação das Imagens
  Field 	Type 	Null 	Key 	Default 	Extra 	
pessoa_d 	smallint(5) unsigned zerofill	NO 	PRI 	
data 	datetime	NO 	MUL 	0000-00-00	
texto 	varchar(250)	NO 		
 * @author Joao Goulart
 */
class Chat_model extends banco_mysql {
 		public $db;
                public  $resul;
		private $pessoa_id;
		private $nome;
		private $texto;
		private $data;
                private $query;
                private $resp;
                private $table;
                private $column;
                private $tela;
                private $opera;
    public function __construct() {
                    $this->db = new banco_mysql;
//            $this->db->mydb_connect();
		}
		public function Browse($resp='') {
            $this->query = " Select pessoa_id, nome, data, texto from chat  where data >  (DATE_SUB(NOW(), INTERVAL 2 DAY))  order by data desc limit 0, 20"; 
            $res = $this->db->mydb_query($this->query,'array',$resp);
            $this->tela = '<div id="chat_container">';
            if ($res)  {
               foreach ($res as $ch) {
                  $this->tela .= '<div class="conversa"><div class="user">'.$ch['nome'].': &nbsp;&nbsp;&nbsp;</div><div class="texto">'.$ch['texto'].'</div></div><hr>';      
               }
            }
            $this->tela .= '</div>';
            return $this->tela;
		}

		public function SQL($query,$opera,$resp='') {
                     $this->resul = $this->db->mydb_query($query,$opera,$resp);
                     return $this->resul;
		}
  
 		public function setId($pessoa_id)  {
                    $this->pessoa_id = $pessoa_id;
                }
		public function setTexto($texto)  {
                    $this->texto = $texto;
                }
		public function getId($pessoa_id)  {
                    return $this->pessoa_id;
                }
		public function getTexto($texto)  {
                    return $this->texto;
                }
	}
