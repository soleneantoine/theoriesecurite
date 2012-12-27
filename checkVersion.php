<?php
    include("class/Groupes.php");
//    if((!isset($_POST['attaquePDF']))) {
//        header('Location: index.php?error=Veuillez sélectionner le fichier pdf correspondant à votre attaque#Attaquer');  
//    }
    if (!isset($_POST['groupe'])) {
         header('Location: index.phpr?errorV=Veuillez préciser votre groupe#Version');  
    }
    elseif ($_POST['groupe'] == "...")  {
         header('Location: index.php?errorV=Veuillez sélectionner un groupe#Version');  
    }
   
    $groupe = Groupe::getGroupe($_POST['groupe']);
    $groupe->ajoutVersion('');

    echo "<a href='index.php'>Retour</a>";
?>
