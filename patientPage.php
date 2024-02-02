<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Center</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        section {
            padding: 20px;
        }
        table {
            width: 60%;
            border-collapse: collapse;
            margin-top: 20px;
            margin: 0 auto;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        td {
            background-color: #f9f9f9;
        }
        h2 {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        button {
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<?php include_once 'components/header.php' ?>

<section id="patient">
    <h2>Patients
    <button onclick="location.href='addPatients.php'">Add New Patients</button>
    </h2>
    <p>This is the patients section.</p>
</section>
<?php
include 'db_connector/db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $sql = "SELECT p_id, p_name, p_email FROM patient_tbl";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>";
        foreach ($result as $row) {
            echo "<tr>
                    <td>{$row['p_id']}</td>
                    <td>{$row['p_name']}</td>
                    <td>{$row['p_email']}</td>
                    <td>
                        <form action='editPatients.php' method='post'>
                            <input type='hidden' name='edit_patient_id' value='{$row['p_id']}'>
                            <button type='submit' class='edit-button'>Edit</button>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if ($conn) {
        $conn = null;
    }
}
?>
<footer>
    <p>&copy; 2024 Medical Center. All rights reserved.</p>
</footer>

</body>
</html>
