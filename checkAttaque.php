<?php
    include("class/Groupes.php");
//    if((!isset($_POST['attaquePDF']))) {
//        header('Location: index.php?error=Veuillez sélectionner le fichier pdf correspondant à votre attaque#Attaquer');  
//    }
    if (!isset($_POST['groupeAttaquant'])) {
         header('Location: index.phpr?error=Veuillez préciser le groupe attaquant#Attaquer');  
    }
    elseif (!isset($_POST['groupeAttaque'])) {
         header('Location: index.php?error=Veuillez préciser le groupe attaqué#Attaquer');  
    }
    elseif (($_POST['groupeAttaque'] == "...") || ($_POST['groupeAttaquant'] == "...")) {
         header('Location: index.php?error=Veuillez sélectionner un groupe#Attaquer');  
    }
    elseif ($_POST['groupeAttaque'] == $_POST['groupeAttaquant']) {
         header('Location: index.php?error=Vous ne pouvez pas vous attaquer vous même#Attaquer');  
    }
    

    $groupes = Groupes::getInstance();
    
    
    $groupeAttaquant = $groupes->getGroupe($_POST['groupeAttaquant']);
    $groupeAttaque = $groupes->getGroupe($_POST['groupeAttaque']);
    
    $groupeAttaquant->attaque($groupeAttaque,"");
    $groupeAttaquant->attaque($groupeAttaque,"");
    //$attaque = new Attaque($groupeAttaquant, $groupeAttaque, $groupeAttaque->getDerniereVersion(), "");
    
    echo $groupeAttaquant->displayAttaques($groupeAttaque);
    
//    
//    echo "groupe attaquant : ".$groupeAttaquant->getNumero()."<br>";
    //$attaque = new Attaque();
    // VERIFIER LE PDF !!!
    
    
?>
