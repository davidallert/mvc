<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Item;

/**
 * Test cases for class Item.
 */
class ItemTest extends TestCase
{
    public function testGetId()
    {
        $item = new Item();

        $res = $item->getId();
        $exp = null;

        $this->assertNull($res);
    }

    public function testSetGetName()
    {
        $item = new Item();
        $item->setName("Test");
        $exp = "Test";

        $res = $item->getName();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetX()
    {
        $item = new Item();
        $item->setX(100);
        $exp = 100;

        $res = $item->getX();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetY()
    {
        $item = new Item();
        $item->setY(100);
        $exp = 100;

        $res = $item->getY();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetRotation()
    {
        $item = new Item();
        $item->setRotation(100);
        $exp = 100;

        $res = $item->getRotation();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetImageUrl()
    {
        $item = new Item();
        $item->setImageUrl("https://www.test.img");
        $exp = "https://www.test.img";

        $res = $item->getImageUrl();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetRoomId()
    {
        $item = new Item();
        $item->setRoomId(1);
        $exp = 1;

        $res = $item->getRoomId();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetInteraction()
    {
        $item = new Item();
        $item->setInteraction("pickup");
        $exp = "pickup";

        $res = $item->getInteraction();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetUsage()
    {
        $item = new Item();
        $item->setUsage("eat");
        $exp = "eat";

        $res = $item->getUsage();

        $this->assertEquals($exp, $res);
    }

    public function testSetGetVisibility()
    {
        $item = new Item();
        $item->setVisibility(true);
        $exp = true;

        $res = $item->getVisibility();

        $this->assertEquals($exp, $res);
    }
}