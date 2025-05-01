
<?php
include("../../config.php");

header('Content-Type: application/json'); // Ensure the response is JSON

if (isset($_GET['songId'])) {
    $songId = $_GET['songId'];

    $query = mysqli_query($con, "SELECT * FROM music WHERE mid='$songId'");
    if (mysqli_num_rows($query) > 0) {
        $song = mysqli_fetch_assoc($query);
        echo json_encode($song);
    } else {
        echo json_encode(["error" => "Song not found"]);
    }
} else {
    echo json_encode(["error" => "No songId provided"]);
}
?>