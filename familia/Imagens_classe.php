<?php
/**
 * Descrição tabela Imagem_info :  Informação das Imagens
  Field 	Type 	Null 	Key 	Default 	Extra 	
imagem_id 	smallint(5) unsigned zerofill	NO 	PRI 	
album_id 	varchar(50)	NO 		NULL	
titulo 	varchar(30)	NO 			
data 	date	NO 	MUL 	0000-00-00	
narrativa 	varchar(255)	NO 		
imagem 	blob,
 * @author Joao Goulart
 */
// include 'inc/banco_ado_class.php';
class Imagens_model extends banco_mysql {
 		public $db;
                public  $resul;
		private $imagem_id;
		private $nome_album;
		private $titulo;
		private $data;
                private $imagem;
                private $query;
                private $opera;
                private $resp;
                private $table;
                private $column;
                private $blob_data;
                private $where;
                private $linhas;
    public function __construct() {
                    $this->db = new banco_mysql;
//                    $this->db->mydb_connect();
		}
		public function Browse($query,$resp='') {
                     $this->query = $query; 
                     $this->resp  = $resp;
                     $this->resul = $this->db->mydb_query($this->query,'array',$resp);
                     return $this->resul;
		}
		public function SQL($query,$opera,$resp='') {
                     $this->query = $query; 
                     $this->opera = $opera;
                     $this->resp  = $resp;
                     $this->resul = $this->db->mydb_query($this->query,$this->opera,$this->resp);
                     return $this->resul;
		}
		public function BLOB2($table,$column,$blob_data,$where,$resp='') {
                     $this->table = $table; 
                     $this->column = $column;
                     $this->resp  = $resp;
                     $this->blob_data = $blob_data;
                     $this->where  = $where;
                     $this->resul = $this->db->mydb_query_blob($this->table,$this->column,$this->blob_data,$this->where,$this->resp);
                     return $this->resul;
		}
		public function BLOB_PDO($query,$column,$blob_data,$resp='') {
                     $this->query  = $query;
                     $this->column = $column;
                     $this->resp  = $resp;
                     $this->blob_data = $blob_data;
                     $this->resul = $this->db->mydb_query_blob($this->query,$this->column,$this->blob_data,$this->resp);
                     return $this->resul;
		}

                public function Inclui_Altera_Exclui($query,$resp='') {
                     $this->query = $query;
                     $this->resp  = $resp;
                     $this->resul = $this->db->mydb_query($this->query,'sql',$this->resp);
                     return $this->resul;
		}
        	public function Novo_Id_Album() {
                     $this->query = " select  (max(album_id) + 1) from album "; 
                     $this->resul = $this->db->mydb_query($this->query,'unico');
                     return $this->resul;
		}
        	public function Novo_Id_Imagem() {
                     $this->query = " select  (max(imagem_id) + 1) from imagens "; 
                     $this->resul = $this->db->mydb_query($this->query,'unico');
                     return $this->resul;
		}
  
 		public function setId($imagem_id)  {
                    $this->imagem_id = $imagem_id;
                }
		public function setNome($nome_album)  {
                    $this->nome_album = $nome_album;
                }
		public function getId($imagem_id)  {
                    return $this->imagem_id;
                }
		public function getNome($nome_album)  {
                    return $this->nome_album;
                }
	}
