<?php
include '../db_connector/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $s_id = $_POST["s_id"];
    $s_date = $_POST["s_date"];
    $s_status = $_POST["s_status"];

    // Perform database update
    try {

        $conn = connectDB();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE schedule_tbl SET s_date = :sdate, s_status = :sstatus WHERE s_id = :sid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sid', $s_id);
        $stmt->bindParam(':sdate', $s_date);
        $stmt->bindParam(':sstatus', $s_status);

        $stmt->execute();

        // Redirect to the page displaying the updated user or any other page
        header("Location: ../schedulePage.php?error=success");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

?>