<?php
    session_start();
    include'class/Groupe.php';
    
    if (!isset($_SESSION['groupe'])){
        print ("<script language = \"JavaScript\">"); 
        print ("location.href = 'index.php';"); 
        print ("</script>");        
    }
    else { 
        if((!isset($_FILES['versionPDF']))) {
            print ("<script language = \"JavaScript\">"); 
            print ("location.href = 'forum.php?errorV=Veuillez sélectionner le fichier pdf correspondant à votre nouvelle version#Version';"); 
            print ("</script>");  
        }
        else {
            $extension = strrchr($_FILES['versionPDF']['name'], '.');
            if ($extension != ".pdf" && $extension != ".PDF"){
                print ("<script language = \"JavaScript\">"); 
                print ("location.href = 'forum.php?errorV=Le fichier doit etre un pdf#Version';"); 
                print ("</script>");
            } 
            else {
                $resultat = MyPDO::get()->query("SELECT * FROM Groupe WHERE numero=".$_SESSION['groupe'])->fetch(PDO::FETCH_OBJ);
                if($resultat->score == NULL) {
                    if(($_REQUEST['coutProtocole']) == "") {
                        print ("<script language = \"JavaScript\">"); 
                        print ("location.href = 'forum.php?errorV=Veuillez préciser le cout du protocole#Version';"); 
                        print ("</script>");
                    }
                    else{
                        $sql = "UPDATE  `theorieSecurite`.`Groupe` SET  `score` =  '-".$_REQUEST["coutProtocole"]."' WHERE  `Groupe`.`numero` =".$_SESSION["groupe"];
                        MyPDO::get()->exec($sql);
                    }
                }
                $groupe = Groupe::getGroupe($_SESSION['groupe']); 
                $fichier = "versions/".$groupe->getNumero()."||".date("dmyGis").".pdf";
                move_uploaded_file($_FILES['versionPDF']['tmp_name'],$fichier);
                $groupe->ajoutVersion($fichier);
                print ("<script language = \"JavaScript\">"); 
                print ("location.href = 'forum.php';"); 
                print ("</script>");
            }
        }
    }
    
   

?>
