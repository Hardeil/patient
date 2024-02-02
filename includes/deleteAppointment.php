<?php
include '../db_connector/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $a_id = $_POST["a_id"];

    // Perform database update
    try {

        $conn = connectDB();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM appointment_tbl WHERE a_id = :a_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':a_id', $a_id);

        $stmt->execute();

        $ssql = "UPDATE schedule_tbl SET s_status = 'available' WHERE s_id = :schedule";
        $sttmt = $conn->prepare($ssql);
        $sttmt->bindParam(':schedule', $schedule);
        $sttmt->execute();

        // Redirect to the page displaying the updated user or any other page
        header("Location: ../appointmentPage.php?error=success");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

?>