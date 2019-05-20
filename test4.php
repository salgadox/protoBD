<?php include "ProtoClass.php"; ?>
<?php include "public/templates/header.php"; ?>

<?php 

	$db = new Proto();
	//$file = "public/uploads/aja_proto_transcrit.txt";
	//echo "gabarit from FIle: ".$db->getGabaritFile($file);
	//$donnees = $db->getAllPhonemesDB();
	//$donnees = $db->getAllLexemesById(2);
	//echo "gabarit FROM DB: ".$db->getGabaritBD($donnees);
	//print_r($db->getAllLexemesBD());
	//echo $db->countLex($file);
	//echo $db->conuntLexDB($donnees);

	//echo $db->countTotalPhon($file);
	//echo $db->countTotalPhonDB($donnees);

	//echo $db->countDiffPhon($file);
	//echo $db->countDiffPhonDB($donnees);

	//print_r( $db->getDiffPhon($file));
	//print_r($db->getDiffPhonDB($donnees));


	//print_r($db->getAllLexemesById(2));

	//echo $db->getNameLang(2);
	//echo $db->getIdLang("aja");

	//echo $db->getGeneralInfoID(2);

	//print_r($db->getGabaritBD($donnees))

	//echo $db->getGabaritById(2);

	//print_r( $db->getDiffGabaritById(2));
	//echo $db->countDiffGabaritById(2);
	//$lexeme = "a j &#660";
	//print_r($db->getInfoLieu(2));
	//print_r($db->getInfoMode(2));
	//print_r($db->getLieuLex($lexeme));
	//print_r($db->getModeLex($lexeme));
	//print_r($bd->getAllPhonsPerLex("a j &#660"));
	//$db->getLieuById(2);
	//$db->getModeById(2);
	//print_r($db->getAllLangues());
	//print_r($db->getAllPhonsPerLex($lexeme));
	//$phoneme = "&#700";
	/*$phoneme = 'k-';
	$phoneme1= "&#612&#800";
	$lexeme = "a k w a&#720";
	
	echo $phoneme;
	echo $db->getId($phoneme);
	echo "<p> ext diacritique " . $db->estDiacritique($phoneme). "</p>";
	echo "<p> est Ejective " . $db->estEjective($phoneme). "</p>";
	echo "<p>a affixe " . $db->aAffixe($phoneme). "</p>";
	echo "<p>est compose " . $db->estCompose($phoneme). "</p>";
	echo "<p>est suffixe" . $db->estSuffixe($phoneme). "</p>";
	echo "<p>est preffixxe" . $db->estPreffixe($phoneme). "</p>";
	/*print_r($db-> getDiacritiquesBD());
	print_r($db->getConsonnesBD());
	print_r($db->getVoyellesBD());*/
	/*echo "<p>consonne Presente ".$db->consonnePresent($phoneme)."</p>";
	//echo "<p> voyelle presente ".$db->voyellePresent($phoneme)."</p>";
	echo "<p> voyelle presente ".$db->voyellePresent($phoneme1)."</p>";

	//echo $db->CouV($phoneme);
	//echo $db->CV($phoneme);
	//echo "id".$db->getId("w");
	 echo $db->getGabaritLex(trim("g u g u "));

	 echo $db->getInfoGabarit(2);
	 echo $db->getInfoLieuDiff(2);
     echo $db->getInfoModeDiff(2);*/

     //echo $db->infoToutesLang();
     //echo $db->tailleMoyen(2);
     //print_r( $db->getAllPhonemesById(2));
   //  print_r($db->getVoyellesById(2));
    // print_r($db->getConsonnesById(2));
    	echo $db->getInfoPhonById(2);


	
	


?>

  

