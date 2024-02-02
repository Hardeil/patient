<?php

include '../db_connector/db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $p_id = $_POST["p_id"];
    $p_name = $_POST["p_name"];
    $p_email = $_POST["p_email"];

    // Perform database update
    try {

        $conn = connectDB();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE patient_tbl SET p_name = :pname, p_email = :pemail WHERE p_id = :pid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pid', $p_id);
        $stmt->bindParam(':pname', $p_name);
        $stmt->bindParam(':pemail', $p_email);

        $stmt->execute();

        // Redirect to the page displaying the updated user or any other page
        header("Location: ../patientPage.php?error=success");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}
?>
