<?php
include 'header.php';
include 'ft.php';
?>

<div class="container mt-5">
    <div class="text-center mb-4">
        <h1>Admin Panel</h1>
        <hr>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM admin";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $row['id']; ?></th>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><span class="text-muted">Encrypted</span></td>
                            <td class="text-center">
                                <a class="btn btn-danger btn-sm me-2" href="deleteAd.php?id=<?php echo $row['id']; ?>"><i class="fas fa-trash"></i> Delete</a>
                                <a class="btn btn-success btn-sm" href="register_admin.php"><i class="fas fa-plus"></i> Add New</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No admins found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Optional Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>