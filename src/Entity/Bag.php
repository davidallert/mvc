<?php

namespace App\Entity;

use App\Repository\BagRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Item;
use App\Entity\Character;

#[ORM\Entity(repositoryClass: BagRepository::class)]
class Bag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "json", nullable: true)]
    private ?array $serializedItems = null;

    // #[ORM\OneToOne(targetEntity: Character::class, inversedBy: "bag", cascade: ["persist", "remove"])]
    // #[ORM\JoinColumn(name: "character_id", referencedColumnName: "id")]
    // private ?Character $character = null;

    #[ORM\OneToOne(targetEntity: Character::class, mappedBy: "bag", cascade: ["persist", "remove"])]
    private ?Character $character = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setItem(?Item $item): static
    {
        $itemsInBag = $this->getItems();

        if ($itemsInBag) {
            foreach ($itemsInBag as $itemInBag) {
                if ($itemInBag->getName() === $item->getName()) {
                    return $this;
                }
            }
        }

        $this->serializedItems[] = serialize($item);

        return $this;
    }

    public function getItems(): ?array
    {
        if ($this->serializedItems === null) {
            return null;
        }

        $items = [];
        foreach ($this->serializedItems as $serializedItem) {
            $items[] = unserialize($serializedItem);
        }

        return $items;
    }

    public function removeItem(?Item $item): static
    {
        if ($this->serializedItems === null) {
            return $this;
        }

        foreach ($this->serializedItems as $key => $serializedItem) {
            $unserializedItem = unserialize($serializedItem);
            if ($unserializedItem->getName() === $item->getName()) {
                unset($this->serializedItems[$key]);
                $this->serializedItems = array_values($this->serializedItems);
                break;
            }
        }

        return $this;
    }
}
