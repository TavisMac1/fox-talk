<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
include("dbinfo.php"); 

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

//check for valid connecton
if (!$conn) die("Connection failed: " . mysqli_connect_error());

//Create a database table
$sql = "CREATE TABLE IF NOT EXISTS messages (
    users_id int(11) NOT NULL AUTO_INCREMENT,
    msg varchar(100) NOT NULL,
    users_name varchar(20) NOT NULL, 
    PRIMARY KEY (users_id)) CHARSET=utf8mb4";

//run query
mysqli_query($conn, $sql);

if (isset($_POST['submit'])) {

    $messageAnswer = mysqli_real_escape_string($conn, $_POST['msg']);
    $userName = mysqli_real_escape_string($conn, $_POST['name']);
    $errorCount = 0;
    $noTxtErr = "<div class='alert alert-danger' role='alert'>Please enter a user name! </div>";
    $invUn = "<div class='alert alert-danger' role='alert'>Invalid username! </div>";
    $passLng = "<div class='alert alert-danger' role='alert'> Password must be 6 characters! </div>";
    $wrngPass = "<div class='alert alert-danger' role='alert'>Wrong password! </div>";
    $dbFail = "<div class='alert alert-danger' role='alert'> Insertion to database failed, try again... </div>";
    //echo "<script type='text/javascript'>alert('$messageAnswer');</script>";

    if (strlen($messageAnswer) < 101) {
        if (!empty($messageAnswer) && !empty($userName)) {
            $sql = "INSERT INTO messages (msg, users_name) VALUES (
                    '$messageAnswer', '$userName'
            )";
            mysqli_query($conn, $sql);
        } else {
            $errorCount = 1;
        }
    }

       //your messages
      //run query on all records from database store in records variable
        $records = mysqli_query($conn,"SELECT * FROM messages WHERE users_name= '$userName'");
        /*
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $records)) {
            $errorCount = 2;
        } else {
            mysqli_stmt_bind_param($stmt, "s", $userName);
            mysqli_stmt_execute($stmt);
            $records = mysqli_stmt_get_result($stmt);
            echo("records 1 succeeded");
        } */

        //their messages
        $records2 = mysqli_query($conn,"SELECT * FROM messages WHERE users_name != '$userName'");
}  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tavis Chat</title>
</head>
<body>
    <link rel="stylesheet" type="text/css" href="Chat.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100;400&display=swap" rel="stylesheet">

    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">tavis-chat</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="signup.php">Sign Up</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Login</a>
            </li>
            </ul>
        </div>
    </nav>

    <div class="header">
        <h1 class="jumbotron">
            log in
        </h1>
    </div>
    <div>
        <?php 
            if ($errorCount == 1) {
                echo($noTxtErr);  
            } else if ($errorCount == 2) {
                echo($dbFail);
            }

            if (strlen($messageAnswer) > 100) {
                echo($txtLng);
            }
        ?>
    </div>

    <div class="form-group">
        <form class="msg" action="index.php" method="POST">
            <input class="form-control" type="text" value="" placeholder="User Name" name="name" style="width: 500px; display: block; float: left;"/>
            <input class="form-control" type="text" value="" placeholder="Password" name="pass" style="width: 500px; display: block; float: left;"/>
            <input class="form-control" type="submit" name="submit" value="Send" style="width: 100px; background-color:whitesmoke; display: block; float: left; color:darkslategrey"/>
        </form>
    </div>
</body>
</html>