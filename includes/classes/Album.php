<?php
class Album {

    private $con;
    private $id;
    private $title;
    private $thumbnail;
    public function __construct($con, $id) {
        $this->con = $con;
        $this->id = $id;

        // Fetch album details from the database
        $query = mysqli_query($this->con, "SELECT * FROM album WHERE aid='$this->id'");
        $album = mysqli_fetch_array($query);

        $this->title = $album['title'];
        $this->thumbnail = $album['thumbnail'];
    }

    // Get the title of the album
    public function getTitle() {
        return $this->title;
    }

    // Get the number of songs in the album
    public function getNumberOfSongs() {
        $query = mysqli_query($this->con, "SELECT mid FROM music WHERE aid='$this->id'");
        return mysqli_num_rows($query);
    }

    // Get the IDs of all songs in the album
    public function getSongIds() {
        $query = mysqli_query($this->con, "SELECT mid FROM music WHERE aid='$this->id' ORDER BY mid ASC");
        $array = array();

        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['mid']);
        }
        return $array;
    }

    // Get the album artwork path
    public function getArtworkPath() {
        $query = mysqli_query($this->con, "SELECT thumbnail FROM album WHERE aid='$this->id'");
        $row = mysqli_fetch_array($query);
        return $row['thumbnail'];
    }

	public function getArtist() {
		$query = mysqli_query($this->con, "SELECT artist.name FROM artist 
										   JOIN music ON artist.aid = music.ar_id 
										   WHERE music.aid = '$this->id' LIMIT 1");
		$row = mysqli_fetch_array($query);
		return $row['name'];
	}
}
?>