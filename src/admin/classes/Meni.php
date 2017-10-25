<?php 

	class Meni extends Db{

		public $mid, 
			   $meni_ime,
			   $en_ime;
	

	public function __construct(){
		parent::__construct();
	}


	public function getMeni(){

		//var_dump($this->pdo);
		 $sql="SELECT mid, meni_ime, en_ime FROM meni ORDER BY mid";
		 $stmt = $this->pdo->prepare($sql);
		 $stmt->execute();	

		  $result = $stmt->fetchAll();
	 	  return $result;
		 
	}

	public function chooseMeni($value){

		//var_dump($this->pdo);
		 $sql="SELECT meni_ime FROM meni WHERE mid=:mid";
		 $stmt = $this->pdo->prepare($sql);
		 $stmt->execute(array(
		 	':mid'=>$value
		 	));	
		 foreach ($stmt as $row) {
		 	return $row['meni_ime'];
		 	
		 }
	}



}

 ?>