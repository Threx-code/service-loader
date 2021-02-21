<?php
/**
 * @package BetkingDBModule
*/

namespace App\Controller;

class Table
{
	private $db;

	public function register()
	{
		$this->db = new Database();

		try{
			$query = $this->db->query("CREATE TABLE IF NOT EXISTS  user(
	    id serial NOT NULL,
	    firstname VARCHAR(100),
	    lastname VARCHAR(100),
	    date_of_birth timestamp,
	    PRIMARY KEY(id))");
		$this->db->execute($query);

		}
		catch( \PDOException $e){
			echo  "Table user error: ".$e->getMessage();
		}


	}
}