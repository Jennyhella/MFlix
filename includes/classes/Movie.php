<?php

class Movie {

    private $con;
    private $id; // Movie ID
    private $title;
    private $genre;
    private $thumbnail;
    private $releaseDate;

    public function __construct($con, $id) {
        $this->con = $con;
        $this->id = $id;

        // Fetch movie details from the database
        $query = mysqli_query($this->con, "SELECT * FROM movie WHERE mov_id='$this->id'");
        $movieData = mysqli_fetch_array($query);

        $this->title = $movieData['title'];
        $this->genre = $movieData['genre'];
        $this->thumbnail = $movieData['thumbnail'];
        $this->releaseDate = $movieData['release_date'];
    }

    // Get the title of the movie
    public function getTitle() {
        return $this->title;
    }

    // Get the genre of the movie
    public function getGenre() {
        return $this->genre;
    }

    // Get the thumbnail path of the movie
    public function getThumbnail() {
        return $this->thumbnail;
    }

    // Get the release date of the movie
    public function getReleaseDate() {
        return $this->releaseDate;
    }
}

?>