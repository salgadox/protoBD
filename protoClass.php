<?php
class Proto extends SQLite3 {
      /**
      Functions: 
            Contructeurs: 
                  __contruct()
            
            Functions to get info about the phonemes: 
                  getId($phoneme)
                  getLieu($phoneme)
                  getMode($phoneme)
                  estConsonne($phoneme)
                  CV($phoneme)
                  estVoise($phoneme)
                  getInfoPhon($phoneme)
                  estVoise($phoneme)
                  getInfoPhon($phoneme)
           
            Function to get info from DB
                  getAllLexemesBD()
                  getAllLexemesById()
                  getAllPhonemesDB()
                  getAllPhonemesById()

            Funtions to get info from file 

      **/
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

            function getAllLexemesBD(){
                  $sql = "SELECT transcription FROM lexeme" ;
                  $ret = $this->query($sql);
                  $lexeme = array();
                  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
                         array_push($lexeme, $row['transcription']);
                  };
                  return $lexeme;
            }

            function getAllLexemesById($id){
                  $sql = "SELECT transcription FROM lexeme WHERE langue_id == '".$id."'" ;
                  $ret = $this->query($sql);
                  $lexeme = array();
                  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
                         array_push($lexeme, $row['transcription']);
                  };
                  return $lexeme;
            }

            function getAllPhonemesDB(){
                 $arr = $this->getAllLexemesBD();
                 $res = array();
                 for ($i=0; $i < sizeof($arr) ; $i++) {
                        $ex = explode(" ", $arr[$i]);
                        for ($e=0; $e < sizeof($ex) ; $e++) { 
                                array_push($res, $ex[$e]);
                          }  
                 }
                 return $res;
            }

            function getAllPhonemesById($id){
                 $arr = $this->getAllLexemesById($id);
                 $res = array();
                 for ($i=0; $i < sizeof($arr) ; $i++) {
                        $ex = explode(" ", $arr[$i]);
                        for ($e=0; $e < sizeof($ex) ; $e++) { 
                                array_push($res, $ex[$e]);
                          }  
                 }
                 return $res;
            }
            

      	function getGabaritLex($lexeme){
      		$phonList=explode(" ", $lexeme);
      		$gabarit = "";
      		for ($i=0; $i < sizeof($phonList) ; $i++) { 
                        echo $phonList[$i];
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

            function getGabaritBD($donnees){
                  $gabarit = "";
                  for ($i=0; $i < sizeof($donnees); $i++) { 
                        $gabarit .= $this->getGabaritLex($donnees[$i])."\n" ;
                        }  
                  
                  return $gabarit;
            }

            function getCleanLexArray($file){
                  $mots = preg_split("/\n/", file_get_contents($file));
                  for ($i=0; $i < sizeof($mots); $i++) { 
                        if($mots[$i]==""){
                              unset($mots[$i]) ;
                        }
                        
                  }
                  return $mots ;
            }

              function getCleanPhonArray($file){
                  $mots = preg_split("/[\s]+/", file_get_contents($file));
                  for ($i=0; $i < sizeof($mots); $i++) { 
                        if($mots[$i]==""){
                              unset($mots[$i]) ;
                        }
                        
                  }
                  return $mots ;
            }

            function countLex($file){
                  $MotArr = $this->getCleanLexArray($file);
                  return count($MotArr);
            }
            function conuntLexDB($donnees){
                  return count($donnees);
            }

            function countTotalPhon($file){
                  $MotArr = $this->getCleanPhonArray($file);
                  return count($MotArr);
            }

            function countTotalPhonDB($donnees){
                  return count($donnees);
            }

            function  countDiffPhon($file){
                  $MotArr = $this->getCleanPhonArray($file);
                 // $mots = preg_split("/[\s]+/", file_get_contents($file));
                  return count(array_count_values($MotArr));
            }

             function countDiffPhonDB($donnees){
                  return count(array_count_values($donnees));
            }

            function getDiffPhonDB($donnees){
                  $MotArr = array_unique($donnees);
                  $keys = array_keys($MotArr);
                  $arr = array();
                  for ($i=0; $i < sizeof($keys); $i++) { 
                       array_push($arr, $MotArr[($keys[$i])]) ;
                  }
                  //print_r($arr);
                  return $arr;

            }

            function getDiffPhon($file){
                  $MotArr = array_unique($this->getCleanPhonArray($file));
                  $keys = array_keys($MotArr);
                  $arr = array();
                  for ($i=0; $i < sizeof($keys); $i++) { 
                       array_push($arr, $MotArr[($keys[$i])]) ;
                  }
                  //print_r($arr);
                  return $arr;

            }
   	}


	
?>