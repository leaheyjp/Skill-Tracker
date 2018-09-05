-- -----------------------------------------------------
-- Nov 16 2017
-- SKLTRKR 3000
-- Team Julia 
-- Max Addington, John Paul Dyar, Patrick Leahey, Jason Pinto
-- Written in MySQL Workbench
-- -----------------------------------------------------
DROP DATABASE IF EXISTS `SKLTRKR3000`;
CREATE DATABASE `SKLTRKR3000`;
USE `SKLTRKR3000`; #Initialize use of table

SET SQL_SAFE_UPDATES = 0;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Table `SKLTRKR3000`.`Centre Students`
-- Description: Students are identified by their Centre ID number, and are associated
-- with only one class at a time
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SKLTRKR3000`.`Centre_Students` (
  `Student_ID` INT NOT NULL,              #Uniquely identifies student, given at enrollment
  `First_Name` VARCHAR(45) NULL,          #Student first name
  `Last_Name` VARCHAR(45) NULL,           #Student last name
  `Graduation_Year` INT NULL,             #Allows you to determine who is still enrolled                    
  `Student_Email` VARCHAR(100) NULL,      #Student email
  `Student_Password` VARCHAR(100) NULL,
  PRIMARY KEY (`Student_ID`))
  ENGINE = InnoDB;            


-- -----------------------------------------------------
-- Table `SKLTRKR3000`.`Instructors`
-- Description: Contains information about class instructors and has a 1:N relationship
-- with classes
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SKLTRKR3000`.`Instructors` (
  `Instructor_ID` INT NOT NULL AUTO_INCREMENT,   #Uniqely identifies instructor, given at hiring
  `First_Name` VARCHAR(45) NULL,         #Instructor first name
  `Last_Name` VARCHAR(45) NULL,          #Instructor last name
  `Instructor_Email` VARCHAR(100) NULL,  #Instructor email
  `Instructor_Password` VARCHAR(100) NULL,
  PRIMARY KEY (`Instructor_ID`))ENGINE = InnoDB;         
  ALTER TABLE `SKLTRKR3000`.`Instructors`
  ALTER Instructor_ID SET DEFAULT 1;
  


-- -----------------------------------------------------
-- Table `SKLTRKR3000`.`Classes`
-- Description: Enforces businness rule that each student can be enrolled in at most one course
-- at a time
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SKLTRKR3000`.`Classes` (
  `Class_ID` INT NOT NULL AUTO_INCREMENT,#System generated unique number
  `Category` VARCHAR(3) NULL,            #Department abbreviation    
  `Number` INT NULL,                     #Course number e.g. 117, 223
  `Section` VARCHAR(45) NULL,            #Section of the class
  `Year` INT NULL,                       #Class year e.g. 2017
  `Semester` VARCHAR(10) NULL,           #Semester e.g. fall, spring
  `Instructor_ID` INT NOT NULL,              #Foreign key linking with Instructors
  `Active` BOOLEAN NOT NULL,             #Course currently active
  PRIMARY KEY (`Class_ID`))ENGINE = InnoDB;


  
  #FOREIGN KEY (`Instructor_ID`) REFERENCES `SKLTRKR3000`.`Instructors`);


-- -----------------------------------------------------
-- Table `SKLTRKR3000`.`Skills`
-- Description: Basic sections of learning
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SKLTRKR3000`.`Skills` (
  `Skill_Name` VARCHAR(45) NOT NULL,    #Name of the skill related to a question
  `Prerequisite_Skill` VARCHAR(45) NULL, #Name of the skill that is a prerequisite skill for another skill
  `Class_ID` INT,
  PRIMARY KEY (`Skill_Name`),
  FOREIGN KEY (`Class_ID`) REFERENCES `SKLTRKR3000`.`Classes` (Class_ID), #DELETION RULES
  FOREIGN KEY(`Prerequisite_Skill`) REFERENCES `SKLTRKR3000`.`Skills`(Skill_Name)
  ON DELETE RESTRICT)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SKLTRKR3000`.`Questions`
-- Description: Questions associated with certain skills for instructors to populate and students to answer
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SKLTRKR3000`.`Questions` (
  `Question_ID` INT NOT NULL AUTO_INCREMENT,    #Uniquely identifies a question
  `Text` VARCHAR(500) NULL,                     #The text of the question
  `Skill_Name` VARCHAR(45) NULL,
  PRIMARY KEY (`Question_ID`),
  FOREIGN KEY (`Skill_Name`) REFERENCES `SKLTRKR3000`.`Skills`(Skill_Name)) #Add deletion rule
ENGINE = InnoDB;




-- -----------------------------------------------------
-- Table `SKLTRKR3000`.`Answers`
-- Description: Answers stores correct and incorrect answers for a multiple choice question. Open response
-- format is also supported. In this case, there is one stored, correct answer. Related to Questions table
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SKLTRKR3000`.`Answers` (
  `Answer_ID` INT NOT NULL AUTO_INCREMENT,
  `Is_Correct` BOOLEAN NULL,
  `Answer_Text` VARCHAR(500) NULL,
  `Question_ID` INT NULL,
  PRIMARY KEY (`Answer_ID`),
  FOREIGN KEY (`Question_ID`) REFERENCES `SKLTRKR3000`.`Questions` (Question_ID) 
  ON DELETE CASCADE)
  ENGINE = InnoDB;
 #ALTER TABLE `SKLTRKR3000`.`Answers`
 #ALTER Answer_ID SET DEFAULT 1;
  

-- -----------------------------------------------------
-- Table `SKLTRKR3000`.`Prerequisites`
-- Description: We decided to give the table Skills a self referencing many to many relationship and added the linking table Prerequisites.

-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SKLTRKR3000`.`Prerequisites` (
  `Skill_Name` VARCHAR(45) NOT NULL,
  `Prerequisite_Skill` VARCHAR(45) NULL,
  PRIMARY KEY (`Skill_Name`,`Prerequisite_Skill`),
  FOREIGN KEY (`Skill_Name`) REFERENCES `SKLTRKR3000`.`Skills` (Skill_Name) 
  ON DELETE RESTRICT,
  FOREIGN KEY (`Prerequisite_Skill`) REFERENCES `SKLTRKR3000`.`Skills`(Skill_Name) 
  ON DELETE RESTRICT)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SKLTRKR3000`.`Student_Responses`-- 
-- Description: The Student Responses table contains students’ responses to questions they attempt. 
-- This is connected to Centre Students with a one to many relationship.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SKLTRKR3000`.`Student_Responses` (
  `Student_Response_ID` INT NOT NULL AUTO_INCREMENT,
  `Response_Text` VARCHAR(500) NULL,
  `Student_ID` INT NULL,
  `Question_ID` INT NULL,
  PRIMARY KEY (`Student_Response_ID`),
  FOREIGN KEY (`Question_ID`) REFERENCES `SKLTRKR3000`.`Questions` (Question_ID),    
  #foreign key that connects the question to the response
  FOREIGN KEY (`Student_ID`) REFERENCES `SKLTRKR3000`.`Centre_Students` (Student_ID))
  ENGINE = InnoDB;     #foreign key that connects responses to a student


-- -----------------------------------------------------
-- Table `SKLTRKR3000`.`Student Classes`
-- This is a linking table between the Students and Classes tables. It handles the many to many relationship
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SKLTRKR3000`.`Student_Classes` (
  `Student_ID` INT NOT NULL,
  `Class_ID` INT NOT NULL,
  PRIMARY KEY (`Student_ID`, `Class_ID`),
  FOREIGN KEY (`Student_ID`) REFERENCES `SKLTRKR3000`.`Centre_Students` (Student_ID) ON DELETE RESTRICT,#foreign key that connects students #classes
  FOREIGN KEY (`Class_ID`) REFERENCES `SKLTRKR3000`.`Classes` (Class_ID))ENGINE = InnoDB;    #foreign key that connects classes to #students
  
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;  
  
INSERT INTO Centre_Students (Student_ID,First_Name,Last_Name,Graduation_Year,Student_Email,Student_Password)
  VALUES(330592,"Jason","Pinto",2019,"jason.pinto@centre.edu","password"),
 (111111,"John_Paul","Dyar",2019,"john.dyar@centre.edu","banana");
 
      
INSERT INTO Instructors
  VALUES(123456,"Tom","Allen","thomas.allen@centre.edu","cabbage");
      
INSERT INTO Classes(Category,Number,Section,Year,Semester,Instructor_ID,Active)
  VALUES("CSC",410,"a","2017","Fall",123456,1),
  ("CSC",117,"a","2017","Fall",123456,1);
  
INSERT INTO Student_Classes
 VALUES (330592, 1),(330592,2),(111111,1);
      
INSERT INTO Skills (Skill_Name,Prerequisite_Skill,Class_ID)
  VALUES("Print_Statements",NULL,2),("Variables","Print_Statements",2), ("The_Design_Process",NULL,1),("Big_Loops","Variables",2),
   ("ER_Diagrams",NULL,1),("Building_a_LAMP_Box","The_Design_Process",1);
      
INSERT INTO Questions (Text, Skill_Name)
  VALUES 
  ("Love = 'battlefield': What is the value of love?","Variables"),
  (" memes = 13 : dreams = 9 :What is memes * dreams?","Variables"),
  ("FOR x in range (1,10): Print('kitten')
            How many kittens are printed?", "Big_Loops"), 
  ("What is wrong with this:
		while(true):
			Print('INFINITY')", "Big_Loops"),
  ("What is the output of this command?
		print('Where am I?')","Print_Statements"),
  ("What is the output of this command?
	print(5+5^2+1)","Print_Statements"),
    ("Which of these should you do for an interview?", "The_Design_Process"),
    ("What is the mission defining statement of your database?", "The_Design_Process"),
	("What does sudo do?","Building_a_LAMP_Box"),
	("What shape is a validation table?", "ER_Diagrams"),
	("What should be placed next to compound primary keys??", "ER_Diagrams"),
    ("How can you save time setting up your LAMP Box?","Building_a_LAMP_Box");
  
    
    

 INSERT INTO Answers (Is_Correct,Answer_Text,Question_ID)
  VALUES(1,"battlefield",1),
  (0,"'battlefield'",1),
  (0,"NULL",1),
  (0,"Pain and Suffering",1),
  (0,"Infinite",2),
  (1, "117",2),
  (0, "About 12",2),
  (0, "It is impossible for a mortal to know.",2),
  (0, "A big ol' litter",3),
  (0, "10.",3),
  (1, "9",3),
  (0, "7 gallons",3),
  (1, "Infinite loop (bad)",4),
  (0, "Infinity is an artificial construct.",4),
  (0, "Nothing, absolutely nothing",4),
  (0, "14",4),
  (0,"In class",5),
  (1,"Where am I?",5),
  (0,"I don't know",5),
  (0,"32.1478 degrees N, 88.0938 degrees W",5),
  (0, "30",6),
  (0, "About 12",6),
  (1, "31",6),
  (0, "2",6),
  (1, "Prepare.",7),
  (0, "Our Lord and Savior Jesus Christ",7),
  (0, "A big line.",7),
  (0, "Some crossword puzzles",7),
  (1, "The Mission Statement",8),
  (0, "The Preliminary Table List",8),
  (0, "The Mission Objectives",8),
  (0, "Fields",8),
  (1, "Superuser Do.",9),
  (0, "I don't know",9),
  (0, "Superuser Don't.",9),
  (0, "Abort",9),
  (0, "Rhombus",10),
  (0, "Octogon",10),
  (0, "Circle",10),
  (1, "Rounded Quadrilateral",10),
  (0, "FK",11),
  (0, "PK",11),
  (1, "CPK",11),
  (0, "APK",11),
  (0, "Snag Dr. Allen's flash drive",12),
  (0, "Build it from scratch",12),
  (1, "Download MAMP or XAMP",12),
  (0, "Tell your group// partner to do it",12);
    
 

  
  
  
  
  
  
  
  
  
  