<?php
    session_start();
    include'class/Groupe.php';
    if (!isset($_SESSION['groupe'])){
        print ("<script language = \"JavaScript\">"); 
        print ("location.href = 'index.php';"); 
        print ("</script>");        
    }
    
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
    $groupe->ajoutVersion('');
    print ("<script language = \"JavaScript\">"); 
    print ("location.href = 'forum.php';"); 
    print ("</script>");

?>
