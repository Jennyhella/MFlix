<?php
include '../includes/config.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .navbar {
            background-color: #343a40; /* Dark gray */
        }
        .navbar-brand {
            color:rgb(128, 230, 209) !important; /* Teal color */
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: #ffffff !important;
        }
        .navbar-nav .nav-link:hover {
            color:rgb(99, 223, 198) !important; /* Teal hover effect */
        }
        .btn-outline-danger {
            color: #ff7675 !important;
            border-color: #ff7675 !important;
        }
        .btn-outline-danger:hover {
            background-color: #ff7675 !important;
            color: #ffffff !important;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-user-shield"></i> Hello, <?php echo $_SESSION['name']; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register_admin.php"><i class="fas fa-user-plus"></i> Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adlist.php"><i class="fas fa-list"></i> Listing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="musiclist.php"><i class="fas fa-music"></i> Music</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="movlist.php"><i class="fas fa-film"></i> Movies</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<!-- Optional Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>