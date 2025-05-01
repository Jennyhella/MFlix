<?php
include("../../config.php");

if (isset($_POST['contentId']) && isset($_POST['playlistId']) && isset($_POST['contentType'])) {
    $contentId = $_POST['contentId'];
    $playlistId = $_POST['playlistId'];
    $contentType = $_POST['contentType'];

    // Check if the content is already in the playlist
    $checkQuery = mysqli_query($con, "SELECT * FROM playlistcontent WHERE pid='$playlistId' AND cid='$contentId'");
    if (mysqli_num_rows($checkQuery) > 0) {
        echo "Content is already in the playlist.";
        exit();
    }

    // Add the content to the playlist
    $query = mysqli_query($con, "INSERT INTO playlistcontent (pid, cid) VALUES ('$playlistId', '$contentId')");

    if ($query) {
        echo ucfirst($contentType) . " added to playlist successfully!";
    } else {
        echo "Failed to add content to playlist.";
    }
} else {
    echo "Content ID, Playlist ID, or Content Type not passed.";
}
?>