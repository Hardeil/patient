<?php
include '../db_connector/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient = $_POST['p_id'];
    $schedule = $_POST['s_id'];
    try {
        // Use the function to get a PDO connection
        $conn = connectDB();

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL statement to insert into the appointment_tbl
        $sql = "INSERT INTO appointment_tbl (p_id, s_id) VALUES (:patient, :schedule)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':patient', $patient);
        $stmt->bindParam(':schedule', $schedule);
        $stmt->execute();

        // Prepare and execute the SQL statement to update the schedule_tbl
        $ssql = "UPDATE schedule_tbl SET s_status = 'not available' WHERE s_id = :schedule";
        $sttmt = $conn->prepare($ssql);
        $sttmt->bindParam(':schedule', $schedule);
        $sttmt->execute();

        // Redirect back to the appointment page after successful insertion
        header("Location: ../appointmentPage.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Always close the connection
        if ($conn) {
            $conn = null;
        }
    }
}
?>