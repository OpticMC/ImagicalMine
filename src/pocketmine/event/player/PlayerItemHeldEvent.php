<?php

/*
 *
 *  _                       _           _ __  __ _
 * (_)                     (_)         | |  \/  (_)
 *  _ _ __ ___   __ _  __ _ _  ___ __ _| | \  / |_ _ __   ___
 * | | '_ ` _ \ / _` |/ _` | |/ __/ _` | | |\/| | | '_ \ / _ \
 * | | | | | | | (_| | (_| | | (_| (_| | | |  | | | | | |  __/
 * |_|_| |_| |_|\__,_|\__, |_|\___\__,_|_|_|  |_|_|_| |_|\___|
 *                     __/ |
 *                    |___/
 *
 * This program is a third party build by ImagicalMine.
 *
 * PocketMine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author ImagicalMine Team
 * @link http://forums.imagicalmine.net/
 *
 *
*/

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

class PlayerItemHeldEvent extends PlayerEvent implements Cancellable
{
    public static $handlerList = null;

    private $item;
    private $slot;
    private $inventorySlot;

    public function __construct(Player $player, Item $item, $inventorySlot, $slot)
    {
        $this->player = $player;
        $this->item = $item;
        $this->inventorySlot = (int) $inventorySlot;
        $this->slot = (int) $slot;
    }

    public function getSlot()
    {
        return $this->slot;
    }

    public function getInventorySlot()
    {
        return $this->inventorySlot;
    }

    public function getItem()
    {
        return $this->item;
    }
}
