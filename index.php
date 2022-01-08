<?php
session_start();

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include("default.php");

$userName = $_SESSION['un'];
$pass = $_SESSION['pun'];
$homeURL = "home.html";

if (empty($userName)) {
    header('Location: '.$homeURL);
}

if (isset($_POST['submit'])) {

    $messageAnswer = mysqli_real_escape_string($conn, $_POST['msg']);
    $errorCount = 0;
    $noTxtErr = "<div class='alert alert-danger' role='alert'>Please enter message! </div>";
    $txtLng = "<div class='alert alert-danger' role='alert'> Message must be less than 100 characters! </div>";
    $dbFail = "<div class='alert alert-danger' role='alert'> Insertion to database failed, try again... </div>";
    //echo "<script type='text/javascript'>alert('$messageAnswer');</script>";

    if (strlen($messageAnswer) < 101) {
        if (!empty($messageAnswer)) {
            $sql = "INSERT INTO messages (msg, users_name, pass_key) VALUES (
                    '$messageAnswer', '$userName', '$pass'
            )";
            mysqli_query($conn, $sql);
        } else {
            $errorCount = 1;
        }
    }


        //generate a random image to use as the avatar
        $rdm=10;
       
        $avatars = array("fox1.png", "fox-2.png", "fox-3.png");
        $tstAvt = 'fox-2.png';
        $rndmAv = '';
          
        for ($i = 0; $i < count($avatars); $i++) {
            $rndmAv = array_rand($avatars, 1);
        }

       //your messages
      //run query on all records from database store in records variable
        $records = mysqli_query($conn,"SELECT * FROM messages WHERE users_name= '$userName' AND msg != ''");
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
        $records2 = mysqli_query($conn,"SELECT * FROM messages WHERE users_name != '$userName' AND msg != ''");
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
        <a class="navbar-brand active" style="color:dodgerblue"><?php  echo($userName);  ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="home.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search rooms</button>
            </form>
        </div>
    </nav>

    <div class="header">
            <div class="bg"></div>
            <div class="bg bg2"></div>
            <div class="bg bg3"></div>  
            <h1 class="jumbotron" id="jumbo" style="font-family:'Josefin Sans', sans-serif;">
                fox-talk
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

    <div id="textchamber" class="container">
        <?php
            //your messages
            while($data = mysqli_fetch_array($records))
            {
            ?>
                <span class="label label-primary .text-primary" style="color: dodgerblue; border-bottom: 1px solid black; display: block; font-family: 'Roboto Mono', monospace;">
                    <img id="avatar" src="<?php echo($tstAvt); ?>" >
                    <?php echo($data['users_name']); echo(": "); echo($data['msg']); ?>
                    <form action="index.php" method="POST">
                        <input value="delete msg: <?php  echo($data['users_id']);?>" type="submit" class="btn btn-danger" name="delete"/>
                            <?php 
                                $uIDo = $data['users_id'];
                            ?>
                    </form>
                </span> 
            
            <?php 
                //their messages
                while($data = mysqli_fetch_array($records2)) {
                ?>    
                     <span class="label label-primary .text-primary" style="color: dodgerblue; border-bottom: 1px solid black; display: block; font-family: 'Roboto Mono', monospace;">
                         <?php echo($data['users_name']); echo(": "); echo($data['msg']); ?>
                     </span>
                <?php
                }
                ?>
        <?php
        }
        ?>
         <div class="form-group">
            <form class="" action="index.php" method="POST">
                <input class="form-control" type="text" value="" name="msg" style="width: 500px; float: left;"/>
                <input class="form-control" type="submit" name="submit" value="Send" style="width: 100px; background-color:whitesmoke; float: left; color:darkslategrey"/>
            </form>
        </div>
    </div>
</body>
</html>

<?php 

    if (isset($_POST['delete'])) {
        $delMsg = "<div class='alert alert-primary' role='alert'> Message deleted </div>";
        // echo($uIDo);

        /*ß
        $records = mysqli_query($conn,"SELECT msg FROM messages WHERE users_name= '$userName' AND msg != ''");
        while($data = mysqli_fetch_array($records))
        {
            $uIDo = $data['users_id'];
        
        } */
        $sql = "DELETE msg FROM messages WHERE users_id = '$uIDo'";
        mysqli_query($conn, $sql); 
    }

?>