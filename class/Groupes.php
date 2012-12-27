<?php
include ("Groupe.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */    
   
    class Groupes{
        public $groupes;
        public static $_instance = null;
        
        private function __construct() {
            $this->groupes = array();
            $this->init();
        }
        
        function Groupes(){
            $this->groupes = array();
            $this->init();
        }
        
        public static function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new Groupes();
                echo (is_null(self::$_instance))."<br>";
                echo "creation instance";
            }
            return self::$_instance;
        }
        
//        public function init(){
//            for ($i = 0; $i < 13; $i++) {
//                    array_push($this->groupes, new Groupe($i+1));
//            }
//            
//            $g1 = $this->groupes[0];
//            $g2 = $this->groupes[1];
//            $g3 = $this->groupes[2];
//            $g4 = $this->groupes[3];
//            $g5 = $this->groupes[4];
//            $g6 = $this->groupes[5];
//            $g7 = $this->groupes[6];
//            $g8 = $this->groupes[7];
//            $g9 = $this->groupes[8];
//            $g10 = $this->groupes[9];
//            $g11 = $this->groupes[10];
//            $g12 = $this->groupes[11];
//            $g13 = $this->groupes[12];
//
//            $g1->initScore(126);
//            $g2->initScore(205);
//            $g3->initScore(325);
//            $g4->initScore(605);
//            $g5->initScore(525);
//            $g6->initScore(105);
//            $g7->initScore(895);
//            $g8->initScore(405);
//            $g9->initScore(215);
//            $g10->initScore(105);
//            $g11->initScore(895);
//            $g12->initScore(405);
//            $g13->initScore(215);
//
//            $g1->ajoutVersion("");
//            $g2->ajoutVersion("");
//
//            $g1->attaque($g2,"pdfs/pdf1.pdf");
//            $g2->attaque($g1,"pdfs/pdf2.pdf");
//
//            $g2->ajoutVersion("");
//            $g1->attaque($g2,"pdfs/pdf3.pdf");
//        }
        
        public function max($groupes){
            $g = $groupes[0];
            foreach ($groupes as $groupe) {
                if ($groupe->getScore() > $g->getScore()){
                    $g = $groupe;
                }
            }
            return $g;
        }
        
        public function classement(){
            $l1 = $this->groupes;
            $l2 = array();
            
            foreach ($l1 as $g){
                array_push($l2, $this->max($l1));
                $l1 = $this->deleteGroupeFromArray($l1, $this->max($l1)->getNumero());     
            }
            return $l2;
        }
    
        
    public function deleteGroupeFromArray($tableau,$numGroupe) {
        while ($g = current($tableau)) {
            if ($g->getNumero() == $numGroupe) {
                $ret = key($tableau);
            }
            next($tableau);
        }
        unset($tableau[$ret]);
        $tableau = array_values($tableau);
        return $tableau;
        
    }
    public function getGroupes() {
        return $this->groupes;
    }

    public function setGroupes($groupes) {
        $this->groupes = $groupes;
    }
    
    public function getGroupe($n){
        foreach ($this->groupes as $g){
            if ( $g->getNumero() == $n) {
                return $g;
            }
        }
        return null;
    }


        
    }
?>
