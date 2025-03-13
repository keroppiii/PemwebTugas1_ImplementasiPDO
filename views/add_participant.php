<?php
include '../config/database.php';
include '../classes/Participant.php';

$database = new Database();
$db = $database->getConnection();
$participant = new Participant($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    $participant->name = $name;
    $participant->email = $email;

    if ($participant->create()) {
        header("Location: participants_list.php");
        exit();
    } else {
        echo "Gagal menambahkan peserta.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peserta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Peserta</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Peserta</button>
            <a href="participants_list.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
