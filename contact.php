<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Me</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .contact-container {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }
        .contact-form, .contact-details {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .contact-form h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .contact-form label {
            display: block;
            margin-bottom: 5px;
        }
        .contact-form input, 
        .contact-form textarea,
        .contact-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .contact-form button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
        }
        .contact-form button:hover {
            background: #0056b3;
        }
        .contact-details {
            font-size: 16px;
        }
        .contact-details h2 {
            margin-top: 0;
        }
        .contact-details p {
            margin: 10px 0;
        }
    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $option = $_POST['option'];
    $message = $_POST['message'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO contacts (first_name, last_name, email, phone, option_selected, message)
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$option', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }

    $conn->close();
}
?>

    <div class="contact-container">
        <form class="contact-form" action="" method="post">
            <h1>Let’s work together!</h1>
            <p>I design and code beautifully simple things and I love what I do. Just simple like that!</p>

            <label for="first-name">First name</label>
            <input type="text" id="first-name" name="first-name" required>

            <label for="last-name">Last name</label>
            <input type="text" id="last-name" name="last-name" required>

            <label for="email">Email address</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone number</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="option">Please choose an option</label>
            <select id="option" name="option" required>
                <option value="web-design">Web Design</option>
                <option value="ui-ux">UI/UX</option>
                <option value="cloud-hosting">Cloud Hosting</option>
            </select>

            <label for="message">Message</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit">Submit</button>
        </form>

        <div class="contact-details">
            <h2>Contact Information</h2>
            <p><strong>Phone:</strong> +01 123 654 8096</p>
            <p><strong>Email:</strong> gerolddesign@mail.com</p>
            <p><strong>Address:</strong> Warne Park Street Pine, FL 33157, New York</p>
        </div>
    </div>

</body>
</html>
