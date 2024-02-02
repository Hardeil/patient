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

        th,
        td {
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

    <section id="schedule">
        <h2>Schedule
            <button onclick="location.href='addSchedule.php'">Add New Schedule</button>
        </h2>
        <!-- Add schedule content here -->
        <p>This is the schedule section.</p>
    </section>
    <?php
    include 'db_connector/db_connection.php';

    try {
        $conn = connectDB();

        if ($conn) {
            $sql = "SELECT s_id, s_date, s_status FROM schedule_tbl";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<table>
                <tr>
                    <th>Schedule ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>";
            foreach ($result as $row) {
                echo "<tr>
                    <td>{$row['s_id']}</td>
                    <td>{$row['s_date']}</td>
                    <td>{$row['s_status']}</td>
                    <td>
                        <form action='editSchedule.php' method='post'>
                            <input type='hidden' name='edit_schedule_id' value='{$row['s_id']}'>
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