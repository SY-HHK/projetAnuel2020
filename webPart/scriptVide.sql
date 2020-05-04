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
-- Data for table `bringme`.`USER`
-- -----------------------------------------------------
INSERT INTO `bringme`.`USER` (`idUser`, `userEmail`, `userPassword`, `userFirstName`, `userLastName`, `userBirth`, `userAddress`, `userIdCity`, `userPhone`, `userPrivilege`, `userIp`, `userAgent`, `userAnnulation`, `state`, `idSubscription`, `subStart`, `subEnd`, `userGuid`) VALUES (1, 'louis.ricour@gmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'Louis', 'Ricour', '2000-06-26', '86 avenue de la Place', 1, '0685643576', 10, '09090909', '35355535', DEFAULT, 0, NULL, NULL, NULL, '7fcd2aa7-9d8a-438a-b834-0de6b6ed69db');
INSERT INTO `bringme`.`USER` (`idUser`, `userEmail`, `userPassword`, `userFirstName`, `userLastName`, `userBirth`, `userAddress`, `userIdCity`, `userPhone`, `userPrivilege`, `userIp`, `userAgent`, `userAnnulation`, `state`, `idSubscription`, `subStart`, `subEnd`, `userGuid`) VALUES (2, 'suvirtha@bringme.fr', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Suvirtha', 'Thayaharan', '2000-05-03', '86 avenue de la Place', 1, '0685643576', 10, '09090909', '35355535', DEFAULT, 0, NULL, NULL, NULL, '506617B9-E5EC-48DA-B6D5-9606CB9251B8');
