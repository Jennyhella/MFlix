<?php
include 'header.php';
include 'ft.php';
include 'C:\wamp64\www\Project\db.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white text-center">
                    <h3>Register Admin</h3>
                </div>
                <div class="card-body bg-dark text-white">
                    <form action="register_admin.php" method="post">
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" name="name" class="form-control bg-light text-dark" id="username" placeholder="Enter Admin Username" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="pwd" class="form-control bg-light text-dark" id="password" placeholder="Enter Password" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="submit" class="btn btn-outline-light">Register</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center bg-dark text-white">
                    <small class="text-white">Ensure the username and password are secure.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $pwd = $_POST['pwd'];
    $hash = password_hash($pwd, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `admin`(`name`, `pwd`) VALUES ('$name','$hash')";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "<script>alert('Admin added successfully.');window.location.href='adlist.php'</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>