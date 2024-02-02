<?php
include '../db_connector/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $s_date = $_POST['s_date'];
    $s_status = $_POST['s_status'];

    try {
        // Use the function to get a PDO connection
        $conn = connectDB();

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO schedule_tbl (s_date,s_status) VALUES (:s_date, :s_status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':s_date', $s_date);
        $stmt->bindParam(':s_status', $s_status);
        $stmt->execute();

        // Redirect back to the user data page after successful insertion
        header("Location: ../schedulePage.php");
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
