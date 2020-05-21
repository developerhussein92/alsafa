<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "alsafa";

    $conn = new mysqli($host, $user, $pass,$dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    //echo "Connected successfully";
    if (!mysqli_set_charset($conn, "utf8")) {
        
        exit();
    }


?>