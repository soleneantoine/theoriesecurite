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
    var $groupe;
    
    function Version($g,$n,$pdf) {
        $this->numero = $n;
        $this->estAttaque = "False";
        $this->pdf = $pdf;
        $this->groupe = $g;
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
    
    public function getGroupe() {
        return $this->groupe;
    }

    public function setGroupe($groupe) {
        $this->groupe = $groupe;
    }

    
    public static function getVersions($orderBy = "numero", $asc_desc="DESC"){
        $versions = array();
        $resultats = MyPDO::get()->query("SELECT * FROM Version ORDER BY $orderBy $asc_desc");
        $resultats->setFetchMode(PDO::FETCH_OBJ);
        while( $ligne = $resultats->fetch() )
        {
            $version = new Version($ligne->groupe,$ligne->numero,$ligne->pdf);
            array_push($versions, $version);
        }
        return $versions;
    }
    
    public static function getVersion($g,$n){
        foreach (Version::getVersions() as $v){
            if (( $v->getNumero() == $n) && ($v->getGroupe() == $g)) {
                return $v;
            }
        }
        return null;
    }
            //put your code here
}

?>
