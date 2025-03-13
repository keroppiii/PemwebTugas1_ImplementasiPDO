<?php
require_once "config/database.php";
require_once "classes/Event.php";
require_once "classes/Participant.php";
require_once 'classes/event_participant.php';

$database = new Database();
$db = $database->getConnection();

$event = new Event($db);
$events = $event->readAll();

$participant = new Participant($db);
$participants = $participant->readAll();

$eventParticipant = new EventParticipant($db);
$eventParticipants = $eventParticipant->readAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Event</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>
<body class="container mt-4">
    <h2 class="mb-4">Daftar Event</h2>
    <table id="eventTable" class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event['id']) ?></td>
                <td><?= htmlspecialchars($event['title']) ?></td>
                <td><?= htmlspecialchars($event['event_date']) ?></td>
                <td><?= htmlspecialchars($event['location']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Daftar Peserta</h2>
    <table id="participantTable" class="table table-striped">
        <thead class="table-secondary">
            <tr>
                <th>Id</th>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $participant): ?>
            <tr>
                <td><?= htmlspecialchars($participant['id']) ?></td>
                <td><?= htmlspecialchars($participant['name']) ?></td>
                <td><?= htmlspecialchars($participant['email']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Daftar Event & Peserta</h2>
    <table id="eventParticipantTable" class="table table-striped">
        <thead class="table-secondary">
            <tr>
                <th>Event ID</th>
                <th>Nama Event</th>
                <th>Peserta</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event['id']) ?></td>
                <td><?= htmlspecialchars($event['title']) ?></td>
                <td>
                    <?php
                    $eventParticipantsList = $eventParticipant->getParticipantsByEvent($event['id']);
                    if (empty($eventParticipantsList)) {
                        echo "Belum ada peserta";
                    } else {
                        foreach ($eventParticipantsList as $p) {
                            echo htmlspecialchars($p['name']) . "<br>";
                        }
                    }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Tambah Peserta ke Event</h2>
    <form action="add_event_participant.php" method="POST">
        <div class="mb-3">
            <label for="event_id" class="form-label">Pilih Event:</label>
            <select name="event_id" id="event_id" class="form-select" required>
                <option value="">-- Pilih Event --</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= htmlspecialchars($event['id']) ?>">
                        <?= htmlspecialchars($event['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="participant_id" class="form-label">Pilih Peserta:</label>
            <select name="participant_id" id="participant_id" class="form-select" required>
                <option value="">-- Pilih Peserta --</option>
                <?php foreach ($participants as $participant): ?>
                    <option value="<?= htmlspecialchars($participant['id']) ?>">
                        <?= htmlspecialchars($participant['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#eventTable').DataTable();
            $('#participantTable').DataTable();
            $('#eventParticipantTable').DataTable();
        });
    </script>
</body>
</html>
