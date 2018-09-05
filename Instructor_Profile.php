<?php
session_start(); ?>
<!DOCTYPE html><!DOCTYPE html>
<style>
    img {
        border-radius: 50%;
        display: block;
        margin: auto;
        width: 300px;

    }
    table {
        background-color: #AAAAAA;
        margin: 0px;
        padding: 0px;
        width=10;
    }
    td {
        width=10;
        border: 1px solid black;
        text-align: center;
        padding: 6px;
        margin: 0;
    }
    th {
        width=10;
        border: 1px solid black;
        text-align: center;
        padding: 4px;
        margin: 0;

    }
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,800,700,300);
    @import url(https://fonts.googleapis.com/css?family=Squada+One);
    body {
        padding: 20px 80px;
        background: #eee url(https://subtlepatterns.com/patterns/extra_clean_paper.png);
    }
    #logo {
        font-family: 'Open Sans', sans-serif;
        color: #555;
        text-decoration: none;
        text-transform: uppercase;
        font-size: 80px;
        font-weight: 800;
        letter-spacing: -3px;
        line-height: 1;
        text-shadow: #EDEDED 3px 2px 0;
        position: relative;
    }

    }
    #logo:after {
        /*background: url(https://subtlepatterns.com/patterns/crossed_stripes.png) repeat;*/
        background-image: -webkit-linear-gradient(left top, transparent 0%, transparent 25%, #555 25%, #555 50%, transparent 50%, transparent 75%, #555 75%);
        background-size: 4px 4px;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        z-index: -5;
        display: block;
        text-shadow: none;
    }
    #menu {
        width: 1090px;
        height: 42px;
        list-style: none;
        margin: 10px 0 0 0; padding: 25px 10px;
        border-top: 4px double #AAA;
        border-bottom: 4px double #AAA;
        position: relative;
        text-align: center;
    }
    #menu li {
        display: inline-block;
        width: 173px;
        margin: 0 10px;
        position: relative;
        -webkit-transform: skewy(-3deg);
        -webkit-backface-visibility: hidden;
        -webkit-transition: 200ms all;
    }
    #menu li a {
        text-transform: uppercase;
        font-family: 'Squada One', cursive;
        font-weight: 800;
        display: block;
        background: #FFF;
        padding: 2px 10px;
        color: #333;
        font-size: 35px;
        text-align: center;
        text-decoration: none;
        position: relative;
        z-index: 1;
        text-shadow:
                1px 1px 0px #FFF,
                2px 2px 0px #999,
                3px 3px 0px #FFF;
        background-image: -webkit-linear-gradient(top, transparent 0%, rgba(0,0,0,.05) 100%);
        -webkit-transition: 1s all;
        background-image: -webkit-linear-gradient(left top,
        transparent 0%, transparent 25%,
        rgba(0,0,0,.15) 25%, rgba(0,0,0,.15) 50%,
        transparent 50%, transparent 75%,
        rgba(0,0,0,.15) 75%);
        background-size: 4px 4px;
        box-shadow:
                0 0 0 1px rgba(0,0,0,.4) inset,
                0 0 20px -5px rgba(0,0,0,.4),
                0 0 0px 3px #FFF inset;
    }
    #menu li:hover {
        width: 203px;
        margin: 0 -5px;
    }
    #menu a:hover {
        color: #d90075;
    }
    #menu li:after,
    #menu li:before {
        content: '';
        position: absolute;
        width: 50px;
        height: 100%;
        background: #BBB;
        -webkit-transform: skewY(8deg);
        x-index: -3;
        border-radius: 4px;
    }
    #menu li:after {
        background-image: -webkit-linear-gradient(left, transparent 0%, rgba(0,0,0,.4) 100%);
        right: 0;
        top: -4px;
    }
    #menu li:before {
        left: 0;
        bottom: -4px;
        background-image: -webkit-linear-gradient(right, transparent 0%, rgba(0,0,0,.4) 100%);
    }

</style>
<div lang = 'en'>
    <?php
    $email = $_SESSION['email'];
    ?>
    <head>
        <meta charset = 'UTF-8'>
        <title>SKLTRKR 3000</title>
    </head>
    <h1 align="center">
        <div id="header">
            <a href="/" id="logo">SKLTRKR 30000</a>
        </div>
    </h1>
    <body style='background-color:lightskyblue'>
    <div align="center">
        <?php
        #Connect to MySQL Database SKLTRKR
        $con = mysqli_connect('localhost', 'root', 'root',"SKLTRKR3000");
        if (!$con) {
            echo "Error: " . mysqli_connect_error();
            exit();
        }

        #------------
        #Student Data
        #------------

        echo '<h3 align="center"> Instructor Data:</h3>';

        $sql = "SELECT First_name, Last_name, Instructor_ID, Instructor_Email
        FROM Instructors
        WHERE Instructor_Email ='" . $email ."';";

        $query = mysqli_query($con,$sql);
        $row = mysqli_fetch_array($query);

        echo "Name: " . $row[0] . " " . $row[1];
        echo "<br />";
        echo "Instructor ID: " . $row[2];
        echo "<br />";
        echo "Email: " . $row[3];
        echo "<br />";

        echo "<form action='SkillsList.php'><input type='submit' value='UPDATE/ADD QUESTIONS' /></form>";
        echo "<form action='New_User.php'><input type='submit' value='ADD STUDENT' /></form>";

        echo "<a href='Login.php'> Logout </a>";

        #-------
        #Courses
        #-------

        echo '<h3 align="center"> Courses:</h3>';
        echo "<form action='Question.php' method='post'>";

        $sql2 = "SELECT Number, Section FROM Classes NATURAL JOIN Instructors WHERE Instructor_Email='" . $email . "';";
        $query2 = mysqli_query($con,$sql2);
        #Queries for each class a professor teaches
        while($row2 = mysqli_fetch_array($query2))
        {

            echo "<h3 style='text-decoration: underline'>CSC " . $row2["Number"] . $row2["Section"] . "</h3>";

            $sql5 = "SELECT Student_Email,First_Name,Last_Name FROM Classes NATURAL JOIN Student_Classes NATURAL JOIN Centre_Students 
            WHERE Classes.Number ='".  $row2["Number"] ."' AND Classes.Section = '" . $row2["Section"]."';";
            $query5 = mysqli_query($con,$sql5);
            #iterates through students in class
            while($row5 =mysqli_fetch_array($query5))
            {
                    #Prints out table with their progress
                echo "<h4>Student: ". $row5["First_Name"] ." ". $row5["Last_Name"] . "</h4>";
                echo " <table>";
                echo " <tr><th width='50%' align='left'>SKILL:</th><th width='50%'>CORRECT/ATTEMPTED</th></tr>";
                $sql3 = "SELECT Skills.Skill_Name 
             FROM Classes NATURAL JOIN Skills NATURAL JOIN Centre_Students 
             WHERE Student_Email='" . $row5["Student_Email"] . "' AND Classes.Number ='". $row2["Number"] . "' AND Classes.Section = '" . $row2["Section"]."';";
                $query3 = mysqli_query($con, $sql3);
                while ($row3 = mysqli_fetch_array($query3)) {
                    echo "<tr>";
                    echo "<td width='50%'>" . $row3["Skill_Name"] . "</td>";
                    $sql_corr = "SELECT  COUNT(DISTINCT Student_Response_ID)
             FROM Student_Responses NATURAL JOIN Centre_Students 
             NATURAL JOIN Questions NATURAL JOIN Answers NATURAL JOIN Classes
             WHERE Student_Email='" . $row5["Student_Email"] . "' 
             AND Student_Responses.Response_Text=Answers.Answer_Text AND Answers.Is_Correct=1
             AND Questions.Skill_Name='" . $row3['Skill_Name'] . "'
             AND Classes.Number ='". $row2["Number"] . "' AND Classes.Section = '" . $row2["Section"]."';";
                    $query_corr = mysqli_query($con, $sql_corr);
                    $row_corr = mysqli_fetch_array($query_corr);
                    $num_correct = $row_corr[0];

                    $sql_total = "SELECT  COUNT(DISTINCT Student_Response_ID)
             FROM Student_Responses NATURAL JOIN Centre_Students 
             NATURAL JOIN Questions NATURAL JOIN Answers NATURAL JOIN Classes
             WHERE Student_Email='" . $row5["Student_Email"] . "' 
             AND Student_Responses.Response_Text=Answers.Answer_Text 
             AND Questions.Skill_Name='" . $row3['Skill_Name'] . "'
             AND Classes.Number ='". $row2["Number"] . "' AND Classes.Section = '" . $row2["Section"]."';";
                    $query4 = mysqli_query($con, $sql_total);
                    $row4 = mysqli_fetch_array($query4);
                    $num_total = $row4[0];
                    echo "<td width='50%'>" . $num_correct . "/" . $num_total . "</td>";
                    echo "</tr>";


                }
                echo "</table>";
                echo "</form>";
            }


        }


        $mysqli->close();
        ?>
    </body>
</div>
</html>
