<?php

namespace App\Controller;

// Classes
use App\Entity\Character;
use App\Repository\CharacterRepository;

use App\Entity\Room;
use App\Repository\RoomRepository;

use App\Entity\Item;
use App\Repository\ItemRepository;

use App\Entity\Bag;
use App\Repository\BagRepository;

// ORM
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdventureJsonApi extends AbstractController
{

    #[Route("/proj/api/rooms")]
    public function jsonRooms(
        RoomRepository $roomRepository,
    ): Response
    {
        $rooms = $roomRepository->findAll();

        $roomArray = [];
        foreach ($rooms as $room) {
            $roomArray[] = [
                'id' => $room->getId(),
                'background' => $room->getBackground(),
                'story' => $room->getStory(),
                'forwardRoomId' => $room->getForwardRoomId(),
                'backwardRoomId' => $room->getBackwardRoomId(),
                'leftRoomId' => $room->getLeftRoomId(),
                'rightRoomId' => $room->getRightRoomId(),
                'completed' => $room->getCompleted(),
            ];
        }

        $data = [
            'rooms' => $roomArray
        ];

        return new JsonResponse($data);
    }

    #[Route("/proj/api/items")]
    public function jsonItems(
        ItemRepository $itemRepository,
    ): Response
    {
        $items = $itemRepository->findAll();

        $itemArray = [];
        foreach ($items as $item) {
            $itemArray[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'x' => $item->getX(),
                'y' => $item->getY(),
                'rotation' => $item->getRotation(),
                'image_url' => $item->getImageUrl(),
                'room_id' => $item->getRoomId(),
                'interaction' => $item->getInteraction(),
                'usage' => $item->getUsage(),
                'visibility' => $item->getVisibility(),
                'opacity' => $item->getOpacity(),
            ];
        }

        $data = [
            'items' => $itemArray
        ];

        return new JsonResponse($data);
    }

    #[Route("/proj/api/items/css")]
    public function jsonItemsCss(
        ItemRepository $itemRepository,
    ): Response
    {
        $items = $itemRepository->findAll();

        $itemArray = [];
        foreach ($items as $item) {
            $itemArray[] = [
                'id' => $item->getId(),
                'x' => $item->getX(),
                'y' => $item->getY(),
                'rotation' => $item->getRotation(),
                'opacity' => $item->getOpacity(),
            ];
        }

        $data = [
            'items' => $itemArray
        ];

        return new JsonResponse($data);
    }

    #[Route("/proj/api/items/images")]
    public function jsonItemsImages(
        ItemRepository $itemRepository,
    ): Response
    {
        $items = $itemRepository->findAll();

        $itemArray = [];
        foreach ($items as $item) {
            $itemArray[] = [
                'id' => $item->getId(),
                'image_url' => $item->getImageUrl(),
            ];
        }

        $data = [
            'items' => $itemArray
        ];

        return new JsonResponse($data);
    }

    #[Route("/proj/api/characters")]
    public function jsonCharacters(
        CharacterRepository $characterRepository,
    ): Response
    {
        $characters = $characterRepository->findAll();

        $characterArray = [];
        foreach ($characters as $character) {
            $characterArray[] = [
                'id' => $character->getId(),
                'name' => $character->getName(),
            ];
        }

        $data = [
            'characters' => $characterArray
        ];

        return new JsonResponse($data);
    }

    #[Route("/proj/api/character", methods: ["POST"], name: "json_name")]
    public function jsonCharacter(
        CharacterRepository $characterRepository,
        Request $request
    ): Response
    {

        $characters = $characterRepository->findAll();
        $data = [];
        $itemsArray = [];
        // var_dump($request->request->get('json_name'));

        foreach ($characters as $character) {
            if (($character->getName()) === ($request->request->get('json_name'))) {

                $items = $character->getBag()->getItems();
                if ($items) {
                    foreach ($items as $item) {
                        $itemsArray[] = $item->getName();
                    }
                }

                $data = [
                    'id' => $character->getId(),
                    'name' => $character->getName(),
                    'health' => $character->getHealth(),
                    'bag' => $itemsArray,
                    'currentRoom' => $character->getCurrentRoom(),
                    'previousRoom' => $character->getPreviousRoom(),
                ];
                break;
            }
        }

        return new JsonResponse($data);
    }

}
