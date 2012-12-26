<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Version
 *
 * @author soleneantoine
 */
class Version {
    var $numero;
    var $estAttaque;
    var $pdf;
    
    function Version($n,$pdf) {
        $this->numero = $n;
        $this->estAttaque = "False";
        $this->pdf = $pdf;
    }
    
    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function getEstAttaque() {
        return $this->estAttaque;
    }

    public function setEstAttaque($estAttaque) {
        $this->estAttaque = $estAttaque;
    }

    public function getPdf() {
        return $this->pdf;
    }

    public function setPdf($pdf) {
        $this->pdf = $pdf;
    }

            //put your code here
}

?>
