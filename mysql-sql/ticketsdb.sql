-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema ticketsdb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ticketsdb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ticketsdb` DEFAULT CHARACTER SET utf8 ;
USE `ticketsdb` ;

-- -----------------------------------------------------
-- Table `ticketsdb`.`events`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ticketsdb`.`events` (
  `event_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `ticketprice_standard` FLOAT NOT NULL,
  `begin_time` DATETIME NOT NULL,
  `end_time` DATETIME NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `description` TEXT(255) NOT NULL,
  PRIMARY KEY (`event_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ticketsdb`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ticketsdb`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password` CHAR(60) NOT NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ticketsdb`.`transactions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ticketsdb`.`transactions` (
  `transaction_id` INT NOT NULL AUTO_INCREMENT,
  `date_transaction` DATETIME NOT NULL,
  `seller_id` INT NOT NULL,
  `buyer_id` INT NULL,
  PRIMARY KEY (`transaction_id`),
  INDEX `fk_transactions_users1_idx` (`seller_id` ASC),
  INDEX `fk_transactions_users2_idx` (`buyer_id` ASC),
  CONSTRAINT `fk_transactions_users1`
    FOREIGN KEY (`seller_id`)
    REFERENCES `ticketsdb`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_transactions_users2`
    FOREIGN KEY (`buyer_id`)
    REFERENCES `ticketsdb`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ticketsdb`.`tickets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ticketsdb`.`tickets` (
  `ticket_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `ticket_price` FLOAT NOT NULL,
  `amount` INT NOT NULL,
  `sale_reason` VARCHAR(45) NOT NULL,
  `event_id` INT NOT NULL,
  `transaction_id` INT NOT NULL,
  PRIMARY KEY (`ticket_id`),
  INDEX `fk_tickets_events1_idx` (`event_id` ASC),
  INDEX `fk_tickets_transactions1_idx` (`transaction_id` ASC),
  CONSTRAINT `fk_tickets_events1`
    FOREIGN KEY (`event_id`)
    REFERENCES `ticketsdb`.`events` (`event_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tickets_transactions1`
    FOREIGN KEY (`transaction_id`)
    REFERENCES `ticketsdb`.`transactions` (`transaction_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ticketsdb`.`artists`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ticketsdb`.`artists` (
  `artist_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `age` VARCHAR(45) NOT NULL,
  `country` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`artist_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ticketsdb`.`events_has_artists`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ticketsdb`.`events_has_artists` (
  `event_id` INT NOT NULL,
  `artist_id` INT NOT NULL,
  PRIMARY KEY (`event_id`, `artist_id`),
  INDEX `fk_events_has_artists_artists1_idx` (`artist_id` ASC),
  INDEX `fk_events_has_artists_events1_idx` (`event_id` ASC),
  CONSTRAINT `fk_events_has_artists_events1`
    FOREIGN KEY (`event_id`)
    REFERENCES `ticketsdb`.`events` (`event_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_events_has_artists_artists1`
    FOREIGN KEY (`artist_id`)
    REFERENCES `ticketsdb`.`artists` (`artist_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ticketsdb`.`user_data`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ticketsdb`.`user_data` (
  `user_id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `friends_invited` INT NULL,
  `tickets_sold` INT NULL,
  `tickets_bought` VARCHAR(45) NULL,
  `address` VARCHAR(45) NOT NULL,
  `city` VARCHAR(45) NOT NULL,
  `country` VARCHAR(45) NOT NULL,
  INDEX `fk_user_data_users1_idx` (`user_id` ASC),
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_data_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `ticketsdb`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
