<?php
include("includes/includedFiles.php");

// Check if the movie ID is passed in the URL
if (isset($_GET['id'])) {
    $movieId = $_GET['id'];
} else {
    header("Location: movie.php");
    exit();
}

// Fetch movie details from the database
$movieQuery = mysqli_query($con, "SELECT * FROM movie WHERE mov_id='$movieId'");
if (mysqli_num_rows($movieQuery) == 0) {
    echo "Movie not found.";
    exit();
}


$movie = mysqli_fetch_array($movieQuery);
$title = $movie['title'];
$cid=$movie['cid']; // Assuming the movie category ID is stored in the `cid` column
$filePath = $movie['file_path']; // Assuming the movie file path is stored in the `file_path` column

$historyQuery = mysqli_query($con, "INSERT INTO history (id, cid) VALUES ('" . $userLoggedIn->getId() . "',$cid )");
if (!$historyQuery) {
    echo "Error adding to history: " . mysqli_error($con);
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch <?php echo $title; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000; /* Black background */
            color: #fff; /* White text color */
        }

        .video-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        video {
            max-width: 100%;
            max-height: 80vh;
            border: 2px solid #fff;
        }
    </style>
</head>
<body>
    <div class="video-container">
        <video controls>
            <source src="<?php echo $filePath; ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</body>
</html>