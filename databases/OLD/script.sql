SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
DROP SCHEMA IF EXISTS `mydb` ;
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;
DROP TABLE IF EXISTS `mydb`.`user` ;
CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` TEXT NOT NULL,
  `middle_name` TEXT NULL,
  `last_name` TEXT NOT NULL,
  `username` VARCHAR(30) NOT NULL,
  `password_hash` TEXT NOT NULL,
  `about` TEXT NULL,
  `college_role` ENUM('student', 'prof', 'ta', 'emp', 'alumni') NOT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `userID_idx` (`user_id` ASC),
  UNIQUE INDEX `userID_UNIQUE` (`user_id` ASC),
  UNIQUE INDEX `UserName_UNIQUE` (`username` ASC))
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`lab` ;
CREATE TABLE IF NOT EXISTS `mydb`.`lab` (
  `lab_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `name` TEXT NOT NULL,
  `location` TEXT NULL,
  `about` TEXT NULL,
  PRIMARY KEY (`lab_id`),
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
  `lab_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`safe_id`),
  UNIQUE INDEX `safe_id_UNIQUE` (`safe_id` ASC),
  INDEX `fk_safe_lab1_idx` (`lab_id` ASC),
  CONSTRAINT `fk_safe_lab1`
    FOREIGN KEY (`lab_id`)
    REFERENCES `mydb`.`lab` (`lab_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
DROP TABLE IF EXISTS `mydb`.`component` ;
CREATE TABLE IF NOT EXISTS `mydb`.`component` (
  `component_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `safe_id` INT UNSIGNED NOT NULL,
  `name` TEXT NOT NULL,
  `functional` TINYINT NOT NULL,
  `count` INT NULL,
  `state` TINYINT NULL,
  `Datasheet_url` TEXT NULL,
  PRIMARY KEY (`component_id`),
  UNIQUE INDEX `component_id_UNIQUE` (`component_id` ASC),
  INDEX `fk_component_safe1_idx` (`safe_id` ASC),
  CONSTRAINT `fk_component_safe1`
    FOREIGN KEY (`safe_id`)
    REFERENCES `mydb`.`safe` (`safe_id`)
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
  `position` VARCHAR(100) NOT NULL,
  `company` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`user_id`, `position`, `company`),
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
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`user_id`, `email`),
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
  `owner` INT NULL,
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
  `notification_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `header_id` INT UNSIGNED NOT NULL,
  `read` BIT NULL,
  `payload` TEXT NULL,
  `time` DATETIME NULL,
  `redirection_url` TEXT NULL,
  PRIMARY KEY (`notification_id`, `header_id`),
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
INSERT INTO `user` (`user_id`, `first_name`, `middle_name`, `last_name`, `username`, `password_hash`, `about`, `college_role`) VALUES (NULL, 'first', 'middle', 'last', 'admin123', 'f865b53623b121fd34ee5426c792e5c33af8c227', 'about', 'prof'), (NULL, 'first', 'middle', 'last', 'user1234', 'f865b53623b121fd34ee5426c792e5c33af8c227', 'about', 'student');
INSERT INTO `admin` (`user_id`) VALUES ('1');
INSERT INTO `phone_number` (`user_id`, `phone_number`) VALUES ('1', '01223456789'), ('2', '01223456789'), ('1', '012234567890'), ('1', '012234567800'), ('2', '01223456000');
INSERT INTO `position` (`user_id`, `position`, `company`) VALUES (1, 'position', 'company'),(1, 'position2', 'company2'),(2, 'position', 'company'),(2, 'position3', 'company');
INSERT INTO `emails` (`user_id`, `email`) VALUES(1, 'ah@m.com'),(1, 'ahh@m.com'),(1, 'ah2@m.com'),(2, 'x@j.com');
INSERT INTO `skill` (`skill_id`, `skill`) VALUES(1, 'skill1'),(2, 'skill2'),(3, 'skill3'),(4, 'skill4');
INSERT INTO `tag` (`tag_id`, `tag`) VALUES(1, 'tag1'),(2, 'tag2'),(3, 'tag3'),(4, 'tag4');
INSERT INTO `post` (`post_id`, `user_id`, `post`, `time`) VALUES(1, 1, 'post', '2017-05-17 00:00:00'),(2, 1, 'post2', '2017-05-11 00:00:00'),(3, 2, 'post user 2', '2017-05-11 00:00:00');
INSERT INTO `comment` (`post_id`, `time`, `user_id`, `comment`) VALUES(1, '2017-05-02 00:00:03', 1, 'comment'),(2, '2017-05-17 00:00:00', 1, 'comment'),(2, '2017-05-31 00:00:02', 1, 'comment'),(3, '2017-05-15 00:00:00', 2, 'comment'),(3, '2017-05-15 00:00:01', 2, 'comment');
INSERT INTO `notification_header` (`header_id`, `user_id`) VALUES(1, 1),(2, 2);
INSERT INTO `notification` (`header_id`, `notification_id`, `read`, `payload`, `time`, `redirection_url`) VALUES(1, 1, b'1', 'payload', '2017-05-23 00:00:00', 'url'),(1, 2, b'0', 'payload', '2017-05-17 00:00:00', 'url'),(2, 3, b'0', 'payload', '2017-05-18 00:00:00', 'url'),(2, 4, b'1', 'payload', '2017-05-18 00:00:00', 'url'),(2, 5, b'0', 'payload', '2017-05-18 00:00:00', 'url');
INSERT INTO `course` (`course_id`, `name`, `about`, `department`, `grading`) VALUES(1, 'course1', 'about', 'dep', 'grad'),(2, 'course2', 'about', 'dep', 'grad'),(3, 'course3', 'about', 'dep', 'grad'),(4, 'course4', 'about', 'dep', 'grad');
INSERT INTO `prof_course` (`user_id`, `course_id`) VALUES(1, 1),(1, 2),(1, 3),(1, 4);
INSERT INTO `student_course` (`user_id`, `course_id`) VALUES(2, 2),(2, 3),(2, 4);
INSERT INTO `user_skill` (`user_id`, `skill_id`) VALUES(1, 1),(1, 2),(2, 1);
INSERT INTO `post_tag` (`post_id`, `tag_id`) VALUES(1, 1),(1, 2),(3, 1);
INSERT INTO `project` (`project_id`, `supervisor`, `idea`, `name`, `abstract`, `date_started`, `date_ended`) VALUES(1, 1, 'idea', 'project', 'abstract', '2017-05-09 00:00:00', '2017-05-25 00:00:00'),(2, 1, 'idea', 'name', 'abstract', '2017-05-24 00:00:00', '2017-05-31 00:00:00');
INSERT INTO `project_file` (`project_id`, `user_id`, `upload_time`, `url`, `descreption`) VALUES(1, 1, '2017-05-06 12:49:51', '../../uploads/project_files/1/ER.pdf', 'test with ER');
INSERT INTO `project_tag` (`project_id`, `tag_id`) VALUES(1, 1),(1, 2);
INSERT INTO `user_project` (`user_id`, `project_id`) VALUES(1, 1),(2, 2);
INSERT INTO `lab` (`lab_id`, `user_id`, `name`, `location`, `about`) VALUES ('1', '1', 'lab1', 'location', 'about'), ('2', '1', 'lab2', 'location2', 'about');
INSERT INTO `safe` (`safe_id`, `lab_id`, `name`) VALUES ('1', '1', 'safe11'), ('2', '1', 'safe12'), ('3', '2', 'safe21'), ('4', '2', 'safe22'), ('5', '2', 'safe23');
INSERT INTO `component` (`component_id`, `safe_id`, `name`, `functional`, `count`, `state`, `Datasheet_url`) VALUES ('1', '1', 'component1', '1', '5', '1', 'url'),('2', '2', 'component2', '1', '1', '1', 'url'),('3', '1', 'component3', '1', '10', '1', 'url'),('4', '3', 'component1', '1', '0', '1', 'url'),('5', '5', 'component1', '1', '4', '1', 'url');
INSERT INTO `borrow` (`user_id`, `component`) VALUES ('1', '3'), ('1', '4'), ('2', '1'), ('2', '2'), ('2', '5');
