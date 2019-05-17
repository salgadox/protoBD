<?php include "public/templates/header.php"; ?>


<?php	
	/*Connecion en la base de datos */
	class MyDB extends SQLite3 {
      	function __construct() {
        	$this->open('ProtoDB.db');
      	}
   	}
	$db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

   /*Fin Connecion en la base de datos */

   /*Lectura del fichiero */
   	$handle = fopen("public/uploads/afroasiatic_proto_transcrit.txt", "r");
	$tout=file("public/uploads/afroasiatic_proto_transcrit.txt",FILE_IGNORE_NEW_LINES);
   /*Fin lectura del fichiero */
	print "<table>";
	$i=0;
	while($i<sizeof($tout)){	
		/*$info=explode(" ",$tout[$i]);
		print "<tr><td>".$info[0]."</td><td>".$info[1]."</td><td>".$info[2]."</td></tr>";*/
		print "$i $tout[$i]\n";
		$sql ="
				INSERT INTO lexeme (lexeme_id,langue_id,transcription)
     			VALUES ('$i', 1, '$tout[$i]')";
   		$db->exec($sql);
  		$i = $i+1;
		}
		print "</table>";
		fclose( $handle );

  /* $i=0;
   while(){
   $sql ="INSERT INTO COMPANY (ID,NAME,AGE,ADDRESS,SALARY)
      VALUES ($i, 'Ximena', 32, $info[$i], 20000.00 )";
   
   $ret = $db->exec($sql);
   $i = $i+1;
   }*/
  
   $db->close();

?>

		