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
      *            totaleLang()
      *            getGeneralInfo()
      *            getGeneralInfoID($id)
      *            moreInfoV($id)
      *            moreInfoC($id)
      *
      *      Functions Gabarits 
      *            getGabaritById($id)
      *            getDiffGabaritById($id)
      *            countDiffGabaritById($id)
      *            getInfoGabarit($id)
      *    
      *      Funtions Infolieu/mode
      *            getLieuById($id)
      *            getModeById($id)
      *            getGabLieuMode($id)
      *            getInfoGabarit($id)
      *            getInfoLieu($id)
      *            getInfoPhonById($id)
      *            getInfoMode($id)
      *            getInfoLieuDiff($id)
      *            getInfoModeDiff($id)    
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
      *            getVoyellesById($id)
      *            searchVInLex($id)
      *            searchCInLex($id)
      *            getConsonneById($id)
      *            decomposer()
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

            function totaleLang(){
                  $sql = "SELECT COUNT(langue_id) FROM langues";
                  $ret = $this->query($sql);
                  $rs= $ret->fetchArray(SQLITE3_ASSOC);
                  $keys = array_keys($rs);
                  return $rs[$keys[0]];
            }

            function getGeneralInfo(){
                  echo "<table>";
                  echo "<tr> <th> toutes les langue: </th> <td> </td> </tr>";
                  echo "<tr> <th> nombre de langues: </th> <td>".$this->totaleLang()."</td> </tr>";
                  echo "</table>";
            }

            function getGeneralInfoID($id){
                  $lexemes= $this->getAllLexemesById($id);
                  $phonemes = $this->getAllPhonemesById($id);
                  $voy = count($this->getVoyellesById($id));
                  $consonnes = count($this->getConsonnesById($id));
                  $phon= $voy+$consonnes;
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  echo "<tr> <th> nombre de mots: </th> <td>".$this->conuntLexDB($lexemes)."</td> </tr>";
                  echo "<tr> <th> nombre de phonemes:  </th> <td>".$this->countTotalPhonDB($phonemes)."</td> </tr>";
                 echo "<tr> <th> gabarit differentes: </th><td>".$this->countDiffGabaritById($id)."</td></tr>";
                 echo "<tr> <th> phonemes differentes: </th> <td>".$phon."</td> </tr>";
                 echo "<tr> <th> consonnes differentes: </th> <td>".$consonnes."</td> </tr>";
                 echo "<tr> <th> voyelles differentes: </th> <td>".$voy."</td> </tr>";
                  echo "</table>";
            }
          
            function moreInfoV($id){
                  $voy = $this->getVoyellesById($id);
                  $keys=array_keys($voy);
                  $all =$this->searchVInLex($id);
                  $j=0;
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  foreach ($keys as $key) {
                        echo "<tr> <th> voyelle: </th> <td style='font-weight:bold'>".$key."</td> </tr>";
                        for ($i=0; $i < sizeof($all[$j]); $i++) { 
                            echo "<tr> <th> </th> <td>".$all[$j][$i]."</td> </tr>";
                           
                        }
                         $j++;

                  }
                  echo "</table>";
            }
            function moreInfoC($id){
                  $con = $this->getConsonnesById($id);
                  $keys=array_keys($con);
                  $all =$this->searchCInLex($id);
                  $j=0;
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  foreach ($keys as $key) {
                        echo "<tr> <th> consonne: </th> <td style='font-weight:bold'>".$key."</td> </tr>";
                        for ($i=0; $i < sizeof($all[$j]); $i++) { 
                            echo "<tr> <th> </th> <td>".$all[$j][$i]."</td> </tr>";
                           
                        }
                         $j++;

                  }
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
                  return count(($this->getDiffGabaritById($id)));
            }

            function getInfoGabarit($id){
                  $gabarits = $this->getDiffGabaritById($id);
                  $keys = array_keys($gabarits);
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  for ($i=0; $i < sizeof($gabarits); $i++) { 
                        echo "<tr> <th> ".$keys[$i] ." </th> <td>".$gabarits[$keys[$i]]."</td> </tr>";
                  }
                  echo "</table>";

            }
            
            function getJusteMots($id){
                  $lexemes=$this->getAllLexemesById($id);
                  $arr=array();
                  for ($i=0; $i < sizeof($lexemes); $i++) { 
                        if ($this->estPrefixe($lexemes[$i])!=1) {
                              array_push($arr, $lexemes[$i]);
                        }
                  }
                  return $arr;
            }

            function getJusteDebRacine($id){
                  $lexemes=$this->getAllLexemesById($id);
                  $arr=array();
                  for ($i=0; $i < sizeof($lexemes); $i++) { 
                        if ($this->aAffixe($lexemes[$i])==1) {
                              if ($this->estPrefixe($lexemes[$i])==1) {
                                   array_push($arr, $lexemes[$i]);
                              } 
                        }
                  }
                  return $arr;
            }

            function getJusteFinRacine($id){
                  $lexemes=$this->getAllLexemesById($id);
                  $arr=array();
                  for ($i=0; $i < sizeof($lexemes); $i++) { 
                        if ($this->aAffixe($lexemes[$i])==1) {
                              if ($this->estSuffixe(substr($lexemes[$i], 1))==1) {
                                   array_push($arr, $lexemes[$i]);
                              } 
                        }
                  }
                  return $arr;
            }

            function matchDebMot($id, $phoneme){
                  $debMot=$this->getJusteMots($id);
                  $arr = array();
                  for ($i=0; $i < sizeof($debMot); $i++) { 
                        $phons = $this->getAllPhonsPerLex($debMot[$i]);
                        if($phons[0]==$phoneme){
                              array_push($arr, $debMot[$i]); 
                        }
                  }
                  return $arr;
            }

            function matchDebMotLieu($id, $lieu){
                  $debMot=$this->getJusteMots($id);
                  $res = array();
                  for ($i=0; $i < sizeof($debMot); $i++) { 
                        $arr = $this->getLieuLexArray($debMot[$i]);
                        if($arr[0]==$lieu){
                              array_push($res, $debMot[$i]); 
                        }
                  }
                  return $res;
            }


            function matchFinMotLieu($id, $lieu){
                  $debMot=$this->getJusteMots($id);
                  $res = array();
                  for ($i=0; $i < sizeof($debMot); $i++) { 
                        $arr = $this->getLieuLexArray($debMot[$i]);
                        if($arr[count($arr)-1]==$lieu){
                              array_push($res, $debMot[$i]); 
                        }
                  }
                  return $res;
            }

            function matchDebMotMode($id, $mode){
                  $debMot=$this->getJusteMots($id);
                  $res = array();
                  for ($i=0; $i < sizeof($debMot); $i++) { 
                        $arr = $this->getModeLexArray($debMot[$i]);
                        if($arr[0]==$mode){
                              array_push($res, $debMot[$i]); 
                        }
                  }
                  return $res;
            }


            function matchFinMotMode($id, $mode){
                  $debMot=$this->getJusteMots($id);
                  $res = array();
                  for ($i=0; $i < sizeof($debMot); $i++) { 
                        $arr = $this->getModeLexArray($debMot[$i]);
                        if($arr[count($arr)-1]==$mode){
                              array_push($res, $debMot[$i]); 
                        }
                  }
                  return $res;
            }
            

            function matchFinMot($id, $phoneme){
                  $debMot=$this->getJusteMots($id);
                  $arr = array();
                  for ($i=0; $i < sizeof($debMot); $i++) { 
                        $phons = $this->getAllPhonsPerLex($debMot[$i]);
                        if($phons[count($phons)-1]==$phoneme){
                              array_push($arr, $debMot[$i]); 
                        }
                  }
                  return $arr;
            }

            function matchDebRacMode($id, $mode){
                  $debMot=$this->getJusteDebRacine($id);
                  $res = array();
                  for ($i=0; $i < sizeof($debMot); $i++) { 
                        $arr = $this->getModeLexArray($debMot[$i]);
                        if($arr[0]==$mode){
                              array_push($res, $debMot[$i]); 
                        }
                  }
                  return $res;
            }


            function matchFinRacMode($id, $mode){
                  $debMot=$this->getJusteDebRacine($id);
                  $res = array();
                  for ($i=0; $i < sizeof($debMot); $i++) { 
                        $arr = $this->getModeLexArray($debMot[$i]);
                        if($arr[count($arr)-1]==$mode){
                              array_push($res, $debMot[$i]); 
                        }
                  }
                  return $res;
            }

            function matchDebRacLieu($id, $lieu){
                  $debMot=$this->getJusteDebRacine($id);
                  $res = array();
                  for ($i=0; $i < sizeof($debMot); $i++) { 
                        $arr = $this->getLieuLexArray($debMot[$i]);
                        if($arr[0]==$lieu){
                              array_push($res, $debMot[$i]); 
                        }
                  }
                  return $res;
            }


            function matchFinRacLieu($id, $lieu){
                  $debMot=$this->getJusteFinRacine($id);
                  $res = array();
                  for ($i=0; $i < sizeof($debMot); $i++) { 
                        $arr = $this->getLieuLexArray($debMot[$i]);
                        if($arr[count($arr)-1]==$lieu){
                              array_push($res, $debMot[$i]); 
                        }
                  }
                  return $res;
            }

            function matchDebRac($id, $phoneme){
                  $rac=$this->getJusteFinRacine($id);
                  $arr = array();
                  //print_r($rac);
                  for ($i=0; $i < sizeof($rac); $i++) { 
                        $phons = $this->getAllPhonsPerLex($rac[$i]);
                        if(($this->CouV($phons[0]))==$phoneme){
                              array_push($arr, $rac[$i]); 
                        }
                  }
                  return $arr;
            }
            function matchFinRac($id, $phoneme){
                  $rac=$this->getJusteFinRacine($id);
                  $arr = array();
                  for ($i=0; $i < sizeof($rac); $i++) { 
                        $phons = $this->getAllPhonsPerLex($rac[$i]);
                        if(($this->CouV($phons[count($phons)-1]))==$phoneme){
                              array_push($arr, $rac[$i]); 
                        }
                  }
                  return $arr;
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

            function getInfoPhonById($id){
                  $voy = $this->getVoyellesById($id);
                  $cons = $this->getConsonnesById($id);
                  $arr=array_merge($voy,$cons);
                  arsort($arr);
                  //print_r($arr);
                  $keys=array_keys($arr);
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  for ($i=0; $i < sizeof($arr); $i++) { 
                        echo "<tr> <th>".$keys[$i]." </th> <td>".$arr[$keys[$i]]."</td> </tr>";
                  }
                  echo "</table>";

            }



            function getInfoMode($id){
                  $lexemes = $this->getAllLexemesById($id); 
                  $mode = array();
                  for ($i=0; $i < sizeof($lexemes); $i++) { 
                       array_push($mode, $this->getModeLex($lexemes[$i])); 
                  }
                  return $mode;
            }

            function getInfoLieuDiff($id){
                  $lieu = array_count_values($this->getInfoLieu($id));
                  $keys = array_keys($lieu);
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  for ($i=0; $i < sizeof($lieu); $i++) { 
                        echo "<tr> <th> ".$keys[$i] ." </th> <td>".$lieu[$keys[$i]]."</td> </tr>";
                  }
                  echo "</table>";
            }

            function getInfoModeDiff($id){
                  $mode = array_count_values($this->getInfoMode($id));
                  $keys = array_keys($mode);
                  echo "<table>";
                  echo "<tr> <th> Langue: </th> <td>".$this->getNameLang($id)."</td> </tr>";
                  for ($i=0; $i < sizeof($mode); $i++) { 
                        echo "<tr> <th> ".$keys[$i] ." </th> <td>".$mode[$keys[$i]]."</td> </tr>";
                  }
                  echo "</table>";
            }

            function getAllLieuBD(){
                  $sql = "SELECT lieu FROM phonemes WHERE consonant = 1" ;
                  $ret = $this->query($sql);
                  $arr= array();
                  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
                         array_push($arr, $row['lieu']);
                  };
                  return array_unique($arr);
            }

            function getAllModeBD(){
                  $sql = "SELECT mode FROM phonemes WHERE consonant = 1" ;
                  $ret = $this->query($sql);
                  $arr= array();
                  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
                         array_push($arr, $row['mode']);
                  };
                  return array_unique($arr);
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
      		//return "";//just in case...
      	}

            function CouV($phoneme){
                  if($phoneme != ""){
                  $estCompose = $this->estCompose($phoneme);
                  $estConsonne = $this->consonnePresent($phoneme);
                  $estVoyelle = $this->voyellePresent($phoneme);
                  if($estCompose == 1){
                        return $estConsonne!==0?$estConsonne:$estVoyelle;
                  }

                  return $phoneme;
                  }
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

            function estPrefixe($lexeme){
                  if($this->aAffixe($lexeme)==1){
                        return (strpos($lexeme, '-')==0?1:0);
                  }
                  return 0;
            }

            function estSuffixe($lexeme){
                  if($this->aAffixe($lexeme)==1){
                        return (strpos($lexeme, '-')==(strlen($lexeme)-1)?1:0);
                  }
                  return 0;
            }

            /*function estSuffixe($phoneme){
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
            }*/
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

            function getVoyellesById($id){
                  $phonemes = $this->getAllPhonemesById($id);
                  //print_r(array_count_values($phonemes));
                  $arr = array();
                  for ($i=0; $i < sizeof($phonemes); $i++) { 
                        $phoneme = $this->CouV($phonemes[$i]);
                        if($phoneme != "" && $this->estConsonne($phoneme)!=1){
                              array_push($arr, $phoneme);
                        }
                  }
                  return array_count_values($arr);
            }
      /*
      function searchVInLex($id){
            $voyelles=$this->getVoyellesById($id);
            $keys=array_keys($voyelles);
            $lexemes=$this->getAllLexemesById($id);
            $arr = array();
            for ($i=0 ; $i < sizeof($voyelles) ; $i++) { 
                  for ($e=0; $e < sizeof($lexemes) ; $e++) { 
                       $phonemes = $this->getPhonsEtDiacPerLex($lexemes[$e]);
                       $pos = array_search($keys[$i], $phonemes);
                       if ($pos !== false) {
                             $line="<p>"; 
                             $j = 0;
                             while ( $j < sizeof($phonemes)) {
                                    if ($j != $pos) {
                                         $line .= $phonemes[$j];
                                    }   
                                
                                    if($j == $pos){
                                          $line .= "<span style='color:red'>".$phonemes[$j]."</span>";
                                         $phonemes[$pos]="-";
                                          $pos = array_search($keys[$i], $phonemes);
                                         
                                    }
                                    
                                    $j++;
                              }

                              $line.="</p>";
                              array_push($arr, $line) ;
                       }           
                      
                  }
            }
            
            return $arr;
      }*/
       function searchVInLex($id){
            $voyelles=$this->getVoyellesById($id);
            $keys=array_keys($voyelles);
            $lexemes=$this->getAllLexemesById($id);
            $arr = array();
            
            for ($i=0 ; $i < sizeof($voyelles) ; $i++) { 
                  $arr1= array();
                  for ($e=0; $e < sizeof($lexemes) ; $e++) { 
                       $phonemes = $this->getPhonsEtDiacPerLex($lexemes[$e]);
                       $pos = array_search($keys[$i], $phonemes);
                       if ($pos !== false) {
                             $line="<p>"; 
                             $j = 0;
                             while ( $j < sizeof($phonemes)) {
                                    if ($j != $pos) {
                                         $line .= $phonemes[$j];
                                    }   
                                    if($j == $pos){
                                          $line .= "<span style='color:red'>".$phonemes[$j]."</span>";
                                         $phonemes[$pos]="-";
                                          $pos = array_search($keys[$i], $phonemes);
                                         
                                    }
                                    
                                    $j++;
                              }

                              $line.="</p>";
                              array_push($arr1, $line) ;
                       }           
                      
                  }
                  array_push($arr, $arr1) ;
            }
            
            return $arr;
      }

      function searchCInLex($id){
            $consonnes=$this->getConsonnesById($id);
            $keys=array_keys($consonnes);
            $lexemes=$this->getAllLexemesById($id);
            $arr = array();
            for ($i=0 ; $i < sizeof($consonnes) ; $i++) { 
                  $arr1= array();
                  for ($e=0; $e < sizeof($lexemes) ; $e++) { 
                       $phonemes = $this->getPhonsEtDiacPerLex($lexemes[$e]);
                       $pos = array_search($keys[$i], $phonemes);
                       if ($pos !== false) {
                             $line="<p>"; 
                             $j = 0;
                             while ( $j < sizeof($phonemes)) {
                                    if ($j != $pos) {
                                         $line .= $phonemes[$j];
                                    }   
                                
                                    if($j == $pos){
                                          $line .= "<span style='color:red'>".$phonemes[$j]."</span>";
                                         $phonemes[$pos]="-";
                                          $pos = array_search($keys[$i], $phonemes);
                                         
                                    }
                                    
                                    $j++;
                              }

                              $line.="</p>";
                              array_push($arr1, $line) ;
                       }           
                      
                  }
                  array_push($arr, $arr1) ;
            }
            
            return $arr;
      }

            function getConsonnesById($id){
                  $phonemes = $this->getAllPhonemesById($id);
                  //print_r(array_count_values($phonemes));
                  $arr = array();
                  for ($i=0; $i < sizeof($phonemes); $i++) { 
                        $phoneme = $this->CouV($phonemes[$i]);
                        if($phoneme != "" && $this->estConsonne($phoneme)==1){
                              array_push($arr, $phoneme);
                        }
                  }
                  return array_count_values($arr);
            }

            

            
            
            function decomposer($phoneme){
                  if ($this->estCompose($phoneme) ==1) {
                       $arr = array();
                       $cv = $this->CouV($phoneme);
                       $sizecv = strlen($cv);
                       $pos = stripos($phoneme, $cv);
                       $line="";
                      for ($i=0; $i < strlen($phoneme) ; $i++) { 
                              if ($i < $pos) {
                                    $line .= substr($phoneme, $i,1); 
                              }
                              if ($i == $pos) {
                                   if ($line != "") {
                                         array_push($arr, $line);
                                    } 
                                    array_push($arr, substr($phoneme, $pos, $sizecv));
                                    array_push($arr, substr($phoneme, $pos+$sizecv));
                              }        
                      }
                      return $arr;
                  }
                  
                  return $phoneme;
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
                              $phoneme =$this->CouV($ex[$e]);
                              array_push($res, $phoneme);
                          }  
                 }
                 return $res;
            }

            function getAllPhonsPerLex($lexeme){
                 $lex = explode(" ", $lexeme);
                 return $lex;
            }

            function getPhonsEtDiacPerLex($lexeme){
                 $lex = $this->getAllPhonsPerLex($lexeme);
                 $arr=array();
                 for ($i=0; $i < sizeof($lex); $i++) { 
                        $lex[$i]=$this->decomposer($lex[$i]);
                        if (gettype($lex[$i])=="array") {
                              foreach ($lex[$i] as $key) {
                                     array_push($arr, $key);
                                }  
                        }
                        else{
                              array_push($arr, $lex[$i]);
                        }
                 }
                 return $arr; 
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
                  //$gabarit = "";
                  $gabarit = array();
                  for ($i=0; $i < sizeof($mots); $i++) { 
                        if($mots[$i]!=""){
                              //$gabarit .= $this->getGabaritLex($mots[$i])."\n" ;
                              array_push($gabarit, $this->getGabaritLex($mots[$i]));
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