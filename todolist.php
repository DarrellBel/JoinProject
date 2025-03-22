<?php
include 'koneksi.php';
session_start(); // Start the session to handle flash messages

// Delete todo functionality
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete the todo item from the database
    $sql_delete = "DELETE FROM todolist WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Set a flash message if deletion is successful
        $_SESSION['flash_message'] = "Todo has been deleted successfully!";
    } else {
        // Set a flash message for failure
        $_SESSION['flash_message'] = "Error deleting todo!";
    }

    // Redirect back to the same page to show the flash message
    header("Location: todolist.php");
    exit();
}

// Query untuk mendapatkan total kategori poin dari semua todo yang berstatus "Done"
$total_done_points = 0;
$sql_done = "SELECT SUM(jumlah) AS total_points FROM todolist WHERE status = 'Done'";
$result_done = mysqli_query($conn, $sql_done);
$row_done = mysqli_fetch_assoc($result_done);
if ($row_done) {
    $total_done_points = $row_done['total_points'];
}

// Fetch all todos
$sql = "SELECT * FROM todolist ORDER BY id ASC"; 
$result = mysqli_query($conn, $sql);

// Flash message display logic
$flash_message = "";
if (isset($_SESSION['flash_message'])) {
    $flash_message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']); // Clear the flash message after displaying it
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Todo</title>
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

        <h2 class="text-center">Daftar Todo</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Proyek</th>
                        <th>Nama Todo</th>
                        <th>Status</th>
                        <th width="200">Kategori Poin</th>
                        <th width="170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_project']); ?></td>
                        <td><?= htmlspecialchars($row['nama_todo']); ?></td>
                        <td>
                            <span class="badge 
                                <?= $row['status'] === 'Done' ? 'bg-success' : 
                                   ($row['status'] === 'In-Progress' ? 'bg-primary' : 
                                   ($row['status'] === 'Review' ? 'bg-secondary' : '')); ?>">
                                <?= htmlspecialchars($row['status']); ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['jumlah']); ?></td>
                        <td>
                            <a href="#" 
                               class="btn btn-danger btn-sm" 
                               style="margin-right: 5px;"
                               onclick="confirmDelete(<?= $row['id']; ?>)">
                                Hapus
                            </a>
                            <a href="review.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
                                 Review
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- Message when no data is available -->
            <div class="alert alert-warning text-center" role="alert">
                Tidak ada data yang dapat ditampilkan.
            </div>
        <?php endif; ?>

        <!-- Total Points for "Done" Todos -->
        <div class="alert alert-info text-center">
            <strong>Total Kategori Poin untuk "Done": </strong> <?= $total_done_points; ?>
        </div>

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

// Confirmation before deletion
function confirmDelete(id) {
    Swal.fire({
        title: "Apakah Anda yakin ingin menghapus todo ini?",
        text: "Data yang dihapus tidak dapat dikembalikan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to delete the item by passing the delete ID in the URL
            window.location.href = "todolist.php?delete_id=" + id;
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
