SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
DROP SCHEMA IF EXISTS `mydb` ;
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;
DROP TABLE IF EXISTS `mydb`.`Emp` ;
CREATE TABLE IF NOT EXISTS `mydb`.`Emp` (
  `idEmp` INT NOT NULL,
  `num` VARCHAR(45) NULL,
  PRIMARY KEY (`idEmp`))
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`user` ;
CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` TEXT NOT NULL,
  `middle_name` TEXT NULL,
  `last_name` TEXT NOT NULL,
  `username` VARCHAR(30) NOT NULL,
  `password_hash` TEXT NOT NULL,
  `about` TEXT NULL,
  `college_role` ENUM('student', 'Professor', 'TA', 'Employee', 'Alumni') NOT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `userID_idx` (`user_id` ASC),
  UNIQUE INDEX `userID_UNIQUE` (`user_id` ASC),
  UNIQUE INDEX `UserName_UNIQUE` (`username` ASC))
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`lab` ;
CREATE TABLE IF NOT EXISTS `mydb`.`lab` (
  `lab_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `content` INT UNSIGNED NULL,
  `location` TEXT NULL,
  `about` TEXT NULL,
  PRIMARY KEY (`lab_id`),
  UNIQUE INDEX `Contents_UNIQUE` (`content` ASC),
  UNIQUE INDEX `lab_id_UNIQUE` (`lab_id` ASC),
  CONSTRAINT `guardian`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`safe` ;
CREATE TABLE IF NOT EXISTS `mydb`.`safe` (
  `safe_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`safe_id`, `content`),
  UNIQUE INDEX `safe_id_UNIQUE` (`safe_id` ASC),
  UNIQUE INDEX `content_UNIQUE` (`content` ASC),
  CONSTRAINT `fk_Safe_Labs1`
    FOREIGN KEY (`safe_id`)
    REFERENCES `mydb`.`lab` (`content`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`component` ;
CREATE TABLE IF NOT EXISTS `mydb`.`component` (
  `component_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `functional` TINYINT NOT NULL,
  `count` INT NULL,
  `state` TINYINT NULL,
  `Datasheet_url` TEXT NULL,
  PRIMARY KEY (`component_id`),
  UNIQUE INDEX `component_id_UNIQUE` (`component_id` ASC),
  CONSTRAINT `fk_component_safe1`
    FOREIGN KEY (`component_id`)
    REFERENCES `mydb`.`safe` (`content`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`project` ;
CREATE TABLE IF NOT EXISTS `mydb`.`project` (
  `project_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `supervisor` INT UNSIGNED NOT NULL,
  `idea` TEXT NULL,
  `name` TEXT NULL,
  `abstract` TEXT NULL,
  `date_started` DATETIME NOT NULL,
  `date_ended` DATETIME NULL,
  PRIMARY KEY (`project_id`, `supervisor`),
  UNIQUE INDEX `project_id_UNIQUE` (`project_id` ASC),
  CONSTRAINT `professor`
    FOREIGN KEY (`supervisor`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`course` ;
CREATE TABLE IF NOT EXISTS `mydb`.`course` (
  `course_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `about` TEXT NULL,
  `department` TEXT NULL,
  `grading` TEXT NULL,
  PRIMARY KEY (`course_id`),
  UNIQUE INDEX `course_id_UNIQUE` (`course_id` ASC))
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`student_course` ;
CREATE TABLE IF NOT EXISTS `mydb`.`student_course` (
  `user_id` INT UNSIGNED NOT NULL,
  `course_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `course_id`),
  CONSTRAINT `fk_Student_have_Courses1`
    FOREIGN KEY (`course_id`)
    REFERENCES `mydb`.`course` (`course_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Student_have_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`prof_course` ;
CREATE TABLE IF NOT EXISTS `mydb`.`prof_course` (
  `user_id` INT UNSIGNED NOT NULL,
  `course_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`course_id`, `user_id`),
  INDEX `fk_Professor_has_Courses_Courses1_idx` (`course_id` ASC),
  CONSTRAINT `fk_Professor_has_Courses_Courses1`
    FOREIGN KEY (`course_id`)
    REFERENCES `mydb`.`course` (`course_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Professor/Teacher_Can_Teach_Courses_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`admin` ;
CREATE TABLE IF NOT EXISTS `mydb`.`admin` (
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC),
  CONSTRAINT `userID`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`skill` ;
CREATE TABLE IF NOT EXISTS `mydb`.`skill` (
  `skill_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `skill` TEXT NULL,
  PRIMARY KEY (`skill_id`),
  UNIQUE INDEX `skill_id_UNIQUE` (`skill_id` ASC))
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`user_skill` ;
CREATE TABLE IF NOT EXISTS `mydb`.`user_skill` (
  `user_id` INT UNSIGNED NOT NULL,
  `skill_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `skill_id`),
  INDEX `fk_Users_has_skills_skills1_idx` (`skill_id` ASC),
  INDEX `fk_Users_has_skills_Users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_Users_has_skills_Users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Users_has_skills_skills1`
    FOREIGN KEY (`skill_id`)
    REFERENCES `mydb`.`skill` (`skill_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`position` ;
CREATE TABLE IF NOT EXISTS `mydb`.`position` (
  `user_id` INT UNSIGNED NOT NULL,
  `position` TEXT NOT NULL,
  `company` TEXT NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_position_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`project_file` ;
CREATE TABLE IF NOT EXISTS `mydb`.`project_file` (
  `project_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `upload_time` DATETIME NOT NULL,
  `url` TEXT NULL,
  `descreption` TEXT NULL,
  PRIMARY KEY (`project_id`),
  CONSTRAINT `releated to project`
    FOREIGN KEY (`project_id`)
    REFERENCES `mydb`.`project` (`project_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`message_header` ;
CREATE TABLE IF NOT EXISTS `mydb`.`message_header` (
  `header_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user1_id` INT UNSIGNED NOT NULL,
  `user2_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`header_id`, `user1_id`, `user2_id`),
  INDEX `fk_messages_users_idx` (`user1_id` ASC),
  INDEX `fk_messages_user2_idx` (`user2_id` ASC),
  UNIQUE INDEX `header_id_UNIQUE` (`header_id` ASC),
  CONSTRAINT `fk_messages_user1`
    FOREIGN KEY (`user1_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_user2`
    FOREIGN KEY (`user2_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`notification_header` ;
CREATE TABLE IF NOT EXISTS `mydb`.`notification_header` (
  `header_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`header_id`, `user_id`),
  INDEX `to_idx` (`user_id` ASC),
  UNIQUE INDEX `header_id_UNIQUE` (`header_id` ASC),
  CONSTRAINT `user_id_user_id_Notification`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`post` ;
CREATE TABLE IF NOT EXISTS `mydb`.`post` (
  `post_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `post` TEXT NULL,
  `time` DATETIME NOT NULL,
  PRIMARY KEY (`post_id`, `user_id`),
  INDEX `fk_posts_User1_idx` (`user_id` ASC),
  UNIQUE INDEX `post_id_UNIQUE` (`post_id` ASC),
  CONSTRAINT `fk_posts_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`comment` ;
CREATE TABLE IF NOT EXISTS `mydb`.`comment` (
  `post_id` INT UNSIGNED NOT NULL,
  `time` DATETIME NOT NULL,
  `user_id` INT NOT NULL,
  `comment` TEXT NULL,
  INDEX `post_idx` (`post_id` ASC),
  PRIMARY KEY (`post_id`, `time`, `user_id`),
  CONSTRAINT `post`
    FOREIGN KEY (`post_id`)
    REFERENCES `mydb`.`post` (`post_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`tag` ;
CREATE TABLE IF NOT EXISTS `mydb`.`tag` (
  `tag_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag` TEXT NOT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE INDEX `tag_id_UNIQUE` (`tag_id` ASC))
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`borrow` ;
CREATE TABLE IF NOT EXISTS `mydb`.`borrow` (
  `user_id` INT UNSIGNED NOT NULL,
  `component` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `component`),
  INDEX `fk_borrows_Devices1_idx` (`component` ASC),
  CONSTRAINT `borrower`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_borrows_Devices1`
    FOREIGN KEY (`component`)
    REFERENCES `mydb`.`component` (`component_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`user_project` ;
CREATE TABLE IF NOT EXISTS `mydb`.`user_project` (
  `user_id` INT UNSIGNED NOT NULL,
  `project_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `project_id`),
  INDEX `fk_User_has_Projects_Projects1_idx` (`project_id` ASC),
  INDEX `fk_User_has_Projects_User1_idx` (`user_id` ASC),
  CONSTRAINT `fk_User_has_Projects_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Projects_Projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `mydb`.`project` (`project_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`project_tag` ;
CREATE TABLE IF NOT EXISTS `mydb`.`project_tag` (
  `project_id` INT UNSIGNED NOT NULL,
  `tag_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`project_id`, `tag_id`),
  INDEX `fk_Projects_has_tags_tags1_idx` (`tag_id` ASC),
  INDEX `fk_Projects_has_tags_Projects1_idx` (`project_id` ASC),
  CONSTRAINT `fk_Projects_has_tags_Projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `mydb`.`project` (`project_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Projects_has_tags_tags1`
    FOREIGN KEY (`tag_id`)
    REFERENCES `mydb`.`tag` (`tag_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`post_tag` ;
CREATE TABLE IF NOT EXISTS `mydb`.`post_tag` (
  `post_id` INT UNSIGNED NOT NULL,
  `tag_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`post_id`, `tag_id`),
  INDEX `fk_posts_has_tags_tags1_idx` (`tag_id` ASC),
  INDEX `fk_posts_has_tags_posts1_idx` (`post_id` ASC),
  CONSTRAINT `fk_posts_has_tags_posts1`
    FOREIGN KEY (`post_id`)
    REFERENCES `mydb`.`post` (`post_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_posts_has_tags_tags1`
    FOREIGN KEY (`tag_id`)
    REFERENCES `mydb`.`tag` (`tag_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`emails` ;
CREATE TABLE IF NOT EXISTS `mydb`.`emails` (
  `user_id` INT UNSIGNED NOT NULL,
  `email` TEXT NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_emails_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`phone_number` ;
CREATE TABLE IF NOT EXISTS `mydb`.`phone_number` (
  `user_id` INT UNSIGNED NOT NULL,
  `phone_number` VARCHAR(14) NOT NULL,
  PRIMARY KEY (`user_id`, `phone_number`),
  CONSTRAINT `fk_phones_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`message` ;
CREATE TABLE IF NOT EXISTS `mydb`.`message` (
  `message_id` INT NOT NULL AUTO_INCREMENT,
  `header_id` INT UNSIGNED NOT NULL,
  `owner` BIT NULL,
  `message` TEXT NULL,
  `time` DATETIME NULL,
  PRIMARY KEY (`message_id`, `header_id`),
  UNIQUE INDEX `message_id_UNIQUE` (`message_id` ASC),
  CONSTRAINT `header_id_header_id_message`
    FOREIGN KEY (`header_id`)
    REFERENCES `mydb`.`message_header` (`header_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`notification` ;
CREATE TABLE IF NOT EXISTS `mydb`.`notification` (
  `header_id` INT UNSIGNED NOT NULL,
  `notification_id` INT UNSIGNED NOT NULL,
  `read` BIT NULL,
  `payload` TEXT NULL,
  `time` DATETIME NULL,
  `redirection_url` TEXT NULL,
  PRIMARY KEY (`header_id`, `notification_id`),
  UNIQUE INDEX `notification_id_UNIQUE` (`notification_id` ASC),
  CONSTRAINT `header_id_header_id_notification`
    FOREIGN KEY (`header_id`)
    REFERENCES `mydb`.`notification_header` (`header_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;