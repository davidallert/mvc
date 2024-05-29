<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Character;
use App\Entity\Bag;
use App\Entity\Item;

/**
 * Test cases for class Bag.
 */
class BagTest extends TestCase
{
    public function testGetId()
    {
        $bag = new Bag();

        $res = $bag->getId();
        $exp = null;

        $this->assertNull($res);
    }

    public function testGetSetItemsArray()
    {
        $bag = new Bag();
        $item = new Item();

        $item->setName("Item 1");
        $bag->setItem($item);
        $res = $bag->getItems();

        $this->assertIsArray($res);
    }

    public function testGetSetItemsObj()
    {
        $bag = new Bag();
        $item = new Item();

        $item->setName("Item 1");
        $bag->setItem($item);
        $res = $bag->getItems()[0];
        $exp = "App\Entity\Item";

        $this->assertInstanceOf($exp, $res);
    }

    public function testSetSameItem()
    {
        $bag = new Bag();
        $item = new Item();

        $item->setName("Item 1");
        $bag->setItem($item);
        $bag->setItem($item);

        $res = count($bag->getItems());
        $exp = 1;

        $this->assertEquals($exp, $res);
    }

    public function testRemoveItem()
    {
        $bag = new Bag();
        $item = new Item();
        $another_item = new Item();

        $item->setName("Item 1");
        $another_item->setName("Item 2");
        $bag->setItem($item);
        $bag->setItem($another_item);

        $bag->removeItem($item);
        $res_item = $bag->getItems()[0];
        $res = $res_item->getName();
        $exp = "Item 2";

        $this->assertEquals($exp, $res);
    }

    public function testRemoveItemFromEmptyBag()
    {
        $bag = new Bag();
        $item = new Item();

        $res = $bag->removeItem($item);
        $exp = "App\Entity\Bag";

        $this->assertInstanceOf($exp, $res);
    }


}