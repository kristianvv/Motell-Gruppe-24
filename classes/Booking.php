<?php

class Booking {
    private int $id;
    private int $roomId;
    private int $roomType;
    private int $userId;
    private $fromDate; // DateTime or string
    private $toDate; // DateTime or string
    private int $adults;
    private int $children;

    // Constructor
    public function __construct($id = null, $roomId = null, $roomType, $userId, $fromDate, $toDate, $adults, $children) {
        $this->id = $id;
        $this->roomId = $roomId;
        $this->roomType = $roomType;
        $this->userId = $userId;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->adults = $adults;
        $this->children = $children;
    }

    // Book a room by type
    public function bookRoomByType($pdo) {
        $roomRange = $this->getRoomRangeByType($this->roomType);

        if (!$roomRange) {
            echo "Invalid room type.";
            return false;
        }

        foreach (range($roomRange['start'], $roomRange['end']) as $roomId) {
            if ($this->isRoomAvailable($pdo, $roomId, $this->fromDate, $this->toDate)) {
                $this->roomId = $roomId; // Assign the available room
                return $this->bookRoom($pdo); // Attempt booking
            }
        }

        echo "No rooms available for the selected type and dates.";
        return false;
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

    // Book a specific room
    public function bookRoom($pdo) {
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

            if ($stmt->execute()) {
                echo "Booking successful for Room ID {$this->roomId}!";
                return true;
            }
        } catch (PDOException $e) {
            echo "Booking error: " . $e->getMessage();
        }
        return false;
    }

    // Get room ID range by type
    private function getRoomRangeByType($roomType) {
        switch ($roomType) {
            case 'enkeltrom': return ['start' => 1, 'end' => 10];
            case 'dobbeltrom': return ['start' => 11, 'end' => 20];
            case 'juniorsuite': return ['start' => 21, 'end' => 25];
            default: return null;
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

    // Get all bookings
    public static function fetch_all_bookings($pdo) {
        try {
            $stmt = $pdo->query("SELECT Booking.id, Booking.roomID, Booking.userID, Booking.checkInDate, Booking.checkOutDate, Booking.createdAt, Rooms.adults, Rooms.roomType, Rooms.children
                                 FROM Booking, Rooms
                                 WHERE Booking.roomID = Rooms.roomID
                                 ORDER BY Booking.createdAt DESC");

           return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error fetching bookings: " . $e->getMessage();
            return [];
        }
    }

    // Getters
    public function get_room_id() {
        return $this->roomId;
    }

    public function get_room_type() {
        return $this->roomType;
    }

    public function get_user_id() {
        return $this->userId;
    }

    public function get_from_date() {
        return $this->fromDate;
    }

    public function get_to_date() {
        return $this->toDate;
    }

    public function get_adults() {
        return $this->adults;
    }

    public function get_children() {
        return $this->children;
    }
}
?>
