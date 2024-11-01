<?php 

class Room {
    private ?int $roomId;
    private ?string $roomType;
    private ?string $description;
    private ?int $nrAdults;
    private ?int $nrChildren;
    private ?bool $availability;
    private ?array $locationDetails;
    private ?array $roomAttributes;

    public function __construct(
        ?int $roomId = null,
        ?string $roomType = null,
        ?int $nrAdults = null,
        ?int $nrChildren = null,
        ?string $description = null,
        ?bool $availability = null,
        ?array $locationDetails = null,
        ?array $roomAttributes = null
    ) {
        $this->roomId = $roomId;
        $this->roomType = $roomType;
        $this->nrAdults = $nrAdults;
        $this->nrChildren = $nrChildren;
        $this->description = $description;
        $this->availability = $availability;
        $this->locationDetails = $locationDetails;
        $this->roomAttributes = $roomAttributes;
    }

    // Getter methods for each property
    public function getRoomId(): ?int {
        return $this->roomId;
    }

    public function getRoomType(): ?string {
        return $this->roomType;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getNrAdults(): ?int {
        return $this->nrAdults;
    }

    public function getNrChildren(): ?int {
        return $this->nrChildren;
    }

    public function getAvailability(): ?bool {
        return $this->availability;
    }

    public function getLocationDetails(): ?array {
        return $this->locationDetails;
    }

    public function getRoomAttributes(): ?array {
        return $this->roomAttributes;
    }

    public function getRoomInfo(int $roomId): ?array {
        // Assume $pdo is your database connection
        global $pdo; 
    
        $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = :roomId");
        $stmt->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $stmt->execute();
        $roomData = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($roomData) {
            // Map database data to class properties if needed
            return [
                'title' => $roomData['title'],
                'description' => $roomData['description'],
                'price' => $roomData['price'],
                'roomType' => $roomData['room_type'],
                'nrAdults' => $roomData['nr_adults'],
                'nrChildren' => $roomData['nr_children'],
                'roomAttributes' => explode(',', $roomData['attributes']),
                'locationDetails' => explode(',', $roomData['location_details']),
                'image' => $roomData['image']
            ];
        }
    
        return null;
    }
    
}

?>
