<?php

class Booking {
    private int $roomId;
    private int $roomType;
    private int $userId;
    private $fromDate; // DateTime or string
    private $toDate; // DateTime or string
    private int $adults;
    private int $children;

    // Constructor
    public function __construct($roomId, $roomType, $userId, $fromDate, $toDate, $adults, $children) {
        $this->roomId = $roomId;
        $this->roomType = $roomType;
        $this->userId = $userId;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->adults = $adults;
        $this->children = $children;
    }

    // Book a room
    public function bookRoom($pdo) {
        if (!$this->isRoomAvailable($pdo, $this->roomId, $this->fromDate, $this->toDate)) {
            echo "Room not available for the selected dates.";
            return false;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO bookings (room_id, room_type, user_id, from_date, to_date, adults, children) 
                                   VALUES (:roomId, :roomType, :userId, :fromDate, :toDate, :adults, :children)");

            $stmt->bindParam(':roomId', $this->roomId, PDO::PARAM_INT);
            $stmt->bindParam(':roomType', $this->roomType, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $this->userId, PDO::PARAM_INT);
            $stmt->bindParam(':fromDate', $this->fromDate);
            $stmt->bindParam(':toDate', $this->toDate);
            $stmt->bindParam(':adults', $this->adults, PDO::PARAM_INT);
            $stmt->bindParam(':children', $this->children, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Booking error: " . $e->getMessage();
            return false;
        }
    }

    // Check room availability
    public function isRoomAvailable($pdo, $roomId, $fromDate, $toDate) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings 
                                   WHERE room_id = :roomId 
                                   AND (from_date < :toDate AND to_date > :fromDate)");
            $stmt->bindParam(':roomId', $roomId, PDO::PARAM_INT);
            $stmt->bindParam(':fromDate', $fromDate);
            $stmt->bindParam(':toDate', $toDate);
            $stmt->execute();

            return $stmt->fetchColumn() == 0;
        } catch (PDOException $e) {
            echo "Error checking availability: " . $e->getMessage();
            return false;
        }
    }

    // Get filtered rooms based on criteria
    public static function getAvailableRooms($pdo, $adults, $children, $fromDate, $toDate) {
        try {
            $stmt = $pdo->prepare("SELECT rooms.id, rooms.room_type, rooms.max_adults, rooms.max_children 
                                   FROM rooms 
                                   WHERE rooms.max_adults >= :adults 
                                   AND rooms.max_children >= :children 
                                   AND rooms.id NOT IN (
                                       SELECT room_id FROM bookings 
                                       WHERE from_date < :toDate AND to_date > :fromDate
                                   )");
            $stmt->bindParam(':adults', $adults, PDO::PARAM_INT);
            $stmt->bindParam(':children', $children, PDO::PARAM_INT);
            $stmt->bindParam(':fromDate', $fromDate);
            $stmt->bindParam(':toDate', $toDate);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching available rooms: " . $e->getMessage();
            return [];
        }
    }
}
?>
