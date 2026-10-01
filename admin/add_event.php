<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $venue = trim($_POST["venue"]);

    if ($title === "" || $description === "" || $event_date === "" || $event_time === "" || $venue === "") {

        $message = "Please fill all fields.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO events (title, description, event_date, event_time, venue)
             VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssss",
            $title,
            $description,
            $event_date,
            $event_time,
            $venue
        );

        if ($stmt->execute()) {
            $message = "Event added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Event</title>

    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .navbar {
            background: #212529;
            color: white;
            padding: 18px 30px;
        }

        .container {
            width: 500px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 18px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        button {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .message {
            background: #d1e7dd;
            padding: 10px;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

    <div class="navbar">
        <h2>College Event Management - Add Event</h2>
    </div>

    <div class="container">

        <h1>Add New Event</h1>

        <?php if ($message !== ""): ?>

            <div class="message">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <label>Event Name</label>

            <input
                type="text"
                name="title"
                placeholder="Enter event name"
                required
            >

            <label>Description</label>

            <textarea
                name="description"
                placeholder="Enter event description"
                required
            ></textarea>

            <label>Event Date</label>

            <input
                type="date"
                name="event_date"
                required
            >

            <label>Event Time</label>

            <input
                type="time"
                name="event_time"
                required
            >

            <label>Venue</label>

            <input
                type="text"
                name="venue"
                placeholder="Enter venue"
                required
            >

            <button type="submit">
                Add Event
            </button>

        </form>

    </div>

</body>

</html>