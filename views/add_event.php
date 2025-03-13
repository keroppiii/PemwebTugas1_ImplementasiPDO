<?php
require_once '../config/database.php';
require_once '../classes/Event.php';

// Pastikan koneksi database sudah ada
$database = new Database();
$db = $database->getConnection();
$event = new Event($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $event_date = $_POST['event_date'];
    $location = trim($_POST['location']);

    // Pastikan semua data diisi
    if (!empty($title) && !empty($description) && !empty($event_date) && !empty($location)) {
        $event->title = $title;
        $event->description = $description;
        $event->event_date = $event_date;
        $event->location = $location;

        if ($event->create()) {
            header("Location: events_list.php?success=1");
            exit();
        } else {
            $error = "Gagal menambahkan event.";
        }
    } else {
        $error = "Semua field harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Event</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Event</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="event_date" class="form-label">Tanggal Event</label>
                <input type="date" class="form-control" name="event_date" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" class="form-control" name="location" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Event</button>
            <a href="events_list.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
