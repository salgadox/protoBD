<?php
class Proto extends SQLite3 {
      /**
      *Functions: 
      *      Contructeurs: 
      *            __contruct()
      *
      *      Funtions to get info about 'langue':
      *            getAllLangues()
      *            getNameLang($id)
      *            getIdLang($name)
      *            getGeneralInfoID($id)
      *
      *      Functions Gabarits 
      *            getGabaritById($id)
      *            getDiffGabaritById($id)
      *            countDiffGabaritById($id){
      *    
      *      Funtions Infolieu/mode
      *            getLieuById($id)
      *            getModeById($id)
      *            getGabLieuMode($id)
      *            getInfoLieu($id)
      *            getInfoMode($id)
      *            
      * 
      *      Functions to get info about the phonemes: 
      *            getId($phoneme)
      *            getLieu($phoneme)
      *            getLieuLexArray($lexeme)
      *            getLieuLex($lexeme)
      *            getMode($phoneme)
      *            getModeLex($lexeme)
      *            getModeLexArray($lexeme)
      *            estConsonne($phoneme)
      *            CV($phoneme)
      *            CouV($phoneme)
      *            estVoise($phoneme)
      *            estDiacritique($phoneme)
      *            estEjective($phoneme)
      *            estAffixe($phoneme)
      *            aAffixe($phoneme)
      *            estCompose($phoneme)
      *            estSuffixe($phoneme)
      *            estPrefixe($phoneme)
      *            consonnePresent($phoneme)
      *            voyellePresent($phoneme)
      *            getInfoPhon($phoneme)
      *     
      *      Function to get info from DB
      *            getAllLexemesBD()
      *            getAllLexemesById($id)
      *            getAllPhonemesDB()
      *            getAllPhonemesById($id)
      *            getAllPhonsPerLex($lexeme)
      *            getDiacritiqueBD()
      *            getVoyellesBD()
      *            getConsonnesBD()
      *            getGabaritLex($lexeme)
      *            getGabaritBD($donnees)
      *            conuntLexDB($donnees)
      *            countTotalPhonDB($donnees)
      *            countDiffPhonDB($donnees)
      *            getDiffPhonDB($donnees)
      *
      *      Funtions to get info from file
      *            getGabaritFile($file)
      *            getCleanLexArray($file)
      *            getCleanPhonArray($file)
      *            countLex($file)
      *            countTotalPhon($file)
      *            countDiffPhon($file)
      *            getDiffPhon($file) 
      *
      **/
      	function __construct() {
        	   $this->open('ProtoDB.db');
      	}

            function getAllLangues(){
                  $sql = "SELECT langue_nom FROM langues" ;
                  $ret = $this->query($sql);
                  $langues = array();
                  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
                         array_push($langues, $row['langue_nom']);
                  };
                  return $langues;
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
                  //print_r($this->getDiffGabaritById($id));
                  return count(($this->getDiffGabaritById($id)));
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

            function getGabLieuMode($id){
                  $lexemes = $this->getAllLexemesById($id);
                  $gabarits = $this->getGabaritBD($lexemes);
                  $lieu = $this->getInfoLieu($id);
                  $mode = $this->getInfoMode($id);
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  for ($i=0; $i < sizeof($gabarits); $i++) { 
                        echo "<tr> <th> ".$lexemes[$i] ." </th> <td>".$gabarits[$i]."</td> <td>".$lieu[$i]."</td> <td>".$mode[$i]."</td>  </tr>";
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
                  $phoneme =$this->CouV($phoneme);
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
                  $phoneme =$this->CouV($phoneme);
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
                  $phoneme =$this->CouV($phoneme);
      		$tmp = $this->estConsonne($phoneme);
      		if ($tmp==0){
      			return 'V';
      		}
      		if($tmp==1){
      			return 'C';
      		}
      		return "";//just in case...
      	}

            function CouV($phoneme){
                  $estCompose = $this->estCompose($phoneme);
                  $estConsonne = $this->consonnePresent($phoneme);
                  $estVoyelle = $this->voyellePresent($phoneme);
                  if($estCompose == 1){
                        return $estConsonne!==0?$estConsonne:$estVoyelle;
                  }
                  return $phoneme;
            }
            

      	function estVoise($phoneme){
      		$sql = "SELECT voisement FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['voisement'];
      	}

            function estDiacritique($phoneme){
                  $sql = "SELECT diacritique FROM phonemes WHERE phoneme =='".$phoneme."'";
                  $ret = $this->query($sql);
                  $rs= $ret->fetchArray(SQLITE3_ASSOC);
                  return $rs['diacritique']==1?1:0;
            }

            function estEjective($phoneme){
                  if ($this->estDiacritique($phoneme) == 1){
                        $eject = $this->getLieu($phoneme);
                        return ($eject=="Ejective"?1:0); 
                  }
                  return 0;
            }

            function estAffixe($phoneme){
                  if ($this->estDiacritique($phoneme) == 1){
                        $affixe = $this->getLieu($phoneme);
                        return ($affixe=="Affixe"?1:0); 
                  }
                  return 0;
            }

            function aAffixe($phoneme){
                  return preg_match('/-/', $phoneme)?1:0;
            }

            function estCompose($phoneme){
                  $size=strlen($phoneme);
                  $affixe = $this->aAffixe($phoneme);
                  return($size>=6 || $size ==2 || $affixe==1)?1:0;
            }

            function estSuffixe($phoneme){
                  if($this->estCompose($phoneme)){
                        return preg_match('/-/', substr($phoneme, 1))?1:0;
                  }
                  return 0;

            }
            function estPreffixe($phoneme){
                  if($this->estCompose($phoneme)){
                        return preg_match('/-/', substr($phoneme, 1))?0:1;
                  }
                  return 0;
            }
            function consonnePresent($phoneme){
                  $consonnes = $this->getConsonnesBD();
                  for ($i=0; $i < sizeof($consonnes) ; $i++) { 
                        $pos = strpos($phoneme, $consonnes[$i]);
                        if($pos !== false) {
                              return $consonnes[$i];
                        }
                  }
                  return 0;
            }     
          
            function voyellePresent($phoneme){
                  $voyelles = $this->getVoyellesBD();
                  for ($i=0; $i < sizeof($voyelles) ; $i++) { 
                        $pos = strpos($phoneme, $voyelles[$i]);
                        if ($pos !== false) {
                              return $voyelles[$i];
                        }
                  }
                  return 0;
            }
            
            /*falta
            function decomposer($phoneme){
                  $arr = array();

                  
                  return $phoneme;
            }*/

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
            
            function getDiacritiquesBD(){
                  $sql = "SELECT phoneme FROM phonemes WHERE diacritique == '1'";
                  $ret = $this->query($sql);
                  $diacritiques = array();
                  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
                         array_push($diacritiques, $row['phoneme']);
                  };
                  return $diacritiques;
            } 

            function getVoyellesBD(){
                  $sql = "SELECT phoneme FROM phonemes WHERE consonant == '0'";
                  $ret = $this->query($sql);
                  $voyelles = array();
                  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
                         array_push($voyelles, $row['phoneme']);
                  };
                  return $voyelles;
            } 

            function getConsonnesBD(){
                  $sql = "SELECT phoneme FROM phonemes WHERE consonant == '1'";
                  $ret = $this->query($sql);
                  $consonnes = array();
                  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
                         array_push($consonnes, $row['phoneme']);
                  };
                  return $consonnes;
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
                  return count(array_count_values($MotArr));
            }

            function getDiffPhon($file){
                  $MotArr = array_unique($this->getCleanPhonArray($file));
                  $keys = array_keys($MotArr);
                  $arr = array();
                  for ($i=0; $i < sizeof($keys); $i++) { 
                       array_push($arr, $MotArr[($keys[$i])]) ;
                  }
                  return $arr;

            }
   	}
?>