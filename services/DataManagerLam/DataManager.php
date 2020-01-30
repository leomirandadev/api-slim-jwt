<?php  
namespace DataManagerLam;
use \PDO;

use Settings\ConfigDB;

class DataManager extends ConfigDB{

	protected $db = null;

	private $dsn;
	private $user;
	private $pass;

	protected $table = null;
	public $data = array();
	public $condition = null;
	public $conditionLike = null;
	public $orderBy = null;
	public $orderByInnerTable = null;
	public $errorDB = null;

	/**
	 * settings
	 *
	 * @return void
	 */
	private function settings() {
		$this->dsn = "mysql:dbname=".$this->getDBName()."; host=".$this->getHost();
		$this->user = $this->getUser();
		$this->pass = $this->getPassword();
	}

	/**
	 * open
	 *
	 * @return void
	 */
	protected function open(){
		$this->settings();
		try{
			$options= array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
			$this->db = new PDO($this->dsn, $this->user, $this->pass, $options);
			return $this->db;
		}catch (PDOException $e){
			echo 'Connection failed: '.$e->getMessage();
		}
	}

	/**
	 * close
	 *
	 * @return void
	 */
	protected function close(){
		$this->db = null;
		return true;
	}

	/**
	 * insert
	 *
	 * @return void
	 */
	protected function insert(){
		$this->open();
		$conector = $this->db;

		$first = 0;
		$values = null;
		$camps = null;
		//camps to create
		foreach ($this->data as $camp => $value) {
			if($first==1){
				$camps.=",";
				$values.=",";
			}
			$camps .= $camp;
			$values .= "\"".$value."\"";
			$first=1;
		}
		$sql = "INSERT INTO $this->table ($camps) VALUES ($values)";
		//try to insert
		try{
			$conector->exec($sql);
			$this->close();
			return $conector->lastInsertId();

		}catch (Exception $e) {
			$this->errorDB = $e;
			$this->close();
			return FALSE;
		}
	}

	/**
	 * update
	 *
	 * @return void
	 */
	protected function update(){
		$this->open();
		$conector = $this->db;

		$first = false;
		$camps = null;
		//camps to update
		foreach ($this->data as $camp => $value) {
			//para corrigir o erro de virgula e ponto transmitido pelo foreach
			$valueFloated = $this->isFloat($value);
			$value = !$valueFloated ? $value : $valueFloated ;

			if($first) $camps.=",";

			$camps .= $camp."=\"$value\"";
			$first = true;

		}
		//conditions of selection 
		$conditions = $this->conditionFormat();
		$sql = "UPDATE $this->table SET $camps WHERE $conditions ";
		//try to update
		return $this->tryCatch($sql,$conector);

	}

	/**
	 * delete
	 *
	 * @return void
	 */
	protected function delete(){
		$this->open();
		$conector = $this->db;
		//conditions for selection 
		$conditions = $this->conditionFormat();
		$sql = "DELETE FROM $this->table WHERE $conditions ";
		//try to delete
		return $this->tryCatch($sql,$conector);
	}

	/**
	 * select
	 *
	 * @return void
	 */
	protected function select(){
		$this->open();
		$conector = $this->db;
		
		$innerJoin = (isset($this->innerJoin)) ? "INNER JOIN ".$this->innerJoin['table']." ON $this->table.".$this->innerJoin["camps"][0]." = ".$this->innerJoin['table'].".".$this->innerJoin['camps'][1] : "";
		$anotherCamp = (isset($this->innerJoin)) ? $this->innerJoin['table'].".*," : "";
		
		// config order by to sql query
		if ( !empty($this->orderBy) ) {
			$orderBySelected = $this->table.".".$this->orderBy;
		} elseif ( empty($this->orderBy) && !empty($this->orderByInnerTable) )	{
			$orderBySelected = $this->innerJoin['table'].".".$this->orderByInnerTable;
		} else{
			$orderBySelected = $this->table.".id DESC";
		}

		//conditions for selection
		if($this->condition !== null){
			$conditions = $this->conditionFormat();
			if ($this->conditionLike !== null) {
				$conditionsLike = $this->conditionLikeFormat();
				$sql = "SELECT $anotherCamp $this->table.* FROM $this->table $innerJoin WHERE $conditions AND $conditionsLike ORDER BY $orderBySelected";
			} else {
				$sql = "SELECT $anotherCamp $this->table.* FROM $this->table $innerJoin WHERE $conditions ORDER BY $orderBySelected";
			}
		}else{
			if ($this->conditionLike !== null) {
				$conditionsLike = $this->conditionLikeFormat();
				$sql = "SELECT $anotherCamp $this->table.* FROM $this->table $innerJoin WHERE $conditionsLike ORDER BY $orderBySelected";
			} else {
				$sql = "SELECT $anotherCamp $this->table.* FROM $this->table $innerJoin ORDER BY $orderBySelected";
			}
		}

		return $this->querySelect($sql,$conector);

	}

	/**
	 * conditionFormat
	 *
	 * @return void
	 */
	private function conditionFormat(){
		$first = false;
		$conditions = null;
		foreach ($this->condition as $camp => $value) {
			if($first)	$conditions .= "AND";

			$first = true;
			$conditions .= " $this->table.$camp = \"$value\" ";
		}
		return $conditions;
	}
	
	/**
	 * conditionLikeFormat
	 *
	 * @return void
	 */
	private function conditionLikeFormat(){
		$first = false;
		$conditions = null;
		foreach ($this->conditionLike as $camp => $value) {
			if($first) $conditions .= "AND";

			$first = true;
			$conditions .= " $this->table.$camp LIKE \"%$value%\" ";
		}
		return $conditions;
	}

	/**
	 * querySelect
	 *
	 * @param  mixed $sql
	 * @param  mixed $conector
	 *
	 * @return void
	 */
	private function querySelect($sql, $conector) {
		$pesquisaSql = $conector->query($sql);
		$rows = $pesquisaSql->rowCount();
		if($rows<1){
			$this->close();
			return FALSE;
		}
		$dados = $pesquisaSql->fetchAll();
		$this->close();

		return $dados;
	}

	/**
	 * tryCatch
	 *
	 * @param  mixed $sql
	 * @param  mixed $conector
	 *
	 * @return void
	 */
	private function tryCatch($sql, $conector) {
		try{
			$conector->exec($sql);
			$this->close();
			return true;
		}catch(Exception $e){
			$this->errorDB = $e;
			$this->close();
			return false;
		}
	}

	private function isFloat($value){
		$pos = strpos($value, ",");
		if($pos !== false){
			$x = explode (",", $value);
			if(!empty($x[0])&&is_numeric($x[0][-1])&&is_numeric($x[1][0])){
				return $value = $x[0].".".$x[1];
			}
		}
		return false;
	}

}