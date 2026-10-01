<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["event_id"])) {

    $event_id = (int) $_POST["event_id"];

    $check = $conn->prepare(
        "SELECT id FROM registrations
         WHERE user_id = ? AND event_id = ?"
    );

    $check->bind_param("ii", $user_id, $event_id);
    $check->execute();

    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {

        $message = "You are already registered for this event.";
        $message_type = "warning";

    } else {

        $insert = $conn->prepare(
            "INSERT INTO registrations (user_id, event_id)
             VALUES (?, ?)"
        );

        $insert->bind_param("ii", $user_id, $event_id);

        if ($insert->execute()) {
            $message = "Registration successful!";
            $message_type = "success";
        } else {
            $message = "Registration failed.";
            $message_type = "error";
        }

        $insert->close();
    }

    $check->close();
}

$result = $conn->query(
    "SELECT
        e.id,
        e.title,
        e.description,
        e.event_date,
        e.event_time,
        e.venue,
        r.id AS registration_id
     FROM events e
     LEFT JOIN registrations r
        ON e.id = r.event_id
        AND r.user_id = $user_id
     ORDER BY e.event_date ASC, e.event_time ASC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #212529;
        }

        .navbar {
            background: #0d6efd;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
            color: white;
        }

        .logout {
            background: #dc3545;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 40px 20px;
        }

        .welcome {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 35px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .welcome h1 {
            margin-top: 0;
            color: #0d6efd;
        }

        .events-title {
            margin-bottom: 20px;
        }

        .event-card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .event-card h2 {
            color: #0d6efd;
            margin-top: 0;
        }

        .event-info {
            margin: 10px 0;
            color: #555;
        }

        .register-btn {
            margin-top: 15px;
            background: #198754;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .registered-btn {
            margin-top: 15px;
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 6px;
            font-weight: bold;
        }

        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .success {
            background: #d1e7dd;
            color: #0f5132;
        }

        .warning {
            background: #fff3cd;
            color: #664d03;
        }

        .error {
            background: #f8d7da;
            color: #842029;
        }

        .no-events {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        @media (max-width: 600px) {

            .navbar {
                padding: 18px 20px;
            }

            .navbar h2 {
                font-size: 18px;
            }

            .container {
                padding: 25px 15px;
            }

        }

    </style>

</head>

<body>

    <div class="navbar">

        <h2>🎓 College Event Management</h2>

        <a class="logout" href="../logout.php">
            Logout
        </a>

    </div>


    <div class="container">

        <div class="welcome">

            <h1>
                Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>! 👋
            </h1>

            <p>
                Explore upcoming college events and register for the ones you like.
            </p>

        </div>


        <?php if ($message !== ""): ?>

            <div class="message <?= htmlspecialchars($message_type) ?>">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>


        <h2 class="events-title">
            📅 Upcoming Events
        </h2>


        <?php if ($result && $result->num_rows > 0): ?>

            <?php while ($event = $result->fetch_assoc()): ?>

                <div class="event-card">

                    <h2>
                        <?= htmlspecialchars($event["title"]) ?>
                    </h2>

                    <p>
                        <?= htmlspecialchars($event["description"]) ?>
                    </p>

                    <p class="event-info">
                        📅 <strong>Date:</strong>
                        <?= htmlspecialchars($event["event_date"]) ?>
                    </p>

                    <p class="event-info">
                        ⏰ <strong>Time:</strong>
                        <?= htmlspecialchars($event["event_time"]) ?>
                    </p>

                    <p class="event-info">
                        📍 <strong>Venue:</strong>
                        <?= htmlspecialchars($event["venue"]) ?>
                    </p>


                    <?php if ($event["registration_id"]): ?>

                        <button class="registered-btn" disabled>
                            ✓ Already Registered
                        </button>

                    <?php else: ?>

                        <form method="POST">

                            <input
                                type="hidden"
                                name="event_id"
                                value="<?= (int) $event["id"] ?>"
                            >

                            <button
                                type="submit"
                                class="register-btn">
                                Register for Event
                            </button>

                        </form>

                    <?php endif; ?>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="no-events">
                <p>No events available right now.</p>
            </div>

        <?php endif; ?>

    </div>

</body>

</html>