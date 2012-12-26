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
