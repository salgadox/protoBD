<?php
class Proto extends SQLite3 {
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
			//echo "<p>phoneme: ". $phoneme. " consonne? ". $rs['consonant']."</p>";
			return $rs['consonant'];
      	}
      	function CV($phoneme){
      		$tmp = $this->estConsonne($phoneme);
      		if ($tmp==0){
      			return 'V';
      		}
      		if($tmp==1){
      			return 'C';
      		}
      		return "";//just in case...
      	}


      	function estVoise($phoneme){
      		$sql = "SELECT voisement FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['voisement'];
      	}
      	function getInfoPhon($phoneme){
      		echo "<table>";
      		echo "<tr> <th> phoneme: </th> <td>".$phoneme."</td> </tr>";
      		echo "<tr> <th> phoneme ID: </th> <td>".$this->getId($phoneme)."</td> </tr>";
      		echo "<tr> <th> lieu </th> <td>".$this->getLieu($phoneme)."</td> </tr>";
      		echo "<tr> <th> mode </th> <td>".$this->getMode($phoneme)."</td> </tr>";
      		echo "<tr> <th> consonne </th><td>".$this->estConsonne($phoneme)."</td></tr>";
      		echo "<tr> <th> voise </th> <td>".$this->estvoise($phoneme)."</td> </tr>";
			echo "</table>";
      	}


      	function getGabaritLex($lexeme){
      		$phonList=explode(" ", $lexeme);
      		$gabarit = "";
      		for ($i=0; $i < sizeof($phonList) ; $i++) { 
      			$gabarit.=$this->CV(trim($phonList[$i]));
      		}
      		return $gabarit;
      	}
      	function getGabaritFile($file){
      		$mots = preg_split("/\n/", file_get_contents($file));
      		$gabarit = "";
      		for ($i=0; $i < sizeof($mots); $i++) { 
      			if($mots[$i]!=""){
      				$gabarit .= $this->getGabaritLex($mots[$i])."\n" ;
      			}
      			
      		}
      		return $gabarit ;
      	}

      	function countLex($file){
      		//this only works if we have an empty last line;
      		return count(preg_split("/[\s]+/", file_get_contents($file)))-1;
      	}
      	

      	function remLastLine($file){
      		$lines = file($file);
      		$last = sizeof(($lines)-1);
      		unset($lines[$last]);
      		return count($mots=preg_split("/[\s]+/", file_get_contents($file)));	
      	}

   	}
	
	$db = new Proto();
	$phoneme ='&#660';
	$file = "public/uploads/aja_proto_transcrit.txt";
	/**echo "phoneme_id: ".$db->getId($phoneme)."\n";
	echo "lieu: ".$db->getLieu($phoneme)."\n";
	echo "mode: ".$db->getMode($phoneme)."\n";
	echo "est consonne? : ".$db->estConsonne($phoneme)."\n";
	echo "est voise? : ".$db->estvoise($phoneme)."\n";
	echo "est C : ".$db->CV($phoneme)."\n";
	//echo "gabarit : ". $db->gabarit("m oo t");
	echo "countLex : ". $db->countLex($file); **/
	echo "getgabarit : ". $db->getGabaritFile($file);
	$db->getInfoPhon($phoneme);

   


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