<?php
require_once "config/database.php";
require_once "classes/Participant.php";
require_once "classes/EventParticipant.php";

$database = new Database();
$db = $database->getConnection();
$participant = new Participant($db);
$participants = $participant->readAll();
$eventParticipant = new EventParticipant($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $participant_id = $_POST['participant_id'];

    echo "Event ID: " . $event_id . "<br>";
    echo "Participant ID: " . $participant_id . "<br>";

    if (!empty($event_id) && !empty($participant_id)) {
        if ($eventParticipant->addParticipantToEvent($event_id, $participant_id)) {
            echo "Peserta berhasil ditambahkan!";
        } else {
            echo "Gagal menambahkan peserta!";
        }
    } else {
        echo "Semua field harus diisi!";
    }
    exit();
}

?>
