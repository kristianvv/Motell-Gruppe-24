<?php 

class Room {
    private ?int $roomID;              // Matches `roomID` in the table
    private ?string $roomType;         // Matches `roomType`
    private ?int $nrAdults;            // Matches `adults`
    private ?int $nrChildren;          // Matches `children`
    private ?string $description;      // Matches `description`
    private ?float $price;             // Matches `price`

    public function __construct(
        ?int $roomID = null,
        ?string $roomType = null,
        ?int $nrAdults = null,
        ?int $nrChildren = null,
        ?string $description = null,
        ?float $price = null
    ) {
        $this->roomID = $roomID;
        $this->roomType = $roomType;
        $this->nrAdults = $nrAdults;
        $this->nrChildren = $nrChildren;
        $this->description = $description;
        $this->price = $price;
    }

    // Getter methods for each property
    public function getRoomID(): ?int {
        return $this->roomID;
    }

    public function getRoomType(): ?string {
        return $this->roomType;
    }

    public function getNrAdults(): ?int {
        return $this->nrAdults;
    }

    public function getNrChildren(): ?int {
        return $this->nrChildren;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function make_unavailable($pdo, $fromDate, $toDate, $description) {
    // Check for overlapping dates
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM Rooms_Unavailable 
        WHERE roomID = :roomID 
        AND (fromDate <= :toDate AND toDate >= :fromDate)
    ");
    $stmt->bindParam(':roomID', $this->roomID, PDO::PARAM_INT);
    $stmt->bindParam(':fromDate', $fromDate);
    $stmt->bindParam(':toDate', $toDate);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {
        return false; // Overlapping date found
    }

    // Insert the unavailability
    $stmt = $pdo->prepare("
        INSERT INTO Rooms_Unavailable (roomID, fromDate, toDate, description) 
        VALUES (:roomID, :fromDate, :toDate, :description)
    ");
    $stmt->bindParam(':roomID', $this->roomID, PDO::PARAM_INT);
    $stmt->bindParam(':fromDate', $fromDate);
    $stmt->bindParam(':toDate', $toDate);
    $stmt->bindParam(':description', $description);
    
    return $stmt->execute();
}
    //Metode som henter ut et rom basert på romID. Returnerer et Room-objekt eller false hvis rommet ikke finnes
    public static function get_room_by_id(int $roomId, PDO $pdo): Room|bool {
        $stmt = $pdo->prepare("SELECT * FROM Rooms WHERE roomID = :roomId");
        $stmt->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $stmt->execute();
        $roomData = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($roomData) {
            return new Room(
                $roomData['roomID'],
                $roomData['roomType'],
                $roomData['adults'],
                $roomData['children'],
                $roomData['description'],
                $roomData['price']
            );
        }
        return false;
    }

    /* 
    
    Metode som lagrer et rom i databasen. Returnerer true hvis lagringen var vellykket, false ellers.
    Fjernet muligheten til å opprette nytt rom da det kun skal finnes 25 rom i data
    
    */
    public function save(PDO $pdo): bool {
        // Check if the room ID exists to ensure we're updating an existing room
        if ($this->roomID) {
            // Update existing room
            $stmt = $pdo->prepare("
                UPDATE Rooms SET
                    roomType = :roomType,
                    adults = :nrAdults,
                    children = :nrChildren,
                    description = :description,
                    price = :price
                WHERE roomID = :roomId
            ");

            $stmt->bindParam(':roomType', $this->roomType, PDO::PARAM_STR);
            $stmt->bindParam(':nrAdults', $this->nrAdults, PDO::PARAM_INT);
            $stmt->bindParam(':nrChildren', $this->nrChildren, PDO::PARAM_INT);
            $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);
            $stmt->bindParam(':roomId', $this->roomID, PDO::PARAM_INT);

            // Execute the query and return whether it was successful
            return $stmt->execute();
        } else {
            // No room ID provided; room update cannot proceed
            return false;
        }
    }
    public static function get_all_rooms(PDO $pdo): array {
        $stmt = $pdo->prepare("SELECT * FROM Rooms");
        $stmt->execute();
        $roomsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $rooms = [];
        foreach ($roomsData as $roomData) {
            $rooms[] = new Room(
                $roomData['roomID'],
                $roomData['roomType'],
                $roomData['adults'],
                $roomData['children'],
                $roomData['description'],
                $roomData['price']
            );
        }
        return $rooms;
    }
    public static function get_room_availability($pdo, $roomID) {
        $stmt = $pdo->prepare("SELECT * FROM Rooms_Unavailable WHERE roomID = :roomID");
        $stmt->bindParam(':roomID', $roomID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete_unavailability($pdo, $fromDate, $toDate, $roomID) {
        $stmt = $pdo->prepare("DELETE FROM Rooms_Unavailable WHERE fromDate = :fromDate AND toDate = :toDate AND roomID = :roomID");
        $stmt->bindParam(':fromDate', $fromDate);
        $stmt->bindParam(':toDate', $toDate);
        $stmt->bindParam(':roomID', $roomID, PDO::PARAM_INT);
        return $stmt->execute();

    }

    //til index
    public static function getAllRooms(PDO $pdo): array {
        $stmt = $pdo->query("SELECT * FROM Rooms");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>