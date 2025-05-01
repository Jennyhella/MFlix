<?php 
include("includes/includedFiles.php");
include("includes/footer.php");

// Check if the album ID is passed in the URL
if(isset($_GET['id'])) {
    $albumId = $_GET['id'];
} else {
    header("Location: index.php");
    exit();
}

// Create an Album object
$album = new Album($con, $albumId);

// Fetch album details
$artist = $album->getArtist();
$songIdArray = $album->getSongIds(); // Get this early for JavaScript
?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>">
    </div>

    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p>By <?php echo $artist; ?></p>
        <p><?php echo $album->getNumberOfSongs(); ?> songs</p>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
        $i = 1;
        foreach($songIdArray as $songId) {
            $albumSong = new Song($con, $songId);
            $albumArtist = $albumSong->getArtist();

            echo "<li class='tracklistRow'>
                    <div class='trackCount'>
                        <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                        <span class='trackNumber'>$i</span>
                    </div>

                    <div class='trackInfo'>
                        <span class='trackName'>" . $albumSong->getTitle() . "</span>
                        <span class='artistName'>" . $albumArtist->getName() . "</span>
                    </div>

                    <div class='trackOptions'>
                        <input type='hidden' class='songId' value='". $albumSong->getId() . "'>
                        <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                    </div>
                        <div class='trackPlay'>
                        <button class='playButton' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                            <img src='assets/images/icons/play-white.png' alt='Play'>
                        </button>
                    </div>
                </li>";
            $i++;
        }
        ?>
    </ul>
</div>

<script>
    var audioElement = new Audio(); // Create an instance of the custom Audio class
    console.log("audioElement initialized:", audioElement);

    // Use the correct PHP variable here
    var tempPlaylist = <?php echo json_encode($songIdArray); ?>.map(Number);
    var currentPlaylist = [];
    var currentIndex = 0;
    var isPlaying = false;

    function playSong() {
        if(audioElement.audio) {
            audioElement.play();
            isPlaying = true;
            $(".controlButton.play").hide();
            $(".controlButton.pause").show();
        }
    }

    function setTrack(songId, playlist, play) {
        console.log("setTrack called with:", {songId, playlist, play});

        if (!songId) {
            console.error("Error: songId is empty or undefined");
            return;
        }

        currentPlaylist = playlist;
        currentIndex = currentPlaylist.indexOf(parseInt(songId));
        
        if (currentIndex === -1) {
            console.error("Error: songId not found in currentPlaylist");
            return;
        }

        $.get("includes/handlers/ajax/getAlbumJson.php", { songId: songId })
            .done(function(song) {
                console.log("Song details fetched:", song);
                
                if (typeof song === "string") {
                    try {
                        song = JSON.parse(song);
                    } catch (error) {
                        console.error("Error parsing song JSON:", error);
                        return;
                    }
                }

                if (!song.file_path) {
                    console.error("Error: file_path is undefined");
                    return;
                }

                const fixedFilePath = song.file_path.replace(/\\/g, "/");
                console.log("Setting track to:", fixedFilePath);
                
                audioElement.setTrack({ path: fixedFilePath });
                
                if (play) {
                    playSong();
                }
            })
            .fail(function() {
                console.error("Error fetching song details");
            });
    }
   
    function pauseSong() {
        if (isPlaying) {
            audioElement.pause();
            isPlaying = false;
            $(".controlButton.play").show();
            $(".controlButton.pause").hide();
        }
    }
</script>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>