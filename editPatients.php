<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #container {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            max-width: 600px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 8px;
        }

        input {
            padding: 10px;
            margin-bottom: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        .button-container {
            text-align: center;
        }

        .update-button {
            background-color: #2196f3;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div id="container">
    <h2 style="text-align: center;">Edit Patient</h2>

    <?php
    include 'db_connector/db_connection.php';

    try {
        $conn = connectDB();

        if ($conn && isset($_POST['edit_patient_id'])) {
            $p_id = $_POST['edit_patient_id'];
            $sql = "SELECT p_id, p_name, p_email FROM patient_tbl WHERE p_id = :pid";  
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pid', $p_id);
            $stmt->execute(); 

            $patientData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($patientData) {
    
    ?>
                <form action="includes/update_patient.php" method="post">   
                    <input type="hidden" name="p_id" value="<?php echo $patientData['p_id']; ?>">
                    <label for="name">Name:</label>
                    <input type="text" name="p_name" id="pname" value="<?php echo $patientData['p_name']; ?>"> 

                    <label for="email">Email:</label>
                    <input type="text" name="p_email" id="pstock" value="<?php echo $patientData['p_email']; ?>"> 

                    <div class="button-container">
                        <button type="submit" class="update-button">Update Patient</button>
                    </div>
                </form>
    <?php
            } else {
                echo "<p>Patient not found.</p>";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        if ($conn) {
            $conn = null;
        }
    }
    ?>
     <div class="button-container">
        <a href="patientPage.php">Back to Patient List</a>
    </div>
</div>

</body>
</html>