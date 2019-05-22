<?php include "ProtoClass.php"; ?>
<?php include "public/templates/header.php"; ?>
<div class="center">
    <h2>Recherche avancée</h2>
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
        
        <label for="langue">type de recherche</label>
        <select name="recherche" form="langSel">
            <option value="iniMot">chercher en position initial du mot</option> 
            <option value="iniRac">chercher en position initial du racine</option>
            <option value="finMot">chercher en position final du mot</option>  
            <option value="finRac">chercher en position final du racine</option> 
        </select>
        <div class="column">
            <label style="font-weight: bold;"><input type='radio' name='par' value='phon' > Phoneme</label>
             <div class="column">
       <label><input type='radio' name='cv' value='Consonne'> Consonne</label>
       <select name="cons" form="langSel">
            <?php 
            $db= new Proto();
            $consonne= $db->getConsonnesBD();
            for ($i=0; $i < sizeof($consonne); $i++) { 
                echo "<option value='".$consonne[$i]."'>".$consonne[$i]."</option>";
            }
            ?>   
        </select>
        </div>
        <div class="column">
        <label><input type='radio' name='cv' value="Voyelle"> Voyelle </label>
        <select name="voy" form="langSel">
        <?php 
            $db= new Proto();
            $voyelle= $db->getVoyellesBD();
            for ($i=0; $i < sizeof($voyelle); $i++) { 
                echo "<option value='".$voyelle[$i]."'>".$voyelle[$i]."</option>";
            }
            ?>
        </select>
        </div>
            <label style="font-weight: bold;"><input type='radio' name='par' value='lieu'> lieu </label>
            </br>
            <select name="lieu" form="langSel">
                <?php 
                $db= new Proto();
                $arr= $db->getAllLieuBD();
                foreach ($arr as $key ) {
                    echo "<option value='".$key."'>".$key."</option>";
                } 
                ?>
            </select>
        </div> 

        <div class="column">
            <label style="font-weight: bold;"><input type='radio' name='par' value='mode'> mode</label>
            <label>  -- </label>
            </br>
                <select name="mode" form="langSel">
                    <?php 
                    $db= new Proto();
                    $arr= $db->getAllModeBD();
                    foreach ($arr as $key ) {
                        echo "<option value='".$key."'>".$key."</option>";
                    } 
                    ?>
                </select>
            <label style="font-weight: bold;"><input type='radio' name='par' value='modeVo'> mode avec voisement</label>
            </br>
                <select name="modeVo" form="langSel">
                    <?php 
                    $db= new Proto();
                    $arr= $db->getAllModeBD();
                    foreach ($arr as $key ) {
                        echo "<option value='".$key."'>".$key."</option>";
                    } 
                    ?>
                </select>
        </div>    
      
        </br>	
        </br>
        <input type="submit" name="submit" value="select">
    </form>
</div>

<?php
$db = new Proto();
$name=$_POST['langue'];
$recherche=$_POST['recherche'];
$c = $_POST['cons'];
$v = $_POST['voy'];
$id = $db->getIdLang($name);
echo "<div class='center'>";
	if (isset($_POST['submit'])&& $_POST["submit"]=="select" ) {
        if (isset($_POST['par']) && $_POST['par'] == 'phon') {  
                if ($recherche=='iniMot') {
                    if (isset($_POST['cv']) && $_POST['cv']=='Consonne') {
                        $arr= ($db->matchDebMot($id, $c));
                    }
                    if(isset($_POST['cv']) && $_POST['cv']=='Voyelle') {
                        
                        $arr= ($db->matchDebMot($id, $v));
                    }
                }
                if ($recherche=='iniRac') {
                    if (isset($_POST['cv']) && $_POST['cv']=='Consonne') {
                        $arr= ($db->matchDebRac($id, $c));
                    }
                    if(isset($_POST['cv']) && $_POST['cv']=='Voyelle') {   
                        $arr= ($db->matchDebRac($id, $v));
                    }
                }
                if ($recherche=='finMot') {
                    if (isset($_POST['cv']) && $_POST['cv']=='Consonne') {
                        $arr= ($db->matchFinMot($id, $c));
                    }
                    if(isset($_POST['cv']) && $_POST['cv']=='Voyelle') {
                        $arr= ($db->matchFinMot($id, $v));
                    }
                }
                if ($recherche=='finRac') {
                    
                    if (isset($_POST['cv']) && $_POST['cv']=='Consonne') {
                        $arr= ($db->matchFinRac($id, $c));
                    }
                    if(isset($_POST['cv']) && $_POST['cv']=='Voyelle') { 
                        $arr= ($db->matchFinRac($id, $v));
                    }
                    
                }
        }
            if (isset($_POST['par']) && $_POST['par'] == 'lieu') {
                if ($recherche=='iniMot') {
                   $arr=($db->matchDebMotLieu($id, $_POST['lieu'])); 
                }
                if ($recherche=='iniRac') {
                   $arr=($db->matchDebRacLieu($id, $_POST['lieu'])); 
                }
                if ($recherche=='finMot') {
                   $arr=($db->matchFinMotLieu($id, $_POST['lieu'])); 
                }
                if ($recherche=='finRac') {
                    $arr=($db->matchFinRacLieu($id, $_POST['lieu'])); 
                }
            }

            if (isset($_POST['par']) && $_POST['par'] == 'mode') {
                if ($recherche=='iniMot') {
                   $arr=($db->matchDebMotMode($id, $_POST['mode'])); 
                }
                if ($recherche=='iniRac') {
                   $arr=($db->matchDebRacMode($id, $_POST['mode'])); 
                }
                if ($recherche=='finMot') {
                   $arr=($db->matchFinMotMode($id, $_POST['mode'])); 
                }
                if ($recherche=='finRac') {
                    $arr=($db->matchFinRacMode($id, $_POST['mode'])); 
                }
            }


            if(count($arr)>0){
                echo "<div style= margin:30px'>";
                echo "<table>"."<tr> <th> Langue: </th> <td>".$name."</td> </tr>";
                echo "<tr> <th> total: </th> <td>".count($arr)."</td> </tr>";
                foreach ($arr as $key) {
                    echo "<tr> <th> </th> <td>".$key."</td> </tr>";
                }
                echo "</div>";
            }else{
                echo "non trouvé";
            }
    }
    
    echo "</div>";

    //$db->(2)
        
    
?>