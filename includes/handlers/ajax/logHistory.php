<?php
include("../../config.php");

// Debugging: Log that the script is being executed
error_log("logHistory.php: Script executed");

if (isset($_POST['userId']) && isset($_POST['contentId'])) {
    $userId = $_POST['userId'];
    $newQ=mysqli_query($con,"SELECT id from users where username='$userId'");
    $q2=mysqli_fetch_array($newQ);
    $id=$q2['id'];
    $contentId = $_POST['contentId'];

    // Debugging: Log the received data
    error_log("logHistory.php: Received Id = $id, contentId = $contentId");

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO history (id, cid) VALUES (?, ?)");
    if ($stmt === false) {
        // Debugging: Log if the prepare statement fails
        error_log("logHistory.php: Prepare statement failed - " . $con->error);
        echo "Error preparing statement: " . $con->error;
        exit();
    }

    $stmt->bind_param("ii", $id, $contentId);

    if ($stmt->execute()) {
        // Debugging: Log success
        error_log("logHistory.php: History logged successfully for userId = $userId, contentId = $contentId");
        echo "Success";
    } else {
        // Debugging: Log SQL error
        error_log("logHistory.php: SQL Error - " . $stmt->error);
        echo "Error logging history: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Debugging: Log invalid request
    error_log("logHistory.php: Invalid request. userId or contentId not set.");
    echo "Invalid request.";
}
?>