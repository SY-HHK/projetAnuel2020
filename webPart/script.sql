SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DROP SCHEMA IF EXISTS `bringme` ;


-- -----------------------------------------------------
-- Schema bringme
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bringme` ;
USE `bringme` ;


-- -----------------------------------------------------
-- Table `bringme`.`CITY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bringme`.`CITY` (
  `idCity` INT AUTO_INCREMENT,
  `cityName` VARCHAR(50),
  `cityRegion` VARCHAR(50),
  `cityDepartement` VARCHAR(50),
  PRIMARY KEY (`idCity`));


-- -----------------------------------------------------
-- Table `bringme`.`PROVIDER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bringme`.`PROVIDER` (
  `idProvider` INT AUTO_INCREMENT,
  `providerFirstName` VARCHAR(50),
  `providerLastName` VARCHAR(45),
  `providerPhone` VARCHAR(20),
  `providerEmail` VARCHAR(50) NOT NULL,
  `providerPassword` VARCHAR(255) NOT NULL,
  `providerAddress` VARCHAR(250),
  `providerIdCity` INT,
  `companyName` VARCHAR(45),
  `providerRate` FLOAT,
  `providerAnnulation` INT,
  `state` TINYINT(1),
  `providerGuid` char(36),
  PRIMARY KEY (`idProvider`),
  INDEX `PROVIDER_CITY_FK` (`providerIdCity` ASC),
  CONSTRAINT `PROVIDER_CITY_FK`
    FOREIGN KEY (`providerIdCity`)
    REFERENCES `bringme`.`CITY` (`idCity`)
    ON DELETE CASCADE);


-- -----------------------------------------------------
-- Table `bringme`.`SERVICE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bringme`.`SERVICE` (
  `idService` INT AUTO_INCREMENT,
  `serviceTitle` VARCHAR(50),
  `servicePrice` FLOAT,
  `serviceDescription` TEXT,
  `serviceImage` VARCHAR(100),
  PRIMARY KEY (`idService`)
);


-- -----------------------------------------------------
-- Table `bringme`.`CONTRACT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bringme`.`CONTRACT` (
  `idContract` INT AUTO_INCREMENT,
  `contractDateStart` DATE ,
  `contractDateEnd` DATE,
  `contractPrice` FLOAT,
  `idService` INT,
  `idProvider` INT,
  PRIMARY KEY (`idContract`),
  INDEX `CONTRACT_SERVICE_FK` (`idService` ASC),
  INDEX `CONTRACT_PROVIDER_FK` (`idProvider` ASC),
  CONSTRAINT `CONTRACT_SERVICE_FK`
    FOREIGN KEY (`idService`)
    REFERENCES `bringme`.`SERVICE` (`idService`)
    ON DELETE CASCADE,
  CONSTRAINT `CONTRACT_PROVIDER_FK`
    FOREIGN KEY (`idProvider`)
    REFERENCES `bringme`.`PROVIDER` (`idProvider`)
    ON DELETE CASCADE);


-- -----------------------------------------------------
-- Table `bringme`.`SUBSCRIPTION`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bringme`.`SUBSCRIPTION` (
  `idSub` INT AUTO_INCREMENT,
  `subName` VARCHAR(20),
  `subDays` INT,
  `subHourStart` INT,
  `subHourEnd` INT,
  `subHour` INT,
  `subPrice` FLOAT,
  `subStripeId` VARCHAR(100),
  PRIMARY KEY (`idSub`));


-- -----------------------------------------------------
-- Table `bringme`.`USER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bringme`.`USER` (
  `idUser` INT AUTO_INCREMENT,
  `userEmail` VARCHAR(50) NOT NULL,
  `userPassword` VARCHAR(255) NOT NULL,
  `userFirstName` VARCHAR(50),
  `userLastName` VARCHAR(50),
  `userBirth` DATE,
  `userAddress` VARCHAR(250),
  `userIdCity` INT,
  `userPhone` VARCHAR(20),
  `userPrivilege` INT,
  `userIp` VARCHAR(50),
  `userAgent` VARCHAR(500),
  `userAnnulation` INT,
  `state` TINYINT(1),
  `idSubscription` INT,
  `subStart` DATE,
  `subEnd` DATE,
  `subHourLeft` FLOAT,
  `userGuid` char(36),
  PRIMARY KEY (`idUser`),
  INDEX `fk_USER_SUBSCRIPTION1_idx` (`idSubscription` ASC),
  CONSTRAINT `fk_USER_SUBSCRIPTION1`
    FOREIGN KEY (`idSubscription`)
    REFERENCES `bringme`.`SUBSCRIPTION` (`idSub`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  INDEX `USER_CITY_FK` (`userIdCity` ASC),
  CONSTRAINT `USER_CITY_FK`
      FOREIGN KEY (`userIdCity`)
      REFERENCES `bringme`.`CITY` (`idCity`)
      ON DELETE CASCADE);


-- -----------------------------------------------------
-- Table `bringme`.`BILL`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bringme`.`BILL` (
  `idBill` INT AUTO_INCREMENT,
  `idUser` INT,
  `billDate` DATE,
  `billDescription` VARCHAR(250),
  `billPrice` FLOAT,
  `billState` INT,
  `billStripeId` VARCHAR(250),
  PRIMARY KEY (`idBill`),
  INDEX `BILL_USER_FK` (`idUser` ASC),
  CONSTRAINT `BILL_USER_FK`
    FOREIGN KEY (`idUser`)
    REFERENCES `bringme`.`USER` (`idUser`)
    ON DELETE CASCADE);


-- -----------------------------------------------------
-- Table `bringme`.`DELIVERY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bringme`.`DELIVERY` (
  `idDelivery` INT AUTO_INCREMENT,
  `deliveryDateStart` DATE,
  `deliveryDateEnd` DATE,
  `deliveryHourStart` TIME,
  `deliveryState` INT,
  `deliveryRate` INT,
  `idService` INT,
  `idProvider` INT,
  `idBill` INT,
  `deliveryHourEnd` TIME,
  PRIMARY KEY (`idDelivery`),
  INDEX `PROVISION_SERVICE_FK` (`idService` ASC),
  INDEX `PROVISION_PROVIDER_FK` (`idProvider` ASC),
  INDEX `PROVISION_BILL_FK` (`idBill` ASC),
  CONSTRAINT `PROVISION_SERVICE_FK`
    FOREIGN KEY (`idService`)
    REFERENCES `bringme`.`SERVICE` (`idService`)
    ON DELETE CASCADE,
  CONSTRAINT `PROVISION_PROVIDER_FK`
    FOREIGN KEY (`idProvider`)
    REFERENCES `bringme`.`PROVIDER` (`idProvider`)
    ON DELETE CASCADE,
  CONSTRAINT `PROVISION_BILL_FK`
    FOREIGN KEY (`idBill`)
    REFERENCES `bringme`.`BILL` (`idBill`)
    ON DELETE CASCADE);


-- -----------------------------------------------------
-- Data for table `bringme`.`SERVICE`
-- -----------------------------------------------------


INSERT INTO `SERVICE` (`idService`, `serviceTitle`, `servicePrice`, `serviceDescription`, `serviceImage`) VALUES
(1, 'Demande spéciale', 50, 'Toute demande non catalogué et spéciale correspond à ce service', '../images/request.png'),
(2, 'Baby sitter', 9, 'Le baby-sitter, nounou ou garde d’enfant, veille à la sécurité, au confort et au bien-être des petits dont il a la charge en l’absence des parents.', '../images/service1.jpg'),
(3, 'Plombier', 50, 'Le plombier installe, répare, règle et entretient les équipements sanitaires (toilettes, salles de bains, etc.), ainsi que les canalisations de distribution de gaz, d’eau et d’évacuation (en acier, cuivre, PVC, etc.)', '../images/service2.jpg'),
(4, 'Services du quotidien', 15, 'Pressing, retouche, cordonnerie, blanchisserie se sont les services du quotidien que nous vous proposons pour alléger vos journées chargées.\r\n\r\nIl vous suffit de déposer vos articles et nous les récupérerons lors de notre passage.','../images/service3.jpg'),
(5, 'Achats express', 10, 'Nous mettons à votre disposition tous types de services qui peuvent faciliter votre vie : paniers bio, bouquets de fleurs, jusqu’à la livraison des vins & spiritueux', '../images/service4.jpeg');

-- -----------------------------------------------------
-- Data for table `bringme`.`CITY`
-- -----------------------------------------------------
INSERT INTO `bringme`.`CITY` (`cityName`, `cityDepartement`, `cityRegion`) VALUES ('paris', '75', 'lle de france');

-- -----------------------------------------------------
-- Data for table `bringme`.`PROVIDER`
-- -----------------------------------------------------
INSERT INTO `bringme`.`PROVIDER` (`idProvider`, `providerFirstName`, `providerLastName`, `providerPhone`, `providerEmail`, `providerPassword`, `providerAddress`, `companyName`, `providerIdCity`, `providerRate`, `providerAnnulation`, `state`) VALUES (1, 'Jean', 'Dupont', '0897567876', 'jeandupont@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '98 rue test', NULL, 1, 5, DEFAULT, 0);
INSERT INTO `bringme`.`PROVIDER` (`idProvider`, `providerFirstName`, `providerLastName`, `providerPhone`, `providerEmail`, `providerPassword`, `providerAddress`, `companyName`, `providerIdCity`, `providerRate`, `providerAnnulation`, `state`) VALUES (2, 'Jacques', 'Jardin', '9067842465', 'jardin@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '76 avenue test', 'ematch', 1, NULL, DEFAULT, 0);

-- -----------------------------------------------------
-- Data for table `bringme`.`CONTRACT`
-- -----------------------------------------------------
INSERT INTO `CONTRACT` (`idContract`,`contractDateStart`,`contractDateEnd`,`contractPrice`,`idService`,`idProvider`) VALUES (1,'2020-03-17','2021-03-17',20,2,1);
INSERT INTO `CONTRACT` (`idContract`,`contractDateStart`,`contractDateEnd`,`contractPrice`,`idService`,`idProvider`) VALUES (2,'2020-03-17','2021-03-17',5,1,1);

-- -----------------------------------------------------
-- Data for table `bringme`.`SUBSCRIPTION`
-- -----------------------------------------------------
INSERT INTO `bringme`.`SUBSCRIPTION` (`idSub`, `subName`, `subDays`, `subHourStart`, `subHourEnd`, `subHour`, `subPrice`,`subStripeId`) VALUES (1, 'de base', 5, 9, 20, 12, 2400, "plan_GoQBCDEN85tByV");
INSERT INTO `bringme`.`SUBSCRIPTION` (`idSub`, `subName`, `subDays`, `subHourStart`, `subHourEnd`, `subHour`, `subPrice`,`subStripeId`) VALUES (2, 'Familial', 6, 9, 20, 25, 3600, "plan_Gr4puDyjnjtFsJ");
INSERT INTO `bringme`.`SUBSCRIPTION` (`idSub`, `subName`, `subDays`, `subHourStart`, `subHourEnd`, `subHour`, `subPrice`,`subStripeId`) VALUES (3, 'Premium', 7, 24, 24, 50, 6000, "plan_Gr4qs5XjRY8Btr");

-- -----------------------------------------------------
-- Data for table `bringme`.`USER`
-- -----------------------------------------------------
INSERT INTO `bringme`.`USER` (`idUser`, `userEmail`, `userPassword`, `userFirstName`, `userLastName`, `userBirth`, `userAddress`, `userIdCity`, `userPhone`, `userPrivilege`, `userIp`, `userAgent`, `userAnnulation`, `state`, `idSubscription`, `subStart`, `subEnd`, `userGuid`) VALUES (1, 'adeline@yahoo.fr', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Adeline', 'Hernadez', '1995-08-12', '86 avenue de la Place', 1, '0685643576', 0, '09090909', '35355535', DEFAULT, 0, NULL, NULL, NULL, '05301411-7c9d-422c-8dd1-842ff4e6c3b5');
INSERT INTO `bringme`.`USER` (`idUser`, `userEmail`, `userPassword`, `userFirstName`, `userLastName`, `userBirth`, `userAddress`, `userIdCity`, `userPhone`, `userPrivilege`, `userIp`, `userAgent`, `userAnnulation`, `state`, `idSubscription`, `subStart`, `subEnd`, `userGuid`) VALUES (2, 'louis.ricour@gmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'Louis', 'Ricour', '2000-06-26', '86 avenue de la Place', 1, '0685643576', 10, '09090909', '35355535', DEFAULT, 0, NULL, NULL, NULL, '7fcd2aa7-9d8a-438a-b834-0de6b6ed69db');
INSERT INTO `bringme`.`USER` (`idUser`, `userEmail`, `userPassword`, `userFirstName`, `userLastName`, `userBirth`, `userAddress`, `userIdCity`, `userPhone`, `userPrivilege`, `userIp`, `userAgent`, `userAnnulation`, `state`, `idSubscription`, `subStart`, `subEnd`, `userGuid`) VALUES (3, 'suvirtha@bringme.fr', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Suvirtha', 'Thayaharan', '2000-05-03', '86 avenue de la Place', 1, '0685643576', 10, '09090909', '35355535', DEFAULT, 0, NULL, NULL, NULL, '506617B9-E5EC-48DA-B6D5-9606CB9251B8');

-- -----------------------------------------------------
-- Data for table `bringme`.`BILL`
-- -----------------------------------------------------
INSERT INTO `bringme`.`BILL` (`idBill`,`idUser` ,`billDate` ,`billDescription`,`billPrice`,`billState` ,`billStripeId`) VALUES (1,1,'2020-03-17','Bill description',789,1,NULL);
INSERT INTO `bringme`.`BILL` (`idBill`,`idUser` ,`billDate` ,`billDescription`,`billPrice`,`billState` ,`billStripeId`) VALUES (2,2,'2020-03-17','Demande speciale ',100,0,NULL);
INSERT INTO `bringme`.`BILL` (`idBill`,`idUser` ,`billDate` ,`billDescription`,`billPrice`,`billState` ,`billStripeId`) VALUES (3,3,'2020-03-17','Demande speciale je veux un arroseur chez moi',100,0,NULL);
INSERT INTO `bringme`.`BILL` (`idBill`,`idUser` ,`billDate` ,`billDescription`,`billPrice`,`billState` ,`billStripeId`) VALUES (4,1,'2020-03-17','Demande speciale descendre poubelle',100,0,NULL);
INSERT INTO `bringme`.`BILL` (`idBill`,`idUser` ,`billDate` ,`billDescription`,`billPrice`,`billState` ,`billStripeId`) VALUES (5,2,'2020-03-17','Demande speciale manger chien',100,0,NULL);
INSERT INTO `bringme`.`BILL` (`idBill`,`idUser` ,`billDate` ,`billDescription`,`billPrice`,`billState` ,`billStripeId`) VALUES (6,3,'2020-03-17','Demande speciale sortir hamster',100,0,NULL);


-- -----------------------------------------------------
-- Data for table `bringme`.`DELIVERY`
-- -----------------------------------------------------
INSERT INTO `bringme`.`DELIVERY` (`idDelivery`,`deliveryDateStart`,`deliveryDateEnd`,`deliveryHourStart` ,`deliveryState` ,`deliveryRate` ,`idService` ,`idProvider` ,`idBill` ,`deliveryHourEnd`) VALUES (1,'2020-03-17','2020-03-17','12:00',1,3,3,2,1,'19:00');
INSERT INTO `bringme`.`DELIVERY` (`idDelivery`,`deliveryDateStart`,`deliveryDateEnd`,`deliveryHourStart` ,`deliveryState` ,`deliveryRate` ,`idService` ,`idProvider` ,`idBill` ,`deliveryHourEnd`) VALUES (2,'2020-03-17','2020-03-17','12:30',2,5,1,1,2,'15:30');
INSERT INTO `bringme`.`DELIVERY` (`idDelivery`,`deliveryDateStart`,`deliveryDateEnd`,`deliveryHourStart` ,`deliveryState` ,`deliveryRate` ,`idService` ,`idProvider` ,`idBill` ,`deliveryHourEnd`) VALUES (3,'2020-03-17','2020-03-17','12:30',2,5,1,1,3,'15:30');
INSERT INTO `bringme`.`DELIVERY` (`idDelivery`,`deliveryDateStart`,`deliveryDateEnd`,`deliveryHourStart` ,`deliveryState` ,`deliveryRate` ,`idService` ,`idProvider` ,`idBill` ,`deliveryHourEnd`) VALUES (4,'2020-03-17','2020-03-17','12:30',2,5,1,1,4,'15:30');
INSERT INTO `bringme`.`DELIVERY` (`idDelivery`,`deliveryDateStart`,`deliveryDateEnd`,`deliveryHourStart` ,`deliveryState` ,`deliveryRate` ,`idService` ,`idProvider` ,`idBill` ,`deliveryHourEnd`) VALUES (5,'2020-03-17','2020-03-17','12:30',2,5,1,1,5,'15:30');
INSERT INTO `bringme`.`DELIVERY` (`idDelivery`,`deliveryDateStart`,`deliveryDateEnd`,`deliveryHourStart` ,`deliveryState` ,`deliveryRate` ,`idService` ,`idProvider` ,`idBill` ,`deliveryHourEnd`) VALUES (6,'2020-03-17','2020-03-17','12:30',2,5,1,1,6,'15:30');






