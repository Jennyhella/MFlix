<?php

class Playlist {

    private $con;
    private $pid; // Playlist ID
    private $uid; // User ID
    private $name;
    private $created_at;

    public function __construct($con, $data) {
        if (!is_array($data)) {
            // If $data is not an array, treat it as a playlist ID
            $query = mysqli_query($con, "SELECT * FROM playlist WHERE pid = '$data'");
            $data = mysqli_fetch_array($query);
        }

        $this->con = $con;
        $this->pid = $data['pid'];
        $this->name = $data['name'];
        $this->uid = $data['id']; // User ID
        $this->created_at = $data['created_at'];
    }

    // Get the name of the playlist
    public function getName() {
        return $this->name;
    }

    // Get the playlist ID
    public function getId() {
        return $this->pid;
    }

    // Get the user ID associated with the playlist
    public function getUID() {
        return $this->uid;
    }

    // Get the creation date of the playlist
    public function getCreatedAt() {
        return $this->created_at;
    }

    // Get all song IDs in the playlist
    public function getSongIds() {
        $query = mysqli_query($this->con, "SELECT cid FROM playlistcontent WHERE pid = '$this->pid'");

        $array = array();

        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['cid']); // Add content ID (cid) to the array
        }

        return $array;
    }

    // Static function to generate a dropdown for playlists
    public static function getPlaylistDropdown($con, $userId) {
        $dropdown = '<select class="item playlist">
                        <option value="">Add to playlist</option>';

        $query = mysqli_query($con, "SELECT pid, name FROM playlist WHERE id = '$userId'");
        while ($row = mysqli_fetch_array($query)) {
            $id = $row['pid'];
            $name = $row['name'];
            $dropdown .= "<option value='$id'>$name</option>";
        }

        return $dropdown . "</select>";
    }
}

?>