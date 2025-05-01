<?php
// filepath: c:\wamp64\www\RefProj\includes\handlers\ajax\addToPlaylist.php
include("../../config.php");

if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];

    // Debugging: Log the received values
    error_log("Playlist ID: $playlistId, Song ID: $songId");

    // Fetch the content ID (cid) corresponding to the song ID (mid)
    $contentQuery = mysqli_query($con, "SELECT cid FROM content WHERE mid = $songId");
    if (mysqli_num_rows($contentQuery) == 0) {
        echo "Invalid Song ID.";
        exit();
    }

    $contentRow = mysqli_fetch_array($contentQuery);
    $cid = $contentRow['cid'];

    // Check if the song is already in the playlist
    $checkQuery = mysqli_query($con, "SELECT * FROM playlistcontent WHERE pid = $playlistId AND cid = $cid");
    if (mysqli_num_rows($checkQuery) > 0) {
        echo "Song is already in the playlist.";
        exit();
    }

    // Add the song to the playlist
    $insertQuery = mysqli_query($con, "INSERT INTO playlistcontent (pid, cid) VALUES ($playlistId, $cid)");
    if ($insertQuery) {
        echo "success";
    } else {
        echo "Failed to add song to playlist.";
    }
} else {
    echo "Playlist ID or Song ID not provided.";
}
?>