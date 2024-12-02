<?php

class Booking {
    private int $id;
    private int $roomId;
    private string $roomType;
    private int $userId;
    private $fromDate; // DateTime or string
    private $toDate; // DateTime or string
    private int $adults;
    private int $children;

    // Constructor
    public function __construct($id, $roomId, $roomType, $userId, $fromDate, $toDate, $adults, $children) {
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
    private function getRoomRangeByType($roomType): array|null {
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
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $bookingObjects = [];
            foreach ($bookings as $booking) {
                $bookingObjects[] = new Booking(id: $booking['id'], roomId: $booking['roomID'], roomType: $booking['roomType'], userId: $booking['userID'], fromDate: $booking['checkInDate'], toDate: $booking['checkOutDate'], adults: $booking['adults'], children: $booking['children']);
            }

            return $bookingObjects;

        } catch (PDOException $e) {
            echo "Error fetching bookings: " . $e->getMessage();
            return [];
        }
    }

    public static function search_bookings($pdo, $query) {
        try {
            $sql = "SELECT Booking.id, Booking.roomID, Booking.userID, Booking.checkInDate, Booking.checkOutDate, Booking.createdAt, 
                           Rooms.adults, Rooms.roomType, Rooms.children
                    FROM Booking
                    JOIN Rooms ON Booking.roomID = Rooms.roomID
                    WHERE Booking.id LIKE :query OR Booking.roomID LIKE :query
                    ORDER BY Booking.createdAt DESC";
    
            $stmt = $pdo->prepare($sql);
            $searchTerm = '%' . $query . '%';
            $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
    
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $bookingObjects = [];
            foreach ($bookings as $booking) {
                $bookingObjects[] = new Booking(
                    id: $booking['id'],
                    roomId: $booking['roomID'],
                    roomType: $booking['roomType'],
                    userId: $booking['userID'],
                    fromDate: $booking['checkInDate'],
                    toDate: $booking['checkOutDate'],
                    adults: $booking['adults'],
                    children: $booking['children']
                );
            }
    
            return $bookingObjects;
    
        } catch (PDOException $e) {
            echo "Error searching bookings: " . $e->getMessage();
            return [];
        }
    }
    
    // Get booking by ID
    public static function get_booking_by_id($pdo, $id) {
        try {
            $stmt = $pdo->prepare("SELECT Booking.id, Booking.roomID, Booking.userID, Booking.checkInDate, Booking.checkOutDate, Booking.createdAt, Rooms.adults, Rooms.roomType, Rooms.children
                                   FROM Booking, Rooms
                                   WHERE Booking.roomID = Rooms.roomID
                                   AND Booking.id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $booking = $stmt->fetch(PDO::FETCH_ASSOC);

            return new Booking(id: $booking['id'], roomId: $booking['roomID'], roomType: $booking['roomType'], userId: $booking['userID'], fromDate: $booking['checkInDate'], toDate: $booking['checkOutDate'], adults: $booking['adults'], children: $booking['children']);

        } catch (PDOException $e) {
            echo "Error fetching booking: " . $e->getMessage();
            return null;
        }
    }
    public static function get_bookings_by_user_id ($pdo, $userID) {
        
        $sql = "SELECT * FROM Booking WHERE userID = :userID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
            
    public static function cancel_booking($pdo, $id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM Booking WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo "Error cancelling booking"; // . $e->getMessage();
        }
    }

    public function getId() {
        return $this->id;
    }
    public function getRoomId() {
        return $this->roomId;
    }

    public function getRoomType() {
        return $this->roomType;
    }

    public function getUserId() {
        return $this->userId;
    }
    public function getFromDate() {
        return $this->fromDate;
    }

    public function getToDate() {
        return $this->toDate;
    }

    public function getAdults() {
        return $this->adults;
    }
    public function getChildren() {
        return $this->children;
    }

}
?>
