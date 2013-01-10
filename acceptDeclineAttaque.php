<?php
    session_start();
    if (!isset($_SESSION['groupe'])){
        print ("<script language = \"JavaScript\">"); 
        print ("location.href = 'index.php';"); 
        print ("</script>");
    }
    include 'class/Groupe.php';   
    ini_set('display_errors', 1);
    $groupe = Groupe::getGroupe($_SESSION['groupe']);   
    if ($_REQUEST["AcceptDecline"] == 'A') {      
        $attaque = Attaque::getAttaque($_REQUEST["attaquant"], $_SESSION['groupe'], $_REQUEST["version"]);
        $groupe->confirmerAttaque($attaque);
    }
    elseif ($_REQUEST["AcceptDecline"] == 'D') {        
        $sql = "DELETE FROM `theorieSecurite`.`AttaqueEnCours` WHERE `AttaqueEnCours`.`id` = ".$_REQUEST["attaque"];
        echo $sql.'<br>';
        MyPDO::get()->exec($sql);
        
        $sql = "INSERT INTO `theorieSecurite`.`Notifications` (`id`, `type`, `groupe`, `groupeAttaque`, `version`) VALUES (NULL, 'decline', '".$_SESSION['groupe']."', '".$_REQUEST["attaquant"]."', '".$_REQUEST["version"]."');";
        MyPDO::get()->exec($sql);    
        echo $sql.'<br>';
    }  
//    print ("<script language = \"JavaScript\">"); 
//    print ("location.href = 'forum.php';"); 
//    print ("</script>");   
?>
