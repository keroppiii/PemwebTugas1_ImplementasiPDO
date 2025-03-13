<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/event_participant.php';

class Event {
    private $conn;
    private $table_name = "events";

    public $id;
    public $title;
    public $description;
    public $event_date;
    public $location;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getEventById($id) {
        $query = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Create event
    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . " (title, description, event_date, location) 
                      VALUES (:title, :description, :event_date, :location)";
            $stmt = $this->conn->prepare($query);

            $this->sanitize();

            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":event_date", $this->event_date);
            $stmt->bindParam(":location", $this->location);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create Event Error: " . $e->getMessage());
            return false;
        }
    }

    // Read all events
    public function readAll() {
        try {
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY event_date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Read All Events Error: " . $e->getMessage());
            return [];
        }
    }

    // Update event
    public function update($id, $title, $description, $event_date, $location) {
        try {
            $query = "UPDATE " . $this->table_name . " 
                      SET title = :title, description = :description, event_date = :event_date, location = :location 
                      WHERE id = :id";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":event_date", $event_date);
            $stmt->bindParam(":location", $location);
    
            if ($stmt->execute()) {
                return true;
            } else {
                print_r($stmt->errorInfo()); 
                return false;
            }
        } catch (PDOException $e) {
            error_log("Update Event Error: " . $e->getMessage());
            return false;
        }
    }
    
    // Delete event
    public function delete() {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete Event Error: " . $e->getMessage());
            return false;
        }
    }

    // Delete event by ID
    public function deleteById($id) {
        try {
            $this->conn->beginTransaction();
            
            // Hapus semua participant dari event sebelum menghapus event
            $eventParticipant = new EventParticipant($this->conn);
            $eventParticipant->deleteByEvent($id);
    
            // Hapus event
            $query = "DELETE FROM events WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }    


    // Sanitasi data input
    private function sanitize() {
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->event_date = htmlspecialchars(strip_tags($this->event_date));
        $this->location = htmlspecialchars(strip_tags($this->location));
    }
}
?>
