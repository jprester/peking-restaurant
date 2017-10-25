<?php
class Jelo extends Db{
	public $jid,
			$sort,
			$broj,
			$naziv,
			$naziv_en,
			$cijena,
			$mid;

	public function __construct(){
	parent::__construct();	

	}

	public function getJela($value){
		$sql="SELECT * FROM jela WHERE mid = :mid ORDER BY sort";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(
			':mid'=>$value
		));	
		$result = $stmt->fetchAll();
		return $result;

	}

	public function chooseJelo($value){
		$sql="SELECT * FROM jela WHERE jid=:jid";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(
			':jid'=>$value
		));	

		$result = $stmt->fetchAll();
		return $result;
	}


	public function insertJelo($sort,$broj,$naziv,$naziv_en,$cijena,$mid){
		$sql="INSERT into jela (sort, broj, naziv, naziv_en, cijena, mid) VALUES (:sort, :broj, :naziv, :naziv_en,	:cijena,:mid)";
		$stmt=$this->pdo->prepare($sql);
		$stmt->execute(array(
			':sort'=>$sort,
			':broj'=>$broj,
			':naziv'=>$naziv,
			':naziv_en'=>$naziv_en,
			':cijena'=>$cijena,
			':mid'=>$mid,
		));
	}

	public function deleteJelo($jid){
		$sql ="DELETE  FROM jela WHERE jid = :jid";
		$stmt=$this->pdo->prepare($sql);
		$stmt->execute(array(
			':jid' =>$jid
		));
	}

	public function editJelo($jid,$broj,$sort,$naziv, $naziv_en, $cijena){
		$sql ="UPDATE jela SET broj= :broj, sort= :sort, naziv= :naziv, naziv_en= :naziv_en, cijena= :cijena WHERE jid = :jid";
		$stmt=$this->pdo->prepare($sql);
		$stmt->execute(array(
			':jid' =>$jid,
			':sort'=>$sort,
			':broj'=>$broj,
			':naziv'=>$naziv,
			':naziv_en'=>$naziv_en,
			':cijena'=>$cijena
		));
	}
}
 ?>