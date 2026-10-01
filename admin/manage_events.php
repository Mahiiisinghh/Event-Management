<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$message = "";

// Delete event
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {

    $event_id = (int) $_POST["delete_id"];

    // First delete registrations for this event
    $delete_registrations = $conn->prepare(
        "DELETE FROM registrations WHERE event_id = ?"
    );

    $delete_registrations->bind_param("i", $event_id);
    $delete_registrations->execute();
    $delete_registrations->close();

    // Then delete the event
    $delete_event = $conn->prepare(
        "DELETE FROM events WHERE id = ?"
    );

    $delete_event->bind_param("i", $event_id);

    if ($delete_event->execute()) {
        $message = "Event deleted successfully.";
    } else {
        $message = "Unable to delete event.";
    }

    $delete_event->close();
}

// Get events
$result = $conn->query(
    "SELECT id, title, description, event_date, event_time, venue
     FROM events
     ORDER BY event_date ASC, event_time ASC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Events</title>

    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .event-card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .event-card h2 {
            color: #0d6efd;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 5px;
            cursor: pointer;
        }

        .message {
            background: #d1e7dd;
            color: #0f5132;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .back-btn {
            display: inline-block;
            background: #212529;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

    </style>

</head>

<body>

<div class="container">

    <a href="dashboard.php" class="back-btn">
        ← Back to Dashboard
    </a>

    <h1>Manage Events</h1>

    <?php if ($message !== ""): ?>

        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>


    <?php if ($result && $result->num_rows > 0): ?>

        <?php while ($event = $result->fetch_assoc()): ?>

            <div class="event-card">

                <h2>
                    <?= htmlspecialchars($event["title"]) ?>
                </h2>

                <p>
                    <?= htmlspecialchars($event["description"]) ?>
                </p>

                <p>
                    <strong>Date:</strong>
                    <?= htmlspecialchars($event["event_date"]) ?>
                </p>

                <p>
                    <strong>Time:</strong>
                    <?= htmlspecialchars($event["event_time"]) ?>
                </p>

                <p>
                    <strong>Venue:</strong>
                    <?= htmlspecialchars($event["venue"]) ?>
                </p>

                <form method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this event?');">

                    <input
                        type="hidden"
                        name="delete_id"
                        value="<?= (int) $event["id"] ?>"
                    >

                    <button
                        type="submit"
                        class="delete-btn">
                        Delete Event
                    </button>

                </form>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <div class="event-card">
            <p>No events available.</p>
        </div>

    <?php endif; ?>

</div>

</body>

</html>