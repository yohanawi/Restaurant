<?php 
    require_once "db.php";
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $sql = "DELETE FROM messages WHERE id=?";
    $stmt = $db->prepare($sql);
        try {
        $stmt->execute([$id]);
        header('Location:../message.php?deleted');
        }
        catch (Exception $e) {
            $e->getMessage();
            echo "Error";
        }
    }
    else {
        header('Location:../message.php?del_error');
    }
?>
