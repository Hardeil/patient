<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
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
        <h2 style="text-align: center;">Edit Schedule</h2>

        <?php
        include 'db_connector/db_connection.php';

        try {
            $conn = connectDB();

            if ($conn && isset($_POST['edit_schedule_id'])) {
                $s_id = $_POST['edit_schedule_id'];
                $sql = "SELECT s_id, s_date, s_status FROM schedule_tbl WHERE s_id = :sid";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':sid', $s_id);
                $stmt->execute();

                $scheduleData = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($scheduleData) {

                    ?>
                    <form action="includes/update_schedule.php" method="post">
                        <input type="hidden" name="s_id" value="<?php echo $scheduleData['s_id']; ?>">
                        <label for="name">Date:</label>
                        <input type="date" name="s_date" id="pname" value="<?php echo $scheduleData['s_date']; ?>">

                        <label for="email">Status:</label>
                        <!-- <input type="text" name="s_status" id="pstock" value="<?php echo $scheduleData['s_status']; ?>"> -->
                        <select name="s_status" id="s_status" value="<?php echo $scheduleData['s_status']; ?>" required>
                            <option value="available">available</option>
                            <option value="not available">not available</option>
                        </select>

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
            <a href="schedulePage.php">Back to Schedule List</a>
        </div>
    </div>

</body>

</html>