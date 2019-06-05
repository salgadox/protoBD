<?php
class Proto extends SQLite3 {
      /**
      *Functions: 
      *      Contructeurs: 
      *            __contruct()
      *
      *      Funtions to get informaion
	  *		 	-from all language
      *            		getAllLangues()
      *            		totaleLang()
	  *					getGeneralInfo()
	  *			-from one language
	  *            		getNameLang($id)
      *            		getIdLang($name)
      *            		getGeneralInfoID($id)
      *            		moreInfoV($id)
      *            		moreInfoC($id)
      *
      *      Functions for/to get the CV template 
      *            		getGabaritById($id)
      *            		getDiffGabaritById($id)
      *            		countDiffGabaritById($id)
      *            		getInfoGabarit($id)
      *    
      *      Funtions to get info/about place/manner of articulation
      *            		getGabLieuMode($id)
	  *		 	-place	
      *            		getLieuById($id)
      *            		getInfoLieu($id)
      *            		getInfoLieuDiff($id)
	  *
      *      	-manner 	  
      *            		getModeById($id)
      *            		getInfoMode($id)
      *            		getInfoModeDiff($id)
	  *	
      *      Functions to get info about the phonemes: 
	  *            		getInfoPhonById($id)
      *            		getInfoPhon($phoneme)
      *            		getId($phoneme)
      *            		getLieu($phoneme)
      *            		getLieuLexArray($lexeme)
      *            		getLieuLex($lexeme)
      *            		getMode($phoneme)
      *            		getModeLex($lexeme)
      *            		getModeLexArray($lexeme)
	  *			-in detail
      *           		estVoise($phoneme)
      *            		estDiacritique($phoneme)
      *            		estEjective($phoneme)
      *            		estAffixe($phoneme)
      *            		aAffixe($phoneme)
      *            		estCompose($phoneme)
      *            		estSuffixe($phoneme)
      *            		estPrefixe($phoneme)
	  *                 decomposer()
	  *
	  *		Functions for CV
	  *	           		CV($phoneme)
      *            		CouV($phoneme)
	  *			-consonants
	  *					estConsonne($phoneme)
      *            		consonnePresent($phoneme)
	  *                 searchCInLex($id)
	  *                 getConsonneById($id)
	  *			-vowels
      *            		voyellePresent($phoneme)
      *            		getVoyellesById($id)
      *            		searchVInLex($id)
      *     
      *      Function to get info from BD
      *            		getAllLexemesBD()
      *            		getAllLexemesById($id)
      *            		getAllPhonemesDB()
      *            		getAllPhonemesById($id)
      *            		getAllPhonsPerLex($lexeme)
      *            		getDiacritiqueBD()
      *            		getVoyellesBD()
      *            		getConsonnesBD()
      *            		getGabaritLex($lexeme)
      *            		getGabaritBD($donnees)
	  *			-get total
      *            		conuntLexDB($donnees)
      *            		countTotalPhonDB($donnees)
      *            		countDiffPhonDB($donnees)
      *            		getDiffPhonDB($donnees)
      *
      *      Funtions to get info from file
      *            		getGabaritFile($file)
      *            		getCleanLexArray($file)
      *            		getCleanPhonArray($file)
	  *            		getDiffPhon($file)
      *            		countLex($file)
      *            		countTotalPhon($file)
      *            		countDiffPhon($file)
      *
      **/
      	function __construct() {
			/**
			* @detail constructor
			* @param no parameters 
			* @return creates object
			*/
        	   $this->open('ProtoDB.db');
      	}

        function getAllLangues(){
			/**
			* @detail get the names of all the languages 
			* @param none
			* @return string array 
			*/
            $sql = "SELECT langue_nom FROM langues" ;
            $ret = $this->query($sql);
            $langues = array();
            while($row = $ret->fetchArray(SQLITE3_ASSOC)){
                array_push($langues, $row['langue_nom']);
            };
            return $langues;
        }

        function getNameLang($id){
			/**
			* @detail get the name of a language using their id 
			* @param int
			* @return string
			*/
            $sql = "SELECT langue_nom FROM langues WHERE langue_id =='".$id."'";
            $ret = $this->query($sql);
            $rs= $ret->fetchArray(SQLITE3_ASSOC);
            return $rs['langue_nom'];
        }

        function getIdLang($name){
			/**
			* @detail get the id of a language using their name  
			* @param string
			* @return int
			*/
            $sql = "SELECT langue_id FROM langues WHERE langue_nom =='".$name."'";
            $ret = $this->query($sql);
            $rs= $ret->fetchArray(SQLITE3_ASSOC);
            return $rs['langue_id'];
        }

        function totaleLang(){
			/**
			* @detail get the total number of all languages in the BD
			* @param none
			* @return int
			*/
            $sql = "SELECT COUNT(langue_id) FROM langues";
            $ret = $this->query($sql);
            $rs= $ret->fetchArray(SQLITE3_ASSOC);
            $keys = array_keys($rs);
            return $rs[$keys[0]];
        }

        function getGeneralInfo(){
			/**
			* @detail visual representation : table with info from all languages
			* @param none
			* @return prints in the screen
			*/
            echo "<table>";
            echo "<tr> <th> toutes les langue: </th> <td> </td> </tr>";
            echo "<tr> <th> nombre de langues: </th> <td>".$this->totaleLang()."</td> </tr>";
            echo "</table>";
        }

        function getGeneralInfoID($id){
			/**
			* @detail visual representation : table with info from a specific language
			* @param int
			* @return prints in the screen
			*/
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
			/**
			* @detail visual representation: table with vowel info from a specific language
			* @param int
			* @return prints in the screen
			*/
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
			/**
			* @detail visual representation : table with consonnat info from a specific language
			* @param int
			* @return prints in the screen
			*/
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
			/**
			* @detail visual representation : a table with the CV template  from a specific language
			* @param int
			* @return prints in the screen
			*/
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
			/**
			* @detail get a array with the CV template from a specific language
			* @param int
			* @return string array
			*/
			  $lexemes = $this->getAllLexemesById($id);
			  $gabarits = $this->getGabaritBD($lexemes);
			  return array_count_values($gabarits);
		}

		function countDiffGabaritById($id){
			/**
			* @detail get the total number of all the differents CV templates from a specific lang.
			* @param int
			* @return int
			*/
			  return count(($this->getDiffGabaritById($id)));
		}

		function getInfoGabarit($id){
			/**
			* @detail visual representation: table with the CV template info from a specific language
			* @param int
			* @return prints in the screen
			*/
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
			/**
			* @detail get array with all the "words" from a specific language
			* @param int
			* @return string array
			*/
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
			/**
			* @detail get array with all the'prefixes roots'
			* @param int
			* @return string array 
			*/
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
			/**
			* @detail get array with all the'suffixes roots
			* @param int
			* @return string array  
			*/
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
			/**
			* @detail get all the words that start with a certain phoneme from a specif language 
			* @param int, string
			* @return string array
			*/
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
			/**
			* @detail get all the words that start with a certain place of articulation  
			* @param int, string
			* @return string array 
			*/
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
			/**
			* @detail get all the words that end with a certain place of articulation  
			* @param int, string
			* @return string array 
			*/
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
			/**
			* @detail get all the words that start with a certain manner a specif language 
			* @param int, string
			* @return string array 
			*/
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
			/**
			* @detail get all the words that end with a certain manner from a specif language 
			* @param int, string
			* @return string array 
			*/
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
			/**
			* @detail get all the words that end with a certain phoneme from a specif language 
			* @param int, string
			* @return string array 
			*/
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
			/**
			* @detail get all the roots that start with a certain manner from a specif language 
			* @param int, string
			* @return string array 
			*/
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
			/**
			* @detail get all the roots that end with a certain manner from a specif language 
			* @param int, string
			* @return string array
			*/
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
			/**
			* @detail get all the roots that start with a certain place from a specif language 
			* @param int, string
			* @return string array 
			*/
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
			/**
			* @detail get all the roots that end with a certain place from a specif language 
			* @param int, string
			* @return string array 
			*/
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
			/**
			* @detail get all the roots that start with a certain phoneme from a specif language 
			* @param int, string
			* @return string array 
			*/
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
			/**
			* @detail get all the roots that end with a certain phoneme from a specif language 
			* @param int, string
			* @return string array 
			*/
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
			/**
			* @detail visual representation: table for a specific lang with the word and its place of articulation template
			* @param int
			* @return prints in the screen
			*/
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
			/**
			* @detail visual representation: table for a specific lang with the word and its manner of articulation template
			* @param int
			* @return prints in the screen
			*/
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
			/**
			* @detail visual representation: table for a specific lang with the word and its manner, place and CV template
			* @param int
			* @return prints in the screen 
			*/
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
			 /**
			* @detail get an array from a specific language withe the place of articulation template for every lexeme
			* @param int
			* @return string array
			*/
			  $lexemes = $this->getAllLexemesById($id); 
			  $lieu = array();
			  for ($i=0; $i < sizeof($lexemes); $i++) { 
				   array_push($lieu, $this->getLieuLex($lexemes[$i])); 
			  }
			  
			  return $lieu;
		   
		}
/**TODO*/
		function getInfoPhonById($id){
			/**
			* @detail 
			* @param int
			* @return prints in the screen
			*/
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
			/**
			* @detail get an array from a specific language withe the manner of articulation template for every lexeme
			* @param int
			* @return string array 
			*/
			  $lexemes = $this->getAllLexemesById($id); 
			  $mode = array();
			  for ($i=0; $i < sizeof($lexemes); $i++) { 
				   array_push($mode, $this->getModeLex($lexemes[$i])); 
			  }
			  return $mode;
		}

		function getInfoLieuDiff($id){
			/**
			* @detail visual representation: table for a specific lang with the all the differents place of articulation template and its total
			* @param int
			* @return prints in the screen  
			*/
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
			/**
			* @detail visual representation: table for a specific lang with the all the differents manner of articulation template and its total
			* @param int
			* @return prints in the screen 
			*/
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
			/**
			* @detail get an array from the BD with all the places of articulation 
			* @param none
			* @return string array 
			*/
			  $sql = "SELECT lieu FROM phonemes WHERE consonant = 1" ;
			  $ret = $this->query($sql);
			  $arr= array();
			  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
					 array_push($arr, $row['lieu']);
			  };
			  return array_unique($arr);
		}

		function getAllModeBD(){
			/**
			* @detail get an array from the BD with all the manners of articulation 
			* @param none
			* @return string array 
			*/
			  $sql = "SELECT mode FROM phonemes WHERE consonant = 1" ;
			  $ret = $this->query($sql);
			  $arr= array();
			  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
					 array_push($arr, $row['mode']);
			  };
			  return array_unique($arr);
		}

		function getId($phoneme){
			/**
			* @detail get id from a phoneme
			* @param string
			* @return int
			*/
			$sql = "SELECT phoneme_id FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['phoneme_id'];
		}
		
		function getLieu($phoneme){
			/**
			* @detail get the place of articulation from a phoneme 
			* @param string
			* @return string
			*/
				  $phoneme =$this->CouV($phoneme);
			$sql = "SELECT lieu FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['lieu'];
		}

		function getLieuLexArray($lexeme){
			/**
			* @detail getan array with the place of articulation template from a specific lexeme
			* @param string
			* @return string array
			*/
			  $phonemes = $this->getAllPhonsPerLex($lexeme);
			  $lieu = array();
			  for ($e=0; $e < sizeof($phonemes); $e++) { 
					array_push($lieu, $this->getLieu(trim($phonemes[$e])));
			  }
			  return $lieu;
		}

		function getLieuLex($lexeme){
			/**
			* @detail get a string of the place of articulation template from a specific lexeme
			* @param string
			* @return string  
			*/
			  $phonemes = $this->getAllPhonsPerLex($lexeme);
			  $lieu = "";
			  for ($e=0; $e < sizeof($phonemes); $e++) { 
					$lieu .= $this->getLieu(trim($phonemes[$e]))." ";
			  }
			  return $lieu;
		}

		function getMode($phoneme){
			/**
			* @detail get the manner of articulation from a phoneme 
			* @param string
			* @return string
			*/
				  $phoneme =$this->CouV($phoneme);
			$sql = "SELECT mode FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['mode'];
		}

		function getModeLex($lexeme){
			/**
			* @detail get a string of the manner of articulation template from a specific lexeme
			* @param string
			* @return string 
			*/
				  $phonemes = $this->getAllPhonsPerLex($lexeme);
				  $mode = "";
				  for ($e=0; $e < sizeof($phonemes); $e++) { 
						$mode .= $this->getMode($phonemes[$e]). " ";
				  }
				  return $mode;
			}

		function getModeLexArray($lexeme){
			/**
			* @detail getan array with the manner of articulation template from a specific lexeme
			* @param string
			* @return string array 
			*/
				  $phonemes = $this->getAllPhonsPerLex($lexeme);
				  $mode = array();
				  for ($e=0; $e < sizeof($phonemes); $e++) { 
						array_push($mode, $this->getMode($phonemes[$e]));
				  }
				  return $mode;
			}

		function estConsonne($phoneme){
			/**
			* @detail check if the phoneme given is a consonant
			* @param string
			* @return boolean
			*/
			$sql = "SELECT consonant FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['consonant'];
		}
			
		function CV($phoneme){
			/**
			* @detail give a C char if the phoneme given is a consonant and a V if it's a vowel
			* @param string
			* @return char
			*/
				  $phoneme =$this->CouV($phoneme);
			$tmp = $this->estConsonne($phoneme);
			if ($tmp==0){
				return 'V';
			}
			if($tmp==1){
				return 'C';
			}
		}

		function CouV($phoneme){
			/**
			* @detail returns the phoneme without any diacritique
			* @param string
			* @return string
			*/
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
			/**
			* @detail 1 if the phoneme is voiced 0 if voiceless
			* @param string
			* @return boolean
			*/
			$sql = "SELECT voisement FROM phonemes WHERE phoneme =='".$phoneme."'";
			$ret = $this->query($sql);
			$rs= $ret->fetchArray(SQLITE3_ASSOC);
			return $rs['voisement'];
		}

			function estDiacritique($phoneme){
				/**
				* @detail 1 if the input is a diacritic symbol, 0 if not
				* @param string
				* @return boolean 
				*/
				  $sql = "SELECT diacritique FROM phonemes WHERE phoneme =='".$phoneme."'";
				  $ret = $this->query($sql);
				  $rs= $ret->fetchArray(SQLITE3_ASSOC);
				  return $rs['diacritique']==1?1:0;
			}

			function estEjective($phoneme){
				/**
				* @detail 1 if the phoneme is comes an ejective diacritic, 0 if not 
				* @param string
				* @return boolean 
				*/
				  if ($this->estDiacritique($phoneme) == 1){
						$eject = $this->getLieu($phoneme);
						return ($eject=="Ejective"?1:0); 
				  }
				  return 0;
			}

			function estAffixe($phoneme){
				/**
				* @detail 1 if the input is an '-' symbol (representing a root)
				* @param string
				* @return boolean 
				*/
				  if ($this->estDiacritique($phoneme) == 1){
						$affixe = $this->getLieu($phoneme);
						return ($affixe=="Affixe"?1:0); 
				  }
				  return 0;
			}

			function aAffixe($phoneme){
				/**
				* @detail 1 if the input has a '-' symbol (representing a root)
				* @param string
				* @return boolean 
				*/
				  return preg_match('/-/', $phoneme)?1:0;
			}

	   
			function estCompose($phoneme){
				/**
				* @detail 1 if the phoneme comes with any diacritic, 0 if not 
				* @param string
				* @return boolean
				*/
				  $size=strlen($phoneme);
				  $affixe = $this->aAffixe($phoneme);
				  return($size>=6 || $size ==2 || $affixe==1)?1:0;
			}

			function estPrefixe($lexeme){
				/**
				* @detail 1 if the phoneme comes with '-' symbol (representing a root) at the begining, 0 if not
				* @param string
				* @return boolean 
				*/
				  if($this->aAffixe($lexeme)==1){
						return (strpos($lexeme, '-')==0?1:0);
				  }
				  return 0;
			}

			function estSuffixe($lexeme){
				/**
				* @detail 1 if the phoneme comes with '-' symbol (representing a root) at the end, 0 if not
				* @param string
				* @return boolean 
				*/
				  if($this->aAffixe($lexeme)==1){
						return (strpos($lexeme, '-')==(strlen($lexeme)-1)?1:0);
				  }
				  return 0;
			}

			function consonnePresent($phoneme){
				/**
				* @detail return a the consonant if found inside the phoneme, 0 if nothing is found
				* @param string
				* @return string 
				*/
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
				/**
				* @detail return a the vowel if found inside the phoneme, 0 if nothing is found
				* @param string
				* @return string 
				*/
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
				/**
				* @detail get an array with all the vowels from a specific lexeme
				* @param int
				* @return string array 
				*/
				  $phonemes = $this->getAllPhonemesById($id);
				  $arr = array();
				  for ($i=0; $i < sizeof($phonemes); $i++) { 
						$phoneme = $this->CouV($phonemes[$i]);
						if($phoneme != "" && $this->estConsonne($phoneme)!=1){
							  array_push($arr, $phoneme);
						}
				  }
				  return array_count_values($arr);
			}

	   function searchVInLex($id){
		   /**
			* @detail search a specific vowel inside all the language lexemes and returns an array with colored tags
			* @param int
			* @return string array
			*/
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
			/**
			* @detail search a specific consonant inside all the language lexemes and returns an array with colored tags
			* @param int
			* @return string array
			*/
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
			/**
			* @detail get an array with all the consonants from a specific lexeme
			* @param int
			* @return string array 
			*/
			  $phonemes = $this->getAllPhonemesById($id);
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
			/**
			* @detail if phoneme comes with diacritic symbols it return split it up and returns an array wih all the components,return the phomene if not
			* @param string
			* @return string array
			*/
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
			/**
			* @detail visual representation: table for a specific phon with the all the information about the place, manner, voice...
			* @param string
			* @return prints in the screen 
			*/
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
			/**
			* @detail get a array with all the lexemes presents in the DB
			* @param none
			* @return string array
			*/
			  $sql = "SELECT transcription FROM lexeme" ;
			  $ret = $this->query($sql);
			  $lexeme = array();
			  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
					 array_push($lexeme, $row['transcription']);
			  };
			  return $lexeme;
		}

		function getAllLexemesById($id){
			/**
			* @detail get a array with all the lexemes from a specific language
			* @param int
			* @return string array
			*/
			  $sql = "SELECT transcription FROM lexeme WHERE langue_id == '".$id."'" ;
			  $ret = $this->query($sql);
			  $lexeme = array();
			  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
					 array_push($lexeme, $row['transcription']);
			  };
			  return $lexeme;
		}

		function getAllPhonemesDB(){
			/**
			* @detail get a array with all the phonemes presents in the DB
			* @param none
			* @return string array 
			*/
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
			/**
			* @detail get a array with all the phonemes presents in a specific language
			* @param int
			* @return string array 
			*/
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
			/**
			* @detail get a array with all the phonemes presents in a lexeme (without any diacritic symbol)
			* @param string
			* @return string array 
			*/
			 $lex = explode(" ", $lexeme);
			 return $lex;
		}

		function getPhonsEtDiacPerLex($lexeme){
			/**
			* @detail get a array with all the phonemes includind diacritics presents in a lexeme
			* @param string
			* @return string array  
			*/
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
			/**
			* @detail get a array with all the diacritics presents in the DB
			* @param none
			* @return string array 
			*/
			  $sql = "SELECT phoneme FROM phonemes WHERE diacritique == '1'";
			  $ret = $this->query($sql);
			  $diacritiques = array();
			  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
					 array_push($diacritiques, $row['phoneme']);
			  };
			  return $diacritiques;
		} 

		function getVoyellesBD(){
			/**
			* @detail get a array with all the vowels presents in the DB
			* @param none
			* @return string array 
			*/
			  $sql = "SELECT phoneme FROM phonemes WHERE consonant == '0'";
			  $ret = $this->query($sql);
			  $voyelles = array();
			  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
					 array_push($voyelles, $row['phoneme']);
			  };
			  return $voyelles;
		} 


		function getConsonnesBD(){
			/**
			* @detail get a array with all the consonants presents in the DB
			* @param none
			* @return string array 
			*/
			  $sql = "SELECT phoneme FROM phonemes WHERE consonant == '1'";
			  $ret = $this->query($sql);
			  $consonnes = array();
			  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
					 array_push($consonnes, $row['phoneme']);
			  };
			  return $consonnes;
		} 

		function getGabaritLex($lexeme){
			/**
			* @detail get a string with the CV template 
			* @param string
			* @return string  
			*/
			$phonList=explode(" ", $lexeme);
			$gabarit = "";
			for ($i=0; $i < sizeof($phonList) ; $i++) { 
				$gabarit.=$this->CV(trim($phonList[$i]));
			}
			return $gabarit;
		}

		function getGabaritBD($donnees){
			/**
			* @detail get a string with all the CV template from the given list
			* @param string
			* @return string array
			*/
				  $gabarit = array();
				  for ($i=0; $i < sizeof($donnees); $i++) { 
						array_push($gabarit, $this->getGabaritLex($donnees[$i]));
						}  
				  
				  return $gabarit;
			}
	  
		function conuntLexDB($donnees){
			/**
			* @detail count all the lexemes from the given list
			* @param array
			* @return int
			*/
			  return count($donnees);
		}      

		function countTotalPhonDB($donnees){
			/**
			* @detail count all the phonemes from the given list
			* @param array
			* @return int 
			*/
			  return count($donnees);
		}

		 function countDiffPhonDB($donnees){
			 /**
			* @detail count all the differents phonemes from the given list
			* @param array
			* @return int  
			*/
			  return count(array_count_values($donnees));
		}

		function getDiffPhonDB($donnees){
			/**
			* @detail get an array with all the differents phonemes from the given list
			* @param array
			* @return array
			*/
			  $MotArr = array_unique($donnees);
			  $keys = array_keys($MotArr);
			  $arr = array();
			  for ($i=0; $i < sizeof($keys); $i++) { 
				   array_push($arr, $MotArr[($keys[$i])]) ;
			  }
			  return $arr;
		}

		function getGabaritFile($file){
			/**
			* @detail get a string with all the CV template from the file given 
			* @param file
			* @return string array 
			*/
			  $mots = preg_split("/\n/", file_get_contents($file));
			  $gabarit = array();
			  for ($i=0; $i < sizeof($mots); $i++) { 
					if($mots[$i]!=""){
						  array_push($gabarit, $this->getGabaritLex($mots[$i]));
					} 
			  }
			  return $gabarit ;
		}


		function getCleanLexArray($file){
			/**
			* @detail get a array with all the lexemes from a file given (without any diacritic symbol)
			* @param file
			* @return string array 
			*/
			  $mots = preg_split("/\n/", file_get_contents($file));
			  for ($i=0; $i < sizeof($mots); $i++) { 
					if($mots[$i]==""){
						  unset($mots[$i]) ;
					} 
			  }
			  return $mots ;
		}

		function getCleanPhonArray($file){
			/**
			* @detail get a array with all the phonemes from a file given (without any diacritic symbol)
			* @param file
			* @return string array  
			*/
			  $mots = preg_split("/[\s]+/", file_get_contents($file));
			  for ($i=0; $i < sizeof($mots); $i++) { 
					if($mots[$i]==""){
						  unset($mots[$i]) ;
					}     
			  }
			  return $mots ;
		}

		function countLex($file){
			/**
			* @detail count all the lexemes from the given file
			* @param file
			* @return int
			*/
			  $MotArr = $this->getCleanLexArray($file);
			  return count($MotArr);
		}

		function countTotalPhon($file){
			/**
			* @detail count all the phonemes from the given file
			* @param file
			* @return int  
			*/
			  $MotArr = $this->getCleanPhonArray($file);
			  return count($MotArr);
		}

		 function  countDiffPhon($file){
			 /**
			* @detail count all the differents phonemes from the given file
			* @param file
			* @return int
			*/
			  $MotArr = $this->getCleanPhonArray($file);
			  return count(array_count_values($MotArr));
		}

		function getDiffPhon($file){
			/**
			* @detail get an array with all the differents phonemes from the given file
			* @param file
			* @return array 
			*/
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
