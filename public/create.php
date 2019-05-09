<?php include "templates/header.php"; ?>

<h2>Add language </h2>

<?php 
    $name = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];

    if (isset($name)) {
        //if not empty echo ok crea variable location 
        if (!empty($name)) {
         echo 'OK.';
         $location = 'uploads/';
            //new location 
            //función move de la locación temporal a la locación nueva y conservar el nombre del file '.$name'
        if (move_uploaded_file($tmp_name, $location.$name)){
            echo 'Uploaded!';
        }else{
            echo'There was an error';
        }

    }else {
        echo 'Please choose a file.';
    }
}
?>

<form action="create.php" method="POST" enctype="multipart/form-data">
    <p>Language name: <input type="text" name="langName"> </p>
    <p>Choose your file: <input type="file" name="file"></p>
    <p>Choose your second file: <input type="file" name="file2"></p>
    <input type="submit" name="Submit">
</form>
<?php  
$myPDO = new PDO('sqlite:/Users/xsal/Desktop/Gipsa_BD/test.db');
    $result = $myPDO->query("SELECT langue_nom from langues");
foreach ($result as $row) {
    print $row['langue_nom']."\n";
}
?>

    <a href="index.php">Back to home</a>

    <?php include "templates/footer.php"; ?>