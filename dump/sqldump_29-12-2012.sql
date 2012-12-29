-- 
-- Structure de la table ` Attaque ` 
--
 
CREATE TABLE `Attaque` (
  `groupeAttaquant` int(11) NOT NULL,
  `groupeAttaque` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pdf` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1
 
-- 
-- Contenu de la table ` Attaque` 
--  
 
INSERT INTO Attaque VALUES ('4' ,'3' ,'1' ,'1' ,'6') ; 
INSERT INTO Attaque VALUES ('4' ,'3' ,'2' ,'2' ,'7') ; 
INSERT INTO Attaque VALUES ('4' ,'3' ,'3' ,'3' ,'8') ; 
INSERT INTO Attaque VALUES ('4' ,'3' ,'4' ,'4' ,'9') ; 
INSERT INTO Attaque VALUES ('4' ,'3' ,'5' ,'5' ,'10') ; 
INSERT INTO Attaque VALUES ('4' ,'3' ,'5' ,'6' ,'11') ; 
INSERT INTO Attaque VALUES ('3' ,'4' ,'1' ,'7' ,'13') ; 

-- 
-- Structure de la table ` AttaqueEnCours ` 
--
 
CREATE TABLE `AttaqueEnCours` (
  `groupeAttaquant` int(11) NOT NULL,
  `groupeAttaque` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pdf` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1
 
-- 
-- Contenu de la table ` AttaqueEnCours` 
--  
 

-- 
-- Structure de la table ` Groupe ` 
--
 
CREATE TABLE `Groupe` (
  `numero` int(11) NOT NULL,
  `motDePasse` varchar(20) NOT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
 
-- 
-- Contenu de la table ` Groupe` 
--  
 
INSERT INTO Groupe VALUES ('1' ,'groupe1' ,'120') ; 
INSERT INTO Groupe VALUES ('2' ,'groupe2' ,'126') ; 
INSERT INTO Groupe VALUES ('3' ,'groupe3' ,'-130') ; 
INSERT INTO Groupe VALUES ('4' ,'groupe4' ,'0') ; 
INSERT INTO Groupe VALUES ('5' ,'groupe5' ,'79') ; 
INSERT INTO Groupe VALUES ('6' ,'groupe6' ,'34') ; 
INSERT INTO Groupe VALUES ('7' ,'groupe7' ,'91') ; 
INSERT INTO Groupe VALUES ('8' ,'groupe8' ,'59') ; 
INSERT INTO Groupe VALUES ('9' ,'groupe9' ,'54') ; 
INSERT INTO Groupe VALUES ('10' ,'groupe10' ,'28') ; 
INSERT INTO Groupe VALUES ('11' ,'groupe11' ,'98') ; 
INSERT INTO Groupe VALUES ('12' ,'groupe12' ,'382') ; 
INSERT INTO Groupe VALUES ('13' ,'groupe13' ,'34') ; 

-- 
-- Structure de la table ` GroupeAttaque ` 
--
 
CREATE TABLE `GroupeAttaque` (
  `groupe` int(11) NOT NULL,
  `attaque` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1
 
-- 
-- Contenu de la table ` GroupeAttaque` 
--  
 

-- 
-- Structure de la table ` Notifications ` 
--
 
CREATE TABLE `Notifications` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `groupe` int(11) NOT NULL,
  `groupeAttaque` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1
 
-- 
-- Contenu de la table ` Notifications` 
--  
 
INSERT INTO Notifications VALUES ('1' ,'version' ,'3' ,'0' ,'1') ; 
INSERT INTO Notifications VALUES ('2' ,'version' ,'3' ,'0' ,'1') ; 
INSERT INTO Notifications VALUES ('3' ,'version' ,'3' ,'0' ,'1') ; 
INSERT INTO Notifications VALUES ('4' ,'version' ,'4' ,'0' ,'1') ; 
INSERT INTO Notifications VALUES ('5' ,'attaque' ,'3' ,'4' ,'1') ; 
INSERT INTO Notifications VALUES ('6' ,'version' ,'3' ,'0' ,'2') ; 
INSERT INTO Notifications VALUES ('7' ,'attaque' ,'3' ,'4' ,'2') ; 
INSERT INTO Notifications VALUES ('8' ,'version' ,'3' ,'0' ,'3') ; 
INSERT INTO Notifications VALUES ('9' ,'attaque' ,'4' ,'3' ,'3') ; 
INSERT INTO Notifications VALUES ('10' ,'version' ,'3' ,'0' ,'4') ; 
INSERT INTO Notifications VALUES ('11' ,'attaque' ,'4' ,'3' ,'4') ; 
INSERT INTO Notifications VALUES ('12' ,'version' ,'3' ,'0' ,'5') ; 
INSERT INTO Notifications VALUES ('13' ,'attaque' ,'4' ,'3' ,'5') ; 
INSERT INTO Notifications VALUES ('14' ,'decline' ,'4' ,'3' ,'3') ; 
INSERT INTO Notifications VALUES ('15' ,'attaque' ,'4' ,'3' ,'5') ; 
INSERT INTO Notifications VALUES ('16' ,'decline' ,'3' ,'4' ,'5') ; 
INSERT INTO Notifications VALUES ('17' ,'attaque' ,'3' ,'4' ,'1') ; 
INSERT INTO Notifications VALUES ('18' ,'version' ,'4' ,'0' ,'2') ; 

-- 
-- Structure de la table ` Version ` 
--
 
CREATE TABLE `Version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `estAttaque` int(11) NOT NULL,
  `groupe` int(11) NOT NULL,
  `pdf` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1
 
-- 
-- Contenu de la table ` Version` 
--  
 
INSERT INTO Version VALUES ('3' ,'1' ,'1' ,'3' ,'') ; 
INSERT INTO Version VALUES ('4' ,'1' ,'1' ,'4' ,'') ; 
INSERT INTO Version VALUES ('5' ,'2' ,'1' ,'3' ,'') ; 
INSERT INTO Version VALUES ('6' ,'3' ,'1' ,'3' ,'') ; 
INSERT INTO Version VALUES ('7' ,'4' ,'1' ,'3' ,'') ; 
INSERT INTO Version VALUES ('8' ,'5' ,'1' ,'3' ,'') ; 
INSERT INTO Version VALUES ('9' ,'2' ,'0' ,'4' ,'') ; 

