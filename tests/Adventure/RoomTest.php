<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Character;
use App\Entity\Room;
use App\Entity\Item;

/**
 * Test cases for class Room.
 */
class RoomTest extends TestCase
{
    public function testGetId()
    {
        $room = new Room();

        $res = $room->getId();
        $exp = null;

        $this->assertNull($res);
    }

    public function testGetSetBackground()
    {
        $room = new Room();
        $room->setBackground("https://www.test.img");

        $res = $room->getBackground();
        $exp = "https://www.test.img";

        $this->assertEquals($exp, $res);
    }

    public function testGetSetStory()
    {
        $room = new Room();
        $room->setStory("A long time ago in a galaxy far, far away....");

        $res = $room->getStory();
        $exp = "A long time ago in a galaxy far, far away....";

        $this->assertEquals($exp, $res);
    }

    public function testGetSetRoomId()
    {
        $room = new Room();
        $room->setForwardRoomId(1);
        $room->setBackwardRoomId(2);
        $room->setLeftRoomId(3);
        $room->setRightRoomId(4);

        $res_forward = $room->getForwardRoomId();
        $res_backward = $room->getBackwardRoomId();
        $res_left = $room->getLeftRoomId();
        $res_right = $room->getRightRoomId();

        $exp_forward = 1;
        $exp_backward = 2;
        $exp_left = 3;
        $exp_right = 4;

        $this->assertEquals($exp_forward, $res_forward);
        $this->assertEquals($exp_backward, $res_backward);
        $this->assertEquals($exp_left, $res_left);
        $this->assertEquals($exp_right, $res_right);
    }

    public function testGetSetCompleted()
    {
        $room = new Room();
        $room->setCompleted(true);

        $res = $room->getCompleted();
        $exp = true;

        $this->assertEquals($exp, $res);
    }

}