<?php
class Participation
{
    private ?int $id = null;
    private ?int $user_id = null;
    private ?int $event_id = null;
    private ?string $registration_date = null;
    private ?string $status = 'pending';

    public function __construct(?int $id = null, ?int $user_id = null, ?int $event_id = null, ?string $registration_date = null, ?string $status = 'pending')
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->event_id = $event_id;
        $this->registration_date = $registration_date;
        $this->status = $status;
    }

    // Getters and Setters
    public function getId(): ?int { return $this->id; }
    public function getUserId(): ?int { return $this->user_id; }
    public function getEventId(): ?int { return $this->event_id; }
    public function getRegistrationDate(): ?string { return $this->registration_date; }
    public function getStatus(): ?string { return $this->status; }

    public function setUserId(int $user_id): void { $this->user_id = $user_id; }
    public function setEventId(int $event_id): void { $this->event_id = $event_id; }
    public function setStatus(string $status): void { $this->status = $status; }

   
}
?>
