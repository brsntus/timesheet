SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user` ;

CREATE  TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(40) NOT NULL ,
  `name` VARCHAR(100) NOT NULL ,
  `hour_rate` DOUBLE(10,2) NOT NULL DEFAULT 0 ,
  `hours_per_day` TINYINT(1) NOT NULL DEFAULT 8 ,
  `salary` DOUBLE(10,2) NOT NULL ,
  `hour_percent` DOUBLE(10,2) NOT NULL DEFAULT 50 ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `timesheet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `timesheet` ;

CREATE  TABLE IF NOT EXISTS `timesheet` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `task` TEXT NOT NULL ,
  `hours` TIME NOT NULL DEFAULT '00:00' ,
  `user_id` INT NOT NULL ,
  `timer_on` TINYINT(1)  NOT NULL DEFAULT 0 ,
  `timer_started_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_timesheet_user` (`user_id` ASC) ,
  CONSTRAINT `fk_timesheet_user`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8, 
COMMENT = 'In this table we store the tasks accomplished by the user an' /* comment truncated */ ;


-- -----------------------------------------------------
-- Table `clock`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `clock` ;

CREATE  TABLE IF NOT EXISTS `clock` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `clock_date` DATE NOT NULL ,
  `clock_time` TIME NOT NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_clock_user1` (`user_id` ASC) ,
  CONSTRAINT `fk_clock_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `holiday`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `holiday` ;

CREATE  TABLE IF NOT EXISTS `holiday` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NOT NULL ,
  `when` DATE NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
