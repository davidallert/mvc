<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $background = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $story = null;

    #[ORM\Column(nullable: true)]
    private ?int $forwardRoomId = null;

    #[ORM\Column(nullable: true)]
    private ?int $backwardRoomId = null;

    #[ORM\Column(nullable: true)]
    private ?int $leftRoomId = null;

    #[ORM\Column(nullable: true)]
    private ?int $rightRoomId = null;

    #[ORM\Column(nullable: true)]
    private ?bool $completed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(string $background): static
    {
        $this->background = $background;

        return $this;
    }

    public function getStory(): ?string
    {
        return $this->story;
    }

    public function setStory(string $story): static
    {
        $this->story = $story;

        return $this;
    }

    public function getForwardRoomId(): ?int
    {
        return $this->forwardRoomId;
    }

    public function getBackwardRoomId(): ?int
    {
        return $this->backwardRoomId;
    }

    public function getLeftRoomId(): ?int
    {
        return $this->leftRoomId;
    }

    public function getRightRoomId(): ?int
    {
        return $this->rightRoomId;
    }

    public function setForwardRoomId(int $id): static
    {
        $this->forwardRoomId = $id;

        return $this;
    }

    public function setBackwardRoomId(int $id): static
    {
        $this->backwardRoomId = $id;

        return $this;
    }

    public function setLeftRoomId(int $id): static
    {
        $this->leftRoomId = $id;

        return $this;
    }

    public function setRightRoomId(int $id): static
    {
        $this->rightRoomId = $id;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;

    }

    public function setCompleted(bool $completed): static
    {
        $this->completed = $completed;

        return $this;
    }
}
