<?php
include("includes/includedFiles.php");
?>

<div class="playlistContainer">	
	<div class="gridViewContainer">		
		<h2>PLAYLISTS</h2>
		<div class="buttonItems">
			<button class="button green" onclick="createPlaylist()">+ NEW PLAYLIST</button>
		</div>
		<?php
			$uid = $userLoggedIn->getId();
			$playlistQuery = mysqli_query($con, "SELECT * FROM playlist WHERE id = $uid");

			if(mysqli_num_rows($playlistQuery) == 0) {
				echo "<div class='noResults'><small>You don't have any playlist yet.</small></div>";
			}
			$dir = "assets/images/playlist-img/*.jpg";
			$img= glob($dir);
			$i=0;
			while($row = mysqli_fetch_array($playlistQuery)) {
				$playlist = new Playlist($con, $row);
				
				while($i<count($img)){
					$image= $img[$i];
				echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() ."\")'>";
					echo "	<div class='playlistImage'>";
		
						        echo "<img src='$image' height='150px' width='150px' />";
						        $i++;break;
				}
							echo "</div>
						<div class='gridViewInfo'>"
								. $playlist->getName() .
							"</div>
						</div>";
				
			}
		?>

	</div>

</div>