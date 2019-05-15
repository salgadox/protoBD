<?php
class Proto extends SQLite3 {
      /**
      Functions: 
            Contructeurs: 
                  __contruct()
            Funtions to get info about 'langue':
                  getNameLang($id)
                  getIdLang($name)
                  getGeneralInfoID($id)

            Functions Gabarits 
                  getGabaritById($id)
                  getDiffGabaritById($id)
                  countDiffGabaritById($id){
          
            Funtions Infolieu/mode
                  getLieuById($id)
                  getModeById($id)
                  getInfoLieu($id)
                  getInfoMode($id)

            Functions to get info about the phonemes: 
                  getId($phoneme)
                  getLieu($phoneme)
                  getLieuLexArray($lexeme)
                  getLieuLex($lexeme)
                  getMode($phoneme)
                  getModeLex($lexeme)
                  getModeLexArray($lexeme)
                  estConsonne($phoneme)
                  CV($phoneme)
                  estVoise($phoneme)
                  getInfoPhon($phoneme)
                  estVoise($phoneme)
                  getInfoPhon($phoneme)
           
            Function to get info from DB
                  getAllLexemesBD()
                  getAllLexemesById($id)
                  getAllPhonemesDB()
                  getAllPhonemesById($id)
                  getAllPhonsPerLex($lexeme)
                  getGabaritLex($lexeme)
                  getGabaritBD($donnees)
                  conuntLexDB($donnees)
                  countTotalPhonDB($donnees)
                  countDiffPhonDB($donnees)
                  getDiffPhonDB($donnees)

            Funtions to get info from file
                  getGabaritFile($file)
                  getCleanLexArray($file)
                  getCleanPhonArray($file)
                  countLex($file)
                  countTotalPhon($file)
                  countDiffPhon($file)
                  getDiffPhon($file) 

      **/
      	function __construct() {
        	$this->open('test.db');
      	}

            function getNameLang($id){
                  $sql = "SELECT langue_nom FROM langues WHERE langue_id =='".$id."'";
                  $ret = $this->query($sql);
                  $rs= $ret->fetchArray(SQLITE3_ASSOC);
                  return $rs['langue_nom'];
            }
            function getIdLang($name){
                  $sql = "SELECT langue_id FROM langues WHERE langue_nom =='".$name."'";
                  $ret = $this->query($sql);
                  $rs= $ret->fetchArray(SQLITE3_ASSOC);
                  return $rs['langue_id'];
            }

            function getGeneralInfoID($id){
                  $lexemes= $this->getAllLexemesById($id);
                  $phonemes = $this->getAllPhonemesById($id);
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  echo "<tr> <th> nombre de mots: </th> <td>".$this->conuntLexDB($lexemes)."</td> </tr>";
                  echo "<tr> <th> nombre de phonemes:  </th> <td>".$this->countTotalPhonDB($phonemes)."</td> </tr>";
                  echo "<tr> <th> phonemes differentes: </th> <td>".$this->countDiffPhonDB($phonemes)."</td> </tr>";
                 echo "<tr> <th> gabarit differentes: </th><td>".$this->countDiffGabaritById($id)."</td></tr>";
                  //echo "<tr> <th> voise </th> <td>".$this->estvoise($phoneme)."</td> </tr>";
                  echo "</table>";
            }
            function getGabaritById($id){
                  $lexemes = $this->getAllLexemesById($id);
                  $gabarits = $this->getGabaritBD($lexemes);
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  for ($i=0; $i < sizeof($gabarits); $i++) { 
                        echo "<tr> <th> ".$lexemes[$i] ." </th> <td>".$gabarits[$i]."</td> </tr>";
                  }
                  echo "</table>";
                  
            }

            function getDiffGabaritById($id){
                  $lexemes = $this->getAllLexemesById($id);
                  $gabarits = $this->getGabaritBD($lexemes);
                  return array_count_values($gabarits);
            }

            function countDiffGabaritById($id){
                  return count(array_count_values($this->getDiffGabaritById($id)));
            }

            function getLieuById($id){
                  $lexemes = $this->getAllLexemesById($id);
                  $lieu = $this->getInfoLieu($id);
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  for ($i=0; $i < sizeof($lieu); $i++) { 
                        echo "<tr> <th> ".$lexemes[$i] ." </th> <td>".$lieu[$i]."</td> </tr>";
                  }
                  echo "</table>";
                  
            }


            function getModeById($id){
                  $lexemes = $this->getAllLexemesById($id);
                  $mode = $this->getInfoMode($id);
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  for ($i=0; $i < sizeof($mode); $i++) { 
                        echo "<tr> <th> ".$lexemes[$i] ." </th> <td>".$mode[$i]."</td> </tr>";
                  }
                  echo "</table>";
                  
            }


             function getInfoLieu($id){
                  $lexemes = $this->getAllLexemesById($id); 
                  $lieu = array();
                  for ($i=0; $i < sizeof($lexemes); $i++) { 
                       array_push($lieu, $this->getLieuLex($lexemes[$i])); 
                  }
                  
                  return $lieu;
               
            }

           /** function getInfoLieu($id){
                  $lexemes = $this->getAllLexemesById($id); 
                  $lieu = array();
                  for ($i=0; $i < sizeof($lexemes); $i++) { 
                       array_push($lieu, $this->getLieuLex($lexemes[$i])); 
                  }
                  
                  return $lieu;
               
            }*/
            
            function getInfoMode($id){
                  $lexemes = $this->getAllLexemesById($id); 
                  $mode = array();
                  for ($i=0; $i < sizeof($lexemes); $i++) { 
                       array_push($mode, $this->getModeLex($lexemes[$i])); 
                  }
                  return $mode;
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

            function getLieuLexArray($lexeme){
                  $phonemes = $this->getAllPhonsPerLex($lexeme);
                  $lieu = array();
                  for ($e=0; $e < sizeof($phonemes); $e++) { 
                        array_push($lieu, $this->getLieu(trim($phonemes[$e])));
                  }
                  return $lieu;
            }

            function getLieuLex($lexeme){
                  $phonemes = $this->getAllPhonsPerLex($lexeme);
                  $lieu = "";
                  for ($e=0; $e < sizeof($phonemes); $e++) { 
                        $lieu .= $this->getLieu(trim($phonemes[$e]))." ";
                  }
                  return $lieu;
            }

      	function getMode($phoneme){
			$sql = "SELECT mode FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['mode'];
      	}

            function getModeLex($lexeme){
                  $phonemes = $this->getAllPhonsPerLex($lexeme);
                  $mode = "";
                  for ($e=0; $e < sizeof($phonemes); $e++) { 
                        $mode .= $this->getMode($phonemes[$e]). " ";
                  }
                  return $mode;
            }

            function getModeLexArray($lexeme){
                  $phonemes = $this->getAllPhonsPerLex($lexeme);
                  $mode = array();
                  for ($e=0; $e < sizeof($phonemes); $e++) { 
                        array_push($mode, $this->getMode($phonemes[$e]));
                  }
                  return $mode;
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

            function getAllPhonsPerLex($lexeme){
                 $lex = explode(" ", $lexeme);
                 return $lex;
            }
                 

      	function getGabaritLex($lexeme){
      		$phonList=explode(" ", $lexeme);
      		$gabarit = "";
      		for ($i=0; $i < sizeof($phonList) ; $i++) { 
      			$gabarit.=$this->CV(trim($phonList[$i]));
      		}
      		return $gabarit;
      	}

      	function getGabaritBD($donnees){
                  $gabarit = array();
                  for ($i=0; $i < sizeof($donnees); $i++) { 
                        array_push($gabarit, $this->getGabaritLex($donnees[$i]));
                        }  
                  
                  return $gabarit;
            }

            

           

            /**function getGabaritBD($donnees){
                  $gabarit = "";
                  for ($i=0; $i < sizeof($donnees); $i++) { 
                        $gabarit .= $this->getGabaritLex($donnees[$i])."\n" ;
                        }  
                  
                  return $gabarit;
            }*/

            
            function conuntLexDB($donnees){
                  return count($donnees);
            }
            

            function countTotalPhonDB($donnees){
                  return count($donnees);
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

            function countTotalPhon($file){
                  $MotArr = $this->getCleanPhonArray($file);
                  return count($MotArr);
            }

             function  countDiffPhon($file){
                  $MotArr = $this->getCleanPhonArray($file);
                 // $mots = preg_split("/[\s]+/", file_get_contents($file));
                  return count(array_count_values($MotArr));
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