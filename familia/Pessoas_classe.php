<?php
/**
 * Description of empresa_classe
 `pessoa_id` smallint(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
 `nome` varchar(50) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
 `sobrenome` varchar(20) NOT NULL,
 `sufixo` varchar(20) NOT NULL,
 `data_nascimento` date NOT NULL DEFAULT '0000-00-00',
 `local_nascimento` varchar(50) NOT NULL,
 `data_falecimento` date NOT NULL DEFAULT '0000-00-00',
 local_falecimento` varchar(50) NOT NULL,
 `sexo` enum('M','F') NOT NULL DEFAULT 'M',
 `mae_id` smallint(5) unsigned zerofill NOT NULL DEFAULT '00000',
 `pai_id` smallint(5) unsigned zerofill NOT NULL DEFAULT '00000',
 `localizar` longtext NOT NULL,
 `atualizado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `criador_id` smallint(6) DEFAULT NULL,
  `editor_id` smallint(6) DEFAULT NULL *
 * @author Joao Goulart
 */
include 'inc/banco_pdo_class.php';

//
class Pessoa_model extends banco_mysql {
 		public $db;
        public  $resul;
		private $pessoa_id;
		private $sobrenome;
		private $sufixo;
		private $data_nascimento;
		private $local_nascimento;
		private $data_falecimento;
		private $local_falecimento;
		private $sexo;
		private $mae_id;
		private $pai_id;
		private $localizar;
		private $aualizado;
		private $criador_id;
		private $editor_id;
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
		}
		public function Busca_login($resp) {
                    $this->resp  = $resp;
                    $this->query  = " SELECT nome,  pessoa_id FROM pessoas  where email like '%@%' order by 1 ";
                    $this->resul = $this->db->mydb_query($this->query,'array',$this->resp);
                    return $this->resul;
		}

		public function Browse($query,$resp) {
                     $this->query = $query; 
                     $this->resul = $this->db->mydb_query($this->query,'array',$this->resp);
                     return $this->resul;
		}
		public function SQL($query,$opera,$resp='') {
                     $this->query = $query; 
                     $this->opera = $opera;
                     $this->resp  = $resp;
                     $this->resul = $this->db->mydb_query($this->query,$this->opera,$this->resp);
                     return $this->resul;
		}
		public function BLOB($table,$column,$blob_data,$where,$resp='') {
                     $this->table = $table; 
                     $this->column = $column;
                     $this->resp  = $resp;
                     $this->blob_data = $blob_data;
                     $this->where  = $where;
                     $this->resul = $this->db->mydb_query_blob($this->table,$this->column,$this->blob_data,$this->where,$this->resp);
                     return $this->resul;
		}
                
		public function AutoComplete($qstring) {
                     $this->query = "  SELECT pessoa_id, CONCAT(nome,' ', sobrenome,' ', sufixo) as nomex
                             FROM pessoas 
                             where UPPER(CONCAT(nome,' ', sobrenome,' ', sufixo)) LIKE '%$qstring%'  ";
                     $this->resul = $this->db->mydb_query($this->query,'array');
                     return $this->resul;
		}
		public function Browse_Genero($tipo) {
                     $this->query = "  select   pessoa_id
                      , CONCAT(nome,' ', sobrenome,' ', sufixo) as nome , data_nascimento
                      from pessoas where sexo = '$tipo' order by nome  ";
                     $this->resul = $this->db->mydb_query($this->query,'array');
                     return $this->resul;
		}
		public function Busca_Birth($mes) {
                       $this->query = " select CONCAT(nome,' ', sobrenome,' ', sufixo) as nome, data_nascimento, 
               LPAD(MONTH(data_nascimento), 2, '0') mes, LPAD(DAY(data_nascimento), 2, '0') dia , pessoa_id 
                 from pessoas where MONTH(data_falecimento) = 00
                 HAVING mes = $mes  order by  dia ";
                     $this->resul = $this->db->mydb_query($this->query,'array');
                     return $this->resul;
                }
                // aniversários de casamento
		public function Busca_Marriage($mes) {
                       $this->query = " SELECT LPAD(MONTH(data_casamento), 2, '0') mes
                                        , data_casamento
                                        , LPAD(DAY(data_casamento), 2, '0') dia
                                        , CONCAT(homem.nome,' ',homem.sobrenome,' ',homem.sufixo) AS marido
                                        , CONCAT(mulher.nome ,' ',mulher.sobrenome,' ',mulher.sufixo)AS esposa  
                                       ,homem.pessoa_id marido_id
                                      , mulher.pessoa_id  esposa_id 
                              FROM casamentos, pessoas AS homem, pessoas AS mulher
                        	where  noivo_id = homem.pessoa_id AND noiva_id = mulher.pessoa_id HAVING mes = $mes order by dia ";
                     $this->resul = $this->db->mydb_query($this->query,'array');
                     return $this->resul;
                }
                // datas de falecimento
		public function Busca_Death($mes) {
                       $this->query = "  select CONCAT(nome,' ', sobrenome,' ', sufixo) as nome, data_falecimento,
                      LPAD(MONTH(data_falecimento), 2, '0') mes, LPAD(DAY(data_falecimento), 2, '0') dia, pessoa_id  
                         from pessoas  HAVING mes = $mes  order by  dia ";
                     $this->resul = $this->db->mydb_query($this->query,'array');
                     return $this->resul;
                }
                // busca casamento
                public function Busca_Casamento($pessoa_id) {
                       $this->query = " SELECT  data_casamento
                                        , CONCAT(homem.nome,' ',homem.sobrenome,' ',homem.sufixo) AS marido
                                        , CONCAT(mulher.nome ,' ',mulher.sobrenome,' ',mulher.sufixo)AS esposa 
                                       ,homem.pessoa_id marido_id
                                      , mulher.pessoa_id  esposa_id 
                                      , local_casamento
                                      , homem.data_falecimento fal_marido
                                      , mulher.data_falecimento fal_esposa 
                              FROM casamentos, pessoas AS homem, pessoas AS mulher
                        	where  noivo_id = homem.pessoa_id AND noiva_id = mulher.pessoa_id  
                                     and ( noivo_id = $pessoa_id or noiva_id = $pessoa_id )  ";
                     $this->resul = $this->db->mydb_query($this->query,'single');
                     return $this->resul;
                }
                public function Elimina_Casamento($pessoa_id) {
                     $this->query = " delete from casamentos where  noivo_id = $pessoa_id or noiva_id = $pessoa_id  ";
                     $this->resul = $this->db->mydb_query($this->query,'sql');
                     return $this->resul;
                }
		public function Busca_Filhos($pessoa_id) {
                       $this->query = " SELECT   CONCAT(pessoas.nome,' ',pessoas.sobrenome,' ',pessoas.sufixo) as filho
                                                ,pessoa_id  filho_id
                                                ,data_falecimento
                          FROM pessoas where   ( mae_id = $pessoa_id or pai_id = $pessoa_id )  ";
                     $this->resul = $this->db->mydb_query($this->query,'array');
                     return $this->resul;
                }
		public function Busca_Irmaos($pessoa_id,$mae_id) {
                       $this->query = " SELECT   CONCAT(pessoas.nome,' ',pessoas.sobrenome,' ',pessoas.sufixo) as irmao
                                       ,pessoa_id  irmao_id, data_falecimento
                                        FROM pessoas
                                	where  mae_id > 0  
                                          and  mae_id    = $mae_id   
                                          and pessoa_id != $pessoa_id  order by 1  ";
                     $this->resul = $this->db->mydb_query($this->query,'array');
                     return $this->resul;
                }
		public function Busca_Pai_Mae($parent_id) {
                       $this->query = " select  CONCAT(nome,' ', sobrenome,' ', sufixo) as nome
                   from pessoas where pessoa_id = '$parent_id' ";
                     $this->resul = $this->db->mydb_query($this->query,'unico');
                     return $this->resul;
                }
		public function Busca_Pessoa($pessoa_id) {
                       $this->query = "  select  *  from pessoas where pessoa_id = $pessoa_id  ";
                     $this->resul = $this->db->mydb_query($this->query,'single');
                     return $this->resul;
                }
		public function Inclui_Altera($query,$resp='') {
                     $this->query = $query;
                     $this->resp  = $resp;
                     $this->resul = $this->db->mydb_query($this->query,'sql',$this->resp);
                     return $this->resul;
		}
		public function Sessao($query,$resp='') {
                     $this->query = $query;
                     $this->resul = $this->db->mydb_query($this->query,'sql');
                     return $this->resul;
		}
 
        	public function Novo_Id() {
                     $this->query = " select  (max(pessoa_id) + 1) from pessoas "; 
                     $this->resul = $this->db->mydb_query($this->query,'unico');
                     return $this->resul;
		}
        	public function Data_Nasc($pessoa_id,$resp) {
                     $this->query = "  select data_nascimento from pessoas where pessoa_id = $pessoa_id
                                       and data_nascimento != '0000-00-00' "; 
                     $this->resp  = $resp;
                     $this->resul = $this->db->mydb_query($this->query,'unico',$this->resp);
                     return $this->resul;
		}
		public function setId($pessoa_id)  {
                    $this->pessoa_id = $pessoa_id;
                }
		public function setNome($nome)  {
                    $this->nome = $nome;
                }
		public function getId($pessoa_id)  {
                    return $this->pessoa_id;
                }
		public function getNome($nome)  {
                    return $this->nome;
                }
	}
 /*       
SELECT DISTINCT pessoa_id, nome
FROM pessoas
WHERE MONTH( data_falecimento ) =00
AND sexo != 'M'
AND NOT
EXISTS (

SELECT 1
FROM casamentos
WHERE pessoa_id = noivo_id
OR pessoa_id = noiva_id
)
LIMIT 0 , 30
  * 
  */