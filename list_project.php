<?php
include 'koneksi.php';
session_start(); // Mulai session untuk flash message

// Menampilkan flash message jika ada
$flash_message = "";
if (isset($_SESSION['flash_message'])) {
    $flash_message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']); // Menghapus flash message setelah ditampilkan
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM projects WHERE id = $delete_id";

    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Proyek berhasil dihapus!'); window.location='list_project.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM projects ORDER BY id ASC"; 
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Proyek</title>
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
                <a class="nav-link text-white fw-bold mx-3" href="todolist.php">To-Do List</a>
            </div>
            <div>
                <a class="nav-link text-white fw-bold" href="#" onclick="confirmLogout()">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- Flash Message -->
        <?php if (!empty($flash_message)): ?>
            <div id="flash-message" class="alert alert-success" role="alert">
                <?= htmlspecialchars($flash_message); ?>
            </div>
        <?php endif; ?>

        <h2 class="text-center">Daftar Proyek</h2>
        <a href="add_project.php" class="btn btn-primary mb-3">Tambah Proyek</a>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Proyek</th>
                        <th>Status</th>
                        <th>Kategori</th>
                        <th width="170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= htmlspecialchars($row['project_name']); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td><?= htmlspecialchars($row['kategori']); ?></td>
                        <td>
                            <a href="list_project.php?delete_id=<?= $row['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');" 
                               style="margin-right: 5px;">
                                Hapus
                            </a>
                            <a href="setting.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
                                Setting
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- Message when no data is available -->
            <div class="alert alert-warning text-center" role="alert">
                Tidak ada data yang bisa ditampilkan.
            </div>
        <?php endif; ?>
    </div>

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

// Flash message disappearance after 2 seconds
window.onload = function() {
    var flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
        setTimeout(function() {
            flashMessage.style.display = 'none';
        }, 2000); // Hide after 2 seconds
    }
};
</script>
