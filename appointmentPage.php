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

        .action-buttons button {
            padding: 8px 12px;
            /* Adjusted padding for smaller buttons */
            margin-right: 5px;
            /* Added margin between buttons */
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
            /* Added smooth transition on hover */
        }

        button {
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .action-buttons button:hover {
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

    <section id="appointment">
        <h2>
            Appointments
            <button onclick="location.href='addAppointment.php'">Add New Appointments</button>
        </h2>
        <p>This is the appointments section.</p>
    </section>
    <?php
    include 'db_connector/db_connection.php';

    try {
        $conn = connectDB();

        if ($conn) {
            $sql = "SELECT 
            a.a_id, 
            p.p_id, 
            p.p_name,
            s.s_id, 
            s.s_date,
            s.s_status
            FROM appointment_tbl a 
            INNER JOIN patient_tbl p ON a.p_id = p.p_id
            INNER JOIN schedule_tbl s ON a.s_id = s.s_id ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<table>
                <tr>
                    <th>Appointment ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>";
            foreach ($result as $row) {
                echo "<tr>
                    <td>{$row['a_id']}</td>
                    <td>{$row['p_name']}</td>
                    <td>{$row['s_date']}</td>
                    <td>{$row['s_status']}</td>
                    <td class='action-buttons'>
                    <form action='edit_product.php' method='post' style='display: inline; margin-right: 5px;'>
                        <input type='hidden' name='edit_product_id' value='{$row['a_id']}'>
                        <button type='submit'>Edit</button>
                    </form>
                    <form action='includes/deleteAppointment.php' method='post' style='display: inline;'>
                        <input type='hidden' name='a_id' value='{$row['a_id']}'>
                        <button type='submit'>Delete</button>
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