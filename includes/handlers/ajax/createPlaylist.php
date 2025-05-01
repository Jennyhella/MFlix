<?php
include("../../config.php");

if (isset($_POST['name']) && isset($_POST['username'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];

    // Fetch the user ID based on the username
    $userQuery = mysqli_query($con, "SELECT id FROM users WHERE username='$username'");
    if (mysqli_num_rows($userQuery) == 0) {
        echo "Error: User not found.";
        exit();
    }

    $userRow = mysqli_fetch_array($userQuery);
    $userId = $userRow['id'];

    // Insert the playlist into the database
    $query = mysqli_query($con, "INSERT INTO playlist (id, name) VALUES('$userId', '$name')");

    if ($query) {
        echo "Playlist created successfully!";
    } else {
        echo "Error: " . mysqli_error($con); // Display detailed error message
    }
} else {
    echo "Name or username parameters not passed into file.";
}
?>