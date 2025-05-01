<?php
include("includes/includedFiles.php");

// Fetch all movies from the database
$moviesQuery = mysqli_query($con, "SELECT * FROM movie");
?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #000; /* Black background */
            color: #fff; /* White text color */
        }

        .card {
            background-color: #1c1c1c; /* Dark gray card background */
            color: #fff; /* White text color for cards */
            border: 2px solid #007bff; /* Add a blue border around the card */
            border-radius: 10px; /* Add rounded corners to the card */
            overflow: hidden; /* Ensure content stays within the card */
            width: 100%; /* Ensure the card takes up the full column width */
            height: 550px; /* Reduced height for the card */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-img-top {
            width: 100%; /* Make the image take the full width of the card */
            height: 350px; /* Reduced height for all images */
            object-fit: cover; /* Crop the image to fit the dimensions while maintaining aspect ratio */
            border-bottom: 2px solid #007bff; /* Add a border below the image */
        }

        .card-body {
            padding: 10px; /* Add padding inside the card body */
            text-align: center; /* Center-align the text */
        }

        .card a.btn-outline-light {
            border: 2px solid #007bff; /* Add a blue border to the button */
            color: #007bff; /* Blue text color for the button */
            font-weight: bold; /* Make the button text bold */
            transition: all 0.3s ease; /* Add a smooth transition effect */
        }

        .card a.btn-outline-light:hover {
            background-color: #007bff; /* Blue background on hover */
            color: #fff; /* White text color on hover */
            border-color: #0056b3; /* Darker blue border on hover */
        }

        h1 {
            color: #fff; /* White color for the heading */
        }

    </style>

    <!-- Bootstrap JS (Optional, for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Movies</h1>
        <div class="row">
            <?php
            while ($row = mysqli_fetch_array($moviesQuery)) {
                $movieId = $row['mov_id'];
                $title = $row['title'];
                $genre = $row['genre'];
                $thumbnail = $row['thumbnail'];
                $releaseDate = $row['release_date'];

                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card'>
                        <img src='$thumbnail' class='card-img-top' alt='$title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$title</h5>
                            <p class='card-text'>Genre: $genre</p>
                            <p class='card-text'>Release Date: $releaseDate</p>
                            <a href='watch.php?id=$movieId' class='btn btn-outline-light'>Watch Now</a>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>