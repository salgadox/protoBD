<?php
class MyDB extends SQLite3 {
      	function __construct() {
        	$this->open('test.db');
      	}

      	function getId($phoneme){
			$sql = "SELECT phoneme_id FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['phoneme_id'];
      	}
      	
      	function getLieu($phoneme){
			$sql = "SELECT lieu FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['lieu'];
      	}

      	function getMode($phoneme){
			$sql = "SELECT mode FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['mode'];
      	}

      	function estConsonne($phoneme){
      		$sql = "SELECT consonant FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['consonant'];
      	}

      	function estVoise($phoneme){
      		$sql = "SELECT voisement FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['voisement'];
      	}
      	function getInfo($phoneme){
      		echo "<table>";
      		echo "<tr> <th> phoneme: </th> <td>".$phoneme."</td> </tr>";
      		echo "<tr> <th> phoneme ID: </th> <td>".$this->getId($phoneme)."</td> </tr>";
      		echo "<tr> <th> lieu </th> <td>".$this->getLieu($phoneme)."</td> </tr>";
      		echo "<tr> <th> mode </th> <td>".$this->getMode($phoneme)."</td> </tr>";
      		echo "<tr> <th> consonne </th><td>".$this->estConsonne($phoneme)."</td></tr>";
      		echo "<tr> <th> voise </th> <td>".$this->estvoise($phoneme)."</td> </tr>";
			echo "</table>";
      	}
   	}
	
	$db = new MyDB();
	$phoneme ="b";
	echo "phoneme_id: ".$db->getId($phoneme)."\n";
	echo "lieu: ".$db->getLieu($phoneme)."\n";
	echo "mode: ".$db->getMode($phoneme)."\n";
	echo "est consonne? : ".$db->estConsonne($phoneme)."\n";
	echo "est voise? : ".$db->estvoise($phoneme)."\n";
	$db->getInfo($phoneme);
   


   if(!$db){
      echo $db->lastErrorMsg();
   } 


Class Phonemes {
	//declaration de variables
	
	public $phon; 
	public $lieu;
	public function __construct($phoneme){
		//$this->lieu=;
		$this->phon = $phoneme;
		//$this->lieu = $lieu;
	}
	public function getPhon(){
		return $this->phon;
	}
	public function getLieu($phon){
		return parent::getLieu($phon);
	}

}
/*
echo "\n prueba phoneme class: \n";
$p= new Phonemes("p");
echo "phoneme: ".$p->getPhon()."\n";
echo "lieu : ".$p->getLieu("p")."\n";
/*if($phoneme == $b->getInfo()){*
	echo "true";
}else{echo "false";}*/


/*$p= new Phonemes("p");
echo $p->getPhon();
$bPhon = new Phonemes($b,"Bi");
echo $b->getPhon();
*/



	
?>