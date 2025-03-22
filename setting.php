<?php
include 'koneksi.php';
session_start();
if (isset($_GET['id'])) {
    $project_id = $_GET['id'];

    // Fetch the project details
    $query = "SELECT * FROM projects WHERE id = $project_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $project = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Project not found'); window.location='list_project.php';</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_project = $_POST['nama_project'];
    $nama_todo = $_POST['nama_todo'];
    $status = $_POST['status'];
    $jumlah = (int)$_POST['jumlah'];

    // Insert the new todo into the database
    $insert_query = "INSERT INTO todolist (nama_todo, nama_project, status, jumlah) 
                     VALUES ('$nama_todo', '$nama_project', '$status', '$jumlah')";

    if (mysqli_query($conn, $insert_query)) {
        // Set flash message for success
        $_SESSION['flash_message'] = 'Todo berhasil ditambahkan!';
        // Redirect to todolist.php to show the message
        header('Location: todolist.php');
        exit();  // Make sure to stop the script after redirect
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$flash_message = "";
if (isset($_SESSION['flash_message'])) {
    $flash_message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']); 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <?php if (!empty($flash_message)): ?>
            <div id="flash-message" class="alert alert-success" role="alert">
                <?= htmlspecialchars($flash_message); ?>
            </div>
        <?php endif; ?>
        <h2 class="text-center">Todo List</h2>
        <form method="POST">
        <div class="mb-3">
    <label class="form-label">Nama Proyek</label>
    <input type="text" class="form-control" value="<?= htmlspecialchars($project['project_name']); ?>" readonly>
    <input type="hidden" name="nama_project" value="<?= htmlspecialchars($project['project_name']); ?>">
</div>

            <div class="mb-3">
                <label class="form-label">Nama Todo</label>
                <input type="text" name="nama_todo" class="form-control" placeholder="Masukkan Nama Todo" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="In-Progress">In-Progress</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="jumlah" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Todo</button>
            <a href="list_project.php" class="btn btn-secondary" onclick="return confirmExit()">Kembali</a>
        </form>
    </div>

    <script>
        function confirmExit() {
            // Show confirmation dialog
            if (confirm('Yakin ingin menghapus data? Data yang sedang dikerjakan tidak akan disimpan.')) {
                window.location.href = 'list_project.php'; // Redirect to list_project.php if confirmed
                return true; // Allow the default action (redirect)
            } else {
                return false; // Prevent the default action (stay on the current page)
            }
        }
    </script>

</body>
</html>
