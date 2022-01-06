<?php
include("dbinfo.php");

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

//check for valid connecton
if (!$conn) die("Connection failed: " . mysqli_connect_error());

//Create a database table
$sql = "CREATE TABLE IF NOT EXISTS messages (
    users_id int(11) NOT NULL AUTO_INCREMENT,
    msg varchar(100) NOT NULL,
    users_name varchar(20) NOT NULL,
    pass_key varchar(20) NOT NULL, 
    PRIMARY KEY (users_id)) CHARSET=utf8mb4";

//run query
mysqli_query($conn, $sql);
