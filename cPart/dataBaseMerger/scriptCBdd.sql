-- MySQL Script generated by MySQL Workbench
-- Thu Feb 13 17:30:57 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema bringmeC
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bringmeC
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bringmeC` DEFAULT CHARACTER SET utf8 ;
USE `bringmeC` ;

-- -----------------------------------------------------
-- Table `bringmeC`.`provider`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bringmeC`.`provider` (
  `idProvider` INT NOT NULL AUTO_INCREMENT,
  `providerFirstName` VARCHAR(55) NOT NULL,
  `providerLastName` VARCHAR(55) NOT NULL,
  `providerPhone` VARCHAR(20) NOT NULL,
  `providerEmail` VARCHAR(55) NULL,
  `providerPassword` VARCHAR(255) NOT NULL,
  `providerAddress` VARCHAR(100) NOT NULL,
  `companyName` VARCHAR(100) NULL,
  `providerRate` FLOAT NOT NULL,
  `providerAnnulation` INT NULL,
  PRIMARY KEY (`idProvider`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
