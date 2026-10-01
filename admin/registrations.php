<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$sql = "
    SELECT
        users.name,
        users.email,
        events.title,
        events.event_date,
        events.venue
    FROM registrations
    JOIN users ON registrations.user_id = users.id
    JOIN events ON registrations.event_id = events.id
    ORDER BY events.event_date ASC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Event Registrations</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        h1 {
            color: #212529;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #212529;
            color: white;
        }

    </style>

</head>

<body>

    <h1>Event Registrations</h1>

    <table>

        <tr>
            <th>Student Name</th>
            <th>Email</th>
            <th>Event</th>
            <th>Date</th>
            <th>Venue</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($row["name"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($row["email"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($row["title"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($row["event_date"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($row["venue"]) ?>
                </td>

            </tr>

        <?php endwhile; ?>

    </table>

</body>

</html>