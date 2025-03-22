<?php
include "koneksi.php"; 
session_start();  // Start the session to store user data

$errorMessage = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validate if all fields are filled
    if (empty($username) || empty($email) || empty($password)) {
        $errorMessage = "Semua field harus diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Email tidak valid!";
    } else {
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username or email already exists
        $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "Username atau Email sudah terdaftar!";
        } else {
            // Insert new user into the database
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$passwordHash')";
            if (mysqli_query($conn, $query)) {
                // Start the session for the user
                $_SESSION["username"] = $username;  // Store username in session

                // Redirect the user to the dashboard
                echo "<script>alert('Registrasi berhasil!'); window.location='dashboard.php';</script>";
            } else {
                $errorMessage = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 350px;">
        <h3 class="text-center">Registrasi</h3>
        
        <!-- Show error message if it exists -->
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?php echo isset($username) ? $username : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        <p class="text-center mt-2">Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
