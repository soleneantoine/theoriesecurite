<?php
    session_start();
    if (!isset($_SESSION['groupe'])) header("location:index.php");
    include("class/Groupes.php");  
    $groupe = Groupe::getGroupe($_SESSION['groupe']);   
    $groupe->ajoutVersion('');
    print ("<script language = \"JavaScript\">"); 
    print ("location.href = 'forum.php';"); 
    print ("</script>");
?>
