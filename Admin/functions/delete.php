<?php
    require_once "db.php";
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $sql = "DELETE FROM category WHERE id=?";
        $stmt = $db->prepare($sql);
        try {
            $stmt->execute([$id]);
            header('Location:../category.php?deleted');
        } catch (Exception $e) {
            $e->getMessage();
            echo "Error";
        }
    } else {
        header('Location:../category.php?del_error');
    }
?>