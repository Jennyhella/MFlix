<?php
include("includes/includedFiles.php");

$userId = $userLoggedIn->getId(); // Get the logged-in user's ID

// Fetch the user's song playback history
$songHistoryQuery = mysqli_query($con, "
    SELECT history.played_at, music.title AS songTitle, artist.name AS artistName
    FROM history
    JOIN music ON history.cid = music.cid
    JOIN artist ON music.ar_id = artist.aid
    WHERE history.id = '$userId' AND history.cid IN (SELECT cid FROM content WHERE type = 'music')
    ORDER BY history.played_at DESC
");

// Debugging: Check if the query executed successfully
if (!$songHistoryQuery) {
    echo "Error executing song history query: " . mysqli_error($con);
    exit();
}

// Fetch the user's movie playback history
$movieHistoryQuery = mysqli_query($con, "
    SELECT history.played_at, movie.title AS movieTitle, movie.genre AS movieGenre
    FROM history
    JOIN movie ON history.cid = movie.cid
    WHERE history.id = '$userId' AND history.cid IN (SELECT cid FROM content WHERE type = 'movie')
    ORDER BY history.played_at DESC
");

// Debugging: Check if the query executed successfully
if (!$movieHistoryQuery) {
    echo "Error executing movie history query: " . mysqli_error($con);
    exit();
}
?>

<div class="historyContainer">
    <h2>Your Playback History</h2>

    <!-- Song Playback History -->
    <h3>Song Playback History</h3>
    <table class="historyTable">
        <thead>
            <tr>
                <th>Played At</th>
                <th>Song Title</th>
                <th>Artist</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($songHistoryQuery)) {
                $playedAt = date("F j, Y, g:i a", strtotime($row['played_at'])); // Format the date
                $songTitle = $row['songTitle'];
                $artistName = $row['artistName'];
                echo "
                    <tr>
                        <td>$playedAt</td>
                        <td>$songTitle</td>
                        <td>$artistName</td>
                    </tr>
                ";
            }
            ?>
        </tbody>
    </table>

    <!-- Movie Playback History -->
    <h3>Movie Playback History</h3>
    <table class="historyTable">
        <thead>
            <tr>
                <th>Played At</th>
                <th>Movie Title</th>
                <th>Genre</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($movieHistoryQuery)) {
                $playedAt = date("F j, Y, g:i a", strtotime($row['played_at'])); // Format the date
                $movieTitle = $row['movieTitle'];
                $movieGenre = $row['movieGenre'];
                echo "
                    <tr>
                        <td>$playedAt</td>
                        <td>$movieTitle</td>
                        <td>$movieGenre</td>
                    </tr>
                ";
            }
            ?>
        </tbody>
    </table>
</div>

<style>
.historyContainer {
    margin: 20px;
    padding: 20px;
    background-color:rgb(120, 119, 119);
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(40, 39, 39, 0.1);
}

.historyTable {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.historyTable th, .historyTable td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.historyTable th {
    background-color:rgb(94, 94, 94);
    font-weight: bold;
}

.historyTable tr:hover {
    background-color:rgb(88, 87, 87);
}
</style>