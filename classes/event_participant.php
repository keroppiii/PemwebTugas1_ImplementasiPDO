<?php
require_once __DIR__ . '/../config/database.php';

class EventParticipant {
    private $conn;
    private $table_name = "event_participant";

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function addParticipantToEvent($event_id, $participant_id) {
        $query = "INSERT INTO event_participant (event_id, participant_id) VALUES (:event_id, :participant_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":event_id", $event_id);
        $stmt->bindParam(":participant_id", $participant_id);
    
        return $stmt->execute();
    }

    public function deleteByEvent($event_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE event_id = :event_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":event_id", $event_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteByParticipant($participant_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE participant_id = :participant_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":participant_id", $participant_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getParticipantsByEvent($event_id) {
        $query = "SELECT p.* FROM participants p 
                  JOIN " . $this->table_name . " ep ON p.id = ep.participant_id 
                  WHERE ep.event_id = :event_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":event_id", $event_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventsByParticipant($participant_id) {
        $query = "SELECT e.* FROM events e 
                  JOIN " . $this->table_name . " ep ON e.id = ep.event_id 
                  WHERE ep.participant_id = :participant_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":participant_id", $participant_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
