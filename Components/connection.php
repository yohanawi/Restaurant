<?php
/* DATABASE CONNECTION*/
$db_name = 'mysql:host=localhost;dbname=restaurants';
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password);
    /*DATABASE CONNECTION */
?>