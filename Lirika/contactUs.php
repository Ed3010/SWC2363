<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "lirikalogin";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Insert the data without checking for duplicates
    $sql = "INSERT INTO reports (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Display a JavaScript alert
        echo '<script>alert("Report submitted successfully!");</script>';
        // Redirect back to the same page after the alert is closed
        echo '<script>window.location.href = "contactus.php";</script>';
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-position: center;
        }

        .container {
            background-color: lightgrey;
            padding: 20px;
            width: 80%;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        h2 {
            margin: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* Align form items to the left */
        }

        label {
            margin: 10px 0;
            text-align: left;
            /* Align label text to the left */
            width: 100%;
        }

        input[type="text"],
        input[type="email"],
        input[type="submit"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        header ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logout-button {
            display: inline-block;
            padding: 8px 12px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            margin-right: auto;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #111;
        }
    </style>
</head>

<body>
    <header>
        <ul>
            <li><a href="userMenu.html"><img src="images/Lirika.png" width="120" height="50"></a></li>
            <li class="logout-container">
                <a href="index.html" class="logout-button">Logout</a>
            </li>
        </ul>
    </header>

    <div class="container">
        <h2>Contact Us</h2>
        <p>Please fill in the form below to submit a report.</p>

        <form action="contactus.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject"
                placeholder="Request lyrics, request to remove lyrics, etc..." required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" placeholder="Enter details" required></textarea>

            <input type="submit" value="Submit Report">
        </form>
    </div>
</body>

</html>