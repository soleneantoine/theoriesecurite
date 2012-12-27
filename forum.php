<!DOCTYPE html>
<?php
    include('class/Groupes.php');
    session_start();
    if (!isset($_SESSION['groupe'])) header("location:index.php");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Theorie de la Sécurité</title>
        <link rel="stylesheet" href="style.css"/>
        <script src="js/jquery.js" type="text/javascript"></script><!-- Insertion de la bibliotheque jQuery -->
        <script type="text/javascript" src="js/localscroll/jquery.localscroll.js"></script>
        <script type="text/javascript" src="js/localscroll/jquery.scrollTo.js"></script>
        <script type="text/javascript" src="js/lancement.js"></script><!-- permet le lancement de la fonction de scroll -->
    </head>
    <body class="home">
        <div id="content">
            <center><h1>Projet : Conception et analyse de protocoles cryptographiques</h1></center>
            
            <div class="menu">
                <a href="#Description">Description</a>
                <a href="#Notifications">Notifications</a>
                <a href="#Evènements">Evènements</a>
                <a href="#Classement">Classement</a>
                <a href="#Attaques">Attaques</a>
                <a href="#Attaquer">Attaquer</a>
                <a href="#Version">Nouvelle version</a>
            </div>
            <div style="clear:both"></div>
            
            <h2 id="Description">Description du projet</h2>
            <p class="description">L'objectif de ce projet est d'apprendre à concevoir des protocoles cryptographiques et à les modéliser et les analyser
            à l'aide de l'outil <span style="color : #00cccc">ProVerif</span>. Dans la première partie du projet, chaque groupe devra concevoir un protocole qui satisfait des contraintes données.
            Dans la deuxième partie du projet, tous les protocoles ainsi proposés seront analysés par chaque groupe. Les attaques trouvées devront être corrigées par les concepteurs
            du protocole attaqué</p>
            
            
            <div class="ligne" id="Notifications"></div>
            <h2>Notifications</h2>
            
            <?php
                $sql = "SELECT * FROM AttaqueEnCours WHERE groupeAttaque = ".$_SESSION["groupe"];
                $resultats = MyPDO::get()->query($sql);
                $resultats->setFetchMode(PDO::FETCH_OBJ);
                while( $ligne = $resultats->fetch() )
                {
                    echo "<form action='acceptDeclineAttaque.php' method='post'>";
                        echo "<input type='hidden' id = 'attaque' name='attaque' value=".$ligne->id.">";
                        echo "<input type='hidden' id = 'attaquant' name='attaquant' value=".$ligne->groupeAttaquant.">";
                        echo "<input type='hidden' id = 'version' name='version' value=".$ligne->version.">";
                        echo "Le groupe ".$ligne->groupeAttaquant." vous a attaqué sur la version ".$ligne->version." (<a href='".$ligne->pdf."'>Voir leur attaque</a>)<br>";
                        echo "  <dd>
                                    <select name='AcceptDecline'>
                                        <option value='A'>Accepter</option>
                                        <option value='D'>Décliner</option>
                                    </select>
                                </dd>";
                        echo "<dd><input type='submit' value='Ok'/></dd>";
                    echo "</form>";
                }
            ?>
            
            <div class="ligne" id="Evènements"></div>
            <h2>Evènements</h2>
            <?php
                $sql = "SELECT * FROM Notifications ORDER BY id DESC LIMIT 0,4";
                $resultats = MyPDO::get()->query($sql);
                $resultats->setFetchMode(PDO::FETCH_OBJ);
                while( $ligne = $resultats->fetch() )
                {
                    if ($ligne->type == "version") {
                        echo "Le groupe ".$ligne->groupe." a ajouté une ".$ligne->version."° version<br>";
                    }
                    else if ($ligne->type == "attaque") {
                        echo "Le groupe ".$ligne->groupe." a attaqué le groupe ".$ligne->groupeAttaque." sur la version ".$ligne->version."<br>";
                    }
                }
            ?>
            
            
            
            <div class="ligne" id="Classement"></div>
            <h2 >Classement des groupes</h2>
            
            <?php
                
                echo "<div style='float:left'><img class='trophee' src='pictures/trophee.png'/><div style='clear:both'></div><p class='felicitations'>Félicitations au groupe ".Groupe::getWinner()->getNumero()."</p></div>";
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
                            foreach (Groupe::getGroupes("numero","ASC") as $g) {
                                $versions = $g->getVersions();
                                $version = "--";
                                if (sizeof($g->getVersions()) > 0){
                                    $version = "v".$versions[sizeof($g->getVersions())-1]->getNumero();
                                }
                                echo "<td class='info'>Groupe ".$g->getNumero()."<br>".$version."</td>";
                            }
                            echo "</tr>";
                        
                            foreach (Groupe::getGroupes("numero","ASC") as $g) {
                                echo "  <tr>
                                            <td  class='info'>Groupe ".$g->getNumero()."</td>";
                                                foreach (Groupe::getGroupes("numero","ASC") as $g3) {
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
                Vous voulez attaquer le groupe 
                        <select name='groupeAttaque'>
                            <option>...</option>
                            <?php
                                foreach (Groupe::getGroupes("numero","ASC") as $g) {
                                     echo "<option id='groupeAE' value='".$g->getNumero()."'>Groupe ".$g->getNumero()."</option>";
                                }
                            ?>
                        </select>
                <br>
                Attaque au format pdf :
                    <input type="file" id ="attaquePDF" name="attaquePDF"  enctype="multipart/form-data">
                    <br>
                    <input type="submit">
                    
            <div class="ligne" id="Version"></div>
            </form>
            
            <h2>Nouvelle version</h2>
            
            <?php 
                if (isset($_GET['errorV'])) {
                    echo "<div class=\"error\">".$_GET["errorV"]."</div>";
                }
                ?>
            
            <form action="checkVersion.php" method="post">               
                Nouvelle version au format pdf :
                    <input type="file" id ="versionPDF" name="versionPDF"  enctype="multipart/form-data">
                    <br>
                    <input type="submit">
            </form>
        </div>
    </body>
</html>