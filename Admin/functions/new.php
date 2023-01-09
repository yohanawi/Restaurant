<?php
    /* DATABASE CONNECTION*/
    $db['db_host'] = 'localhost';
    $db['db_user'] = 'root';
    $db['db_pass'] = '';
    $db['db_name'] = 'restaurants';
 
    foreach ($db as $key => $value) {
        define(strtoupper($key), $value);
    }
    global $conn;
    $conn = mysqli_connect($db['db_host'], $db['db_user'], $db['db_pass'], $db['db_name']);
    if (!$conn) {
        die("Cannot Establish A Secure Connection To The Host Server At The Moment!");
    }
    try {
        $db = new PDO('mysql:dbhost=localhost;dbname=restaurants;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Cannot Establish A Secure Connection To The Host Server At The Moment!');
    }
    /*DATABASE CONNECTION */
if(isset($_POST['add']))
    {
        $category = $_POST['category'];
        //-- Insert Data Into DB --//
        $sql = "INSERT INTO category (category) 
        VALUES (?)";
        $stmt = $db->prepare($sql);
        try {
            $stmt->execute([$category]);
            header('Location:../category.php?success');
        } catch (Exception $e) {
            $e->getMessage();
            echo "Error";
        }
    }

    if(isset($_POST['submit']))
    {
        $role = $_POST['category'];
        //-- Insert Data Into DB --//
        $sql = "INSERT INTO category (category) 
        VALUES (?)";
        $stmt = $db->prepare($sql);
        try {
            $stmt->execute([$role]);
            header('Location:../category.php?success');
        } catch (Exception $e) {
            $e->getMessage();
            echo "Error";
        }
    }

    ?>