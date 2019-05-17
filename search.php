<?php include "ProtoClass.php"; ?>
<?php include "public/templates/header.php"; ?>
<div class="center">
    <h2>Interface de requêtes</h2>
    <h3>__</h3>

    <form action="#" method="post" id="langSel">
    	<label for="langue">Langue</label>
    	<select name="langue" form="langSel">
    		<option value="toutes">toutes les langues</option>
    		<?php 
    		$db= new Proto();
    		$langues = $db->getAllLangues();
    		for ($i=0; $i < sizeof($langues); $i++) { 
    			echo "<option value='".$langues[$i]."'>".$langues[$i]."</option>";
    		}
    		?>	
    	</select>
        <div class="column">
        <p><input type='radio' name='genInfo'> General information</p>
        <p><input type='radio' name='gabarits'>  Gabarits </p>
        <p><input type='radio' name='lieu'> Par lieu </p>
        </div>
        <div class="column">
        <p><input type='radio' name='mode'> Par mode </p>
        <p><input type='radio' name='all'> Gabarit + lieu + mode </p>
        <p><input type='radio' name='avance'> recherche avancé </p>
        </div>
        </br>
    	
    </br>
    <input type="submit" name="submit" value="select">
    </form>
</div>
<?php
$db = new Proto();
$name=$_POST['langue'];
$id = $db->getIdLang($name);

	if (isset($_POST['submit'])&& $_POST["submit"]=="select" ) {
        if (isset($_POST['genInfo'])) {
            echo "<div class='center'>";
            echo $db->getGeneralInfoID($id);
            echo "</div>";
        }
        if (isset($_POST['gabarits'])) {
            echo "<div class='center'>";
            echo $db->getGabaritById($id);
            echo "</div>";
        }
        if (isset($_POST['lieu'])) {
            echo "<div class='center'>";
            echo $db->getLieuById($id);
            echo "</div>";
        }
        if (isset($_POST['mode'])) {
            echo "<div class='center'>";
            echo $db->getModeById($id);
            echo "</div>";
        }
        if (isset($_POST['all'])) {
            echo "<div class='center'>";
            echo $db->getGabLieuMode($id);
            echo "</div>";
        }
    }
        
    
?>