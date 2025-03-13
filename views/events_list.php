<?php
require_once '../config/database.php';
require_once '../classes/Event.php';

// Buat objek Database dan ambil koneksi
$database = new Database();
$pdo = $database->getConnection();

// Pastikan $pdo tidak null
if (!$pdo) {
    die("Database connection failed.");
}

// Buat objek Event dan ambil semua event
$event = new Event($pdo);
$events = $event->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Event</h2>
        <a href="add_event.php" class="btn btn-primary mb-3">Tambah Event</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($events as $event) : ?>
                    <tr>
                        <td><?= htmlspecialchars($event['id']); ?></td>
                        <td><?= htmlspecialchars($event['title']); ?></td>
                        <td><?= htmlspecialchars($event['description']); ?></td>
                        <td><?= htmlspecialchars($event['event_date']); ?></td>
                        <td><?= htmlspecialchars($event['location']); ?></td>
                        <td>
                            <a href="edit_event.php?id=<?= $event['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_event.php?id=<?= $event['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus event ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
