<?php
include 'koneksi.php';
session_start(); // Start the session to handle flash messages

// Check if the ID is passed via the URL
if (isset($_GET['id'])) {
    $todo_id = $_GET['id'];

    // Fetch the todo item from the database based on the passed ID
    $sql = "SELECT * FROM todolist WHERE id = $todo_id";
    $result = mysqli_query($conn, $sql);
    $todo = mysqli_fetch_assoc($result);

    // Check if the todo item exists
    if (!$todo) {
        echo "<script>alert('Todo tidak ditemukan!'); window.location='todolist.php';</script>";
        exit;
    }

    // Handle form submission to update the status
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_status = $_POST['status'];

        // Update the status in the database
        $update_query = "UPDATE todolist SET status = '$new_status' WHERE id = $todo_id";
        if (mysqli_query($conn, $update_query)) {
            // Set flash message
            $_SESSION['flash_message'] = 'Status berhasil diubah!';
            // Redirect to the todolist page
            header("Location: todolist.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='todolist.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Todo</title>
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
        <h2 class="text-center">Review Todo</h2>

        <!-- Display the todo details -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($todo['nama_todo']); ?></h5>
                <p class="card-text">Nama Proyek: <?= htmlspecialchars($todo['nama_project']); ?></p>
                <p class="card-text">Kategori Poin: <?= htmlspecialchars($todo['jumlah']); ?></p>
                <p class="card-text">Status: <?= htmlspecialchars($todo['status']); ?></p>
            </div>
        </div>

        <!-- Form to update the status -->
        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label for="status" class="form-label">Update Status</label>
                <select name="status" class="form-select" id="status">
                    <option value="In-Progress" <?= $todo['status'] === 'In-Progress' ? 'selected' : ''; ?>>In-Progress</option>
                    <option value="Review" <?= $todo['status'] === 'Review' ? 'selected' : ''; ?>>Review</option>
                    <option value="Done" <?= $todo['status'] === 'Done' ? 'selected' : ''; ?>>Done</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>

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
</script>
