<?php 
include("includes/includedFiles.php");
?>
<!--<script>openPage("browse.php");</script>-->
<div class="pageHeadingBig">
    
<h1>Welcome, <?php echo $userLoggedIn->getUsername(); ?>!</h1>
<p>Discover new music, manage your playlists, and enjoy your favorite tracks.</p>

<div class="quickLinks">
    <button class="button green" onclick="openPage('browse.php')">Browse Music</button>
    <button class="button" onclick="openPage('yourMusic.php')">Your Library</button>
    <button class="button" onclick="createPlaylist()">Create Playlist</button>
</div>
</div>

<div class="featuredSection">
    <h2>Featured Albums</h2>
    <div class="gridViewContainer">
        <?php
        $albumQuery = mysqli_query($con, "SELECT * FROM album ORDER BY RAND() LIMIT 6");
        while ($row = mysqli_fetch_array($albumQuery)) {
            echo "<div class='gridViewItem'>
                    <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['aid'] . "\")'>
                        <img src='" . $row['thumbnail'] . "'>
                        <div class='gridViewInfo'>" . $row['title'] . "</div>
                    </span>
                  </div>";
        }
        ?>
    </div>
</div>

<div class="trendingSection">
    <h2>Trending Songs</h2>
    <ul class="tracklist">
        <?php
        $trendingQuery = mysqli_query($con, "SELECT * FROM music");
        while ($row = mysqli_fetch_array($trendingQuery)) {
            $song = new Song($con, $row['mid']);
            $genre = $song->getGenre(); // Fetch the genre as a string
            echo "<li class='tracklistRow'>
                    <span class='trackName'>" . $song->getTitle() . "</span>
                    <span class='genreName'>" . $genre . "</span> <!-- Display genre -->
                  </li>";
        }
        ?>
    </ul>
</div>