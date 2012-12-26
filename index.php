<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Theorie de la Sécurité</title>
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body class="home">
        <div id="content">
            <center><h1>Projet : Conception et analyse de protocoles cryptographiques</h1></center>
            
            <div class="menu">
                <a href="#Description">Description</a>
                <a href="#Classement">Classement</a>
                <a href="#Attaques">Attaques</a>
                <a href="#Attaquer">Attaquer</a>
            </div>
            
            <h2 id="Description">Description du projet</h2>
            <p class="description">L'objectif de ce projet est d'apprendre à concevoir des protocoles cryptographiques et à les modéliser et les analyser
            à l'aide de l'outil <span style="color : #00cccc">ProVerif</span>. Dans la première partie du projet, chaque groupe devra concevoir un protocole qui satisfait des contraintes données.
            Dans la deuxième partie du projet, tous les protocoles ainsi proposés seront analysés par chaque groupe. Les attaques trouvées devront être corrigées par les concepteurs
            du protocole attaqué</p>
            
            <div class="ligne" id="Classement"></div>
            <h2 >Classement des groupes</h2>
            
            <?php
//            ini_set('display_errors', 1);
            
                include('class/Groupes.php');
                include('connection.php');
                
                echo "<div><img class='trophee' src='pictures/gagnant2.png'/><p class='felicitations'>Félicitations au groupe ".Groupe::getWinner()->getNumero()."</p></div>";
                echo "
                   <table class='classement'>
                    <tr class='info'><td>Position</td><td>Groupe</td><td>Score</td></tr>";
                $i = 1;
                foreach (Groupe::getGroupes("score") as $g) {
                    echo "<tr><td class='info'>".$i."</td><td>Groupe ".$g->getNumero()."</td>
                              <td>".$g->getScore()."</td></tr>";
                    $i = $i+1;
                }
                echo "</table>";
                
              ?>
            
            <div class="ligne" id="Attaques"></div>
            <h2>Attaques des protocoles</h2>
            
             <?php
                echo "<table>
                        <tr>
                            <td class='info'></td>";
                            foreach (Groupe::getGroupes() as $g) {
                                $versions = $g->getVersions();
                                $version = "--";
                                if (sizeof($g->getVersions()) > 0){
                                    $version = "v".$versions[sizeof($g->getVersions())-1]->getNumero();
                                }
                                echo "<td class='info'>Groupe ".$g->getNumero()."<br>".$version."</td>";
                            }
                            echo "</tr>";
                        
                            foreach (Groupe::getGroupes() as $g) {
                                echo "  <tr>
                                            <td  class='info'>Groupe ".$g->getNumero()."</td>";
                                                foreach (Groupe::getGroupes() as $g3) {
                                                    if ($g->getNumero() == $g3->getNumero()){
                                                        echo "<td class='info'></td>";
                                                    }
                                                    else {
                                                        echo "<td>".$g->displayAttaques($g3)."</td>";
                                                    }
                                                }
                                        echo "</tr>";   
                }
                echo "</table>";
            ?>
            
            <div class="ligne" id="Attaquer"></div>
            <h2>Attaquer</h2>
            
            <?php 
                if (isset($_GET['error'])) {
                    echo "<div class=\"error\">".$_GET["error"]."</div>";
                }
                ?>
            
            <form action="checkAttaque.php" method="post">
                Vous êtes le 
                    <select name='groupeAttaquant'>
                        <option>...</option>
                        <?php
                            foreach (Groupe::getGroupes() as $g) {
                                 echo "<option id='groupeA' value='".$g->getNumero()."'>Groupe ".$g->getNumero()."</option>";
                            }
                        ?>
                    </select>
                et vous voulez attaquer le groupe 
                        <select name='groupeAttaque'>
                            <option>...</option>
                            <?php
                                foreach (Groupe::getGroupes() as $g) {
                                     echo "<option id='groupeAE' value='".$g->getNumero()."'>Groupe ".$g->getNumero()."</option>";
                                }
                            ?>
                        </select>
                <br>
                Attaque au format pdf :
                    <input type="file" id ="attaquePDF" name="attaquePDF"  enctype="multipart/form-data">
                    <br>
                    <input type="submit">
            </form>
        </div>
    </body>
</html>