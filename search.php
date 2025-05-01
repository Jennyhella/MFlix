<?php
include("includes/includedFiles.php");

if(isset($_GET['term'])) {
    $term = urldecode($_GET['term']);
} else {
    $term = "";
}
?>

<div class="searchContainer">
    <input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="What would you like to watch/listen?" onfocus="this.value = this.value">
</div>

<script>
$(".searchInput").focus();

$(function() {
    $(".searchInput").keyup(function() {
        clearTimeout(timer);

        timer = setTimeout(function() {
            var val = $(".searchInput").val();
            openPage("search.php?term=" + val);
        }, 2000);
    });
});
</script>

<?php if($term == "") { ?>

<h1 class="noResults">Search for music, movies & more...</h1>

<?php
} else {
?>

<div class="tracklistContainer borderBottom">
    <h2>SONGS</h2>
    <ul class="tracklist">
        <?php
        $songsQuery = mysqli_query($con, "SELECT mid FROM music WHERE title LIKE '$term%' LIMIT 10");

        if(mysqli_num_rows($songsQuery) == 0) {
            echo "<span class='noResults'>No songs found matching " . $term . "</span>";
        }

        $songIdArray = array();
        $i = 1;

        while($row = mysqli_fetch_array($songsQuery)) {
            if($i > 15) {
                break;
            }

            array_push($songIdArray, $row['mid']);
            $albumSong = new Song($con, $row['mid']);
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
                </li>";

            $i++;
        }
        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';		
            tempPlaylist = JSON.parse(tempSongIds);
            console.log(tempPlaylist);
        </script>
    </ul>
</div>

<div class="gridViewContainer">
    <h2>MOVIES</h2>
    <?php
        $movieQuery = mysqli_query($con, "SELECT * FROM movie WHERE title LIKE '$term%' LIMIT 10");

        if(mysqli_num_rows($movieQuery) == 0) {
            echo "<span class='noResults'>No movies found matching " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($movieQuery)) {
            echo "<div class='gridViewItem'>
                    <span role='link' tabindex='0' onclick='openPage(\"watch.php?id=" . $row['mov_id'] . "\")'>
                        <img src='" . $row['thumbnail'] . "'>
                        <div class='gridViewInfo'>"
                            . $row['title'] .
                        "</div>
                        
                    </span>
                </div>";
        }
}
    ?>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>