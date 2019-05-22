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
            <p><input type='radio' name='gabInfo'> information gabarit</p>
            <p><input type='radio' name='lieuInfo'> information par lieu</p>
            <p><input type='radio' name='modeInfo'> information par mode</p>
            <p><input type='radio' name='phonInfo'> information par phoneme</p>
            <p><input type='radio' name='moreInfoV'> plus info #voyelle</p>
            

            </div>
        <div class="column">
            <p><input type='radio' name='moreInfoC'> plus info #consonne</p>
            <p><input type='radio' name='gabarits'>  Gabarits </p>
            <p><input type='radio' name='lieu'> Par lieu </p>
            <p><input type='radio' name='mode'> Par mode </p>
            <p><input type='radio' name='all'> Gabarit + lieu + mode </p>
           
        </div>
        </br>	
        </br>
        <input type="submit" name="submit" value="Select">
    </form>
    </br>   
    </br>
    <form action="advSearch.php">
        <input type="submit" name="advSearch" value="Recherche avancée">
    </form>
</div>

<?php
$db = new Proto();
$name=$_POST['langue'];
$id = $db->getIdLang($name);
echo "<div class='center'>";
	if (isset($_POST['submit'])&& $_POST["submit"]=="select" ) {
        if (isset($_POST['genInfo'])) {
            echo "<div  style='float:left; margin:10px'>";
            echo "<h4>General information</h4>";
            echo $db->getGeneralInfoID($id);
            echo "</div>";
        }
        if (isset($_POST['gabInfo'])) {
            echo "<div style='float:left; margin:10px'>";
            echo $db->getInfoGabarit($id);
            echo "</div>";
        }

        if (isset($_POST['modeInfo'])) {
            echo "<div style='float:left; margin:10px'>";
            echo $db->getInfoModeDiff($id);
            echo "</div>";
        }

        if (isset($_POST['lieuInfo'])) {
            echo "<div style='float:left; margin:10px'>";
            echo $db->getInfoLieuDiff($id);
            echo "</div>";
        }

        if (isset($_POST['gabarits'])) {
            echo "<div style='float:left; margin:10px'>";
            echo $db->getGabaritById($id);
            echo "</div>";
        }
        if (isset($_POST['lieu'])) {
            echo "<div style='float:left; margin:10px'>";
            echo $db->getLieuById($id);
            echo "</div>";
        }
        if (isset($_POST['mode'])) {
            echo "<div style='float:left; margin:10px'>";
            echo $db->getModeById($id);
            echo "</div>";
        }
        if (isset($_POST['all'])) {
            echo "<div style='float:left; margin:10px'>";
            echo $db->getGabLieuMode($id);
            echo "</div>";
        }
        if (isset($_POST['phonInfo'])) {
            echo "<div style='float:left; margin:10px'>";
            echo $db->getInfoPhonById($id);
            echo "</div>";
        }

        if (isset($_POST['moreInfoV'])) {
            echo "<div style='float:left; margin:10px'>";
            echo $db->moreInfoV($id);
            echo "</div>";
        }
        if (isset($_POST['moreInfoC'])) {
            echo "<div style='float:left; margin:10px'>";
            echo $db->moreInfoC($id);
            echo "</div>";
        }
        
    }
    echo "</div>";
    //$db->(2)
        
    
?>