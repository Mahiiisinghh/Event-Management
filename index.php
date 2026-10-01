<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>College Event Management System</title>

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
            padding: 18px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
            color: white;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-weight: bold;
        }

        .hero {
            text-align: center;
            padding: 100px 20px;
            background: white;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: #0d6efd;
        }

        .hero p {
            font-size: 20px;
            color: #555;
            max-width: 700px;
            margin: auto;
            line-height: 1.6;
        }

        .buttons {
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 14px 30px;
            margin: 8px;
            border-radius: 7px;
            text-decoration: none;
            color: white;
            background: #0d6efd;
            font-weight: bold;
        }

        .btn-register {
            background: #198754;
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 25px;
            padding: 60px 30px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            width: 280px;
            padding: 30px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .card h2 {
            color: #0d6efd;
        }

        .card p {
            color: #666;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            background: #212529;
            color: white;
            padding: 20px;
        }

        @media (max-width: 600px) {

            .navbar {
                padding: 18px 20px;
                flex-direction: column;
                gap: 15px;
            }

            .hero h1 {
                font-size: 34px;
            }

        }

    </style>

</head>

<body>

    <div class="navbar">

        <h2>🎓 College Event Management</h2>

        <div class="nav-links">

            <a href="index.php">Home</a>

            <a href="login.php">Login</a>

            <a href="register.php">Register</a>

        </div>

    </div>


    <section class="hero">

        <h1>
            College Event Management System
        </h1>

        <p>
            A simple platform to discover college events,
            register for events and manage event activities easily.
        </p>

        <div class="buttons">

            <a href="login.php" class="btn">
                Login
            </a>

            <a href="register.php" class="btn btn-register">
                Register Now
            </a>

        </div>

    </section>


    <section class="features">

        <div class="card">

            <h2>📅 Events</h2>

            <p>
                View upcoming college events with
                date, time and venue details.
            </p>

        </div>


        <div class="card">

            <h2>📝 Registration</h2>

            <p>
                Students can quickly register
                for available college events.
            </p>

        </div>


        <div class="card">

            <h2>👨‍💼 Admin</h2>

            <p>
                Admin can add events, manage events
                and view student registrations.
            </p>

        </div>

    </section>


    <div class="footer">

        © 2026 College Event Management System

    </div>

</body>

</html>