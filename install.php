
<?php

/**
  * Open a connection via PDO to create a
  * new database and table with structure.
  *
  */

require "config.php";

try {
  //$connection = new PDO("sqlite:host=$host", $username, $password, $options);
	$myPDO = new PDO('sqlite:/Users/xsal/Desktop/Gipsa_BD/test.db');
	$result = $myPDO->query("SELECT * from langues");
//  $sql = file_get_contents("data/init.sql");
//  $connection->exec($sql);

  echo "Database and table users created successfully.";
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
