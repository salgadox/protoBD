<?php include "public/templates/header.php"; ?>


<?php	

	class MyDB extends SQLite3 {
      	function __construct() {
        	$this->open('test.db');
      	}
   	}
   	$db = new MyDB();
   	if(!$db) {
    	echo $db->lastErrorMsg();
   	} else {
    	echo "Opened database successfully\n";
    }

    echo "here"; 
    print_r( file_get_contents("public/uploads/afroasiatic_proto_transcrit.txt"));

	$handle = fopen("public/uploads/afroasiatic_proto_transcrit.txt", "r");
	$tout=file("public/uploads/afroasiatic_proto_transcrit.txt",FILE_IGNORE_NEW_LINES);
	print "<table>";
	for($i=0;$i<sizeof($tout);$i++){	
		$info=explode(" ",$tout[$i]);
		print "<tr><td>".$info[0]."</td><td>".$info[1]."</td><td>".$info[2]."</td></tr>".
		"</td><td>".$info[3]."</td></tr>";
		}
		print "</table>";
		fclose( $handle );

?>
<!--
	<form method="post" enctype="multipart/form-data" action="td_lecture_fichiers.php">
		<input type="file" name="fichier">
		<input type="submit" name="valider" value="Uploader">
	</form>
		
<?php
			
	/**if (isset($_POST['valider'])){
		$erreur=0;
		if ($_FILES['fichier']['error']>0){
			print "<br>Erreur d'upload du fichier";
			$erreur=1;
		}
		if ($_FILES['fichier']['size']>20000){
			print "<br>Fichier trop volumineux :";
			$erreur=1;
		}
		if (substr($_FILES['fichier']['name'],-3)!="csv"){
			print "<br>Le format de fichier n'est pas bon. Format CSV attendu.";
			$erreur=1;
		}
		if ($erreur==1){
			print "<br>Veuillez sélectionner un fichier à uploader<br>";
		}else{
			move_uploaded_file($_FILES['fichier']['tmp_name'],"lexique.csv");
		}
	}
	print $_FILES['fichier']['type'];*/
?>-->
		