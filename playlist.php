<?php 
include("includes/includedFiles.php");
include_once("includes/classes/Song.php");
include("includes/footer.php");

// Check if the playlist ID is passed in the URL
if (isset($_GET['id'])) {
    $playlistId = $_GET['id'];
} else {
    header("Location: index.php");
    exit();
}

// Fetch playlist details
$playlistQuery = mysqli_query($con, "SELECT * FROM playlist WHERE pid='$playlistId'");
if (mysqli_num_rows($playlistQuery) == 0) {
    echo "Playlist not found.";
    exit();
}

$playlist = mysqli_fetch_array($playlistQuery);
$playlistName = $playlist['name'];
$playlistOwnerId = $playlist['id'];

// Fetch user details
$userQuery = mysqli_query($con, "SELECT username FROM users WHERE id='$playlistOwnerId'");
$user = mysqli_fetch_array($userQuery);
$username = $user['username'];
?>
<link rel="stylesheet" type="text/css" href="assets/css/style.css">

<div class="entityInfo">
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/playlist-img/playlist.jpg" alt="Playlist">
        </div>
    </div>

    <div class="rightSection">
        <h2><?php echo $playlistName; ?></h2>
        <p>By <?php echo $username; ?></p>
        <p>
            <?php 
            $contentCountQuery = mysqli_query($con, "SELECT COUNT(*) as contentCount FROM playlistcontent WHERE pid='$playlistId'");
            $contentCount = mysqli_fetch_array($contentCountQuery)['contentCount'];
            echo $contentCount; 
            ?> items
        </p>
        <button class="button" onclick="deletePlaylist('<?php echo $playlistId; ?>')">DELETE PLAYLIST</button>
        <button class="button" onclick="openAddContentModal('<?php echo $playlistId; ?>')">ADD CONTENT</button>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
        $contentQuery = mysqli_query($con, "SELECT cid FROM playlistcontent WHERE pid='$playlistId'");
        $i = 1;

        $songIds = []; // Array to store song IDs for JavaScript

        while ($row = mysqli_fetch_array($contentQuery)) {
            $contentId = $row['cid'];

            // Check if the content is music
            $musicQuery = mysqli_query($con, "SELECT * FROM music WHERE cid='$contentId'");
            if (mysqli_num_rows($musicQuery) > 0) {
                $music = mysqli_fetch_array($musicQuery);
                $songId = $music['mid'];
                $songTitle = basename($music['file_path']); // Extract only the file name
                $artistId = $music['ar_id'];

                // Add song ID to the array
                $songIds[] = $songId;

                // Fetch artist details
                $artistQuery = mysqli_query($con, "SELECT name FROM artist WHERE aid='$artistId'");
                $artist = mysqli_fetch_array($artistQuery);
                $artistName = $artist['name'];

                // Display the song with a Play Button
                ?><li class='tracklistRow'>
                        <div class='trackCount'>
                            <span class='trackNumber'><?php echo $i; ?> </span>
                        </div>

                        <div class='trackInfo'>
                            <span class='trackName'><?php echo $songTitle; ?></span>
                            <span class='artistName'><?php echo $artistName; ?></span>
                        </div>

                        <div class='trackOptions'>
                            <input type='hidden' class='songId' value='$songId'>
                            <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                        </div>

                        <div class='trackDuration'>
                            <button class='playButton smallPlayButton' onclick='setTrack(<?php echo $songId; ?>, tempPlaylist, true)'>
                                <img src='assets/images/icons/play-white.png' alt='Play'>Play
                            </button> <!-- Placeholder duration -->
                        </div>
                    </li>
        <?php    }
            $i++;
        }
        ?>
    </ul>
</div>

<!-- Add Content Modal -->
<div id="addContentModal" class="modal" style="display: none;">
    <div class="modalContent">
        <span class="closeButton" onclick="closeAddContentModal()">&times;</span>
        <h2>Add Content to Playlist</h2>
        <form id="addContentForm">
            <h4>Select Song:
            <select id="song" name="song">
                <?php
                // Fetch all songs from the database
                $songsQuery = mysqli_query($con, "SELECT * FROM music");
                while ($song = mysqli_fetch_array($songsQuery)) {
                    $songId = $song['mid'];
                    $songTitle = basename($song['file_path']); // Extract only the file name
                    echo "<option value='$songId'>$songTitle</option>";
                }
                ?>
            </select></h4>
            <button type="button" onclick="addToPlaylist('<?php echo $playlistId; ?>')">Add</button>
        </form>
    </div>
</div>

<script>
    var audioElement = new Audio(); // Create an instance of the custom Audio class
    console.log("audioElement initialized:", audioElement); // Debugging

    var tempPlaylist = <?php echo json_encode($songIds); ?>.map(Number);  // Pass the playlist to JavaScript
    var currentPlaylist = [];
    var currentIndex = 0;
    var isPlaying = false; // State variable to track playback


    function setTrack(songId, playlist, play) {
    console.log("setTrack called with songId:", songId); // Debugging

    if (!songId) {
        console.error("Error: songId is empty or undefined");
        return;
    }

    currentPlaylist = playlist; // Set the current playlist
    console.log("currentPlaylist:", currentPlaylist); // Debugging

    currentIndex = currentPlaylist.indexOf(parseInt(songId)); 
    console.log("currentIndex:", currentIndex); // Debugging

    if (currentIndex === -1) {
        console.error("Error: songId not found in currentPlaylist");
        return;
    }

    // Fetch the song details using the song ID
    $.get("includes/handlers/ajax/getSongJson.php", { songId: songId })
        .done(function(song) {
            console.log("Song details fetched:", song); // Debugging
            console.log("Type of song:", typeof song); // Debugging

            // Check if song is a string and parse it if necessary
            if (typeof song === "string") {
                try {
                    song = JSON.parse(song); // Parse the string into an object
                    console.log("Parsed song object:", song); // Debugging
                } catch (error) {
                    console.error("Error parsing song JSON:", error);
                    return;
                }
            }

            if (!song.file_path) {
                console.error("Error: file_path is undefined in the fetched song details");
                return;
            }

            // Fix the file path by replacing backslashes with forward slashes
            const fixedFilePath = song.file_path.replace(/\\/g, "/");
            console.log(`Fixed file path: ${fixedFilePath}`); // Debugging

            audioElement.setTrack({ path: fixedFilePath }); // Set the track using the custom Audio class
            console.log(`Audio source set to: ${fixedFilePath}`); // Debugging

            if (play) {
                console.log("Calling playSong() from setTrack");
                playSong(); // Start playback
            }
        })
        .fail(function() {
            console.error("Error fetching song details");
        });
}
   
    function pauseSong() {
        if (isPlaying) {
            audioElement.pause(); // Call the pause method of the custom Audio class
            isPlaying = false; // Update state
            $(".controlButton.play").show();
            $(".controlButton.pause").hide();
        }
    }

    function openAddContentModal(playlistId) {
        document.getElementById("addContentModal").style.display = "block";
    }

    function closeAddContentModal() {
        document.getElementById("addContentModal").style.display = "none";
    }

    function addToPlaylist(playlistId) {
        const songId = document.getElementById("song").value;

        if (!songId) {
            alert("Please select a song to add.");
            return;
        }

        $.post("includes/handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId })
            .done(function (response) {
                if (response === "success") {
                    alert("Song added to playlist successfully!");
                    closeAddContentModal();
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert("Error adding song to playlist: " + response);
                }
            })
            .fail(function () {
                alert("An error occurred while adding the song to the playlist.");
            });
    }
</script>