<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Attaque
 *
 * @author soleneantoine
 */
class Attaque {
    var $groupeAttaquant;
    var $groupeAttaque;
    var $version;
    var $pdf;
    
    function Attaque($gAttaquant, $gAttaque, $v, $p) {
        $this->groupeAttaquant = $gAttaquant;
        $this->groupeAttaque = $gAttaque;
        $this->version = $v;
        $this->pdf = $p;
        
        $attaquant = Groupe::getGroupe($this->groupeAttaquant);
        $attaquant->setScore($attaquant->getScore()+20);
        
        $attaque = Groupe::getGroupe($this->groupeAttaque);
        $attaque->setScore($attaque->getScore()-20);     
                
        $sql = "UPDATE  `theorieSecurite`.`Groupe` SET  `score` =  '".$attaquant->getScore()."' WHERE  `Groupe`.`numero` =".$attaquant->getNumero();
        MyPDO::get()->exec($sql);
        
        $sql = "UPDATE  `theorieSecurite`.`Groupe` SET  `score` =  '".$attaque->getScore()."' WHERE  `Groupe`.`numero` =".$attaque->getNumero();
        MyPDO::get()->exec($sql);
        
        $sql = "INSERT INTO  `theorieSecurite`.`Notifications` (`id` ,`type` ,`groupe` ,`groupeAttaque` ,`version`)VALUES ('',  'attaque',  '".$attaquant->getNumero()."',  '".$attaque->getNumero()."',  '".$this->version."');";
        MyPDO::get()->exec($sql);
        
        $sql = "INSERT INTO `theorieSecurite`.`Attaque` (`groupeAttaquant`, `groupeAttaque`, `version`, `id`, `pdf`) VALUES ('".$attaquant->getNumero()."', '".$attaque->getNumero()."', '".$this->version."', NULL, '".$this->pdf."');";
        MyPDO::get()->exec($sql);
        
        $sql = "UPDATE  `theorieSecurite`.`Version` SET  `estAttaque` =  '1' WHERE  `Version`.`groupe` = '".$attaque->getNumero() ."' AND `Version`.`numero` =". $this->version;
        MyPDO::get()->exec($sql);
        
//        $sql = "INSERT INTO `theorieSecurite`.`AttaqueEnCours` (`groupeAttaquant`, `groupeAttaque`, `version`, `id`, `pdf`) VALUES ('".  $this->groupeAttaquant."', '".  $this->groupeAttaque."', '".$this->version."', NULL, '".$this->pdf."');";
//        MyPDO::get()->exec($sql);
        
    }
    
    public function getGroupeAttaquant() {
        return $this->groupeAttaquant;
    }

    public function setGroupeAttaquant($groupeAttaquant) {
        $this->groupeAttaquant = $groupeAttaquant;
    }

    public function getGroupeAttaque() {
        return $this->groupeAttaque;
    }

    public function setGroupeAttaque($groupeAttaque) {
        $this->groupeAttaque = $groupeAttaque;
    }

    public function getVersion() {
        return $this->version;
    }

    public function setVersion($version) {
        $this->version = $version;
    }

    public function getPdf() {
        return $this->pdf;
    }

    public function setPdf($pdf) {
        $this->pdf = $pdf;
    }
    
    public static function getAttaques(){
        $attaques = array();
        $resultats = MyPDO::get()->query("SELECT * FROM AttaqueEnCours");
        $resultats->setFetchMode(PDO::FETCH_OBJ);
        while( $ligne = $resultats->fetch() )
        {
            $attaque = new Attaque($ligne->groupeAttaquant,$ligne->groupeAttaque,$ligne->version,$ligne->pdf);
            array_push($attaques, $attaque);
        }
        return $attaques;
    }
    
    public static function getAttaque($gAttaquant,$gAttaque,$v){
        foreach (Attaque::getAttaques() as $a){
            if (( $a->getGroupeAttaquant() == $gAttaquant) && ( $a->getGroupeAttaque() == $gAttaque)&& ( $a->getVersion() == $v)) {
                return $a;
            }
        }
        return null;
    }
    


}

?>
