<?php
    $conn = new mysqli('localhost', 'root', '', 'MyFavesDatabase');

    if($conn->connect_error) {
        die('Could not connecto to the database.'.$conn->connect_error);
    }

?>