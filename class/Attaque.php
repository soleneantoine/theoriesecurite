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
        $this->version->setEstAttaque("True");
        $this->pdf = $p;
        
        $this->groupeAttaquant->score = $this->groupeAttaquant->score + 20;
        $this->groupeAttaque->setScore($this->groupeAttaque->getScore()-20);
        
        $sql = "INSERT INTO `theorieSecurite`.`Attaque` (`groupeAttaquant`, `groupeAttaque`, `version`, `id`, `pdf`) VALUES ('".$this->groupeAttaquant->getNumero()."', '".$this->groupeAttaque->getNumero()."', '".$this->version->getNumero()."', NULL, '".$this->pdf."');";
        MyPDO::get()->exec($sql);
        
        $sql = "UPDATE  `theorieSecurite`.`Version` SET  `estAttaque` =  '1' WHERE  `Version`.`groupe` = '".$this->groupeAttaque->getNumero() ."' AND `Version`.`numero` =". $this->version->getNumero();
        MyPDO::get()->exec($sql);
        
        $sql = "UPDATE  `theorieSecurite`.`Groupe` SET  `score` =  '".$this->groupeAttaquant->score."' WHERE  `Groupe`.`numero` =".$this->groupeAttaquant->getNumero();
        MyPDO::get()->exec($sql);
        
        $sql = "UPDATE  `theorieSecurite`.`Groupe` SET  `score` =  '".$this->groupeAttaque->score."' WHERE  `Groupe`.`numero` =".$this->groupeAttaque->getNumero();
        MyPDO::get()->exec($sql);
        
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

}

?>
