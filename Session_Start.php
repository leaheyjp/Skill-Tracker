<?php
session_start(); ?>
<!DOCTYPE html>
<html lang = 'en'>
<style type="text/css">
    body {
        padding: 20px 80px;
        background: #eee url(https://subtlepatterns.com/patterns/extra_clean_paper.png);
    }
</style>
<body>
<head>
    <meta charset = 'UTF-8'>
    <title>SKLTRKR 3000</title>
</head>

<?php
#Start Session and set Session Variables
//session_start();
$_SESSION['email'] = $_POST['email'];
$email = $_SESSION['email'];
$_SESSION['password'] = $_POST['password'];
$password = $_SESSION['password'];

$con = mysqli_connect('localhost', 'root', 'root',"SKLTRKR3000");

#Query for match with email and password entered
$sql = "SELECT Student_Email FROM Centre_Students WHERE Student_Email = '" . $email . "' AND Student_Password = '" .$password . "';";
$query = mysqli_query($con,$sql);
if (mysqli_num_rows($query)!=0) {
    ## if a match is found
    $_SESSION['valid'] = true;
    echo '<meta http-equiv="refresh" content="1;Student_Profile.php" />';
}
else {
    #else checks to see if match is in instructor table
    $sql2 = "SELECT Instructor_Email FROM Instructors WHERE Instructor_Email = '" . $email . "' AND Instructor_Password = '" . $password . "';";
    $query2 = mysqli_query($con, $sql2);
    if (mysqli_num_rows($query2) != 0) {
        #if there is a match, send to instructor profile page
        $_SESSION['valid'] = true;
        echo '<meta http-equiv="refresh" content="1;Instructor_Profile.php" />';
    } else {
        #else send back to login with session variable false
        $_SESSION['valid'] = false;
        echo '<meta http-equiv="refresh" content="1;Login.php" />';
    }
}








?>

</body>
</html>

