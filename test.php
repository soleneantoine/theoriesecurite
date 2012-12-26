<?php

include('class/Groupes.php');
//$groupes = array();
//
//$g1 = new Groupe(1);
//array_push($groupes, $g1);
//$g2 = new Groupe(2);
//array_push($groupes, $g2);
//$g3 = new Groupe(3);
//array_push($groupes, $g3);
//$g4 = new Groupe(4);
//array_push($groupes, $g4);
//
//
//$g1->initScore(125);
//$g2->initScore(205);
//$g3->initScore(145);
//$g4->initScore(206);
//
//$g2->ajoutVersion();
//
//$g1->attaque($g2);
//$g1->attaque($g2);
//
//$g2->ajoutVersion();
//
//
//echo "Score g1 : $g1->score<br>";
//echo "Score g2 : $g2->score<br>";
//
//function max(){
//            $g = $this->groupes[0];
//            foreach ($this->groupes as $groupe) {
//                if ($this->groupe->getScore() > $g->getScore()){
//                    $g = $this->groupe;
//                }
//            }
//            return $g;
//        }
//        
//function classement(){
//            $l1 = array();
//            $l2 = $this->groupes;
//            foreach ($l2 as $g){
//                array_push($l1, max($l2));
//                array_unshift($l2, max($l2));
////                unset(max($l2));
//            }
//            return $l1;
//        }

$groupes = new Groupes();
$groupes->init();

echo "<pre>".var_dump($groupes)."</pre>";
//echo "max : ".$groupes->max($groupes);
                
//var_dump(classement($groupes));           


?>
