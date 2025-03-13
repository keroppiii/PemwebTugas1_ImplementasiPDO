<?php
include '../config/database.php';
include '../classes/Event.php';

$database = new Database();
$pdo = $database->getConnection();
$event = new Event($pdo);

if (isset($_GET['id'])) {
    $eventData = $event->getEventById($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // Cek apakah data dikirim
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];

    if ($event->update($id, $title, $description, $event_date, $location)) {
        header("Location: events_list.php");
        exit();
    } else {
        echo "Gagal mengupdate event.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Event</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $eventData['id'] ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Event</label>
                <input type="text" class="form-control" name="title" value="<?= $eventData['title'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" required><?= $eventData['description'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="event_date" class="form-label">Tanggal Event</label>
                <input type="date" class="form-control" name="event_date" value="<?= $eventData['event_date'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" class="form-control" name="location" value="<?= $eventData['location'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Event</button>
            <a href="events_list.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
