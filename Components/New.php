<?php

/* DATABASE CONNECTION*/
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'restaurants';

global $connection;
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
    die("Cannot Establish A Secure Connection To The Host Server At The Moment!");
}
try {
    $db = new PDO('mysql:dbhost=localhost;dbname=restaurants;charset=utf8', 'root', '');
} catch (Exception $e) {

    die('Cannot Establish A Secure Connection To The Host Server At The Moment!');
}
/*DATABASE CONNECTION */
if(isset($_POST['sub']))
{
    $subscribe = $_POST['subscribe'];
    //-- Insert Data Into DB --//
    $sql = "INSERT INTO subscribe (subscribe) 
    VALUES (?)";
    $stmt = $db->prepare($sql);
    try {
        $stmt->execute([$subscribe]);
        header('Location:../index.php?success');
    } catch (Exception $e) {
        $e->getMessage();
        echo "Error";
    }
}

?>