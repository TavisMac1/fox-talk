<?php

include("SqlBase.php");

//run the db function from SqlBase i made
dbStart();

$message = "";

if (isset($_POST)) {
    $messageAnswer = $message;

    $sql = "INSERT INTO messages ";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tavis Chat</title>
</head>
<body>
    <div class="header">
        <h1>
            Tavis messaging app
        </h1>
    </div>
    <form action="ChatBase.php" method="POST">
        <input type="text" value=""/>
        <input type="submit" value="Send"/>
    </form>
</body>
</html>