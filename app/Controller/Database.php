<?php
/**
 * @package BetkingDBModule
*/
namespace App\Controller;

class Database
{
	private $host = DB_HOST;
	private $db	  = DB_NAME;
	private $port =	DB_PORT;
	private $user = DB_USER;
	private $pass =	DB_PASS;

	public $conn;
	public $error;


	public function __construct()
	{
		$dns = "pgsql:host=" . $this->host . ";port=" .$this->port . ";dbname=" . $this->db;
		$option = array(
			\PDO::ATTR_PERSISTENT => TRUE,
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
		);

		try {
			$this->conn = new \PDO( $dns, $this->user, $this->pass, $option );
		
		} catch (\PDOException $e) {
			throw new \Exception("Error Reading Database Configuration: " . $e->getMessage(), 1);
			
		}
	}


		/*
	==========================================================================================
	database query setup
	==========================================================================================
	*/
	public function query($query){
		$this->stmt = $this->conn->prepare($query, [\PDO::ATTR_CURSOR=>\PDO::CURSOR_FWDONLY]);
	}
	
	/*
	==========================================================================================
	database bind the statement
	==========================================================================================
	*/
	public function bindStatement($param, $value, $type=NULL){
		if(is_null($type)){
			switch (TRUE) {
				case is_int($value):
					$type = \PDO::PARAM_INT;
					break;

				case is_bool($value):
					$type = \PDO::PARAM_BOOL;
					break;

				case is_null($value):
					$type = \PDO::PARAM_NULL;
					break;
				
				default:
					$type = \PDO::PARAM_STR;
					break;
			}
		}

	$this->stmt->bindValue($param, $value, $type);
	}


	/*
	==========================================================================================
	EXECUTING THE STATEMENT
	==========================================================================================
	*/
	 public function execute(){
	 	return $this->stmt->execute();
	 }
	

	/*
	=========================================================================================
	FETCHING ALL DATA AT ONCE
	=========================================================================================
	*/

	public function fetchAll(){
		$this->execute();
		return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
	}


	/*
	=========================================================================================
	FETCH ONLY A SINGLE DATA
	=========================================================================================
	*/

	public function fetchSingle(){
		$this->execute();
		return $this->stmt->fetch(\PDO::FETCH_OBJ);
	}

	public function numCounter(){
		$this->execute();
		$num = $this->stmt->fetchColumn();
		return $num;

	}

}