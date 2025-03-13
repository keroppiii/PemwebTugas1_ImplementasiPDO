<?php
include '../config/database.php';
include '../classes/Participant.php';

$database = new Database();
$pdo = $database->getConnection();
$participant = new Participant($pdo);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($participant->deleteById($id)) {
        header("Location: participants_list.php?success=deleted");
        exit();
    } else {
        echo "Gagal menghapus peserta.";
    }
} else {
    echo "ID tidak diberikan.";
}
?>
