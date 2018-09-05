<!DOCTYPE html><!DOCTYPE html>
<html>
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
    <?php
    session_id(123);
    session_start();
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
    <div align="center"></div>


<form action="questionsList.php" method="post">


    <h1>Skills</h1>
    <?php $skills = array();

    #Connect to MySQL Database SKLTRKR
    $con = mysqli_connect('localhost', 'root', 'root',"SKLTRKR3000");
    if (!$con) {
        echo "Error: " . mysqli_connect_error();
        exit();
    }


    $sql = "SELECT Skill_Name FROM Skills";
    $result = mysqli_query($con,$sql);

    echo '<table>';

    while($row = mysqli_fetch_array($result))
    {
        echo '<tr>';
            ?>
            <td align="right"><?php echo $row['Skill_Name']; ?></td>
            <td align="right"><input type='submit' name="skill" style="background-color: seagreen; color: #FFFFFF; font-family: Damascus" value='<?php echo $row['Skill_Name']; ?>'></td>
        <?php
    }
    ?>


    </table>


</form>
</body>
</div>
</html>