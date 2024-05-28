<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Bag;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $health = null;

    #[ORM\Column(length: 255)]
    #[ORM\Unique]
    private ?string $name = null;

    // #[ORM\Column(type: "text")]
    // private ?string $bag = null;

    // #[ORM\OneToOne(targetEntity: Bag::class, mappedBy: "character", cascade: ["persist", "remove"])]
    // private ?Bag $bag = null;

    #[ORM\OneToOne(targetEntity: Bag::class, inversedBy: "character", cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(name: "bag_id", referencedColumnName: "id")]
    private ?Bag $bag = null;

    #[ORM\Column(options: ["default" => 1])]
    private ?int $currentRoom = null;

    #[ORM\Column(nullable: true)]
    private ?int $previousRoom = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): static
    {
        $this->health = $health;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    // public function getBag(): ?Bag
    // {
    //     return $this->bag ? unserialize($this->bag) : null;
    // }

    // public function setBag(?Bag $bag): static
    // {
    //     $this->bag = $bag ? serialize($bag) : null;
    //     return $this;
    // }

    public function getBag(): ?Bag
    {
        return $this->bag;
    }

    public function setBag(?Bag $bag): static
    {
        $this->bag = $bag;
        return $this;
    }

    public function findByName(string $name): ?Character
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name = :name')
            ->setParameter('name', $name)
            ->getQuery();
    }

    public function getCurrentRoom(): ?int
    {
        return $this->currentRoom;
    }

    public function setCurrentRoom(?int $currentRoom): static
    {
        $this->currentRoom = $currentRoom;
        return $this;
    }

    public function getPreviousRoom(): ?int
    {
        return $this->previousRoom;
    }

    public function setPreviousRoom(?int $previousRoom): static
    {
        $this->previousRoom = $previousRoom;
        return $this;
    }
}
