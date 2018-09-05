<?php session_start() ?>
<!DOCTYPE html><!DOCTYPE html>
<html lang = 'en'>
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
        text-align: left;
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
        font-size: 120px;
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

<head>
    <meta charset = 'UTF-8'>
    <title>SKLTRKR 3000</title>
</head>
<div align="center">
    <h1 align="center">
        <div id="header">
            <a href="/" id="logo">SKLTRKR 30000</a>
        </div>
    </h1>
<body style='background-color:lightskyblue'>
<?php

#----------------
#Connect to MySQL
#----------------
$con = mysqli_connect('localhost', 'root', 'root',"SKLTRKR3000");
if (!$con) {
    echo "Error: " . mysqli_connect_error();
    exit();
}

#-------------------
#Retrieve Skill_Name
#-------------------
# Resets the session variable so when the page is reloaded after answering a question, the correct variable is assigned
if (!isset($_SESSION['Skill_Name'])) {
    $_SESSION['Skill_Name'] = $_POST['Skill_Name'];
    $Skill_Name = $_SESSION['Skill_Name'];
}
elseif ($_POST['Skill_Name'] != $_SESSION['Skill_Name'] And ($_POST['Skill_Name'] != '')) {
    $_SESSION['Skill_Name'] = $_POST['Skill_Name'];
    $Skill_Name = $_SESSION['Skill_Name'];
}
else {
    $Skill_Name = $_SESSION['Skill_Name'];
}


#----
#Quiz
#----
echo "<h1 style='border-style: solid; background-color: gray; border-width: medium; border-color: #555555; color: yellow';>" . "Testing skill: " . $Skill_Name . "</h1>";
#This Query identifies all the questions that the student has not yet answered for the identified skill
$sql1 = "SELECT Text, Question_ID 
         FROM Questions
         WHERE Question_ID NOT IN (SELECT Question_ID 
                                   FROM Student_Responses NATURAL JOIN Questions) 
         AND Questions.Skill_Name ='" . $Skill_Name ."';";
$query1 = mysqli_query($con,$sql1);
if (mysqli_num_rows($query1)!=0)
{
    echo '<h2> Select the correct answer to the question below, and click submit to check you answer:</h2>';
    echo '<br />';
    $row1 = mysqli_fetch_array($query1);
        $Question_ID = $row1['Question_ID'];
        echo '<h3>' . $row1['Text'] . '<br />' . '</h3>';
        echo '<form action = "Evaluate.php" method="post" >';
        #Query for answers to the question, list them off in a form
        echo "<table>";
        $sql2 = "SELECT Answer_Text, Answer_ID 
                 FROM Answers 
                 WHERE Question_ID = '" . $row1['Question_ID'] . "';";
        $query2 = mysqli_query($con, $sql2);
        while ($row2 = mysqli_fetch_array($query2))
        {
            $Answer_ID = $row2['Answer_ID'];
            $Answer_Text = $row2['Answer_Text'];
            ?>
            <tr><td><input type='radio' name = 'Answer_ID' value = <?php echo $Answer_ID ?>> <?php echo $Answer_Text ?></td></tr>
            <?php

        }
        echo '</table>';
        ?>

        <input type = "hidden" name = 'Question_ID' value = <?php echo $Question_ID ?>>
        <?php
        echo '<br />';
        echo '<input type = "submit" />';
        echo '</form>';
}
else #In the case where there are no remaining questions to be asked about the identified skill
{
    echo '<h2> Congratulations, you have completed all the questions for this skill!</h2>';
    echo '<a href="Student_Profile.php">Click to return to Profile</a>';
}

$mysqli->close();
?>
</body>
</div>
</html>
