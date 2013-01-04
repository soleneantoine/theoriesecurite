<?php
    include 'class/Groupe.php';
    session_start();
    $sql = "SELECT * FROM Groupe WHERE  `numero` =  \"".$_REQUEST['groupeId']."\" and `motDePasse` =  \"".$_REQUEST['password']."\"";
    if($data = MyPDO::get()->query($sql)->fetch(PDO::FETCH_OBJ) == '') {
        print ("<script language = \"JavaScript\">"); 
        print ("location.href = 'index.php?error=Authentification incorrecte. Veuillez réessayer.';"); 
        print ("</script>");
    }
    else {
        $_SESSION["groupe"] = $_REQUEST['groupeId'];       
        print ("<script language = \"JavaScript\">"); 
        print ("location.href = 'forum.php';"); 
        print ("</script>");
    }
?>