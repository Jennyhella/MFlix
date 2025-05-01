<?php
	class Song {

		private $con;
		private $mid;
		private $id;
		private $mysqliData;
		private $title;
		private $genre;
		private $path;
		private $artistId;
		

		public function __construct($con, $id) {
			$this->con = $con;
			$this->id = $id;

			$query = mysqli_query($this->con, "SELECT * FROM music WHERE mid='$this->id'");
			$this->mysqliData = mysqli_fetch_array($query);
			$this->title = $this->mysqliData['title'];
			$this->id = $this->mysqliData['mid'];
			$this->path = $this->mysqliData['file_path'];
			$this->genre = $this->mysqliData['genre'];
			$this->artistId = $this->mysqliData['ar_id'];
		}
		public function getArtist() {
			return new Artist($this->con, $this->artistId);
		}
		
		public function getAlbum() {
			return new Album($this->con, $this->albumId);
		}

		public function getTitle() {
			return $this->title;
		}

		public function getId() {
			return $this->id;
		}

		public function getMID() {
			return $this->mid;
		}

		public function getPath() {
			return $this->path;
		}

		public function getMysqliData() {
			return $this->mysqliData;
		}

		public function getGenre() {
			return $this->genre;
		}
	}
?>