<?php
    session_start();
    if (!isset($_SESSION['groupe'])){
        print ("<script language = \"JavaScript\">"); 
        print ("location.href = 'index.php';"); 
        print ("</script>");
    }
    include 'class/Groupe.php';
    ini_set('display_errors', 1);
    $groupeAttaquant = Groupe::getGroupe($_SESSION['groupe']);   
    $extension = strrchr($_FILES['attaquePDF']['name'], '.');
//    if((!isset($_POST['attaquePDF']))) {
//        header('Location: index.php?error=Veuillez sélectionner le fichier pdf correspondant à votre attaque#Attaquer');  
//    }
    if (!isset($_POST['groupeAttaque'])) {
            print ("<script language = \"JavaScript\">"); 
            print ("location.href = 'forum.php?error=Veuillez préciser le groupe attaqué#Attaquer';"); 
            print ("</script>");
    }
    elseif ($_POST['groupeAttaque'] == "...") {
            print ("<script language = \"JavaScript\">"); 
            print ("location.href = 'forum.php?error=Veuillez sélectionner un groupe#Attaquer';"); 
            print ("</script>"); 
    }
    elseif ($_POST['groupeAttaque'] == $groupeAttaquant->getNumero()) {
            print ("<script language = \"JavaScript\">"); 
            print ("location.href = 'forum.php?error=Vous ne pouvez pas vous attaquer vous même#Attaquer';"); 
            print ("</script>");
    }
    elseif ($extension != ".pdf" && $extension != ".PDF"){
        print ("<script language = \"JavaScript\">"); 
        print ("location.href = 'forum.php?error=Le fichier doit etre un pdf#Attaquer';"); 
        print ("</script>");
    }
    
    $groupeAttaque = Groupe::getGroupe($_POST['groupeAttaque']);
    $fichier = "attaques/".$groupeAttaquant->getNumero()."vers".$groupeAttaque->getNumero()."||".date("dmyGis").".pdf";
    
    $groupeAttaquant->attaque($groupeAttaque,$fichier);
    move_uploaded_file($_FILES['attaquePDF']['tmp_name'],$fichier);
    
    print ("<script language = \"JavaScript\">"); 
    print ("location.href = 'forum.php';"); 
    print ("</script>");
    ?>
