<?php
session_start();
include 'config.php'; // Include your database connection configuration

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details from database
$query = $conn->prepare("SELECT * FROM user_details WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_picture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Update database with new image path
            $stmt = $conn->prepare("UPDATE user_details SET image_path = ? WHERE user_id = ?");
            $stmt->bind_param("si", $target_file, $user_id);
            $stmt->execute();

            // Update user session data
            $_SESSION['image_path'] = $target_file;
            $user['image_path'] = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .dashboard {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .profile-picture {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .profile-picture img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="profile-picture">
            <img src="<?php echo htmlspecialchars($user['image_path']); ?>" alt="Profile Picture">
        </div>
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
        <p>Email ID: <?php echo htmlspecialchars($user['email_id']); ?></p>
        <p>User ID: <?php echo htmlspecialchars($user['user_id']); ?></p>
        <p>Age: <?php echo htmlspecialchars($user['age']); ?></p>
        <p>Program: <?php echo htmlspecialchars($user['program']); ?></p>
        <p>Address: <?php echo htmlspecialchars($user['address']); ?></p>
        <p>Bio: <?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
        
        <form action="dashboard.php" method="post" enctype="multipart/form-data">
            <label for="profile_picture">Upload Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture">
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>
