<?php
 session_start();

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
 $_SESSION['un'];
 $_SESSION['pun'];

include("default.php");

if (isset($_POST['submit'])) {
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $errorCount = 0;
    $successCount = 0;
    $noTxtErr = "<div class='alert alert-danger' role='alert'>Please enter a user name! </div>";
    $noPassErr = "<div class='alert alert-danger' role='alert'>Please enter a valid password! </div>";
    $invUn = "<div class='alert alert-danger' role='alert'>Invalid username! </div>";
    $existUn = "<div class='alert alert-danger' role='alert'> Username already exists, login or create a new account! </div>";
    $dbFail = "<div class='alert alert-danger' role='alert'> Insertion to database failed, try again... </div>";


    $created = "<div class='alert alert-success alert-dismissible fade show' role='alert'> Logged in as: '$name'
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
        </div>";

    $canChat = false;

    $goChat = "<div class='alert alert-primary alert-dismissible fade show' role='alert'>  
                <a href='index.php' >Go to chat </a>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
            </div>";

    if (!empty($name) && !empty($pass)) {
        $records = mysqli_query($conn,"SELECT users_name FROM messages");
        while($data = mysqli_fetch_array($records))
        {   //echo($name);
            if ($name == $data['users_name']) {
                $successCount ++;
                break;
            } else {
                //$errorCount = 3;
            }
        }
        $records2 = mysqli_query($conn,"SELECT users_name, pass_key FROM messages WHERE users_name = '$name' AND pass_key = '$pass'");
        while($data = mysqli_fetch_array($records2))
        {
            if ($pass == $data['pass_key']) {
                //$errorCount = 4;
                $successCount ++;
            } 
        }

    }  else if (empty($name)) {
        $errorCount = 1;
    }  else if (empty($pass)) {
        $errorCount = 2;
    }

    if ($successCount == 2) {
        $_SESSION['un'] = $name;
        $_SESSION['pun'] = $pass;
        $canChat = true;
    } 
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@1,700&display=swap" rel="stylesheet"> 

    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
    <a class="navbar-brand" style="color:firebrick"><img id="logo" src="fox.png" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.html">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="signup.php">Signup</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout <?php echo($name); ?></a>
            </li>
            </ul>
        </div>
    </nav>

    <div class="header">
        <div class="bg"></div>
        <div class="bg bg2"></div>
        <div class="bg bg3"></div>  
        <h1 class="jumbotron" id="jumbo" style="font-family:'Josefin Sans', sans-serif;">
            login to fox-talk
        </h1>
        </div>
    <div>
    <div>
        <?php 
            if ($errorCount == 1) {
                echo($noTxtErr);  
                $creating = '';
            } else if ($errorCount == 2) {
                echo($noPassErr);
                $creating = '';
            }

            if ($errorCount == 3) {
                echo($invUn);
            }

            if ($errorCount == 4) {
                echo($noPassErr);
            }
        ?>
    </div>
    <div id="signchamber" class="container">
        <span class="label label-primary .text-primary" style="color: dimgrey; border-bottom: 1px solid black; display: block; font-family: 'Roboto Mono', monospace;">
            <legend>Password</legend>
            <p>
                login with username and password
            </p>      
            <span>
                <?php
                     if ($canChat == true) {
                        echo($created);
                        echo($goChat);
                    }
                ?>
            </span>
        </span> 
    </div>

    <div class="form-group">
        <form class="msg" action="login.php" method="POST">
            <input class="form-control" type="text" value="" placeholder="User Name" name="name" style="width: 500px; display: block; float: left;"/>
            <input class="form-control" type="password" value="" placeholder="Password" name="pass" style="width: 500px; display: block; float: left;"/>
            <input class="form-control" type="submit" name="submit" value="Send" style="width: 100px; background-color:whitesmoke; display: block; float: left; color:darkslategrey"/>
        </form>
    </div>
</body>
</html>