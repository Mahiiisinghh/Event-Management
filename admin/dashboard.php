```php
<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

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
            background: #212529;
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
            padding: 45px 20px;
        }

        .welcome {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .welcome h1 {
            margin-top: 0;
            color: #212529;
        }

        .welcome p {
            color: #666;
        }

        .panel {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            flex: 1;
            min-width: 250px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .card h2 {
            margin-top: 0;
        }

        .card p {
            color: #666;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 10px;
            margin-right: 5px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .add-btn {
            background: #0d6efd;
        }

        .registration-btn {
            background: #198754;
        }

        .manage-btn {
            background: #6f42c1;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            color: #777;
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

        <a href="../logout.php" class="logout">
            Logout
        </a>

    </div>


    <div class="container">

        <div class="welcome">

            <h1>
                Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>! 👋
            </h1>

            <p>
                Manage college events and student registrations from here.
            </p>

        </div>


        <div class="panel">

            <div class="card">

                <h2>➕ Add Event</h2>

                <p>
                    Create a new college event by adding its
                    title, date, time and venue.
                </p>

                <a href="add_event.php" class="btn add-btn">
                    Add Event
                </a>

            </div>


            <div class="card">

                <h2>👥 Registrations</h2>

                <p>
                    View students who have registered
                    for college events.
                </p>

                <a href="registrations.php" class="btn registration-btn">
                    View Registrations
                </a>

            </div>


            <div class="card">

                <h2>📋 Manage Events</h2>

                <p>
                    View existing events and delete
                    events when required.
                </p>

                <a href="manage_events.php" class="btn manage-btn">
                    Manage Events
                </a>

            </div>

        </div>


        <div class="footer">

            © 2026 College Event Management System

        </div>

    </div>

</body>

</html>
```
