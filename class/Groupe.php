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
            $v = new Version($numero,$row['numero'],'');
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
    
    public function ajoutVersion($pdf){
        if ($this->ajoutVersionAutorise() == "True") {
            $v = new Version($this->numero,(sizeof($this->versions)+1),$pdf);
            
            $sql = "INSERT INTO `theorieSecurite`.`Version` (`id`, `numero`, `estAttaque`, `groupe`, `pdf`) VALUES (NULL, '".(sizeof($this->versions)+1)."', '0', '".$this->numero."', '');";
            MyPDO::get()->exec($sql);
            array_push($this->versions, $v);
        }
        else echo "Ajout non autorisé<br>";
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
            echo $attaque.'<br>';
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
            new Attaque($this, $groupe,$v[sizeof($groupe->getVersions())-1],$pdf);        
        }
        else throw new Exception("Attaque non autorisée<br>");        
    }
    
    public function displayAttaques ($groupe) {
        
        $r = "";
        $sql = "SELECT * FROM Attaque WHERE groupeAttaquant = $this->numero";
        foreach  (MyPDO::get()->query($sql) as $row) {
            if($row["groupeAttaque"] == $groupe->getNumero()) {
                $r .= "attaque(v".$row["version"].") <a href='".$row["pdf"]."'><img src='pictures/imageLoupe.png' style='width: 25px; heigth: 25px;'/></a><br>";
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
   
}
?>
