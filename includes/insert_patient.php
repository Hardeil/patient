<?php
include '../db_connector/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = $_POST['p_name'];
    $p_email = $_POST['p_email'];

    try {
        // Use the function to get a PDO connection
        $conn = connectDB();

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO patient_tbl (p_name,p_email) VALUES (:p_name, :p_email)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':p_name', $p_name);
        $stmt->bindParam(':p_email', $p_email);
        $stmt->execute();

        // Redirect back to the user data page after successful insertion
        header("Location: ../patientPage.php");
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
