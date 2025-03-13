<?php
include '../config/database.php';
include '../classes/Participant.php';

// Koneksi ke database
$database = new Database();
$pdo = $database->getConnection();
$participant = new Participant($pdo);

// Pastikan ID peserta diberikan di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $participantData = $participant->getById($id);

    if (!$participantData) {
        die("Peserta tidak ditemukan.");
    }
} else {
    die("ID tidak diberikan.");
}

// Jika form dikirim, update data peserta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    // Set properti objek
    $participant->id = $id;
    $participant->name = $name;
    $participant->email = $email;

    if ($participant->update()) {
        header("Location: participants_list.php");
        exit();
    } else {
        echo "Gagal mengupdate peserta.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Participant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Peserta</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $participantData['id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" name="name" value="<?= $participantData['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= $participantData['email'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Peserta</button>
            <a href="participants_list.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
