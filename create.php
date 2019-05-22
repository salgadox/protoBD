<?php include "ProtoClass.php"; ?>
<?php include "public/templates/header.php"; ?>


<?php	
	$db = new Proto();
   
   /*Fin Connecion en la base de datos */

   /*Lectura del fichiero */
   	$handle = fopen("public/uploads/afroasiatic_proto_transcrit.txt", "r");
    $gab= $db->getGabaritFile("public/uploads/afroasiatic_proto_transcrit.txt");
	$tout=file("public/uploads/afroasiatic_proto_transcrit.txt",FILE_IGNORE_NEW_LINES);
   /*Fin lectura del fichiero */
	print "<table>";
	$i=0;
	while($i<sizeof($tout)){	
		/*$info=explode(" ",$tout[$i]);
		print "<tr><td>".$info[0]."</td><td>".$info[1]."</td><td>".$info[2]."</td></tr>";*/
		print "$i $tout[$i]\n";
		$sql ="
				INSERT INTO lexeme (lexeme_id,langue_id,transcription, gabarit)
     			VALUES ('$i', 1, '$tout[$i]','$gab[$i]')";
   		$db->exec($sql);
  		$i = $i+1;
		}
		print "</table>";
		fclose( $handle );

 
  
   $db->close();

?>

		