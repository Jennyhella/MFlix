<?php
include 'header.php';
include 'ft.php';
?>

<div class="container mt-5">
    <div class="text-center mb-4">
        <h1>Welcome to the Admin Dashboard</h1>
        <p class="text-muted">Manage your content efficiently</p>
        <hr>
    </div>

    <div class="row g-4">
        <!-- Movies Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Movies</h5>
                    <p class="card-text text-muted">Manage all movies in the database.</p>
                    <a href="movlist.php" class="btn btn-primary"><i class="fas fa-film"></i> View Movies</a>
                </div>
            </div>
        </div>

        <!-- Music Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Music</h5>
                    <p class="card-text text-muted">Manage all music tracks in the database.</p>
                    <a href="musiclist.php" class="btn btn-success"><i class="fas fa-music"></i> View Music</a>
                </div>
            </div>
        </div>

        <!-- Admins Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Admins</h5>
                    <p class="card-text text-muted">Manage admin accounts.</p>
                    <a href="adlist.php" class="btn btn-warning text-light"><i class="fas fa-user-shield"></i> View Admins</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>