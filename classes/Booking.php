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

    // Create booking entry
    public function bookRoom($pdo) { // Pass the PDO object for database interaction
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

            return $stmt->execute(); // Returns true on success
        } catch (PDOException $e) {
            // Handle the error (log it or display a message)
            echo "Booking error: " . $e->getMessage();
            return false; // Return false on failure
        }
    }

    // Cancel existing booking
    public function cancelBooking($pdo, $bookingId) { // Pass the PDO object and booking ID
        try {
            $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = :bookingId AND user_id = :userId");
            $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $this->userId, PDO::PARAM_INT);
            return $stmt->execute(); // Returns true on success
        } catch (PDOException $e) {
            echo "Cancellation error: " . $e->getMessage();
            return false; // Return false on failure
        }
    }

    // Return booking information
    public function getBookingDetails($pdo, $bookingId) { // Pass the PDO object and booking ID
        try {
            $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = :bookingId AND user_id = :userId");
            $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $this->userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Return booking details as associative array
        } catch (PDOException $e) {
            echo "Error fetching booking details: " . $e->getMessage();
            return null; // Return null on failure
        }
    }

    // Check if room is available
    public function isRoomAvailable($pdo, $roomId, $fromDate, $toDate) { // Pass the PDO object
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE room_id = :roomId AND 
                                   ((from_date <= :toDate AND to_date >= :fromDate))");
            $stmt->bindParam(':roomId', $roomId, PDO::PARAM_INT);
            $stmt->bindParam(':fromDate', $fromDate);
            $stmt->bindParam(':toDate', $toDate);
            $stmt->execute();

            $count = $stmt->fetchColumn();
            return $count == 0; // Return true if available, false if booked
        } catch (PDOException $e) {
            echo "Error checking availability: " . $e->getMessage();
            return false; // Return false on failure
        }
    }
}
?>