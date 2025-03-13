<?php
require_once '../config/database.php';
require_once '../classes/Participant.php';

$database = new Database();
$pdo = $database->getConnection();

if (!$pdo) {
    die("Database connection failed.");
}

$participant = new Participant($pdo);
$participants = $participant->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Participant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Peserta</h2>
        <a href="add_participant.php" class="btn btn-primary mb-3">Tambah Peserta</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($participants as $participant) : ?>
                    <tr>
                        <td><?= htmlspecialchars($participant['id']); ?></td>
                        <td><?= htmlspecialchars($participant['name']); ?></td>
                        <td><?= htmlspecialchars($participant['email']); ?></td>
                        <td>
                            <a href="edit_participant.php?id=<?= $participant['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_participant.php?id=<?= $participant['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus peserta ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
