<?php
include("MyPDO.php");
include("Version.php");
include("Attaque.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group
 *
 * @author soleneantoine
 */
class Groupe {
    var $numero;
    var $score;
    var $versions;
    
    function Groupe($numero) {
        $this->numero = $numero;
        
        /* @var $connexion PDO */
        $groupe = MyPDO::get()->query("SELECT * FROM Groupe WHERE numero = $numero")->fetch(PDO::FETCH_OBJ);
        $this->score = $groupe->score;
        
        $sql = "SELECT * FROM Version WHERE `groupe` = $numero";
        $this->versions = array();
        foreach  (MyPDO::get()->query($sql) as $row) {
            $v = new Version($numero,$row['numero'],$row["pdf"]);
            if ($row["estAttaque"] == "1") $v->setEstAttaque ("True");
            array_push($this->versions,$v);
        }
    }
    
    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function getScore() {
        return $this->score;
    }

    public function setScore($score) {
        $this->score = $score;
    }
    
    public function getVersions() {
        return $this->versions;
    }

    public function setVersions($versions) {
        $this->versions = $versions;
    }
    
    public function ajoutVersion($pdf,$cout){
        if ($this->ajoutVersionAutorise() == "True") {
            $v = new Version($this->numero,(sizeof($this->versions)+1),$pdf);
            
            $sql = "INSERT INTO `theorieSecurite`.`Version` (`id`, `numero`, `estAttaque`, `groupe`, `pdf`, `cout`) VALUES (NULL, '".(sizeof($this->versions)+1)."', '0', '".$this->numero."', '".$pdf."','".$cout."');";
            MyPDO::get()->exec($sql);
            
            $sql = "INSERT INTO  `theorieSecurite`.`Notifications` (`id` ,`type` ,`groupe` ,`groupeAttaque` ,`version`)VALUES ('',  'version',  '".$_SESSION["groupe"]."',  '',  '".(sizeof($this->versions)+1)."');";
            MyPDO::get()->exec($sql);
            
            array_push($this->versions, $v);
        }
        else{
                print ("<script language = \"JavaScript\">"); 
                print ("location.href = 'forum.php?errorV=Vous ne pouvez pas proposer de nouvelle version#Version'"); 
                print ("</script>");
        }
    }
    
    public function displayVersions() {
        foreach ($this->versions as $v) {
            echo $v->getNumero()."<br>";         
        }
        
    }
    
    public function derniereVersionAttaquee() {
        $attaque = "True";
        if (sizeof($this->versions) > 0) {
            $attaque = $this->versions[sizeof($this->versions)-1]->getEstAttaque();
        }
        return $attaque;
    }
    
    public function ajoutVersionAutorise() {
        $correct = "True";
        if ((sizeof($this->versions) >= 5) || ($this->derniereVersionAttaquee() == "False")) $correct = "False";
        return $correct;
    }
    
    public function initScore($cout) {
        if ($cout >= 0){
        $this->score = -$cout;
        }
        else throw new Exception("Le coût doit être positif");
    }
    
    public function attaque($groupe,$pdf) {
        if ((sizeof($groupe->getVersions()) > 0) && ($groupe->getNumero() != $this->numero)) {
            $v = $groupe->getVersions();
            new Attaque($this->getNumero(), $groupe->getNumero(),$v[sizeof($groupe->getVersions())-1]->getNumero(),$pdf);
            
        }
        else {
            print ("<script language = \"JavaScript\">"); 
            print ("location.href = 'forum.php?error=Attaque non autorisée. Le groupe que vous attaquez n\'a pas encore de version#Attaquer';"); 
            print ("</script>");
        }
    }
    
    public function displayAttaques ($groupe) {
        
        $r = "";
        $sql = "SELECT * FROM Attaque WHERE groupeAttaquant = $this->numero";
        foreach  (MyPDO::get()->query($sql) as $row) {
            if($row["groupeAttaque"] == $groupe->getNumero()) {
                $r .= "attaque(v".$row["version"].") <br>";
            }
        }
        return $r;
    }
    
    public function getDerniereVersion() {
        $versions = $this->getVersions();
        $dVersion = $versions[sizeof($versions)-1];
        return $dVersion;
    }
    
    public static function getGroupes($orderBy = "numero", $asc_desc="DESC"){
        $groupes = array();
        $resultats = MyPDO::get()->query("SELECT * FROM Groupe ORDER BY $orderBy $asc_desc");
        $resultats->setFetchMode(PDO::FETCH_OBJ);
        while( $ligne = $resultats->fetch() )
        {
            $groupe = new Groupe($ligne->numero);
            array_push($groupes, $groupe);
        }
        return $groupes;
    }
    
    public static function getWinner(){
        $resultat = MyPDO::get()->query("SELECT * FROM Groupe ORDER BY score DESC")->fetch(PDO::FETCH_OBJ);
        return new Groupe($resultat->numero);
    }
    
    public static function getGroupe($n){
        foreach (Groupe::getGroupes() as $g){
            if ( $g->getNumero() == $n) {
                return $g;
            }
        }
        return null;
    }
    
    public function confirmerAttaque($attaque) {   
        
        
        $numVersion = $attaque->getVersion();
        $version = Version::getVersion($this->numero, $numVersion);
        $version->setEstAttaque("True");
        
        $sql = "INSERT INTO `theorieSecurite`.`Attaque` (`groupeAttaquant`, `groupeAttaque`, `version`, `id`, `pdf`) VALUES ('".$attaque->getGroupeAttaquant()."', '".$attaque->getGroupeAttaque()."', '".$attaque->getVersion()."', NULL, '".$attaque->getPdf()."');";
        echo $sql.'<br>';
        MyPDO::get()->exec($sql);
         
        $sql = "UPDATE  `theorieSecurite`.`Version` SET  `estAttaque` =  '1' WHERE  `Version`.`groupe` = '".$attaque->getGroupeAttaque() ."' AND `Version`.`numero` =". $attaque->getVersion();
        echo $sql.'<br>';
        MyPDO::get()->exec($sql);
        
        $gAttaquant = Groupe::getGroupe($attaque->getGroupeAttaquant());
        $gAttaquant->setScore($gAttaquant->getScore() + 20);
        
        $gAttaque = Groupe::getGroupe($attaque->getGroupeAttaque());
        $gAttaque->setScore($gAttaque->getScore() - 20);
        
        $sql = "UPDATE  `theorieSecurite`.`Groupe` SET  `score` =  '".$gAttaquant->getScore()."' WHERE  `Groupe`.`numero` =".$gAttaquant->getNumero();
        echo $sql.'<br>';
        MyPDO::get()->exec($sql);
        
        $sql = "UPDATE  `theorieSecurite`.`Groupe` SET  `score` =  '".$gAttaque->getScore()."' WHERE  `Groupe`.`numero` =".$gAttaque->getNumero();
        echo $sql.'<br>';
        MyPDO::get()->exec($sql);
        
        $sql = "DELETE FROM `theorieSecurite`.`AttaqueEnCours` WHERE `AttaqueEnCours`.`groupeAttaquant` = ".$attaque->getGroupeAttaquant()." AND `AttaqueEnCours`.`groupeAttaque` = ".$attaque->getGroupeAttaque()." AND `AttaqueEnCours`.`version` = ".$attaque->getVersion()." AND `Version`.`pdf`='".$attaque->getPdf()."'";
        echo $sql.'<br>';
        MyPDO::get()->exec($sql);
               
        $sql = "INSERT INTO  `theorieSecurite`.`Notifications` (`id` ,`type` ,`groupe` ,`groupeAttaque` ,`version`)VALUES ('',  'attaque',  '".$attaque->getGroupeAttaquant()."',  '".$_SESSION["groupe"]."',  '".$attaque->getVersion()."');";
        echo $sql.'<br>';
        MyPDO::get()->exec($sql);
    }
   
}
?>
