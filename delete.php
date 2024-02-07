<?php
if (isset($_REQUEST["delete_id"])) {
    $id = $_REQUEST["delete_id"];

    // Validate the ID parameter (to prevent SQL injection)
    if (!is_numeric($id)) {
        die("Invalid ID");
    }

    $select_stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $select_stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        die("Record not found");
    }

    // Delete the record from the db
    $delete_stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $delete_stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $delete_stmt->execute();

    header("Location: tables_users.php");
}
?>
