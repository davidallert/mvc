<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Character;
use App\Entity\Bag;

/**
 * Test cases for class Character.
 */
class CharacterTest extends TestCase
{
    public function testGetId()
    {
        $character = new Character();

        $res = $character->getId();
        $exp = null;

        $this->assertNull($res);
    }

    public function testSetGetName()
    {
        $character = new Character();
        $character->setName("Test");
        $exp = "Test";

        $res = $character->getName();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetHealth()
    {
        $character = new Character();
        $character->setHealth(100);
        $exp = 100;

        $res = $character->getHealth();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetCurrentRoom()
    {
        $character = new Character();
        $character->setCurrentRoom(1);
        $exp = 1;

        $res = $character->getCurrentRoom();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetPreviousRoom()
    {
        $character = new Character();
        $character->setPreviousRoom(1);
        $exp = 1;

        $res = $character->getPreviousRoom();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetBag()
    {
        $character = new Character();
        $bag = new Bag();

        $character->setBag($bag);
        $res = $character->getBag();

        $exp = "App\Entity\Bag";

        $this->assertInstanceOf($exp, $res);
    }

}