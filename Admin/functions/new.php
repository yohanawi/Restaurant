<?php
require_once "db.php";

if (isset($_POST['about'])) {
    $about = $_POST['about'];
    //-- Insert Data Into DB --//
    $sql = "INSERT INTO about (about) 
        VALUES (?)";
    $stmt = $db->prepare($sql);
    try {
        $stmt->execute([$about]);
        header('Location:../about.php?success');
    } catch (Exception $e) {
        $e->getMessage();
        echo "Error";
    }
}
