<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Character;
use App\Repository\CharacterRepository;

use App\Entity\Room;
use App\Repository\RoomRepository;

use App\Entity\Item;
use App\Repository\ItemRepository;

use App\Entity\Bag;
use App\Repository\BagRepository;

class AdventureController extends AbstractController
{
    #[Route('/proj', name: 'proj')]
    public function proj(): Response
    {

        return $this->render('adventure/proj.html.twig');
    }

    #[Route('/proj/adventure', name: 'adventure_app')]
    public function index(): Response
    {
        return $this->render('adventure/index.html.twig');
    }

    #[Route('/proj/about', name: 'proj_about')]
    public function about(): Response
    {
        return $this->render('adventure/proj_about.html.twig');
    }

    #[Route('/proj/about/database', name: 'proj_about_database')]
    public function aboutDatabase(): Response
    {
        return $this->render('adventure/proj_about_database.html.twig');
    }

    #[Route('/proj/api', name: 'proj_api')]
    public function api(): Response
    {
        return $this->render('adventure/proj_api.html.twig');
    }

    #[Route('/init_process', name: 'init_process', methods: ['POST'])]
    public function init_process(
        ManagerRegistry $doctrine,
        ItemRepository $itemRepository,
        RoomRepository $roomRepository,
        Request $request,
        sessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $bag = new Bag();
        $character = new Character();

        $character->setHealth(100);
        $character->setName($request->get('name'));
        $character->setBag($bag);
        $character->setCurrentRoom(1);
        $character->setPreviousRoom(1);

        $items = $itemRepository->findAll();
        foreach ($items as $item) {
            $item->setVisibility(true);
            $entityManager->persist($item);
        }

        $rooms = $roomRepository->findAll();
        foreach ($rooms as $room) {
            $room->setCompleted(false);
            $entityManager->persist($room);
        }

        $room = $roomRepository->find(1);

        $entityManager->persist($bag);
        $entityManager->persist($character);

        $entityManager->flush();

        $this->addFlash('message', "<span class='name'>" . $character->getName() . "'s story" . "</span>" . "<br><br>" . $room->getStory());

        $session->set("characterName", $character->getName());

        return $this->redirectToRoute('adventure_game', ['roomId' => 1]);
    }

    #[Route('/continue_process', name: 'continue_process', methods: ['POST'])]
    public function continue_process(
        ManagerRegistry $doctrine,
        CharacterRepository $characterRepository,
        Request $request,
        sessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $character = $characterRepository->findByName($request->get('continue_name'))[0];

        $entityManager->flush();

        $session->set("characterName", $character->getName());

        return $this->redirectToRoute('adventure_game', ['roomId' => $character->getCurrentRoom()]);
    }

    #[Route('/adventure/game/{roomId}', name: 'adventure_game', methods: ['GET'])]
    public function game(
        int $roomId,
        ManagerRegistry $doctrine,
        CharacterRepository $characterRepository,
        RoomRepository $roomRepository,
        ItemRepository $itemRepository,
        BagRepository $bagRepository,
        sessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $character = $characterRepository->findByName($session->get("characterName"))[0];
        $rooms = $roomRepository->findAll();
        $items = $itemRepository->findAll();
        $bag = $character->getBag();

        $data = [
            "rooms" => $rooms,
            "items" => $items,
            "roomId" => $roomId,
            "bag" => $bag
        ];

        return $this->render('adventure/game.html.twig', $data);
    }

    #[Route('/adventure/game/pickup/{itemId}', name: 'pickup', methods: ['GET'])]
    public function pickupItem(
        int $itemId,
        ManagerRegistry $doctrine,
        Request $request,
        CharacterRepository $characterRepository,
        ItemRepository $itemRepository,
        BagRepository $bagRepository,
        RoomRepository $roomRepository,
        sessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        // Fetch data.
        $character = $characterRepository->findByName($session->get("characterName"))[0];
        $bag = $character->getBag();
        $item = $itemRepository->find($itemId);

        // Add the item to the player's bag.
        $bag->setItem($item);
        $item->setVisibility(false);

        $entityManager->persist($bag);
        $entityManager->persist($item);

        if ($item->getName() === "royal scepter") {
            $room = $roomRepository->find($character->getCurrentRoom());
            $room->setCompleted(true);
            $ghost = $itemRepository->find(4);
            $ghost->setVisibility(false);
            $entityManager->persist($ghost);
        }

        $entityManager->flush();

        $this->addFlash('message', "You picked up: " . $item->getName() . ".");

        return $this->redirectToRoute('adventure_game', ['roomId' => $character->getCurrentRoom()]);
    }

    #[Route('/adventure/game/unlock/{itemId}', name: 'unlock', methods: ['GET'])]
    public function unlockItem(
        int $itemId,
        ManagerRegistry $doctrine,
        Request $request,
        CharacterRepository $characterRepository,
        ItemRepository $itemRepository,
        BagRepository $bagRepository,
        RoomRepository $roomRepository,
        sessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $character = $characterRepository->findByName($session->get("characterName"))[0];
        $room = $roomRepository->find($character->getCurrentRoom());
        $bag = $character->getBag();
        $padlock = $itemRepository->find($itemId);
        $items = $bag->getItems();
        if ($items) {
            foreach ($items as $item) {
                if ($item->getName() === "key") {
                    $padlock->setVisibility(false);
                    $room->setCompleted(true);
                    $bag->removeItem($item);
                    $this->addFlash('message', "You unlock the gate and remove the heavy iron padlock.");

                    $entityManager->persist($padlock);
                    $entityManager->persist($room);
                    $entityManager->persist($bag);

                    $entityManager->flush();

                    return $this->redirectToRoute('adventure_game', ['roomId' => $character->getCurrentRoom()]);
                }
            }
        }

        $this->addFlash('message', "The gate is locked.");

        return $this->redirectToRoute('adventure_game', ['roomId' => $character->getCurrentRoom()]);
    }

    #[Route('/adventure/game/talk/{itemId}', name: 'talk', methods: ['GET'])]
    public function talk(
        int $itemId,
        ManagerRegistry $doctrine,
        Request $request,
        ItemRepository $itemRepository,
        CharacterRepository $characterRepository,
        RoomRepository $roomRepository,
        sessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();
        $character = $characterRepository->findByName($session->get("characterName"))[0];
        $room = $roomRepository->find($character->getCurrentRoom());
        $room->setCompleted(true);
        $entityManager->persist($room);

        $entityManager->flush();

        $this->addFlash('message', "So... the...... rat is out of its... cage... a long time... a long time... indeed... since one has... escaped... how entertaining... once... I was...... like you... human... a long time... a long time ago... <br><br> Entertain me... rat... I will help you... escape...... I will unlock the storage room for... you... look for the... for his...... Scepter... a long time... a long time... indeed... since it has been used... it will be hidden... a long time... a long time... a long time... indeed... a long time... be careful......");

        return $this->redirectToRoute('adventure_game', ['roomId' => $character->getCurrentRoom()]);
    }

    #[Route('/adventure/game/move/{roomId}/{direction}', name: 'move', methods: ['GET'])]
    public function move(
        int $roomId,
        string $direction,
        ManagerRegistry $doctrine,
        // Request $request,
        CharacterRepository $characterRepository,
        RoomRepository $roomRepository,
        sessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();
        $character = $characterRepository->findByName($session->get("characterName"))[0];
        $nextRoom = $roomRepository->find($roomId);
        // $previousRoom = $roomRepository->find($character->getPreviousRoom());
        $currentRoom = $roomRepository->find($character->getCurrentRoom());

        if ($roomId === 0) {

            $this->addFlash('message', "You can't go there.");

        } elseif ($currentRoom->getCompleted() or ($direction === "backward") or ($roomId === 5)) {

            if ($roomId === 5) {
                $currentRoom->setCompleted(true);
                $entityManager->persist($currentRoom);
            }

            // Set the previous room to the id of the room the character is leaving.
            $character->setPreviousRoom($character->getCurrentRoom());
            // Set the current room to the id of the room the character is entering.
            $character->setCurrentRoom($roomId);

            $entityManager->persist($character);


            // Display the story if the room hasn't been completed.
            if (!$nextRoom->getCompleted()) {
                $this->addFlash('message', $nextRoom->getStory());
            }

            if ($roomId === 5) {
                $nextRoom->setCompleted(true);
                $entityManager->persist($nextRoom);
            }

            $entityManager->flush();

        } elseif (!$nextRoom->getCompleted()) {
            $this->addFlash('message', "Something prevents you from going that direction.");
        }
        return $this->redirectToRoute('adventure_game', ['roomId' => $character->getCurrentRoom()]);
    }

    #[Route('/adventure/game/eat/{itemId}', name: 'eat', methods: ['GET'])]
    public function eat(
        int $itemId,
        ManagerRegistry $doctrine,
        Request $request,
        ItemRepository $itemRepository,
        CharacterRepository $characterRepository,
        BagRepository $bagRepository,
        sessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $character = $characterRepository->findByName($session->get("characterName"))[0];

        $health = $character->getHealth();
        $newHealth = $health - 20;
        $character->setHealth($newHealth);

        $item = $itemRepository->find($itemId);
        $bag = $character->getBag();
        $bag->removeItem($item);

        $entityManager->persist($character);
        $entityManager->persist($bag);

        $entityManager->flush();

        $this->addFlash('message', "Ouch! The apple is actually made of wood. You must have broken a tooth biting into that.<br><br> -20 HP.");

        return $this->redirectToRoute('adventure_game', ['roomId' => $character->getCurrentRoom()]);
    }

    #[Route('/adventure/game/magic/{itemId}', name: 'magic', methods: ['GET'])]
    public function magic(
        int $itemId,
        ManagerRegistry $doctrine,
        Request $request,
        CharacterRepository $characterRepository,
        ItemRepository $itemRepository,
        RoomRepository $roomRepository,
        sessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $character = $characterRepository->findByName($session->get("characterName"))[0];
        if ($character->getCurrentRoom() === 4) {
            // $item = $itemRepository->find($itemId);
            $character->setCurrentRoom(6);
            $room = $roomRepository->find($character->getCurrentRoom());
            $room->setCompleted(true);

            $entityManager->persist($room);
            $entityManager->persist($character);

            $entityManager->flush();

            $this->addFlash('message', $room->getStory());

        }


        return $this->redirectToRoute('adventure_game', ['roomId' => $character->getCurrentRoom()]);

    }
}
