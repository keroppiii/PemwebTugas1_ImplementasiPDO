<?php
include '../config/database.php';
include '../classes/Event.php';

$database = new Database();
$pdo = $database->getConnection();
$event = new Event($pdo);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($event->deleteById($id)) {
        header("Location: events_list.php?success=deleted");
        exit();
    } else {
        echo "Gagal menghapus event.";
    }
} else {
    echo "ID tidak diberikan.";
}
?>
