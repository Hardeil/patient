<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Appointment</title>
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
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            appearance: none;
            /* Remove default arrow icon */
            background-image: url('data:image/svg+xml;utf8,<svg fill="%234caf50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            /* Custom arrow icon */
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 20px;
            cursor: pointer;
        }

        button {
            background-color: #4caf50;
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

        a {
            color: #4caf50;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <?php
    include('db_connector/db_connection.php');
    ?>
    <div id="container">
        <div class="button-container">
            <a href="appointmentPage.php">Back to Appointment List</a>
        </div>
        <h2 style="text-align: center;">Add Appointment</h2>

        <form action="includes/insert_appointment.php" method="post">
            <label for="userSelect">User Name:</label>
            <select name="p_id" id="userSelect">
                <?php
                try {
                    $conn = connectDB();
                    $stmt = $conn->query("SELECT * FROM patient_tbl");
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    die("Query failed: " . $e->getMessage());
                }

                foreach ($result as $row) {
                    echo "<option value='{$row['p_id']}'>{$row['p_name']}</option>";
                }
                ?>
            </select>

            <label for="scheduleSelect">Schedule:</label>
            <select name="s_id" id="scheduleSelect">
                <option value="">Select Schedule</option>
                <?php
                try {
                    $conn = connectDB();
                    $stmt = $conn->query("SELECT * FROM schedule_tbl WHERE s_status = 'available'");
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        echo "<option value='{$row['s_id']}'>{$row['s_date']} - {$row['s_status']}</option>";
                    }
                } catch (PDOException $e) {
                    die("Query failed: " . $e->getMessage());
                }
                ?>
            </select>
            <div class="button-container">
                <button type="submit">Add Appointment</button>
            </div>

        </form>


    </div>

</body>

</html>