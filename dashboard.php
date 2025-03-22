<?php
session_start();
if (!isset($_SESSION["username"])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container d-flex justify-content-center">
    <a class="navbar-brand fw-bold me-4" href="dashboard.php">JoinProject</a>
    
 

    
        <div class="mx-auto d-flex">
        <a class="nav-link text-white fw-bold mx-3" href="dashboard.php">Dashboard</a>
        <a class="nav-link text-white fw-bold mx-3" href="add_project.php">Add Project</a>
        <a class="nav-link text-white fw-bold mx-3" href="list_project.php">Projects</a>
        <a class="nav-link text-white fw-bold mx-3" href="todolist.php"> To-Do List</a>
        </div>       
        <div>
            <a class="nav-link text-white fw-bold" href="#" onclick="confirmLogout()">Logout</a>
        </div>
    </div>
</nav>

 
    <div class="container text-center mt-5">
        <h2>Selamat datang, <?= $_SESSION["username"]; ?>!</h2>
        <p class="lead">Ini adalah halaman dashboard Anda.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmLogout() {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Anda akan keluar dari akun!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Logout!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "logout.php"; 
        }
    });
}
</script>
