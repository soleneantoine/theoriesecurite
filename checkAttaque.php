<?php

    session_start();
    if (!isset($_SESSION['groupe'])) header("location:index.php");
    include 'class/Groupe.php';
    $groupeAttaquant = Groupe::getGroupe($_SESSION['groupe']);   
//    if((!isset($_POST['attaquePDF']))) {
//        header('Location: index.php?error=Veuillez sélectionner le fichier pdf correspondant à votre attaque#Attaquer');  
//    }
    if (!isset($_POST['groupeAttaque'])) {
         header('Location: forum.php?error=Veuillez préciser le groupe attaqué#Attaquer');  
    }
    elseif ($_POST['groupeAttaque'] == "...") {
         header('Location: forum.php?error=Veuillez sélectionner un groupe#Attaquer');  
    }
    elseif ($_POST['groupeAttaque'] == $groupeAttaquant->getNumero()) {
         header('Location: forum.php?error=Vous ne pouvez pas vous attaquer vous même#Attaquer');  
    }
    $groupeAttaque = Groupe::getGroupe($_POST['groupeAttaque']);
    $groupeAttaquant->attaque($groupeAttaque,"");
    print ("<script language = \"JavaScript\">"); 
    print ("location.href = 'forum.php';"); 
    print ("</script>");  
//    
//    echo "groupe attaquant : ".$groupeAttaquant->getNumero()."<br>";
    //$attaque = new Attaque();
    // VERIFIER LE PDF !!!
    ?>
