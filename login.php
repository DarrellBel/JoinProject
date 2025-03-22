<?php
include "koneksi.php"; 
session_start();

$errorMessage = ""; // Variable to store error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if the email format is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Masukkan email yang valid!";
    } else {
        // Query to check if the email exists
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Email found, now check the password
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                // Password is correct, start session and redirect
                $_SESSION["username"] = $row["username"];
                echo "<script>alert('Login berhasil!'); window.location='dashboard.php';</script>";
                exit;
            } else {
                // Incorrect password
                $errorMessage = "Password salah!";
            }
        } else {
            // Email not found in the database
            $errorMessage = "Email tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 350px;">
        <h3 class="text-center">Login</h3>

        <!-- Show error message if it exists -->
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-2">Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</body>
</html>
