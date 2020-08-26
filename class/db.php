<?php
class DB{

	private $host = 'localhost';
	private $username = 'root';
	private $password = '';
	private $database = 'boutique';
	public $db;

//initialisation du constructeur
	public function __construct($host = null, $username = null, $password = null, $database = null){
		if($host != null){
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;
		}
		try{
			$this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password,
			// on interragit avec la BDD en UTF8 ce qui empêche les problèmes d'accent
			// indique la requête sql à lancer quand on se connecte
			array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
			//mode d'erreur pour avoir des warning
					PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
				));
		//récupération des erreurs
		}catch(PDOException $e)
		{
			die('<h1>Impossible de se connecter a la BDD</h1>');
		}
	}

	public function connectDb(){
        try{
			$this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password,
			// on interragit avec la BDD en UTF8 ce qui empêche les problèmes d'accent
			// indique la requête sql à lancer quand on se connecte
			array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
			//mode d'erreur pour avoir des warning
					PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
				));
		    return $this->db;
		//récupération des erreurs
		}catch(PDOException $e)
		{
			die('<h1>Impossible de se connecter a la BDD</h1>');
		}
    }


//méthode qui permet de faire une requête rapidement, prend en paramètre la requête à faire
// pour faire une requête : $DB->query('SELECT * FROM table')
	public function query($sql, $data = array()){
		$req =$this->db->prepare($sql);
		$req->execute($data);
//le résultat est retourné sous forme d'objet
		return $req->fetchAll(PDO::FETCH_OBJ);
	}



	//pour faire une req insert into :
	//$ins=array('','','','');
	//$a->insert('matable',$ins,null);
	public function insert($table,$value,$row=null){
		$insert= " INSERT INTO ".$table;
		if($row!=null){
			$insert.=" (". $row." ) ";
		}
		for($i=0; $i<count($value); $i++){
			if(is_string($value[$i])){
				$value[$i]= '"'. $value[$i] . '"';
			}
		}
		$value=implode(',',$value);
		$insert.=' VALUES ('.$value.')';
		$ins=$this->db->query($insert);
		if($ins){
			return true;
		}else{
			return false;
			}
		}

		public function delete($table,$where=null){
			if($where == null)
	            {
	                $delete = "DELETE ".$table;
	            }
	            else
	            {
	                $delete = "DELETE  FROM ".$table." WHERE ".$where;
	            }
				$del=$this->db->query($delete);
				if($del){
					return true;
				}else{
					return false;
				}
		}
}
