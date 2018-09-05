SKLTRKR 30000.  
Jason, Patrick, John Paul, Max A.

Login.php - The first file is the login page, Login.php. This file has a form that submits the user’s email and password to the next page…

Session_Start.php - This file compares inputted email and password to those in the student and instructor tables. If incorrect, sends user back to Login.php, else sends user to corresponding page.

Student_Profile.php - This file prints out a table of the user’s classes and the skills that go with that class. The student can select a skill and answer questions.

Question.php - presents the question and answers in a form with radio boxes. The user submits his/her answer.

Evaluate.php - checks the student’s answer and returns if they were correct or not. Allows student to continue answering or return to profile.

Instructor_Profile - Page where instructor can see all of his/her classes and students in each class. He/she can then add/edit questions or add new students.

New_User.php - This page has a form and boxes for the instructor to add a student and a radio box to select which class he/she is in.

Register.php - Runs query to add the user.

SkillsList.php - This page is form the button to add/edit questions. The instructor selects a skill to add a question to or edit a current question.

QuestionsList.php - This page has all of the questions listed for the instructor to edit or the ability to add a new question.

QuestionUpdater.php - This file runs the query to update questions.

Question_Adder.php - This file runs the query to add a desired question.

lambda.jpg - image used in login screen

SKLTRKR3000.sql - MySql script initially made in Mysql Workbench. Currently contains some initial data such as some questions for each class/skill.o

