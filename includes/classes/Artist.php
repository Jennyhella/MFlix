<?php
	class Artist {

		private $con;
		private $id;

		public function __construct($con, $id) {
			$this->con = $con;
			$this->id = $id;
		}

		public function getId() {
			return $this->id;
		}
		public function getName() {
			$artistQuery = mysqli_query($this->con, "SELECT name FROM artist WHERE aid='$this->id'");
			$artist = mysqli_fetch_array($artistQuery);
			return $artist['name'];
		}
		public function getBio() {
			$artistQuery = mysqli_query($this->con, "SELECT name FROM artist WHERE aid='$this->id'");
			$artist = mysqli_fetch_array($artistQuery);
			return $artist['bio'];
		}
		public function getSongIds() {
			$query = mysqli_query($this->con, "SELECT mid FROM music WHERE artist='$this->id'");
			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['mid']);
			}

			return $array;
		}
	}
?>