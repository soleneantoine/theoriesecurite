<?php
/*
//ce fichier a ete realise e partir des codes sources suivants :
// - pour la partir "dump" : http://www.siteduzero.com/forum-83-90968-791061-script-de-sauvegarde-de-db.html
// - pour la partie "envoi par mail" : http://www.vulgarisation-informatique.com/mail.php
// 
// dans la premiere partie du fichier, modifiez les informations de connexion e la base de donnees, puis les variables necessaires pour l'envoi du mail.
// 
// Dans un premier temps, le script creer un fichier dump portant la date d'aujourd'hui.
// Ensuite, il va effacer le fichier cree 21 jours plus tet. Comme cela, si ce script est lance par une commande en cron chaque semaine, il y aura seulement 3 fichiers dump dans le repertoire.
// Pour finir, le fichier cree va etre envoye par mail e l'adresse de votre choix.
// Cela permet d'avoir deux sauvegardes : la premiere stockee sur l'espace ftp, mais detruite au bout de 3 semaines, et la deuxieme reeue par mail.
//*/

// 


     //-----------------------------------------------
     //pour la sauvegarde de la base de donnees
     //-----------------------------------------------

$host = 'localhost';  // le nom de machine Mysql (generalement localhost)
$user = 'theorieSecurite'; // votre nom d'utilisateur Mysql
$pass = 'securite12345';  // votre mot de passe Mysql
$base = 'theorieSecurite'; // le nom de la base de donnees


     //-----------------------------------------------
     //pour l'envoi par mail
     //-----------------------------------------------

     $destinataire='soso.antoine@gmail.com';  // l'adresse e-mail de destination
     $nom_expediteur='TheorieSecurite';  // le nom de l'expediteur, tel qu'il apparaetra dans le mail
     $email_expediteur='soso.antoine@gmail.com'; // l'email de l'expediteur, tel qu'il apparaetra dans le mail
     $email_reply='Le dump a été fait';  // l'email de reponse tel qu'il apparaetra dans le mail
     $sujet='dump theorieSecurite';  // le sujet du mail
     
    $fichierjoint="sqldump_".date("d-n-Y").".sql";
    
     $message_html='<html>
     <head>
     <title>'.$sujet.'</title>
     </head>
     <body>Bonjour, <br />En piece jointe, la derniere sauvegarde de votre base de donnees</body>
     </html>';







     //-----------------------------------------------
     //debut du script
     //-----------------------------------------------




// connexion e la base
mysql_connect($host, $user, $pass);
mysql_select_db($base);


function mysql_structure() {
// on va faire une requete pour rechercher toutes les tables de la bdd concernee
$req_table = "SHOW TABLES";
$result_table = mysql_query($req_table) or die ("Impossible d'executer la requete concernant la recherche des tables - ".mysql_error());

// et on va les afficher sous forme de lien
while ($donnees_table = mysql_fetch_array($result_table)) {
$table = $donnees_table[0];
                               
// on va creer une variable pour y mettre le texte concernant l'en-tete de la structure qui sera ecrit dans le fichier .txt
@$result .= "-- \n";
$result .= "-- Structure de la table ` ".$table." ` \n";
$result .= "--\n \n";
               
// on va demander la "creation" de la table
$req_structure = "SHOW CREATE TABLE $table ";
$result_structure = mysql_query($req_structure) or die ("Impossible de trouver la structure de ". $table .mysql_error());
$donnee_structure = mysql_fetch_array($result_structure);
$structure = $donnee_structure[1] ;
$structure .= "\n \n" ;
$result .= $structure;
               
// on cree une variable pour le titre du contenu de la table
$titre_contenu = "-- \n";
$titre_contenu .= "-- Contenu de la table ` ".$table."` \n";
$titre_contenu .= "--  \n \n";
$result .= $titre_contenu;
               
// on va recuperer le nombre de champs presents dans la table   
$req_champ = "SHOW COLUMNS FROM $table";
$result_champ = mysql_query ($req_champ) or die ("Impossible de trouver les champs de ". $table .mysql_error());
$nbre_champ = mysql_num_rows($result_champ);
// on va rechercher TOUS les enregistrements de la table concernee
$req_tout = "SELECT * FROM $table ";
$result_tout = mysql_query($req_tout) or die ("Impossible de trouver les enregistrements de ". $table .mysql_error());
// on va boucler pour sortir toutes les donnees
while($donnees_tout = mysql_fetch_array($result_tout)) {
$contenu = "INSERT INTO " . $table . " VALUES (";
$i = 0;
// on va boucler tous les champs
while ( $i < $nbre_champ ) {
// et on affiche les resultats en fonction des champs et dans l'ordre des champs
$contenu .= "'". mysql_real_escape_string($donnees_tout[$i]) ."' ,";
$i++;
}
// on va enlever la derniere virgule
$contenu = substr($contenu,0,-2);
$contenu .= ") ; \n";
$result .= $contenu;
}
$result .= "\n";
}
return $result;
}

// creation d'une fonction file_put_content si le script est en PHP4 :

if(!function_exists('file_put_contents')) {
function file_put_contents($filename, $data, $file_append = false) {
$fp = fopen($filename, (!$file_append ? 'w+' : 'a+'));
if(!$fp) {
trigger_error('file_put_contents ne peut pas ecrire dans le fichier.', E_USER_ERROR);
return;
}
fputs($fp, $data);
fclose($fp);
}
}

// creation du fichier de dump sur le meme niveau que ce fichier dump.php

file_put_contents('sqldump_'.date("d-n-Y").".sql", mysql_structure());

// effacement du fichier precedant (cree 21 jours plus tot)

$time_old = getdate(time()-(21*24*3600));
$an = $time_old['year'];
$mois = $time_old['mon'];
$jour = $time_old['mday'];

// formatage des jours e 1 chiffre

for($k=1; $k<10; $k++)
{
if ($jour==$k)
{
$jour='0'.$jour;
}
}

$date_old =$jour.'-'.$mois.'-'.$an;
$file_old = 'sqldump_'.$date_old.".sql";

if (file_exists($file_old)) {
unlink($file_old);
}

echo 'Sauvegarde effectuee<br />';
?>




<?php //Pour envoyer ce fichier par mail :
//
//
//     //-----------------------------------------------
//     //GENERE LA FRONTIERE DU MAIL 
//     //-----------------------------------------------
//
//     $frontiere = '-----=' . md5(uniqid(mt_rand()));
//
//     //-----------------------------------------------
//     //HEADERS DU MAIL
//     //-----------------------------------------------
//
//     $headers = 'From: "'.$nom_expediteur.'" <'.$email_expediteur.'>'."\n";
//     $headers .= 'Return-Path: <'.$email_reply.'>'."\n";
//     $headers .= 'MIME-Version: 1.0'."\n";
//     $headers .= 'Content-Type: multipart/mixed; boundary="'.$frontiere.'"';
//
//
//     //-----------------------------------------------
//     //MESSAGE HTML
//     //-----------------------------------------------
//     $message="";
//     $message .= '--'.$frontiere."\n";
//
//     $message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
//     $message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
//     $message .= $message_html."\n\n";
//
//     
//     //-----------------------------------------------
//     //PIECE JOINTE
//     //-----------------------------------------------
//$message .= '--'.$frontiere."\n";
//     $message .= 'Content-Type: text/tab-separated-value; name="'.$fichierjoint.'"'."\n";
//     $message .= 'Content-Transfer-Encoding: base64'."\n";
//     $message .= 'Content-Disposition:attachement; filename="'.$fichierjoint.'"'."\n\n";
//
//     $message .= chunk_split(base64_encode(file_get_contents('./'.$fichierjoint.'')))."\n";
//    $message .= '--'.$frontiere.'--'."\n";
//     if(mail($destinataire,$sujet,$message,$headers))
//     {
//          echo 'Le mail a ete envoye';
//     }
//     else
//     {
//          echo 'Le mail n\'a pu etre envoye';
//     }

?> 