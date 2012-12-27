<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyPDO
 *
 * @author soleneantoine
 */

class MyPDO extends PDO {
    const PARAM_hote='localhost'; // le chemin vers le serveur
    const PARAM_nom_bd='theorieSecurite'; // le nom de votre base de données
    const PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
    const PARAM_mot_passe='root'; // mot de passe de l'utilisateur pour se connecter
    
    public function __construct() {
        try {
            parent::__construct('mysql:host='.self::PARAM_hote.';dbname='.self::PARAM_nom_bd, self::PARAM_utilisateur, self::PARAM_mot_passe);

        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public static function get(){
        return new MyPDO();
    }
}

?>
